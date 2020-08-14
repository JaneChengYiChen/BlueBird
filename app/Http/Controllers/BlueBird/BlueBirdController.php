<?php

namespace App\Http\Controllers\BlueBird;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LINE\LINEBot;
use Exception;
use App\Http\Controllers\BlueBird\WhichBot;

class BlueBirdController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->whichBot = new WhichBot($this->request);
    }

    public function echoBot()
    {
        $signature = $this->whichBot->signature(WhichBot::ECHO_BOT);
        $lineBot = $this->whichBot->bot();

        try {
            $events = $lineBot->parseEventRequest($this->request->getContent(), $signature);
            foreach ($events as $event) {
                $replyToken = $event->getReplyToken();
                $text = $event->getText();
                $lineBot->replyText($replyToken, $text);
            }
        } catch (Exception $e) {
            return;
        }
        return;
    }
}
