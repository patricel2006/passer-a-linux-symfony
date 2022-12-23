<?php

namespace App\Services;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;

class Tools
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function getUser(): ?User
    {
        $user = $this->security->getUser();
        return $user;
    }
}
