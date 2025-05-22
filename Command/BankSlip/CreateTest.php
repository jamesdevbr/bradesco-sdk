<?php

namespace JamesDevBR\BradescoSDK\Commands\BankSlip;

use JamesDevBR\BradescoSDK\Commands\BaseCommand;
use Carbon\Carbon;
use Faker\Factory;

class CreateTest extends BaseCommand
{
    protected $signature = 'bradesco:bankslip:create-test';

    protected $description = 'Creation of a test bank slip through Bradesco.';

    public function handle()
    {
        $bradesco = $this->getBradesco();

        $faker = Factory::create('en_US');

        $address = $bradesco->address()
            ->setZipCode('88303540')
            ->setNumber(rand(10, 99))
            ->setComplement('')
            ->setCity($faker->city)
            ->setState('SC')
            ->setNeighborhood($faker->streetAddress)
            ->setStreet($faker->streetAddress);

        $buyer = $bradesco->buyer()
            ->setName($faker->name)
            ->setDocument('54674371511')
            ->setIp($faker->ipv4)
            ->setUserAgent($faker->userAgent)
            ->setAddress($address);

        $price = (int)(rand(100, 999) / 10 * 100);

        $order = $bradesco->order()
            ->setNumber((int) date('YmdHms'))
            ->setValue($price)
            ->setDescription('Order Description Test');

        $bankSlip = $bradesco->bankSlip()
            ->setBeneficiaryName('Company Test')
            ->setWallet(26)
            ->setBankNumber('9' . date('mdHms'))
            ->setIssueDate(date('Y-m-d'))
            ->setDueDate(Carbon::now()->addDays(10)->format('Y-m-d'))
            ->setNominalValue($price)
            ->setHeaderMessage('')
            ->setRenderingType('2');

        $bankSlipResource = $bradesco->bankSlipResource();

        $response = $bankSlipResource->create($order, $buyer, $bankSlip);

        if (!$response) {
            $this->error($bankSlipResource->getErrorMessage());
            return 1;
        }

        dd($response);
    }
}
