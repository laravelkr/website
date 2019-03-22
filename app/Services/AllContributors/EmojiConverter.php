<?php


namespace App\Services\AllContributors;


use Exception;

class EmojiConverter
{
    /**
     * @param string $string
     * @return string
     * @throws Exception
     */
    public function convert(string $string)
    {

        switch ($string) {

            case"question":
                return "💬";
            case"bug":
                return "🐛";
            case"blog":
                return "📝";
            case"business":
                return "💼";
            case"code":
                return "💻";
            case"content":
                return "🖋";
            case"doc":
                return "📖";
            case"design":
                return "🎨";
            case"examples":
                return "💡";
            case"eventOrganizing":
                return "📋";
            case"financial":
                return "💵";
            case"fundingFinding":
                return "🔍";
            case"ideas":
                return "🤔";
            case"infra":
                return "🚇";
            case"maintenance":
                return "🚧";
            case"platform":
                return "📦";
            case"plugin":
                return "🔌";
            case"projectManagement":
                return "📆";
            case"review":
                return "👀";
            case"security":
                return "🛡️";
            case"tool":
                return "🔧";
            case"translation":
                return "🌍";
            case"test":
                return "⚠️";
            case"tutorial":
                return "✅";
            case"talk":
                return "📢";
            case"userTesting":
                return "📓";
            case"video":
                return "📹";

            default:
                throw new Exception("지원하지 않는 항목입니다");

        }

    }
}