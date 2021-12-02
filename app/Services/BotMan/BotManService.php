<?php

namespace App\Services\BotMan;

use JetBrains\PhpStorm\Pure;

class BotManService
{
    #[Pure]
    public function hearMessage(string $message): string
    {
        if ($message === 'What is your name?') {
            return $this->returnBotName();
        }

        return "Sorry, I can't answer :(.";
    }

    public function returnBotName(): string
    {
        return 'My name is Legion BotMan.';
    }
}
