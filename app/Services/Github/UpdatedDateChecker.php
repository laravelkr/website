<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 1:03
 */

namespace App\Services\Github;


use App\Exceptions\NotSupportedLanguageException;
use App\Services\Documents\UpdateDateInterface;


class UpdatedDateChecker implements UpdateDateInterface
{


    /**
     * @var CommitInformation
     */
    protected $commitInformation;

    public function __construct(CommitInformation $commitInformation)
    {


        $this->commitInformation = $commitInformation;
    }

    /**
     * @param $lang
     * @param $version
     * @param $doc
     * @return mixed
     * @throws NotSupportedLanguageException
     */
    public function getDocsUpdatedAt($lang, $version, $doc)
    {
        if ($lang == 'kr') {
            $owner = 'laravelkr';
            $branch = "kr-" . $version;
        } elseif ($lang == 'en') {
            $owner = 'laravel';
            $branch = $version;
        } else {
            throw new NotSupportedLanguageException();
        }


        $date = $this->commitInformation->getLastCommitDate($owner, "docs", $branch, $doc . '.md');

        return $date;

    }


}
