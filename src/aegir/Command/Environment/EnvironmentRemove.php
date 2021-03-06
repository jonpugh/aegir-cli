<?php

namespace aegir\Command\Environment;

use Symfony\Component\Console\Input\InputOption;
use aegir\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use aegir\Factory\EnvironmentFactory;

class EnvironmentRemove extends Command
{
    protected function configure()
    {
        $this
        ->setName('environment:remove')
        ->setDescription('Removes an environment.')
        ->addArgument(
            'app_name',
            InputArgument::OPTIONAL,
            'The name the app to remove.'
        )
        ->addArgument(
            'environment_name',
            InputArgument::OPTIONAL,
            'The name the environment to remove.'
        )
        ;
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
      // Ask for an app and environment.
      $this->getApp($input, $output);
      $this->getEnvironment($input, $output);

        // Don't continue unless we have an environment.
        if (empty($this->environment)) {
            return;
        }
      $environment_name = $this->environment->name;
      $app_name = $this->app->name;
      $helper = $this->getHelper('question');

        // Confirm removal of the app.
        if (!$input->getOption('yes')) {
            $question = new ConfirmationQuestion("Are you sure you would like to remove the environment <question>$app_name:$environment_name</question>?  All files at {$this->environment->path} will be deleted, and all containers will be killed. [y/N] ", false);
        }
        else {
            $output->writeln("<info>Running with --yes flag. Skipping confirmation step.</info>");
        }
        if (!$input->getOption('yes') && !$helper->ask($input, $output, $question)) {
            $output->writeln('<error>Cancelled</error>');
            return;
        } else {
            // Remove the environment from config registry.
            // @TODO: Move this to EnvironmentFactory class

            // Remove files
            $fs = new Filesystem();

            try {
                $fs->remove(array(
                  $this->environment->path,
                ));
                $output->writeln("<info>Files for environment $app_name:$environment_name has been deleted.</info>");
            } catch (IOExceptionInterface $e) {
                $output->writeln('<error>Unable to remove '.$e->getPath().'</error>');
            }

            // Destroy the environment
            $environmentFactory = new EnvironmentFactory($this->environment, $this->app);
            $environmentFactory->destroy();

            unset($this->app->environments[$environment_name]);
            $this->getApplication()->getAegir()->getConfig()->add('apps', $app_name, (array) $this->app);
            $this->getApplication()->getAegir()->getConfig()->save();

            $output->writeln("<info>Environment $app_name:$environment_name has been removed.</info>");
        }
    }
}
