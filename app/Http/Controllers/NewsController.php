<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Services\NewsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    protected NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['category', 'source', 'author', 'date']);
        $news = $this->newsService->getNews($filters);

        return response()->json([
            'data' => NewsResource::collection($news),
            'meta' => [
                'current_page' => $news->currentPage(),
                'total_pages' => $news->lastPage(),
                'total_items' => $news->total(),
                'per_page' => $news->perPage(),
            ],
        ]);
    }
}
