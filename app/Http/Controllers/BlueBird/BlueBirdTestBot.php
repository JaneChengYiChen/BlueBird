<?php

namespace App\Http\Controllers\BlueBird;

use Illuminate\Http\Request;
use LINE\LINEBot;
use Exception;
use App\Http\Controllers\BlueBird\WhichBot;
use App\Http\Controllers\BlueBird\StoryClass;

class BlueBirdTestBot extends BlueBirdConstruct
{
    public function testBot()
    {
        $signature = $this->whichBot->signature(WhichBot::TEST_BOT);
        $lineBot = $this->whichBot->bot();

        try {
            $events = $lineBot->parseEventRequest($this->request->getContent(), $signature);
            foreach ($events as $event) {
                $replyToken = $event->getReplyToken();
                $text = $event->getText();
                if ($text == '?') {
                    $storyClass = new StoryClass;
                    $stories = $storyClass->main();
                    $lineBot->replyMessage($replyToken, $stories);
                }
            }
        } catch (Exception $e) {
            Listening::log($e);
            return;
        }
        return;
    }
}
