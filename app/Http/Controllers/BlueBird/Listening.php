<?php

namespace App\Http\Controllers\BlueBird;

use File;

class Listening
{
    public static function log($target)
    {
        $log_file_path = storage_path("logs/line.log");
        File::append($log_file_path, $target);
    }
}
