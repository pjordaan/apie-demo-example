<?php

namespace App\Apie\Collection\Identifiers;

use Apie\Core\Identifiers\Identifier;
use Apie\Core\Identifiers\IdentifierInterface;
use App\Apie\Collection\Resources\Collectable;
use ReflectionClass;

class CollectableIdentifier extends Identifier implements IdentifierInterface
{
    public static function getReferenceFor(): ReflectionClass
    {
        return new ReflectionClass(Collectable::class);
    }
}
