<?php

declare(strict_types=1);

namespace App\Security;

use App\ReadModel\User\UserFetcher;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements UserProviderInterface
{
    private $users;

    public function __construct(UserFetcher $users)
    {
        $this->users = $users;
    }

    public function loadUserByUsername(string $username): UserInterface
    {
        $user = $this->users->findForAuth($username);

        if (!$user) {
            throw new UsernameNotFoundException('');
        }

        return new UserIdentity($user->id, $user->email, $user->password_hash, $user->role, $user->status);
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        if (!$user instanceof UserIdentity) {
            throw new UnsupportedUserException('Invalid user class ' . \get_class($user));
        }

        return $user;
    }

    public function supportsClass(string $class): bool
    {
        return UserIdentity::class === $class;
    }
}
