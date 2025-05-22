<?php

namespace JamesDevBR\BradescoSDK\Commands\Pix;

use JamesDevBR\BradescoSDK\Commands\BaseCommand;
use Faker\Factory;

class CreateTest extends BaseCommand
{
    protected $signature = 'bradescosdk:pix:create';

    protected $description = 'Creation of a test PIX through Bradesco SDK';

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
            ->setDescription('Testing PIX Order')
            ->setFormat(1)
            ->setExpiration(86400);

        $pixResource = $bradesco->pixResource();

        $response = $pixResource->create($order, $buyer);

        if (!$response) {
            $this->error($pixResource->getErrorMessage());
            return 1;
        }

        dd($response);
    }
}
