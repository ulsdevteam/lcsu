<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\ORM\TableRegistry;
use Cake\Console\ConsoleOptionParser;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Cake\Core\Configure;

/**
 * Simple console wrapper around Psy\Shell.
 */
class ExportCommand extends Command
{
    protected $imported_count = 0;
    protected $error_log;
    protected $error_log_filename;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Trays');
        $this->loadModel('Books');
        $this->error_log_filename = "logs/export_error_log-".date('Y-m-d_H-i-s').".txt";
    }

    /**
    * Command classes must implement an execute() method
    * that does the bulk of their work. This method is
    * called when a command is invoked
    * e.g. "bin/cake Export"
    */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $data = $this->export($args->getOption('test'));
        // Avoid ConsoleIo->out() output of trailing "\n" if no data
        if ($data) {
            // If data exists, remove the trailing newline because ConsoleIo->out() will make one for us.
            $data = rtrim($data, "\n");
            $io->out($data);
        }
    }

    /**
     * Export completed trays
     * @param $test boolean Is this a test run?  If so, don't mark the trays as exported
     */
    public function export($test)
    {
        $trays = $this->Trays->find('all')->contain(['Books'])->where(['Trays.status_id' => Configure::read('Completed')]);
        if ($trays) {
            $content = '';
            foreach ($trays as $tray) {
                foreach ($tray->books as $book) {
                    $content .= $tray->tray_barcode.' '.date('m/d/y', strtotime($tray->created))."\t".$book->book_barcode."\t".date('Y/m/d h:i:s', strtotime($tray->created))."\t".'pittlcsu'."\n";
                }
                if (!$test) {
                    $tray->status_id = Configure::read('Exported');
                    if (!$this->Trays->save($tray)) {
			$this->addErrorLog('Save of '.$tray->tray_barcode.' failed');
                    }
                }
            }
        }
 	return $content;
    }

    /**
     * Add error log method
     *
     * @param $msg string error message
     */
    protected function addErrorLog($msg)
    {
        if (!$this->error_log) {
            $this->error_log = fopen($this->error_log_filename, 'w');
        }
        fwrite($this->error_log, $msg);
	error_log($msg);
    }

    /**
     * Override the Option Parser
     * @return $parser ConsoleOptionParser
     */
    public function getOptionParser()
    {
	$parser = parent::getOptionParser();
        $parser->addOption('test', ['short' => 't', 'help' => 'Is this a test run?', 'boolean' => true]);
        return $parser;
    }
}
