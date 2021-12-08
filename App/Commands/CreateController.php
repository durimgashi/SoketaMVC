<?php

namespace App\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateController extends Command {
    protected static $defaultName = 'make:controller';

    protected function configure(): void {
        $this->setHelp("This command helps you create a controller class!");
        $this->addArgument('controller-name',InputArgument::REQUIRED , 'Controller name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int {
        $controllerName = $input->getArgument('controller-name');

        if($this->checkExistingFile($controllerName)) {
            $output->writeln("<bg=red>Controller '" . $controllerName . "' already exists!</>");
            return Command::FAILURE;
        }

        $controllerTemplate = file_get_contents(__DIR__.'\Utils\ControllerTemplate.txt');
        $controllerTemplate = str_replace("##Controller##", $controllerName, $controllerTemplate);

        $newController = fopen(__DIR__."/../Controllers/".$controllerName."Controller.php", "w");

        if(fwrite($newController, $controllerTemplate)) {
            $output->writeln("<bg=green>Controller '" . $controllerName . "' created successfully!</>");
            shell_exec('cd ../../');
            shell_exec('composer update');
            return Command::SUCCESS;
        }

        return Command::FAILURE;
    }

    function checkExistingFile($name): bool {
        $dir = scandir(__DIR__."/../Controllers");
        return in_array($name.'Controller.php', $dir);
    }
}