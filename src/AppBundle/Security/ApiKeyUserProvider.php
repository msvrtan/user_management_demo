<?php

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class ApiKeyUserProvider.
 */
class ApiKeyUserProvider implements UserProviderInterface
{
    /**
     * @param $apiKey
     *
     * @return bool|string
     */
    public function getUsernameForApiKey($apiKey)
    {
        // Look up the username based on the token in the database, via
        // an API call, or do something entirely different
        if ($apiKey === '123') {
            return 'admin';
        } elseif ($apiKey === '987') {
            return 'visitor';
        } else {
            return false;
        }
    }

    /**
     * @param string $username
     *
     * @return User
     */
    public function loadUserByUsername($username)
    {
        if ($username === 'admin') {
            $roles = ['ROLE_ADMIN'];
        } elseif ($username === 'visitor') {
            $roles = ['ROLE_USER'];
        } else {
            throw new \Exception('Cant find user');
        }

        return new User($username, null, $roles);
    }

    /**
     * @param UserInterface $user
     * @SuppressWarnings("PHPMD.UnusedFormalParameter")
     *
     * @return UserInterface|void
     */
    public function refreshUser(UserInterface $user)
    {
        // this is used for storing authentication in the session
        // but in this example, the token is sent in each request,
        // so authentication can be stateless. Throwing this exception
        // is proper to make things stateless
        throw new UnsupportedUserException();
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return 'Symfony\Component\Security\Core\User\User' === $class;
    }
}
