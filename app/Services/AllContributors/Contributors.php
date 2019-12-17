<?php

namespace App\Services\AllContributors;

use App\Services\AllContributors\TakeGitContributors;

class Contributors
{
    /**
     * @var EmojiConverter
     */
    protected $emojiConverter;

    protected $takeGitContributors;

    private $contributorDatas = [];

    public function __construct(
        EmojiConverter $emojiConverter,
        TakeGitContributors $takeGitContributors
    ) {
        $this->emojiConverter = $emojiConverter;
        $this->takeGitContributors = $takeGitContributors;
    }

    public function getHtml(): string
    {
        $gitContributors = $this->takeGitContributors->getDefaultData();

        $this->initializeContributorDatas($gitContributors);

        return $this->convertHtml();
    }

    private function initializeContributorDatas($gitContributors)
    {
        foreach ($gitContributors as $gitContributor) {
            array_map(
                [$this, 'settingContributors'],
                json_decode($gitContributor)->contributors
            );
        }
    }

    private function settingContributors($res): bool
    {
        $user_id = $res->login;

        if ($this->existsContributor($user_id)) {
            $this->contributorDatas[$user_id]->contributions =
                array_merge(
                    $this->contributorDatas[$user_id]->contributions,
                    $res->contributions
                );

            return false;
        }

        $this->contributorDatas[$user_id] = $res;
        return true;
    }

    private function existsContributor(string $user_id): bool
    {
        return key_exists($user_id, $this->contributorDatas);
    }

    private function convertHtml(): string
    {
        $return = "";

        foreach ($this->contributorDatas as $contributor) {
            $return .= "<div><a href=\"{$contributor->profile}\" target='_blank'><img src=\"{$contributor->avatar_url}\" width=\"100px;\" alt=\"{$contributor->name}\"><br><sub><b>{$contributor->name}</b></sub></a><br />";

            foreach ($contributor->contributions as $contribution) {
                $return .= "<span title='{$contribution}'>";
                $return .= $this->emojiConverter->convert($contribution);
                $return .= "</span>";
            }
            $return .= "</div>";
        }

        return $return;
    }
}
