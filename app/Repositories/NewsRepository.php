<?php

namespace App\Repositories;

use App\Models\News;
use App\Repositories\Contracts\NewsRepositoryInterface;

class NewsRepository implements NewsRepositoryInterface
{
    public function getAll(array $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = News::query();

        if (!empty($filters['category'])) {
            $query->whereFullText('category', $filters['category']);
        }

        if (!empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }

        if (!empty($filters['author'])) {
            $query->where('author', $filters['author']);
        }

        if (!empty($filters['date'])) {
            $query->whereDate('published_at', $filters['date']);
        }

        return $query->latest()->paginate();
    }
}
