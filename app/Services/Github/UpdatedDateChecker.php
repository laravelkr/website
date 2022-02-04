<?php
/**
 * Created by PhpStorm.
 * User: kkame
 * Date: 18. 10. 14
 * Time: 오전 1:03
 */

namespace App\Services\Github;


use App\Exceptions\CommitInformationNotFoundException;
use App\Exceptions\NotSupportedLanguageException;
use App\Services\Documents\UpdateDateInterface;


class UpdatedDateChecker implements UpdateDateInterface
{

    public function __construct(protected CommitInformation $commitInformation)
    {
    }

    /**
     * @param  string  $lang
     * @param  string  $version
     * @param  string  $doc
     * @return string
     * @throws NotSupportedLanguageException
     * @throws CommitInformationNotFoundException
     */
    public function getDocsUpdatedAt(string $lang, string $version, string $doc): string
    {
        if ($lang === 'kr') {
            $owner = 'laravelkr';
            $branch = "kr-".$version;
        } elseif ($lang === 'en') {
            $owner = 'laravel';
            $branch = $version;
        } else {
            throw new NotSupportedLanguageException();
        }


        $date = $this->commitInformation->getLastCommitDate($owner, "docs", $branch, $doc.'.md');

        return $date;
    }


}
