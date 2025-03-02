<?php

namespace App\Repositories\Contracts;

interface NewsRepositoryInterface
{
    public function getAll(array $filters = []): mixed;

}
