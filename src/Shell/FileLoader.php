<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\ORM\TableRegistry;

/**
 * Simple console wrapper around Psy\Shell.
 */
class FileLoaderCommand extends Command
{
    public function initialize()
    {
        parent::initialize();
        // $this->loadModel('Ranges');
        // $this->loadModel('Modules');
        // $this->loadModel('Shelves');
        // $this->loadModel('Trays');
        // $this->loadModel('Books');

        echo "initialize";
    }

    public function loadTest()
    {
        echo "load Test";
    }
}
