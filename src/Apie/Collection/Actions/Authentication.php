<?php

namespace App\Apie\Collection\Actions;

use Apie\Common\ApieFacade;
use Apie\Core\Attributes\Not;
use Apie\Core\Attributes\Requires;
use Apie\Core\Attributes\RuntimeCheck;
use Apie\Core\BoundedContext\BoundedContextId;
use Apie\Core\Exceptions\EntityNotFoundException;
use App\Apie\Collection\Identifiers\UserId;
use App\Apie\Collection\Resources\User;

class Authentication
{
    public function __construct(private readonly ApieFacade $apie)
    {
    }

    #[RuntimeCheck(new Not(new Requires('authenticated')))]
    public function verifyAuthentication(UserId $username, string $password): ?User
    {
        try {
            $user = $this->apie->find($username, new BoundedContextId('collection'));
        } catch (EntityNotFoundException) {
            return null;
        }
        if ($user instanceof User && !$user->isDisabled()) {
            return $user->verifyPassword($password) ? $user : null;
        }
        

        return null; // @phpstan-ignore-line
    }
}
