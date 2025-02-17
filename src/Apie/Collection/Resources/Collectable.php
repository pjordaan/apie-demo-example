<?php

namespace App\Apie\Collection\Resources;

use Apie\Core\Attributes\AllowMultipart;
use Apie\Core\Attributes\HasRole;
use Apie\Core\Attributes\RuntimeCheck;
use Apie\Core\Attributes\StaticCheck;
use Apie\Core\Entities\EntityInterface;
use App\Apie\Collection\Identifiers\CollectableIdentifier;
use App\Apie\Collection\Lists\TagSet;
use App\Apie\Collection\ValueObjects\CollectableName;
use Psr\Http\Message\UploadedFileInterface;

#[AllowMultipart]
class Collectable implements EntityInterface
{
    #[RuntimeCheck(new HasRole('admin'))]
    public function __construct(
        private CollectableIdentifier $id,
        private CollectableName $name,
        private UploadedFileInterface $picture,
        private TagSet $tags
    ) {
    }

    public function getId(): CollectableIdentifier
    {
        return $this->id;
    }

    #[RuntimeCheck(new HasRole('admin'))]
    public function setName(CollectableName $name)
    {
        $this->name = $name;
    }

    public function getName(): CollectableName
    {
        return $this->name;
    }

    #[RuntimeCheck(new HasRole('admin'))]
    public function setTags(TagSet $tags)
    {
        $this->tags = $tags;
    }

    public function getTags(): TagSet
    {
        return $this->tags;
    }

    #[RuntimeCheck(new HasRole('admin'))]
    public function setPicture(UploadedFileInterface $picture)
    {
        $this->picture = $picture;
    }

    public function getPicture(): UploadedFileInterface
    {
        return $this->picture;
    }
}
