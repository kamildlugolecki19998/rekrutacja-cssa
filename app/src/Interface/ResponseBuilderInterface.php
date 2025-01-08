<?php

namespace App\Interface;

interface ResponseBuilderInterface
{
    public function buildResponse(object $entity): DTOResponseInterface;
}
