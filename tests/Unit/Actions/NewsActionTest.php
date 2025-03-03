<?php
namespace Tests\Unit\Actions;

use App\Actions\NewsAction;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_inserts_news_articles()
    {
        $articles = [
            [
                'title' => 'Breaking News',
                'content' => 'This is a breaking news article.',
                'author' => 'John Doe',
                'category' => 'uncategorized',
                'published_at' => now()->subDay()->toDateTimeString(),
                'source' => 'CNN',
                'url' => 'https://example.com/news1',
                'image_url' => 'https://example.com/image1.jpg',
            ],
        ];

        $action = new NewsAction();
        $action->execute($articles, 'CNN');

        $this->assertDatabaseHas('news', [
            'title' => 'Breaking News',
            'content' => 'This is a breaking news article.',
            'author' => 'John Doe',
            'category' => 'uncategorized',
        ]);
    }

    public function test_it_updates_existing_news_article()
    {
        News::create([
            'title' => 'Breaking News',
            'content' => 'Old content',
            'author' => 'John Doe',
            'category' => 'World',
            'published_at' => now()->subDay()->toDateTimeString(),
            'source' => 'CNN',
            'url' => 'https://example.com/news1',
            'image_url' => 'https://example.com/image1.jpg',
        ]);

        $articles = [
            [
                'title' => 'Breaking News',
                'content' => 'Updated breaking news content.',
                'author' => 'John Doe',
                'category' => 'World',
                'published_at' => now()->toDateTimeString(),
                'source' => 'CNN',
                'url' => 'https://example.com/news1',
                'image_url' => 'https://example.com/image1.jpg',
            ],
        ];

        $action = new NewsAction();
        $action->execute($articles, 'CNN');

        $this->assertDatabaseHas('news', [
            'title' => 'Breaking News',
            'content' => 'Updated breaking news content.',
        ]);
    }

}
