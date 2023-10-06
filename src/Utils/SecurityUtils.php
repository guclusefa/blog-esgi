<?php

namespace App\Utils;

use App\Constants\UserConstants;
use Symfony\Bundle\SecurityBundle\Security;

class SecurityUtils
{
    public function __construct
    (
        private readonly Security $security
    )
    {
    }

    /**
     * Method to check if the user is already authenticated
     *
     * @return bool
     */
    public function isUserAuthenticated(): bool
    {
        return $this->security->isGranted('IS_AUTHENTICATED_FULLY');
    }

    /**
     * Method to check if the user is admin
     *
     * @return bool
     */
    public function isUserAdmin(): bool
    {
        return $this->security->isGranted(UserConstants::ROLE_ADMIN);
    }
}