<?php

namespace App;

use Feed;

class FeedChecker {

    /**
     * @var OutputGenerator
     */
    private $outputGenerator;

    public function __construct(OutputGenerator $outputGenerator)
    {
        $this->outputGenerator = $outputGenerator;
    }

    public function __invoke()
    {
        $test = [
            "title" => "Dark Matter Candidates",
              "link" => "https://xkcd.com/2035/",
              "guid" => "https://xkcd.com/2035/",
              "timestamp" => "1534737600",
        ];

        $this->post($test, TootFeed::first());
        return;

        $feeds = TootFeed::all();

        foreach ($feeds as $feed)
        {
            $this->run($feed);
        }
    }

    private function run(TootFeed $feed)
    {
        $postedBefore = $feed->getLatest();

        $rss = Feed::loadRss($feed->getUrl());

        $newItems = collect();

        foreach ($rss->item as $item)
        {
            if ($item->guid !== $postedBefore) {
                $newItems->push((array) $item);
            }
            if (!$postedBefore) break;
        }

        if (!$newItems->count()) return;

        $newItems = $newItems->reverse();

        $newItems->each(function($item) use ($feed) {
          $this->post($item, $feed);
        });
    }

    private function post(array $item, TootFeed $feed)
    {
        $status = $this->outputGenerator->generate($item['title'], $item['link'], $feed->getOutput());

        // TODO toot toot
    }

}
