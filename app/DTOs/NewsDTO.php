<?php

namespace App\DTOs;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class NewsDTO
{
    public string $title;
    public string $content;
    public string $author;
    public string $category;
    public string $publishedAt;
    public string $source;
    public string $url;
    public string $imageUrl;

    public function __construct(array $data, string $source)
    {
        $this->title = $this->extractTitle($data);
        $this->content = $this->extractContent($data);
        $this->author = $data['author'] ?? 'Unknown';
        $this->category = $this->extractCategory($data);
        $this->publishedAt = $this->extractPublishedAt($data);
        $this->source = $this->extractSource($data);
        $this->url = $this->extractUrl($data);
        $this->imageUrl = $this->extractImageUrl($data, $source);
    }

    private function extractTitle(array $data): string
    {
        return $data['headline']['main']
            ?? $data['webTitle']
            ?? $data['title']
            ?? 'No title';
    }

    private function extractContent(array $data): string
    {
        return $data['lead_paragraph']
            ?? $data['content']
            ?? 'No content';
    }

    private function extractCategory(array $data): string
    {
        return $data['subsection_name']
            ?? $data['sectionName']
            ?? 'General';
    }

    private function extractPublishedAt(array $data): string
    {
        $date = $data['webPublicationDate']
            ?? $data['pub_date']
            ?? $data['publishedAt']
            ?? null;

        return $date ? Carbon::parse($date)->format('Y-m-d H:i:s') : Carbon::now()->format('Y-m-d H:i:s');
    }

    private function extractSource(array $data): string
    {
        return $data['source']['name']
            ?? $data['source']
            ?? 'Unknown Source';
    }

    private function extractUrl(array $data): string
    {
        return $data['web_url']
            ?? $data['webUrl']
            ?? $data['url']
            ?? '';
    }

    private function extractImageUrl(array $data, string $source): string
    {
        $extractors = [
            'nyt' => fn($data) => $this->extractNytImageUrl($data),
            'guardian' => null,
            'newsapi' => fn($data) => $data['urlToImage'] ?? '',
        ];
Log::info($source);
        return isset($extractors[$source]) ? $extractors[$source]($data) : '';
    }


    private function extractNytImageUrl($data):string
    {
        $imageUrl = null;
        if (!empty($data['multimedia']) && is_array($data['multimedia'])) {
            foreach ($data['multimedia'] as $media) {
                if (isset($media['url'])) {
                    $imageUrl = $media['url'];
                    break;
                }
            }
        }
        return $imageUrl;

    }
}
