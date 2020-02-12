<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    public function testGuest(): void
    {
        $client = static ::createClient();
        $client->request('GET', '/');
    }

    public function testSuccess(): void
    {

    }
}
