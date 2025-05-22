<?php

namespace JamesDevBR\BradescoSDK\Commands\Order;

use JamesDevBR\BradescoSDK\Commands\BaseCommand;
use Carbon\Carbon;

class ListTest extends BaseCommand
{
    protected $signature = 'bradesco:order:list-test {--days=5 : Number of days to subtract from the current date for the start date}';

    protected $description = 'Command to test listing orders using the Bradesco SDK.';

    public function handle()
    {
        $orderResource = $this->getBradesco()->orderResource();

        $days = $this->option('days');
        $startDate = Carbon::now()->subDays($days)->format('Y/m/d');

        $endDate = Carbon::now()->format('Y/m/d');

        $response = $orderResource->list($orderResource::BANKSLIP, $startDate, $endDate);

        if (!$response) {
            dd($orderResource->getErrorMessage());
        }

        dd($response);
    }
}
