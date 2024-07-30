<?php

namespace App\Apie\Collection\Identifiers;

use Apie\Core\Identifiers\IdentifierInterface;
use Apie\Core\Identifiers\UuidV4;
use App\Apie\Collection\Resources\CollectedRegistration;
use ReflectionClass;

class CollectedRegistrationIdentifier extends UuidV4 implements IdentifierInterface
{
    public static function getReferenceFor(): ReflectionClass
    {
        return new ReflectionClass(CollectedRegistration::class);
    }
}
