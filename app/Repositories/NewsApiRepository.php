<?php
namespace App\Repositories;

use App\Repositories\Contracts\NewsSourceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewsApiRepository implements NewsSourceInterface
{
    protected string $source ='https://newsapi.org/v2/everything';

    public function fetch(): array
    {
        $response = Http::get($this->source, [
            'q' => 'news',
            'from' => Carbon::today(),
            'apiKey' => config('services.news_api.token'),
        ]);
        $newsData = $response->json();
        return $newsData['status'] === 'ok' ? $newsData['articles'] : [];


    }
}
