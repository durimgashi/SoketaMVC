<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateModel extends Command {
    protected static $defaultName = 'make:model';

    protected function configure(): void {
        $this->setHelp("This command helps you create a model class!");
        $this->addArgument('model-name',InputArgument::REQUIRED , 'Model name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $modelName = $input->getArgument('model-name');

        if($this->checkExistingFile($modelName)) {
            $output->writeln("<bg=red>Model '" . $modelName . "' already exists!</>");
            return Command::FAILURE;
        }

        $modelTemplate = file_get_contents(__DIR__."\Utils\ModelTemplate.txt");
        $modelTemplate = str_replace("##Model##", $modelName, $modelTemplate);
        $modelTemplate = str_replace("##table##", strtolower($modelName), $modelTemplate);

        $newModel = fopen(__DIR__."/../Models/".$modelName."Model.php", "w");

        if (fwrite($newModel, $modelTemplate)) {
            $output->writeln("<bg=green>Model '" . $modelName . "' created successfully!</>");
            shell_exec('cd ../../');
            shell_exec('composer update');
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }

    function checkExistingFile($name): bool {
        $dir = scandir(__DIR__."/../Models");
        return in_array($name.'Model.php', $dir);
    }
}