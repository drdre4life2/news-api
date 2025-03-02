<?php
namespace App\Repositories;

use App\Repositories\Contracts\NewsSourceInterface;
use Illuminate\Support\Facades\Http;

class GuardianRepository implements NewsSourceInterface
{
    protected string $source ='https://content.guardianapis.com/search';

    public function fetch(): array
    {
        $response = Http::get($this->source, [
            'api-key' => config('services.guardian.token'),
        ]);
        $newsData = $response->json();
        return $newsData['ok'] ?? $newsData['response']['results'];

    }
}
