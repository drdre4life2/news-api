<?php

namespace App\Console\Commands;

use App\Jobs\FetchNewsJob;
use Illuminate\Console\Command;

class FetchNewsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch news articles from multiple sources and store them in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Dispatching FetchNewsJob...');

        FetchNewsJob::dispatch('nyt');
        FetchNewsJob::dispatch('guardian');
        FetchNewsJob::dispatch('newsapi');

        $this->info('FetchNewsJob has been dispatched.');
    }
}
