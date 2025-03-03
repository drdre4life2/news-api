<?php

namespace Tests\Unit\Services;

use App\Services\NewsService;
use App\Repositories\NewsRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class NewsServiceTest extends TestCase
{
    protected NewsRepository $newsRepository;
    protected NewsService $newsService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->newsRepository = Mockery::mock(NewsRepository::class);
        $this->newsService = new NewsService($this->newsRepository);
    }

    public function test_get_news_fetches_from_repository_and_caches_result()
    {
        Cache::shouldReceive('remember')
            ->once()
            ->with(Mockery::type('string'), Mockery::any(), Mockery::on(function ($closure) {
                return is_callable($closure);
            }))
            ->andReturnUsing(function ($key, $time, $callback) {
                return $callback();
            });

        $filters = ['category' => 'Technology'];
        $paginatedData = new LengthAwarePaginator([], 0, 10);

        $this->newsRepository->shouldReceive('getAll')
            ->once()
            ->with($filters)
            ->andReturn($paginatedData);

        $result = $this->newsService->getNews($filters);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }
}
