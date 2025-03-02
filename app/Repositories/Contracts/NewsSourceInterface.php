<?php
namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface NewsSourceInterface
{
    public function fetch(): array;
}
