<?php

namespace App\Console\Commands;

use App\FeedChecker;
use Illuminate\Console\Command;

class CheckFeeds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tooter:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check feeds for new items';
    /**
     * @var FeedChecker
     */
    private $feedChecker;

    /**
     * Create a new command instance.
     *
     * @param FeedChecker $feedChecker
     */
    public function __construct(FeedChecker $feedChecker)
    {
        parent::__construct();
        $this->feedChecker = $feedChecker;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->feedChecker->__invoke();
    }
}
