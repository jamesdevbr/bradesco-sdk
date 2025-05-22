<?php

namespace JamesDevBR\BradescoSDK\Commands;

use JamesDevBR\BradescoSDK\Services\Bradesco;
use Illuminate\Console\Command;

abstract class BaseCommand extends Command
{
    protected function getBradesco(): Bradesco
    {
        return new Bradesco(
            config('bradesco.mode'),
            config("bradesco.merchant_id"),
            config("bradesco.security_key"),
            config("bradesco.email")
        );
    }
}
