<?php

namespace JamesDevBR\BradescoSDK\Commands\Order;

use JamesDevBR\BradescoSDK\Commands\BaseCommand;

class ListPaymentTest extends BaseCommand
{
    protected $signature = 'bradesco:order:list-payment-test {--days=5 : Number of days to subtract from the current date for the start date}';

    protected $description = 'Command to test listing payments for orders using the Bradesco SDK.';

    public function handle()
    {
        $orderResource = $this->getBradesco()->orderResource();

        $days = $this->option('days');
        $startDate = date('Y/m/d', strtotime("-$days days"));

        $endDate = date('Y/m/d');

        $response = $orderResource->listPayment($orderResource::BANKSLIP, $startDate, $endDate, 1, 1, 10);

        if (!$response) {
            dd($orderResource->getErrorMessage());
        }

        dd($response);
    }
}
