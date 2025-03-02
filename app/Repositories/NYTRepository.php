<?php
namespace App\Repositories;

use App\Repositories\Contracts\NewsSourceInterface;
use Illuminate\Support\Facades\Http;

class NYTRepository implements NewsSourceInterface
{
    protected string $source ='https://api.nytimes.com/svc/search/v2/articlesearch.json';

    public function fetch(): array
    {
            $response = Http::get($this->source, [
                'api-key' => config('services.nyt.token'),
            ]);
            $newsData = $response->json();
            return $newsData['ok'] ?? $newsData['response']['docs'];

    }
}
