<?php

namespace Tests\Feature\Controller;

use App\Services\Documents\Location;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Tests\TestCase;

class DocsControllerTest extends TestCase
{

    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->createApplication();
    }


    /**
     * @test
     * @dataProvider versionProvider
     * @param $version
     * @param $urls
     */
    public function check_all_document(string $version, array $urls)
    {


        $this->get(route('docs.show', [$version]))->assertStatus(200);

        $url = Arr::random($urls);

        if (Str::endsWith($url, "/api")) {
            $this->get($url)->assertRedirect();
        } else {
            $this->get($url)->assertOk();
        }
    }


    public function versionProvider()
    {

        $return = [];

        $versions = config('docs.versions');
        $parseTargetDocument = 'documentation';

        /**
         * @var Location $location
         */
        $location = resolve(Location::class);
        $location->setLanguage('ko');

        foreach ($versions as $version => $versionStatus) {


            $location->setVersion($version);
            $fileContent = file_get_contents($location->getFileLocation($parseTargetDocument));

            $fileContent = str_replace("{{version}}", $version, $fileContent);

            preg_match_all('/\((?P<url>.*)\)/', $fileContent, $matches);
            $return[] = [$version, $matches['url']];
        }


        return $return;
    }


    /**
     * @test
     */
    public function check_redirect_if_not_exist_version_and_document_name()
    {

        $this->get(url('/docs'))->assertRedirect(route('docs.show', [config('docs.default')]));

    }

    /**
     * @test
     */
    public function check_redirect_if_exist_only_document_name()
    {

        $this->get(route('docs.show', ['mix']))
            ->assertRedirect(route('docs.show', [config('docs.default'), 'mix']));

        $this->get(route('docs.show', ['eloquent']))
            ->assertRedirect(route('docs.show', [config('docs.default'), 'eloquent']));

    }

    /**
     * @test
     */
    public function check_redirect_if_invalid_version()
    {

        $this->get(route('docs.show', ['INVALID_VERSION', 'eloquent']))
            ->assertRedirect(route('docs.show', [config('docs.default'), 'eloquent']));

    }

    /**
     * @test
     */
    public function check_redirect_if_not_exist_document()
    {

        $this->get(route('docs.show', [config('docs.default'), 'NOT_EXISTS']))
            ->assertRedirect(route('docs.show', [config('docs.default')]));

    }
}
