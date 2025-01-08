<?php

namespace App\Interface;

use Doctrine\Common\Collections\Collection;

interface ResponseCollectionBuilderInterface
{
    public function buildResponse(array|Collection $entity): array;
}

