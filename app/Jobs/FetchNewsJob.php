<?php
namespace App\Jobs;

use App\Actions\NewsAction;
use App\Repositories\GuardianRepository;
use App\Repositories\NewsApiRepository;
use App\Repositories\NYTRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class FetchNewsJob implements ShouldQueue
{
    use Dispatchable;

    private string $source;

    public function __construct(string $source)
    {
        $this->source = $source;
    }

    public function handle(NewsAction $storeNews)
    {
        $repositoryMapping = [
            'nyt' => app(NYTRepository::class),
            'guardian' => app(GuardianRepository::class),
            'newsapi' => app(NewsApiRepository::class),
        ];

        if (!isset($repositoryMapping[$this->source])) {
            return;
        }
        $news = $repositoryMapping[$this->source]->fetch([]);
        $storeNews->execute($news, $this->source);
    }
}
