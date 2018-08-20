<?php

namespace App\Console\Commands;

use App\TootFeed;
use Illuminate\Console\Command;

class ManageFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tooter:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage feeds';

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

        $id = $this->ask('Enter ID to delete, empty or n to cancel');

        if (!$id) $this->finish('Aborted');

        $feed = TootFeed::where('id', $id);

        if (!$feed) $this->finish('No feed found for #' . $id);

        return $this->finish($feed->delete() ? 'Feed Deleted' : 'Unable to delete, please try again');
    }

    private function finish(string $message)
    {
        $this->info($message);
        return;
    }
}
