<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function log($message)
    {
        echo date('[Y-m-d H:i:s] ') . $message . PHP_EOL;
    }
}
