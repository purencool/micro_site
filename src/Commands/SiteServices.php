<?php

namespace App\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Repository\Processes\Install;
use App\Repository\Processes\Update;
use App\Repository\Processes\LayoutCaches;

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
        $output->writeln(array_merge(
            [
              '',
              ' ==============================================================',
              ' Website Update.',
              ' =============================================================='
            ],
            LayoutCaches::destroy()['response'],
            Update::update()['response'],
            LayoutCaches::create($this->layoutEnvVariable)['response'],
            [
              ' ==============================================================',
              ''
            ]
        ));

        return Command::SUCCESS;

      case 'layout:reset':
        $output->writeln(array_merge(
            [
              '',
              ' ==============================================================',
              ' Layout Reset.',
              ' =============================================================='
            ],
            LayoutCaches::destroy()['response'],
            LayoutCaches::create($this->layoutEnvVariable)['response'],
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
            ' Reset layout cache          `./bin/console si:se layout:reset`',
            ' Update custom website             `./bin/console si:se update`',
          ]
        );
        break;
    }

    return Command::SUCCESS;
  }

}
