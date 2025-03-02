<?php

use App\Console\Commands\FetchNewsCommand;
use Illuminate\Support\Facades\Schedule;


Schedule::command(FetchNewsCommand::class)->hourly();

