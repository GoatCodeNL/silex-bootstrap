<?php

namespace SilexBootstrap;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command
{

    protected function configure()
    {
        $this
                ->setName('init')
                ->setDescription('Setup basic structure for silex REST application')
                ->addArgument(
                        'modules', InputArgument::IS_ARRAY, 'What mudules do you want to prepare (separate multiple modules with a space)?'
        );
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $directories = [
            'public',
            'src',
            'app',
            'config'
        ];

        $filesToCopy = [
            'app/bootstrap.php',
            'app/app.php',
            'config/application.php',
            'public/.htaccess',
            'public/index.php',
        ];

        $filesToGenerate = [
        ];

        $commandsToExecute = [
        ];

        $output->writeln("Creating directories.");
        foreach ($directories as $directory) {
            if (file_exists($directory) === false) {
                mkdir($directory, 0775);
            }
        }

        $output->writeln("Copying files.");

        foreach ($filesToCopy as $file) {
            if (file_exists(dirname($file)) === false) {
                mkdir(dirname($file), 0755, true);
            }

            copy(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'files' . DIRECTORY_SEPARATOR . $file, $file);
        }

        $output->writeln("Init completed.");
    }

}
