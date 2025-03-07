<?php

namespace App\Repositories;

use App\Models\News;
use App\Repositories\Contracts\NewsRepositoryInterface;

class NewsRepository implements NewsRepositoryInterface
{
    public function getAll(array $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return News::query()
            ->when(!empty($filters['category']), fn($q) => $q->whereFullText('category', $filters['category']))
            ->when(!empty($filters['source']), fn($q) => $q->where('source', $filters['source']))
            ->when(!empty($filters['author']), fn($q) => $q->where('author', $filters['author']))
            ->when(!empty($filters['date']), fn($q) => $q->whereDate('published_at', $filters['date']))
            ->latest()
            ->paginate();
    }
}
