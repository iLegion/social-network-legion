<?php

namespace App\Http\Controllers\Api\BotMan;

use App\Http\Controllers\Controller;
use App\Services\BotMan\BotManService;
use BotMan\BotMan\BotMan;

class BotManController extends Controller
{
    public function __invoke()
    {
        $botMan = app('botman');

        $botMan->hears('(.*)', function (BotMan $botMan, $message) {

            $botMan->reply(
                (new BotManService())->hearMessage($message)
            );
        });

        $botMan->listen();
    }
}
