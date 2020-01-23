<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity\User\SignUp;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class ConfirmTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->buildSignedUpUser();

        $user->confirmSignUp();

        self::assertTrue($user->isActive());
        self::assertFalse($user->isWait());

        self::assertNull($user->getConfirmToken());
    }

    public function testAlready(): void
    {
        $user = $this->buildSignedUpUser();

        $user->confirmSignUp();
        $this->expectExceptionMessage('User is already confirmed.');
        $user->confirmSignUp();
    }

    private function buildSignedUpUser(): User
    {
        return User::signUpByEmail(
            $id = Id::next(),
            $date = new \DateTimeImmutable(),
            $email = new Email('test@app.test'),
            $hash = 'hash',
            $token = 'token'
        );
    }
}
