<?php

namespace Horoscope\Command;

use GuzzleHttp\Client;
use Horoscope\Fetcher\WirtualnaPolska;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HoroscopeWpCommand extends Command {

    private $timestamp; // date of birth unix timestamp

    /**
     *
     * @param int $timestamp Date of birth unix timestamp
     */
    public function __construct($timestamp = null) {
        $this->timestamp = $timestamp;
        parent::__construct();
    }

    protected function configure() {
        $this
            ->setName('horoscope:wp')
            ->setDescription('Shows current horoscope from the Wirtualna Polska')
        ;
        if ($this->timestamp) {
            $this->addArgument('birth', InputArgument::OPTIONAL, 'date of birth', date('j M Y', $this->timestamp));
        } else {
            $this->addArgument('birth', InputArgument::REQUIRED, 'date of birth');
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $horoscope = new WirtualnaPolska(new Client());
        $timestamp = strtotime($input->getArgument('birth'));
        $output->writeln($horoscope->getHoroscope($timestamp));

        return 0;
    }
}
