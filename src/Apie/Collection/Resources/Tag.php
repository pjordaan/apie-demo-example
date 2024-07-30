<?php

namespace App\Apie\Collection\Resources;

use Apie\Core\Attributes\HasRole;
use Apie\Core\Attributes\RemovalCheck;
use Apie\Core\Attributes\RuntimeCheck;
use App\Apie\Collection\Identifiers\TagIdentifier;

#[RemovalCheck(new RuntimeCheck(new HasRole('admin')))]
class Tag implements \Apie\Core\Entities\EntityInterface
{
    #[RuntimeCheck(new HasRole('admin'))]
    public function __construct(
        private TagIdentifier $id
    ) {
    }

    public function getId(): TagIdentifier
    {
        return $this->id;
    }
}
