<?php
namespace App\Actions;

use App\Models\News;
use App\DTOs\NewsDTO;
use Illuminate\Support\Facades\Log;

class NewsAction
{
    public function execute(array $articles, string $source): void
    {
       // dd($articles);
       // try {
            $newsData = [];
            foreach ($articles as $article) {
                $dto = new NewsDTO($article, $source);
                $newsData[] = [
                    'title' => $dto->title,
                    'content' => $dto->content,
                    'author' => $dto->author,
                    'category' => $dto->category,
                    'published_at' => $dto->publishedAt,
                    'source' => $dto->source,
                    'url' => $dto->url,
                    'image_url' => $dto->imageUrl,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
          //  dd($newsData);
            if (!empty($newsData)) {
                News::upsert(
                    $newsData,
                    ['title'],
                    ['content', 'author', 'category', 'published_at', 'source', 'url', 'image_url', 'updated_at']
                );
            }
//        } catch (\Throwable $exception) {
//            Log::error("Something went wrong: {$exception->getMessage()}");
//        }
    }
}
