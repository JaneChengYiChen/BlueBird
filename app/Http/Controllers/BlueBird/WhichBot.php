<?php

namespace App\Http\Controllers\BlueBird;

use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\SignatureValidator;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Illuminate\Http\Request;

class WhichBot
{
    const ECHO_BOT = 'echoBot';
    const TEST_BOT = 'testBot';
    const STORY_BOT = 'storyBot';

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function signature($mode)
    {
        $this->mode = $mode;
        $this->init();

        $lineAccessToken = $this->lineAccessToken;
        $lineChannelSecret =  $this->lineChannelSecret;

        $signature = $this->request->headers->get(HTTPHeader::LINE_SIGNATURE);
        if (!SignatureValidator::validateSignature($this->request->getContent(), $lineChannelSecret, $signature)) {
            exit;
        }

        return $signature;
    }

    public function bot()
    {
        $httpClient = new CurlHTTPClient($this->lineAccessToken);
        $lineBot = new LINEBot($httpClient, ['channelSecret' => $this->lineChannelSecret]);
        
        return $lineBot;
    }

    private function init()
    {
        switch ($this->mode) {
            case WhichBot::ECHO_BOT:
                $this->lineAccessToken = env('line_channel_access_token');
                $this->lineChannelSecret = env('line_channel_secret');
                break;
            case WhichBot::TEST_BOT:
                $this->lineAccessToken = env('test_line_channel_access_token');
                $this->lineChannelSecret = env('test_line_channel_secret');
                break;
            case WhichBot::STORY_BOT:
                $this->lineAccessToken = env('story_line_channel_access_token');
                $this->lineChannelSecret = env('story_line_channel_secret');
                break;
            default:
                $this->lineAccessToken = null;
                $this->lineChannelSecret = null;
                break;
        }
    }
}
