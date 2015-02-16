<?php

namespace Horoscope;

use Horoscope\Command\DateCommand;
use Horoscope\Command\HoroscopeWpCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class ConsoleApplication extends Application {

    public function __construct() {
        parent::__construct("Horoscope", "1.0");

        $finder = new Finder();
        $finder
            ->files()
            ->in(__DIR__.'/../../../')
            ->ignoreDotFiles(false)
            ->name('.date')
        ;

        $timestamp = null;
        foreach ($finder as $file) {
            /* @var $file SplFileInfo */
            $timestamp = intval($file->getContents());
            break;
        }

        $this->add(new DateCommand());
        $this->add(new HoroscopeWpCommand($timestamp));
    }

}
