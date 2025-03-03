<?php

namespace Tests\Unit\DTOs;

use PHPUnit\Framework\TestCase;
use App\DTOs\NewsDTO;
use Carbon\Carbon;

class NewsDTOTest extends TestCase
{
    /**
     * Test extraction when all expected keys are provided (NYT source).
     */
    public function testFullDataExtractionForNYT()
    {
        $data = [
            'headline' => ['main' => 'Test Headline'],
            'lead_paragraph' => 'Test content from lead paragraph',
            'author' => 'John Doe',
            'subsection_name' => 'Sports',
            'webPublicationDate' => '2022-01-01T12:00:00Z',
            'source' => ['name' => 'The New York Times'],
            'web_url' => 'http://example.com/article',
            'multimedia' => [
                ['url' => 'http://example.com/image1.jpg']
            ]
        ];

        $newsDTO = new NewsDTO($data, 'nyt');

        $this->assertEquals('Test Headline', $newsDTO->title);
        $this->assertEquals('Test content from lead paragraph', $newsDTO->content);
        $this->assertEquals('John Doe', $newsDTO->author);
        $this->assertEquals('Sports', $newsDTO->category);
        $this->assertEquals(
            Carbon::parse('2022-01-01T12:00:00Z')->format('Y-m-d H:i:s'),
            $newsDTO->publishedAt
        );
        $this->assertEquals('The New York Times', $newsDTO->source);
        $this->assertEquals('http://example.com/article', $newsDTO->url);
        $this->assertEquals('http://example.com/image1.jpg', $newsDTO->imageUrl);
    }

    /**
     * Test extraction using fallback keys.
     * Here, no headline is given so the DTO should fall back to webTitle,
     * and similarly for other fields.
     */
    public function testFallbackExtraction()
    {
        $data = [
            'webTitle' => 'Fallback Web Title',
            'lead_paragraph' => 'Fallback content',
            'author' => 'Jane Smith',
            'sectionName' => 'News',
            'pub_date' => '2022-02-02T15:30:00Z',
            'source' => 'Fallback Source',
            'webUrl' => 'http://example.com/webtitle',
            'urlToImage' => 'http://example.com/newsapi-image.jpg'
        ];

        $newsDTO = new NewsDTO($data, 'newsapi');
        $this->assertEquals('Fallback Web Title', $newsDTO->title);
        $this->assertEquals('Fallback content', $newsDTO->content);
        $this->assertEquals('Jane Smith', $newsDTO->author);
        $this->assertEquals('News', $newsDTO->category);
        $this->assertEquals(
            Carbon::parse('2022-02-02T15:30:00Z')->format('Y-m-d H:i:s'),
            $newsDTO->publishedAt
        );
        $this->assertEquals('Fallback Source', $newsDTO->source);
        $this->assertEquals('http://example.com/webtitle', $newsDTO->url);
        $this->assertEquals('http://example.com/newsapi-image.jpg', $newsDTO->imageUrl);
    }

    /**
     * Test extraction of image URL for a newsapi source.
     */
    public function testNewsApiImageExtraction()
    {
        $data = [
            'title' => 'Test Title',
            'content' => 'Test Content',
            'urlToImage' => 'http://example.com/newsapi-image.jpg',
            'pub_date' => '2022-03-03T10:00:00Z',
            'source' => 'Some Source'
        ];

        $newsDTO = new NewsDTO($data, 'newsapi');
        $this->assertEquals('http://example.com/newsapi-image.jpg', $newsDTO->imageUrl);
    }

    /**
     * Test NYT image extraction when multimedia array is empty.
     */
    public function testNytImageExtractionWithEmptyMultimedia()
    {
        $data = [
            'headline' => ['main' => 'Test Headline'],
            'content' => 'Test Content',
            'webPublicationDate' => '2022-04-04T10:00:00Z',
            'source' => ['name' => 'NYT'],
            'web_url' => 'http://example.com/nyt',
            'multimedia' => [] // empty multimedia array
        ];
        $newsDTO = new NewsDTO($data, 'nyt');
        $this->assertEmpty($newsDTO->imageUrl);
    }

    /**
     * Test NYT image extraction when multimedia is not an array.
     */
    public function testNytImageExtractionWithInvalidMultimediaFormat()
    {
        $data = [
            'headline' => ['main' => 'Test Headline'],
            'content' => 'Test Content',
            'webPublicationDate' => '2022-05-05T10:00:00Z',
            'source' => ['name' => 'NYT'],
            'web_url' => 'http://example.com/nyt',
            'multimedia' => 'not an array'
        ];
        $newsDTO = new NewsDTO($data, 'nyt');
        $this->assertEmpty($newsDTO->imageUrl);
    }

}
