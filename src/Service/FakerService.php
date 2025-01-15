<?php

namespace App\Service;

use Faker\Factory;
use Faker\Generator;

class FakerService
{
    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function getFaker(): Generator
    {
        return $this->faker;
    }
}
