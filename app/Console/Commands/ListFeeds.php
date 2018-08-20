<?php

namespace App\Console\Commands;

use App\TootFeed;
use Illuminate\Console\Command;

class ListFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tooter:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all feeds';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $feeds = TootFeed::all();

        $this->table(['id', 'url', 'output', 'latest'], $feeds);
    }
}
