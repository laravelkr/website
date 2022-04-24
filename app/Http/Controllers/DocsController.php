<?php

namespace App\Http\Controllers;

use App\Exceptions\CommitInformationNotFoundException;
use App\Models\Banner;
use App\Models\Notice;
use App\Services\Documents\UpdateDateInterface;
use App\Services\Github\ContributorSearcher;
use App\Services\Markdown\AsideMenuBar;
use App\Services\Markdown\ManualArticle;
use App\Services\Markdown\ManualNavigator;
use App\Services\ModernPug\Dto\Response;
use App\Services\ModernPug\Recruits;
use App\Services\Navigator\LinkExtractor;
use App\Services\Navigator\Location;
use Carbon\Carbon;
use DateTimeInterface;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Cache;
use Throwable;

class DocsController extends Controller
{

    protected const CACHE_SECONDS = 1800;

    protected mixed $defaultVersions;

    public function __construct(
        protected ManualArticle $articleProvider,
        protected ManualNavigator $navigatorProvider,
        protected UpdateDateInterface $documentUpdatedDateChecker,
        protected LinkExtractor $navigatorLinkExtractor,
        protected Location $navigatorLinkLocationProvider,
        protected ContributorSearcher $contributorSearcher,
        protected AsideMenuBar $asideMenuBar,
        protected Recruits $recruits
    ) {
        parent::__construct();

        $this->defaultVersions = config('docs.default');
    }

    public function showDocs($version, $doc = null)
    {
        //버전을 지정하지 않고 문서로 바로 접속한 경우
        if ($doc === null && $this->isDocument($version)) {
            return redirect(route('docs.show', [$this->defaultVersions, $version]));
        }

        // 지원하는 버전이 아니면 기본 버전으로 이동
        if ($this->isInvalidVersion($version)) {
            return redirect(route('docs.show', [$this->defaultVersions, $doc]));
        }

        //번역중인 버전에 대한 안내표시
        if ($this->isInTranslationVersion($version)) {
            toastr()->info($version." 문서는 현재 번역 중입니다", "", [
                "positionClass" => "toast-top-full-width",
            ]);

            return redirect(route('docs.show', [$this->defaultVersions, $doc]));
        }

        //지정하지 않은 파일은 재선언해준다
        if ($doc === null) {
            $doc = 'README';
        }


        $args = Cache::remember('document.'.$version.'.'.$doc, self::CACHE_SECONDS, function () use ($version, $doc) {
            $notificationMessage = '';
            if ($this->checkDeprecated($version)) {
                $notificationMessage = $this->getDeprecatedNotificationMessage($version, $doc);
            }


            $this->navigatorProvider->setVersion($version);
            $this->navigatorProvider->setLanguage('ko');
            $tableContent = $this->navigatorProvider->getContent();

            $this->articleProvider->setVersion($version);
            $this->articleProvider->setDocumentFilename($doc);

            $this->articleProvider->setLanguage('ko');
            $krContent = $this->articleProvider->getContent();
            $subTableContent = $this->articleProvider->getSubTableContent();


            $this->articleProvider->setLanguage('en');
            $enContent = $this->articleProvider->getContent();


            try {
                $enUpdated = $this->documentUpdatedDateChecker->getDocsUpdatedAt('en', $version, $doc);
                $enTimeAgoUpdate = Carbon::createFromFormat(DateTimeInterface::ATOM, $enUpdated)->diffForHumans();
            } catch (CommitInformationNotFoundException) {
                $enUpdated = null;
                $enTimeAgoUpdate = null;
            }

            try {
                $krUpdated = $this->documentUpdatedDateChecker->getDocsUpdatedAt('kr', $version, $doc);
                $krTimeAgoUpdate = Carbon::createFromFormat(DateTimeInterface::ATOM, $krUpdated)->diffForHumans();
            } catch (CommitInformationNotFoundException) {
                $krUpdated = null;
                $krTimeAgoUpdate = null;
            }


            try {
                $this->contributorSearcher->setBranch($version);
                $contributors = $this->contributorSearcher->getContributors($doc);
            } catch (ConnectException) {
                $contributors = [];
            } catch (Throwable $exception) {
                report($exception);
                $contributors = [];
            }


            $links = $this->navigatorLinkExtractor->extractToArray($tableContent);
            $this->navigatorLinkLocationProvider->setLinks($links);
            $this->navigatorLinkLocationProvider->setNowDocumentIndex($doc);
            $nowLink = $this->navigatorLinkLocationProvider->getNowLink();
            $prevLink = $this->navigatorLinkLocationProvider->getPrevLink();
            $nextLink = $this->navigatorLinkLocationProvider->getNextLink();

            return compact('version', 'tableContent', 'subTableContent', 'krContent', 'enContent', 'doc',
                'enUpdated', 'krUpdated', 'enTimeAgoUpdate', 'krTimeAgoUpdate', 'contributors', 'nowLink',
                'prevLink', 'nextLink', 'notificationMessage');
        });

        $args['recruits'] = $this->getRecruits();
        $args['notices'] = Notice::getAll();
        $args['banners'] = Banner::getAll();
        $args['asidePageList'] = $this->asideMenuBar->getAsideList();

        return view('docs.show', $args);
    }

    private function isValidVersion(string $version): bool
    {
        return in_array($version, array_keys(config('docs.versions')));
    }

    private function checkDeprecated(string $version): bool
    {
        $deprecatedAt = config("docs.versions")[$version]['deprecatedAt'];
        return Carbon::now() > $deprecatedAt;
    }

    private function getDeprecatedNotificationMessage(string $version, string $doc): string
    {
        return "라라벨 ".$version."버전은 공식 유지보수 기간이 종료됨에 따라 한글 문서번역도 종료되었습니다. 최신 데이터를 확인하기 위해서는 공식 홈페이지를 참조해주시기 바랍니다<br /><br /><a class='btn bg-white btn-outline-primary text-primary' href='".route('docs.show',
                [config('docs.default'), $doc])."'>".config('docs.default')."버전 바로가기</a>";
    }

    private function isInTranslationVersion(string $version): bool
    {
        return config('docs.versions')[$version]['in_translation'];
    }

    protected function isDocument(string $version): bool
    {
        return preg_match('/[0-9].[0-9x]/', $version, $matches) === 0;
    }

    protected function isInvalidVersion(string $version): bool
    {
        return $this->isValidVersion($version) === false;
    }

    protected function getRecruits(): Response
    {
        return Cache::remember('document.recruits', self::CACHE_SECONDS, function () {
            return $this->recruits->getAll();
        });
    }
}
