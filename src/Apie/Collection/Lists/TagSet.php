<?php
namespace App\Apie\Collection\Lists;

use Apie\Core\Lists\ItemSet;
use App\Apie\Collection\Identifiers\TagIdentifier;

final class TagSet extends ItemSet
{
    public function offsetGet(mixed $offset): TagIdentifier
    {
        return parent::offsetGet($offset);
    }
}