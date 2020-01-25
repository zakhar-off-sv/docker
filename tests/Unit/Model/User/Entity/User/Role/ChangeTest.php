<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity\User\Role;

use App\Model\User\Entity\User\Role;
use App\Tests\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;

class ChangeTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();

        $user->changeRole(Role::admin());

        self::assertFalse($user->getRole()->isUser());
        self::assertTrue($user->getRole()->isAdmin());
    }

    public function testAlready(): void
    {
        $user = (new UserBuilder())->viaEmail()->confirmed()->build();

        $user->changeRole(Role::admin());

        self::expectExceptionMessage('Role is already same.');
        $user->changeRole(Role::admin());
    }
}
