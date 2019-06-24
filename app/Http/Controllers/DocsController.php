<?php

namespace App\Http\Controllers;

use App\Banner;
use App\Exceptions\CommitInformationNotFoundException;
use App\Notice;
use App\Services\Github\ContributorSearcher;
use App\Services\Documents\UpdateDateInterface;
use App\Services\Markdown\ManualArticle;
use App\Services\Markdown\ManualMarkdownProvider;
use App\Services\Markdown\ManualNavigator;
use App\Services\Markdown\AsideMenuBar;
use App\Services\Navigator\LinkExtractor;
use App\Services\Navigator\Location;
use Carbon\Carbon;
use DateTime;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Cache;

class DocsController extends Controller
{

    const CACHE_MINUTES = 30;

    protected $defaultVersions;

    /**
     * @var ManualMarkdownProvider
     */
    protected $articleProvider;
    /**
     * @var UpdateDateInterface
     */
    protected $documentUpdatedDateChecker;
    /**
     * @var ContributorSearcher
     */
    protected $contributorSearcher;
    /**
     * @var ManualNavigator
     */
    protected $navigatorProvider;
    /**
     * @var Location
     */
    protected $navigatorLinkLocationProvider;
    /**
     * @var LinkExtractor
     */
    protected $navigatorLinkExtractor;

    protected $asideMenuBar;

    public function __construct(
        ManualArticle $articleProvider,
        ManualNavigator $navigatorProvider,
        UpdateDateInterface $documentUpdatedDateChecker,
        LinkExtractor $navigatorLinkExtractor,
        Location $navigatorLinkLocationProvider,
        ContributorSearcher $contributorSearcher,
        AsideMenuBar $asideMenuBar
    ) {
        parent::__construct();

        $this->defaultVersions = config('docs.default');
        $this->articleProvider = $articleProvider;
        $this->navigatorProvider = $navigatorProvider;
        $this->documentUpdatedDateChecker = $documentUpdatedDateChecker;
        $this->navigatorLinkExtractor = $navigatorLinkExtractor;
        $this->navigatorLinkLocationProvider = $navigatorLinkLocationProvider;
        $this->contributorSearcher = $contributorSearcher;
        $this->asideMenuBar = $asideMenuBar;
    }

    public function showDocs($version = null, $doc = null)
    {
        if ($version === null) {
            $version = $this->defaultVersions;
        }

        // 5.3 이상 버전에 한해서 기본 문서를 readme 로 설정
        if ($doc === null) {
            $doc = 'README';
        }

        if (preg_match('/[0-9.]+/', $version, $matches) === 0) {
            return redirect(route('docs.show', [$this->defaultVersions, $version]));
        } // 지원하는 버전이 아니면 기본 버전으로 이동
        elseif ($this->isValidVersion($version)) {
            return redirect(route('docs.show', [$this->defaultVersions, $doc]));
        }

        $args = Cache::remember('document.' . $version . '.' . $doc, self::CACHE_MINUTES,
            function () use ($version, $doc) {


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
                    $enTimeAgoUpdate = Carbon::createFromFormat(DateTime::ISO8601, $enUpdated)->diffForHumans();
                } catch (CommitInformationNotFoundException $exception) {
                    $enUpdated = null;
                    $enTimeAgoUpdate = null;

                }

                try {

                    $krUpdated = $this->documentUpdatedDateChecker->getDocsUpdatedAt('kr', $version, $doc);
                    $krTimeAgoUpdate = Carbon::createFromFormat(DateTime::ISO8601, $krUpdated)->diffForHumans();
                } catch (CommitInformationNotFoundException $exception) {
                    $krUpdated = null;
                    $krTimeAgoUpdate = null;
                }


                $this->contributorSearcher->setBranch($version);

                try {

                    $contributors = $this->contributorSearcher->getContributors($doc);
                } catch (ConnectException $exception) {
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

        $args['notices'] = Notice::getAll();
        $args['banners'] = Banner::getAll();
        $args['asidePageList'] = $this->asideMenuBar->getAsidelist();
        
        return view('docs.show', $args);
    }

    /**
     * @param $version
     * @return bool
     */
    private function isValidVersion($version): bool
    {
        return in_array($version, array_keys(config('docs.versions'))) === false;
    }

    private function checkDeprecated($version)
    {

        $deprecatedAt = config("docs.versions")[$version]['deprecatedAt'];
        return Carbon::now() > $deprecatedAt;

    }

    private function getDeprecatedNotificationMessage($version, $doc)
    {

        return "라라벨 " . $version . "버전은 공식 유지보수 기간이 종료됨에 따라 한글 문서번역도 종료되었습니다. 최신 데이터를 확인하기 위해서는 공식 홈페이지를 참조해주시기 바랍니다<br /><br /><a class='btn bg-white btn-outline-primary text-primary' href='" . route('docs.show',
                [config('docs.default'), $doc]) . "'>" . config('docs.default') . "버전 바로가기</a>";

    }
}
