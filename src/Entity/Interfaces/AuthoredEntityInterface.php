<?php


namespace App\Entity\Interfaces;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Interface AuthoredEntityInterface
 * @package App\Entity\Interfaces
 */
interface AuthoredEntityInterface
{
    /**
     * @param UserInterface $user
     * @return AuthoredEntityInterface
     */
    public function setAuthor(UserInterface $user): AuthoredEntityInterface;
}