<?php

namespace App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Repository\Processes\Install;
use App\Repository\Processes\Update;



#[AsCommand(
    name: 'site:services',
    description: 'Provides and sets configuration for the sites services.',
    hidden: false,
    aliases: ['si:se']
  )]

/**
 * The AppServices class runs the following functionality,
 *  1. .
 *  2. . 
 *  3. .
 */
class SiteServices extends Command {

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

   $return = ['response' => 'Request is not valid']; 
   switch ($input->getArgument('request')) {
      case 'install':
        $return = Install::create();
        $output->writeln($return);
        return Command::SUCCESS;
      
      case 'update':
        $return = Update::update();
        $output->writeln($return);
        return Command::SUCCESS;

      default:
    $output->writeln([
      '',
      '=================================================',
      ' Services',
      '=================================================',
      ' Website installation command `si:se install`',
      ' Update custom site configuration `si:s e update`',
      '=================================================',
      '',
    ]);
        break;
    }


    return Command::SUCCESS;
  }

}
