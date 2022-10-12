<?php

namespace App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Repository\Processes\Install;
use App\Repository\Processes\Update;
use App\Repository\Processes\Caching;
use App\Repository\Processes\DataObjects;

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
   * 
   * @var type
   */
  private $layoutEnvVariable;

  /**
   * 
   * @param string $layoutEnvVariable
   */
  public function __construct(string $layoutEnvVariable) {
    parent::__construct();
    $this->layoutEnvVariable = $layoutEnvVariable;
  }

  /**
   * @inheritDoc
   * 
   * @return void
   */
  protected function configure(): void {
    $this
      ->addArgument('request', InputArgument::OPTIONAL, 'request default')
      ->addArgument('param', InputArgument::OPTIONAL, 'request parameter')
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

    switch ($input->getArgument('request')) {
      case 'install':
        $output->writeln(array_merge(
            [
              '',
              ' ==============================================================',
              ' Website Installation.',
              ' =============================================================='
            ],
            Install::create()['response'],
            [
              ' ==============================================================',
              ''
            ]
        ));

        return Command::SUCCESS;

      case 'update':
        $inputParam = $input->getArgument('param');
        if ($inputParam == '') {
          $output->writeln(
            [
              '',
              ' ==============================================================',
              ' Update didn\'t run.',
              ' ==============================================================',
              ' Update commands            `./bin/console si:se update {flag}`',
              '                                                   {test|prod}`',
              ' ==============================================================',
              ''
            ]
          );
          return Command::INVALID;
        }
        $output->writeln(array_merge(
            [
              '',
              ' ==============================================================',
              ' Website Update.',
              ' =============================================================='
            ],
            Update::update($this->layoutEnvVariable, $inputParam)['response'],
            Caching::create()['response'],
            [
              ' ==============================================================',
              ''
            ]
        ));

        return Command::SUCCESS;

      case 'object:request':
        $inputParam = $input->getArgument('param');
        if ($inputParam == '') {
          $output->writeln(
            [
              '',
              ' ==============================================================',
              ' Object request didn\'t run.',
              ' ==============================================================',
              ' Update commands  `./bin/console si:se object:request {object}`',
              ' ==============================================================',
              ''
            ]
          );
          return Command::INVALID;
        }
        $output->writeln(array_merge(
            [
              '',
              ' ==============================================================',
              ' Object requested.',
              ' =============================================================='
            ],
            DataObjects::consoleRequest($inputParam)['response'],
            [
              ' ==============================================================',
              ''
            ]
        ));

        return Command::SUCCESS;

      case 'caching':
        $output->writeln(array_merge(
            [
              '',
              ' ==============================================================',
              ' Layout Reset.',
              ' =============================================================='
            ],
            //Caching::destroy($inputParam)['response'],
            Caching::create()['response'],
            [
              ' ==============================================================',
              ''
            ]
        ));
        return Command::SUCCESS;

      default:
        $output->writeln(
          [
            '',
            ' ==============================================================',
            ' Services Offered By System.',
            ' ==============================================================',
            ' Website installation             `./bin/console si:se install`',
            ' Reset layout cache     `./bin/console si:se caching {options}`',
            '                                            {""|all|test|prod}`',
            ' Update custom website      `./bin/console si:se update {flag}`',
            '                                                   {test|prod}`',
            ' ==============================================================',
            ''
          ]
        );
        break;
    }

    return Command::SUCCESS;
  }

}
