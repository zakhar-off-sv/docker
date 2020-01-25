<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\Role\Change;

class Command
{
    /**
     * @var string
     */
    public $id;
    /**
     * @var string
     */
    public $role;
}
