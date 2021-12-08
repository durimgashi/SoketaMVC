<?php

require 'vendor/autoload.php';

use App\Commands\CreateController;
use App\Commands\CreateModel;
use Symfony\Component\Console\Application;

$application = new Application();

// ... register commands
$application->add(new CreateController());
$application->add(new CreateModel());


try {
    $application->run();
} catch (Exception $e) {
}