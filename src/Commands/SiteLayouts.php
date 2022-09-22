<?php

namespace App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


#[AsCommand(
    name: 'site:layouts',
    description: 'Provides and sets configuration for the sites layout.',
    hidden: false,
    aliases: ['si:la']
  )]

/**
 * The Layouts class runs the following functionality,
 *  1. List of layouts Available to the website.
 *  2. Setting the websites layout using configuration. 
 *  3. Over ride the websites layout via the CLI.
 */
class SiteLayouts extends Command {

  /**
   * @inheritDoc
   * 
   * @return void
   */
  protected function configure(): void {
    $this
      ->addArgument('request', InputArgument::OPTIONAL, 'request default')
    ;
  }

  /**
   * @inheritDoc
   * 
   * @param InputInterface $input
   * @param OutputInterface $output
   * @return int
   */
  protected function execute(InputInterface $input, OutputInterface $output): int {

    $output->writeln([
      '',
      '=====================================',
      ' Layouts',
      '=====================================',
    ]);
    $output->writeln(' setting: ' . $input->getArgument('request'));
    $output->writeln([
      '=====================================',
      '',
    ]);
    return Command::SUCCESS;
  }

}
