<?php

namespace App\Http\Controllers\BlueBird;

use Illuminate\Http\Request;
use LINE\LINEBot;
use Exception;
use App\Http\Controllers\BlueBird\WhichBot;

class BlueBirdTestBot extends BlueBirdConstruct
{
    public function testBot()
    {
        $signature = $this->whichBot->signature(WhichBot::TEST_BOT);
        $lineBot = $this->whichBot->bot();

        try {
            $events = $lineBot->parseEventRequest($this->request->getContent(), $signature);
            Listening::log($this->request->getContent());
            foreach ($events as $event) {
                $replyToken = $event->getReplyToken();
                $text = $event->getText();
                $lineBot->replyText($replyToken, $text);
            }
        } catch (Exception $e) {
            Listening::log($e);
            return;
        }
        return;
    }
}
