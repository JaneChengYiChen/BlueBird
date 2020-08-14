<?php

namespace App\Http\Controllers\BlueBird;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BlueBird\WhichBot;

class BlueBirdConstruct extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->whichBot = new WhichBot($this->request);
    }
}
