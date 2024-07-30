<?php

namespace App\Apie\Collection\Resources;

use Apie\Core\Attributes\Context;
use Apie\Core\Attributes\HasRole;
use Apie\Core\Attributes\Internal;
use Apie\Core\Attributes\LoggedIn;
use Apie\Core\Attributes\RemovalCheck;
use Apie\Core\Attributes\RuntimeCheck;
use Apie\Core\Attributes\StaticCheck;
use Apie\Core\Entities\EntityInterface;
use Apie\Core\Lists\PermissionList;
use Apie\Core\Permissions\RequiresPermissionsInterface;
use App\Apie\Collection\Identifiers\CollectableIdentifier;
use App\Apie\Collection\Identifiers\CollectedRegistrationIdentifier;
use App\Apie\Collection\Identifiers\UserId;
use App\Apie\Collection\ValueObjects\CollectableAmount;

#[RuntimeCheck(new LoggedIn())]
#[RemovalCheck(new StaticCheck())]
#[RemovalCheck(new RuntimeCheck())]
class CollectedRegistration implements EntityInterface, RequiresPermissionsInterface
{
    private CollectedRegistrationIdentifier $id;

    private UserId $userId;

    public function __construct(
        #[Context('authenticated')]
        User $user,
        private CollectableIdentifier $collectable,
        private CollectableAmount $amount
    ) {
        $this->userId = $user->getId();
        $this->id = CollectedRegistrationIdentifier::createRandom();
    }

    public function setAmount(CollectableAmount $amount)
    {
        $this->amount = $amount;
    }

    public function getId(): CollectedRegistrationIdentifier
    {
        return $this->id;
    }

    #[RuntimeCheck(new HasRole('admin'))]
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getCollectable(): CollectableIdentifier
    {
        return $this->collectable;
    }

    public function getAmount(): CollectableAmount
    {
        return $this->amount;
    }

    #[Internal]
    public function getRequiredPermissions(): PermissionList
    {
        return new PermissionList(['user:' . $this->userId, 'admin']);
    }
}
