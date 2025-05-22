<?php

namespace JamesDevBR\BradescoSDK\Commands\Order;

use JamesDevBR\BradescoSDK\Commands\BaseCommand;

class GetOrderByIdTest extends BaseCommand
{
    protected $signature = 'bradesco:order:getbyid {id}';

    protected $description = 'Returns the order registered with Bradesco.';

    public function handle()
    {
        $id = $this->argument('id');

        if (!$id) {
            $id = $this->ask('Enter the Order ID:');
        }

        if (!$id) {
            $this->error('ID not provided.');

            return;
        }

        $orderResource = $this->getBradesco()->orderResource();

        $response = $orderResource->getById($id);

        if (!$response) {
            dd($orderResource->getErrorMessage());
        }

        dd($response);
    }
}
