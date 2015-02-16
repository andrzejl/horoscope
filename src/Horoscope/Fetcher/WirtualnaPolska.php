<?php

namespace Horoscope\Fetcher;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class WirtualnaPolska {

    /* @var $client Client */
    private $client;

    public function __construct($client) {
        $this->client = $client;
    }

    /**
     *
     * @param int $timestamp date of birth unix timestamp
     */
    public function getHoroscope($timestamp) {

        $response = $this->client->post(
            'http://horoskop.wp.pl/',
            [
                'body' => [
                    '_action' => 'ShowHoroscope',
                    'hid' => '215',
                    'cid' => '1',
                    'lid' => '1',
                    'T[day]' => date('j', $timestamp),
                    'T[month]' => date('n', $timestamp),
                    'T[year]' => date('Y', $timestamp),
                ]
            ]
        );

        $crawler = new Crawler($response->getBody()->getContents());
        $title = $crawler->filter('.hor_desc .hor_name .c1');
        $contents = $crawler->filter('.hor_desc .hor_txt p');

        return sprintf(
            "<options=bold>%s</options=bold>\n%s",
            $title->text(),
            $contents->text()
        );
    }
}
