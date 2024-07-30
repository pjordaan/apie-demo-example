<?php
namespace App\Apie\Collection\Lists;

use Apie\Core\Identifiers\Identifier;
use Apie\Core\Lists\ItemSet;

final class TagSet extends ItemSet
{
    public function offsetGet(mixed $offset): Identifier
    {
        return parent::offsetGet($offset);
    }
}
