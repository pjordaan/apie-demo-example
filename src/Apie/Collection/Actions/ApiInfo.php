<?php

namespace App\Apie\Collection\Actions;

use App\Apie\Collection\Dtos\ApplicationInfo;

class ApiInfo
{
    public function __invoke(): ApplicationInfo
    {
        return new ApplicationInfo();
    }
}
