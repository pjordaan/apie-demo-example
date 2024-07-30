<?php

namespace App\Apie\Collection\Dtos;

use Apie\CommonValueObjects\FullName;
use Apie\Core\Dto\DtoInterface;
use Apie\Core\ValueObjects\DatabaseText;

class DtoExample implements DtoInterface
{
    public DatabaseText $description;

    public FullName $name;
}
