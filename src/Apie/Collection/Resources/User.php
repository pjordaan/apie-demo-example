<?php
namespace App\Apie\Collection\Resources;

use Apie\Common\Interfaces\CheckLoginStatusInterface;
use Apie\Common\Interfaces\HasRolesInterface;
use Apie\CommonValueObjects\Email;
use Apie\Core\Attributes\HasRole;
use Apie\Core\Attributes\Internal;
use Apie\Core\Attributes\LoggedIn;
use Apie\Core\Attributes\RuntimeCheck;
use Apie\Core\Entities\EntityWithStatesInterface;
use Apie\Core\Lists\PermissionList;
use Apie\Core\Lists\StringList;
use Apie\Core\Permissions\PermissionInterface;
use Apie\Core\Permissions\RequiresPermissionsInterface;
use Apie\Serializer\Exceptions\ValidationException;
use Apie\Core\ValueObjects\DatabaseText;
use Apie\TextValueObjects\EncryptedPassword;
use Apie\TextValueObjects\StrongPassword;
use App\Apie\Collection\Enums\UserRole;
use App\Apie\Collection\Identifiers\UserId;
use LogicException;

#[RuntimeCheck(new LoggedIn())]
final class User implements EntityWithStatesInterface, CheckLoginStatusInterface, HasRolesInterface, PermissionInterface, RequiresPermissionsInterface
{
    private UserId $id;
    private EncryptedPassword $password;
    private ?DatabaseText $blockedReason = null;
    private UserRole $role = UserRole::Collector;

    #[RuntimeCheck(new HasRole('admin'))]
    public function __construct(
        private Email $email,
        StrongPassword $password
    ) {
        $this->id = UserId::fromNative($email);
        $this->password = EncryptedPassword::fromUnencryptedPassword($password);
    }

    public function getId(): UserId
    {
        return $this->id;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function isDisabled(): bool
    {
        return $this->blockedReason !== null;
    }

    #[RuntimeCheck(new HasRole('admin'))]
    public function getBlockedReason(): ?DatabaseText
    {
        return $this->blockedReason;
    }

    private function checkUnblocked(string $field): void
    {
        if ($this->blockedReason !== null) {
            throw ValidationException::createFromArray([
                $field => new LogicException('User "' . $this->email . '" is blocked!')
            ]);
        }
    }

    #[RuntimeCheck(new HasRole('admin'))]
    public function block(DatabaseText $blockedReason): User
    {
        $this->checkUnblocked('blockedReason');
        $this->blockedReason = $blockedReason;

        return $this;
    }

    #[RuntimeCheck(new HasRole('admin'))]
    public function unblock(): User
    {
        if ($this->blockedReason === null) {
            throw new LogicException('User "' . $this->email . '" is not blocked!');
        }
        $this->blockedReason = null;

        return $this;
    }

    #[Internal]
    public function provideAllowedMethods(): StringList
    {
        return new StringList(
            $this->isDisabled() ? ['unblock'] : ['block']
        );
    }

    #[RuntimeCheck(new HasRole('admin'))]
    public function verifyPassword(string $password): bool
    {
        $this->checkUnblocked('password');
        return $this->password->verifyUnencryptedPassword($password);
    }

    #[Internal]
    public function getRoles(): StringList
    {
        return new StringList([$this->role->value]);
    }

    #[Internal]
    public function getPermissionIdentifiers(): PermissionList
    {
        if ($this->role === UserRole::Admin) {
            return new PermissionList(['admin', 'user:' . $this->id]);
        }
        return new PermissionList(['user:' . $this->id]);
    }

    #[Internal]
    public function getRequiredPermissions(): PermissionList
    {
        return new PermissionList(['user:' . $this->id->toNative(), 'admin']);
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }

    #[RuntimeCheck(new HasRole('admin'))]
    public function setRole(UserRole $role): void
    {
        $this->role = $role;
    }
}
