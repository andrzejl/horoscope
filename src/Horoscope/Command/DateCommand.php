<?php

namespace Horoscope\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DateCommand extends Command {

    protected function configure() {
        $this
            ->setName('date')
            ->setDescription('Set default date of birth')
            ->addArgument('birth', InputArgument::REQUIRED, 'date of birth');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $timestamp = strtotime($input->getArgument('birth'));
        file_put_contents(__DIR__.'/../../../.date', $timestamp);
        $output->writeln(sprintf('New date of birth: <options=bold>%s</options=bold>', date('j M Y', $timestamp)));
        $output->writeln('<fg=green>saved</fg=green>');

        return 0;
    }
}
