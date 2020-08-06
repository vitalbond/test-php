<?php

namespace App\Libraries\Parser;

use Symfony\Component\DomCrawler\Crawler;

class RbcParser extends BaseParser {
    const URL = 'https://www.rbc.ru/';

    public function parseIndexPage()
    {
        $html = $this->fetchUrl(self::URL);

        $crawler = new Crawler($html);

        $items = $crawler->filter('.js-news-feed-list a.news-feed__item');

        return $items->each(function (Crawler $node) {
            $url = $node->attr('href');
            $url = $this->normalizeUrl($url);

            return [
                'url' => $url,
                'source_id' => $this->getIdFromUrl($url),
            ];
        });
    }

    public function parseFullPage($url)
    {
        $html = $this->fetchUrl($url);

        $crawler = new Crawler($html);

        $h1 = $crawler->filter('.article__header__title')->first();
        $title = $h1 ? $h1->text() : '';

        $datetime = $crawler->filter('.article__header__date')->first()->attr('content');
        $date = str_replace('T', ' ', substr($datetime, 0, 19));

        $text = '';

        $announce = $crawler->filter('.article__text .article__text__overview span');
        if ($announce->count()) {
            $text .= '<p class="announce">' . $announce->text() . '</p>';
        }

        $text .= join("\n", $crawler->filter('.article__text > p')->each(function ($p) {
            return '<p>' . $p->text() . '</p>';
        }));

        $imageUrl = null;
        $image = $crawler->filter('.article__main-image__image');
        if ($image->count()) {
            $imageUrl = $image->first()->attr('src');
        }

        return [
            'title' => $title,
            'text' => $text,
            'datetime' => $datetime,
            'imageUrl' => $imageUrl,
        ];
    }

    public function normalizeUrl($url)
    {
        return preg_replace('#\?(.*)#', '', $url);
    }

    public function getIdFromUrl($url)
    {
        if (preg_match('#[0-9a-z]{20,}$#i', $url, $matches)) {
            return $matches[0];
        }
    }
}
