<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Reset\Reset;

class Command
{
    /**
     * @var string
     */
    public $token;
    /**
     * @var string
     */
    public $password;
}
