<?php

namespace App\Services;

use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\Cache;

class NewsService
{
    protected NewsRepository $newsRepository;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getNews(array $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $cacheKey = 'news_' . md5(json_encode($filters));

        return Cache::remember($cacheKey, now()->addMinutes(62), function () use ($filters) {
            return $this->newsRepository->getAll($filters);
        });
    }
}
