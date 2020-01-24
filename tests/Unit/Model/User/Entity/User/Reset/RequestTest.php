<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity\User\Reset;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\ResetToken;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testSuccess(): void
    {
        $now = new \DateTimeImmutable();
        $token = new ResetToken('token', $now->modify('+ 1 day'));

        $user = $this->buildSignedUpUserByEmail();

        $user->requestPasswordReset($token, $now);

        self::assertNotNull($user->getResetToken());
    }

    public function testAlready(): void
    {
        $now = new \DateTimeImmutable();
        $token = new ResetToken('token', $now->modify('+ 1 day'));

        $user = $this->buildSignedUpUserByEmail();

        $user->requestPasswordReset($token, $now);
        $this->expectExceptionMessage('Resetting is already request.');
        $user->requestPasswordReset($token, $now);
    }

    public function testExpired(): void
    {
        $now = new \DateTimeImmutable();

        $user = $this->buildSignedUpUserByEmail();

        $token1 = new ResetToken('token', $now->modify('+ 1 day'));
        $user->requestPasswordReset($token1, $now);
        self::assertEquals($token1, $user->getResetToken());

        $token2 = new ResetToken('token', $now->modify('+ 3 day'));
        $user->requestPasswordReset($token2, $now->modify('+ 2 day'));
        self::assertEquals($token2, $user->getResetToken());
    }

    public function testWithoutEmail(): void
    {
        $now = new \DateTimeImmutable();
        $token = new ResetToken('token', $now->modify('+ 1 day'));

        $user = $this->buildSignedUpUserByNetwork();

        $this->expectExceptionMessage('Email is not specified.');
        $user->requestPasswordReset($token, $now);
    }

    private function buildSignedUpUserByEmail(): User
    {
        $user = User::signUpByEmail(
            Id::next(),
            new \DateTimeImmutable(),
            new Email('test@app.test'),
            'hash',
            'token'
        );
        $user->confirmSignUp();

        return $user;
    }

    private function buildSignedUpUserByNetwork(): User
    {
        return User::signUpByNetwork(
            Id::next(),
            new \DateTimeImmutable(),
            'vk',
            '0000001'
        );
    }
}
