<?php

namespace App\Console\Commands;

use App\TootFeed;
use Illuminate\Console\Command;

class AddFeed extends Command
{
    const DEFAULT_OUTPUT = '{{title}} {{url}}';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tooter:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a new feed';

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
        $feedUrl = $this->ask('Feed URL?');

        $this->info('Adding feed: ' . $feedUrl);

        $output = $this->ask('Toot output? Default: ' . self::DEFAULT_OUTPUT);

        if (!$output) $output = self::DEFAULT_OUTPUT;

        TootFeed::create([
            'url' => $feedUrl,
            'output' => $output,
        ]);

        $this->info('Added' . $feedUrl . ', tooting as ' . $output);
    }
}
