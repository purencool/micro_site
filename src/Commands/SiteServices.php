<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Repository\Processes\Install;
use App\Repository\Processes\Update;
use App\Repository\Processes\Caching;
use App\Repository\Processes\DataObjects;
use App\Repository\Processes\ContentDeploy;
use App\Repository\Processes\RouteCreation;
use App\Repository\Processes\DataObjectsList;
use App\Repository\Processes\LayoutCreation;


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
      ->addArgument('param_one', InputArgument::OPTIONAL, 'request parameter')
      ->addArgument('param_two', InputArgument::OPTIONAL, 'request parameter')
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
              ' Website installation.',
              ' =============================================================='
            ],
            Install::create()['response'],
            [
              ''
            ]
        ));

        return Command::SUCCESS;

      case 'update':
        $inputParam = $input->getArgument('param_one');
        if ($inputParam == '') {
          $output->writeln(
            [
              '',
              ' Update didn\'t run.',
              ' ==============================================================',
              ' Update commands            `./bin/console si:se update {flag}`',
              '                                                   {test|prod}`',
              ''
            ]
          );
          return Command::INVALID;
        }
        $output->writeln(array_merge(
            [
              '',
              ' Website update.',
              ' =============================================================='
            ],
            Update::update($this->layoutEnvVariable, $inputParam)['response'],
            Caching::create()['response'],
            LayoutCreation::create()['response'],
            RouteCreation::create()['response'],
            [
              ''
            ]
        ));

        return Command::SUCCESS;

      case 'data:object':
        $inputParamOne = $input->getArgument('param_one');
        if ($inputParamOne == '') {
          $output->writeln(
            [
              '',
              ' Data object request didn\'t run.',
              ' ==============================================================',
              ' `./bin/console si:se data:object {object} {environment}`      ',
              ''
            ]
          );
          return Command::INVALID;
        }
        $inputParamTwo = $input->getArgument('param_two');
        if ($inputParamTwo == '') {
          $inputParamTwo = 'test';
        }
        $output->writeln(array_merge(
            [
              '',
              ' Data object requested.',
              ' =============================================================='
            ],
            DataObjects::consoleRequest($inputParamOne, $inputParamTwo)['response'],
            [
              ''
            ]
        ));

        return Command::SUCCESS;

      case 'data:object:list':
        $inputParamOne = $input->getArgument('param_one');
        if ($inputParamOne == '') {
          $output->writeln(
            [
              '',
              ' Data objects list request didn\'t run.',
              ' ==============================================================',
              ' `./bin/console si:se data:object:list {object} {environment}` ',
              ''
            ]
          );
          return Command::INVALID;
        }
        $inputParamTwo = $input->getArgument('param_two');
        if ($inputParamTwo == '') {
          $inputParamTwo = 'test';
        }
        $output->writeln(array_merge(
            [
              '',
              ' Data objects list requested.',
              ' =============================================================='
            ],
            DataObjectsList::consoleRequest($inputParamOne, $inputParamTwo)['response'],
            [
              ''
            ]
        ));

        return Command::SUCCESS;

      case 'caching':
        $output->writeln(array_merge(
            [
              '',
              ' Layout reset.',
              ' =============================================================='
            ],
            //Caching::destroy($inputParam)['response'],
            Caching::create()['response'],
            [
              ''
            ]
        ));
        return Command::SUCCESS;

      case 'content:deploy':
        $output->writeln(array_merge(
            [
              '',
              ' Content deploy.',
              ' =============================================================='
            ],
            ContentDeploy::deploy()['response'],
            [
              ''
            ]
        ));
        return Command::SUCCESS;

      case 'route:creation':
        $output->writeln(array_merge(
            [
              '',
              ' Route creation.',
              ' =============================================================='
            ],
            RouteCreation::create()['response'],
            [
              ''
            ]
        ));
        return Command::SUCCESS;

      default:
        $output->writeln(
          [
            '',
            ' Services offered by system.',
            ' ==================================================================================',
            ' Reset layout cache                     ./bin/console si:se caching {all|test|prod}',
            ' Content Deploy                                  ./bin/console si:se content:deploy',
            ' Data object request    ./bin/console si:se data:object {data obj} {test|prod|cont}',
            ' Data objects list ./bin/console si:se data:object:list {data obj} {test|prod|cont}',
            ' Update custom website                       ./bin/console si:se update {test|prod}',
            ' Website installation                                   ./bin/console si:se install',
            ''
          ]
        );
        break;
    }

    return Command::SUCCESS;
  }

}
