<?php

namespace Tests\Unit\Jobs;

use App\Actions\NewsAction;
use App\Jobs\FetchNewsJob;
use App\Repositories\GuardianRepository;
use App\Repositories\NewsApiRepository;
use App\Repositories\NYTRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Mockery;
use Tests\TestCase;

class FetchNewsJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_handle_executes_news_action_for_nyt()
    {
        $newsMockData = [
            ['title' => 'Breaking News'],
            ['title' => 'Second News'],
        ];

        $nytRepositoryMock = Mockery::mock(NYTRepository::class);
        $nytRepositoryMock->shouldReceive('fetch')
            ->once()
            ->with([])
            ->andReturn($newsMockData);
        App::instance(NYTRepository::class, $nytRepositoryMock); // Bind mock to container

        $storeNewsMock = Mockery::mock(NewsAction::class);
        $storeNewsMock->shouldReceive('execute')
            ->once()
            ->with(Mockery::type('array'), 'nyt');

        $job = new FetchNewsJob('nyt');
        $job->handle($storeNewsMock);
    }

    public function test_handle_executes_news_action_for_guardian()
    {
        $newsMockData = [
            ['title' => 'Guardian Headline'],
            ['title' => 'Another Guardian News'],
        ];

        $guardianRepositoryMock = Mockery::mock(GuardianRepository::class);
        $guardianRepositoryMock->shouldReceive('fetch')
            ->once()
            ->with([])
            ->andReturn($newsMockData);
        App::instance(GuardianRepository::class, $guardianRepositoryMock); // Bind mock

        $storeNewsMock = Mockery::mock(NewsAction::class);
        $storeNewsMock->shouldReceive('execute')
            ->once()
            ->with(Mockery::type('array'), 'guardian');

        $job = new FetchNewsJob('guardian');
        $job->handle($storeNewsMock);
    }

    public function test_handle_executes_news_action_for_newsapi()
    {
        $newsMockData = [
            ['title' => 'API Headline'],
            ['title' => 'API Second News'],
        ];

        $newsApiRepositoryMock = Mockery::mock(NewsApiRepository::class);
        $newsApiRepositoryMock->shouldReceive('fetch')
            ->once()
            ->with([])
            ->andReturn($newsMockData);
        App::instance(NewsApiRepository::class, $newsApiRepositoryMock); // Bind mock

        $storeNewsMock = Mockery::mock(NewsAction::class);
        $storeNewsMock->shouldReceive('execute')
            ->once()
            ->with(Mockery::type('array'), 'newsapi');

        $job = new FetchNewsJob('newsapi');
        $job->handle($storeNewsMock);
    }

    public function test_handle_does_nothing_for_invalid_source()
    {
        $storeNewsMock = Mockery::mock(NewsAction::class);
        $storeNewsMock->shouldNotReceive('execute');

        $job = new FetchNewsJob('invalid_source');
        $job->handle($storeNewsMock);
    }
}
