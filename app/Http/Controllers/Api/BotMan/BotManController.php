<?php

namespace App\Http\Controllers\Api\BotMan;

use App\Http\Controllers\Controller;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Web\WebDriver;

class BotManController extends Controller
{
    public function __invoke()
    {
        $botMan = app('botman');

        $botMan->hears('{message}', function (BotMan $botMan, $message) {
            $botMan->reply('Test');
        });

        $botMan->listen();
    }
}
