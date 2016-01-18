<?php


use Danack\Console\Application;
use Danack\Console\Output\BufferedOutput;
use Danack\Console\Command\Command;
use Danack\Console\Input\InputArgument;
use Auryn\Injector;

$autoloader = require_once realpath(__DIR__).'/../vendor/autoload.php';


$injectionParams = require_once __DIR__."/../src/injectionParams.php";

chdir(realpath(__DIR__));


$injector = new Injector();

\Intahwebz\Functions::load();
\Intahwebz\MBExtra\Functions::load();

require_once __DIR__."/../src/appFunctions.php";
require_once __DIR__."/../lib/Tier/tierFunctions.php";

Tier\addInjectionParams($injector, $injectionParams);

use Blog\GeneratedSourcePath;

//$path = new GeneratedSourcePath(__DIR__.'/../var/compile');

$injector->share(__DIR__.'/../var/compile');

$dbParams = array(
    ':host'     => MYSQL_SERVER,
    ':username' => MYSQL_USERNAME,
    ':password' => MYSQL_PASSWORD,
    ':port'     => MYSQL_PORT,
    ':socket'   => MYSQL_SOCKET_CONNECTION
);

$injector->define(
    'Intahwebz\DB\Connection',
    $dbParams
);


try {
    $application = createApplication();
}
catch(\Exception $e) {
    echo "Exception: ".$e->getMessage()."\n";
}

//Figure out what Command was requested.
try {
    $parsedCommand = $application->parseCommandLine();
}
catch(\Exception $e) {
    //@TODO change to just catch parseException when that's implemented 
    $output = new BufferedOutput();
    $application->renderException($e, $output);
    echo $output->fetch();
    exit(-1);
}

try {
    $input = $parsedCommand->getInput();
    foreach ($parsedCommand->getParams() as $key => $value) {
        $injector->defineParam($key, $value);
    }
    $injector->execute($parsedCommand->getCallable());
}
catch(\Exception $e) {
    echo "Unexpected exception of type ".get_class($e)." running imagick-demos: ".$e->getMessage().PHP_EOL;
    echo $e->getTraceAsString();
    exit(-2);
}



/**
 * Creates a console application with all of the commands attached.
 * @return Application
 */
function createApplication() {
//    $rpmCommand = new Command('rpmdir', ['Bastion\RPMProcess', 'packageSingleDirectory']);
//    $rpmCommand->addArgument('directory', InputArgument::REQUIRED, "The directory containing the composer'd project to build into an RPM.");
////$uploadCommand->addOption('dir', null, InputArgument::OPTIONAL, 'Which directory to upload from', './');
//    $rpmCommand->setDescription("Build an RPM from an directory that contains all the files of a project. Allows for faster testing than having to re-tag, and download zip files repeatedly.");

//    $statsCommand = new Command('statsRunner', 'Stats\SimpleStats::run');
//    $statsCommand->setDescription("Run the stats collector and send the results to Librato.");
//
//    $taskCommand = new Command('imageRunner', 'ImagickDemo\Queue\ImagickTaskRunner::run');
//    $taskCommand->setDescription("Pull image request jobs off the queue and generated the images.");
//
//    
//    $clearCacheCommand = new Command('clearCache', 'ImagickDemo\Config\APCCacheEnvReader::clearCache');
//    $clearCacheCommand->setDescription("Clear the apc cache.");

    $envWriteCommand = new Command('genEnvSettings', 'Blog\Config\EnvConfWriter::writeEnvFile');
    $envWriteCommand->setDescription("Write an env setting bash script.");
    $envWriteCommand->addArgument('env', InputArgument::REQUIRED, 'Which environment the settings should be generated for.');
    $envWriteCommand->addArgument('filename', InputArgument::REQUIRED, 'The file name that the env settings should be written to.');

    
    $upgradeCommand = new Command('upgrade', ['Blog\Tool\Upgrade', 'main']);
    $upgradeCommand->setDescription('Upgrade the database to the latest defined schema');
    
    
//    $clearRedisCommand = new Command('clearRedis', 'ImagickDemo\Queue\ImagickTaskQueue::clearStatusQueue');
//    $clearRedisCommand->setDescription("Clear the imagick task queue."); 

    $console = new Application("Blog", "1.0.0");
//    $console->add($statsCommand);
//    $console->add($taskCommand);
//    $console->add($clearCacheCommand);
//    $console->add($clearRedisCommand);
    $console->add($envWriteCommand);
    $console->add($upgradeCommand);

    return $console;
}