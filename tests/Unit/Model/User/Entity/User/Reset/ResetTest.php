<?php

declare(strict_types=1);

namespace App\Tests\Unit\Model\User\Entity\User\Reset;

use App\Model\User\Entity\User\Email;
use App\Model\User\Entity\User\Id;
use App\Model\User\Entity\User\ResetToken;
use App\Model\User\Entity\User\User;
use PHPUnit\Framework\TestCase;

class ResetTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = $this->buildSignedUpUserByEmail();

        $now = new \DateTimeImmutable();
        $token = new ResetToken('token', $now->modify('+ 1 day'));

        $user->requestPasswordReset($token, $now);

        self::assertNotNull($user->getResetToken());

        $user->passwordReset($now, $hash = 'hash');

        self::assertNull($user->getResetToken());
        self::assertEquals($hash, $user->getPasswordHash());
    }

    public function testExpiredToken(): void
    {
        $user = $this->buildSignedUpUserByEmail();

        $now = new \DateTimeImmutable();
        $token = new ResetToken('token', $now);

        $user->requestPasswordReset($token, $now);

        self::expectExceptionMessage('Reset token is expired.');
        $user->passwordReset($now->modify('+ 1 day'), 'hash');
    }

    public function testNotRequested(): void
    {
        $user = $this->buildSignedUpUserByEmail();

        $now = new \DateTimeImmutable();

        self::expectExceptionMessage('Resetting is not requested.');
        $user->passwordReset($now, 'hash');
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
}
