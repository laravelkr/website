<?php


namespace App\Services\AllContributors;


use Exception;

class EmojiConverter
{
    public function convert(string $string): string
    {
        return match ($string) {
            "question" => "💬",
            "bug" => "🐛",
            "blog" => "📝",
            "business" => "💼",
            "code" => "💻",
            "content" => "🖋",
            "doc" => "📖",
            "design" => "🎨",
            "examples" => "💡",
            "eventOrganizing" => "📋",
            "financial" => "💵",
            "fundingFinding" => "🔍",
            "ideas" => "🤔",
            "infra" => "🚇",
            "maintenance" => "🚧",
            "platform" => "📦",
            "plugin" => "🔌",
            "projectManagement" => "📆",
            "review" => "👀",
            "security" => "🛡️",
            "tool" => "🔧",
            "translation" => "🌍",
            "test" => "⚠️",
            "tutorial" => "✅",
            "talk" => "📢",
            "userTesting" => "📓",
            "video" => "📹",
            default => throw new Exception("지원하지 않는 항목입니다"),
        };
    }
}
