<?php
namespace App\Apie\Collection\Actions;

use Apie\CommonValueObjects\Email;
use Apie\Core\Attributes\Context;
use Apie\Core\Attributes\Requires;
use Apie\Core\Attributes\StaticCheck;
use Apie\Core\Datalayers\ApieDatalayer;
use Apie\TextValueObjects\StrongPassword;
use App\Apie\Collection\Enums\UserRole;
use App\Apie\Collection\Resources\User;

final class AdminTools
{
    #[StaticCheck(new Requires('console'))]
    public static function createAdminUser(
        #[Context()]
        ApieDatalayer $datalayer,
        Email $email
    ): string {
        $password = StrongPassword::createRandom();
        $user = new User(
            $email,
            $password
        );
        $user->setRole(UserRole::Admin);
        $datalayer->persistNew($user);
        return 'Admin user created. Generated password' . PHP_EOL . $password->toNative();
    }
}