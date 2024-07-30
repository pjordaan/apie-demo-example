<?php

namespace App\Apie\Collection\Identifiers;

use Apie\Core\Identifiers\Identifier;
use Apie\Core\Identifiers\IdentifierInterface;
use App\Apie\Collection\Resources\Tag;
use ReflectionClass;

class TagIdentifier extends Identifier implements IdentifierInterface
{
    public static function getReferenceFor(): ReflectionClass
    {
        return new ReflectionClass(Tag::class);
    }

    protected function convert(string $input): string
    {
        return strtolower($input);
    }
}
