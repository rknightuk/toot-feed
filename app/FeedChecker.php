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
            $uuid = (string) $item->guid ?? $item->link;

            if ($uuid === $postedBefore) break;

            $newItems->push([
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'uuid' => $uuid,
            ]);

            if (!$postedBefore) break;
        }

        if (!$newItems->count()) return;

        $latestItem = $newItems->first();
        $feed->setLatest($latestItem['uuid']);
        $feed->save();

        $newItems = $newItems->reverse();

        $newItems->each(function($item) use ($feed) {
            $this->post($item, $feed);
        });
    }

    private function post(array $item, TootFeed $feed)
    {
        $status = $this->outputGenerator->generate($item['title'], $item['link'], $feed->getOutput());

        $client = app(MastodonClient::class);

        $client->toot($status);
    }

}
