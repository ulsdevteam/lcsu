<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\ORM\TableRegistry;
use Cake\Console\ConsoleOptionParser;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Simple console wrapper around Psy\Shell.
 */
class FileLoaderCommand extends Command
{
    protected $imported_count = 0;
    protected $error_log;
    protected $error_log_filename;

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Trays');
        $this->loadModel('Books');
        $this->loadModel('Ranges');
        $this->loadModel('Modules');
        $this->loadModel('Shelves');
        $this->loadModel('Traysizes');
        $this->error_log_filename = "errors/error_log-".date('Y-m-d_H-i-s').".txt";
        echo "initialize\n";
    }

    /**
    * Command classes must implement an execute() method
    * that does the bulk of their work. This method is
    * called when a command is invoked
    * sudo su apache -s/bin/bash -c "bin/cake FileLoader -t ew"
    */
    public function execute(Arguments $args, ConsoleIo $io)
    {
        $input = $args->getArgument('file_name');
        if ($args->getOption('shelves')) {
            $this->loadShelves($input, $io);
        } else if ($args->getOption('trays')) {
            $this->loadTrays($input, $io);
        }
    }

    /**
    * @param $row row in *.csv Shelfaddr, shelf_height, tray_size
    * @param $segs "R01-M02-S03" split by '-' as an arry ["R01", "M02", "S03"]
    *  e.g. sudo su apache -s/bin/bash -c "bin/cake FileLoader -s sample_shelves.csv"
    */
    public function loadShelves($input, $io)
    {
        $ranges  = [];
        $modules = [];
        $result = $this->Ranges->find();
        foreach ($result as $row) {
            $ranges[$row->range_title] = $row->range_id;
        }

        $result = $this->Modules->find()
                                ->select(['Ranges.range_title', 'Modules.module_id', 'Modules.module_title'])
                                ->contain(['Ranges']);
        foreach ($result as $row) {
            $modules[$row->module_option] = $row->module_id;
        }

        $result = $this->Traysizes->find('all');
        foreach ($result as $row) {
            $traysizes[$row->tray_category.$row->shelf_height] = $row->traysize_id;
        }

        $file = fopen($input, "r");
        $count = 0;
        while(! feof($file)) {
            $row = fgetcsv($file);
            if ( strpos($row[0], '-')) {
                $count++;
                $segs = explode('-', $row[0]);
                $range_id = (array_key_exists($segs[0], $ranges))? $ranges[$segs[0]] : $this->createRange($segs[0], $ranges);
                $module_id = (array_key_exists($segs[0].'-'.$segs[1], $modules))? $modules[$segs[0].'-'.$segs[1]] : $this->createModule($segs, $range_id, $modules);
                $traysize_id = (array_key_exists($row[2].$row[1], $traysizes))? $traysizes[$row[2].$row[1]] : NULL;
                $this->createShelf($count, $row, $segs, $module_id, $traysize_id);
                if ($this->imported_count%1000 == 0 && $this->imported_count > 0) $io->out( "Imported ".$this->imported_count." rows\n");
            }
        }
        fclose($file);
        $io->out("The process is done! Imported ".$this->imported_count.'/'.$count." data into database");
        if ($this->imported_count != $count) {
            $io->out("There are some failure results, please check ".$this->error_log_filename);
            fclose($this->error_log);
        }
    }

    /**
    * @param $row row in *.csv Shelfaddr, Tray_barcode, Book_barcode
    * @param $segs "R05-M15-S23-T09" split by '-' as an arry ["R05", "M15", "S23", "T09"]
    * e.g. sudo su apache -s/bin/bash -c "bin/cake FileLoader -t lcsu-barcodes.csv"
    */
    public function loadTrays($input, $io)
    {
        $trays = [];
        $sql_filename = "sql/insert-".date('Y-m-d_H-i-s').".sql";
        $sql_file = fopen($sql_filename, "w");

        $time_start = microtime(true);
        $file = fopen($input, "r");
        $count = 0;
        while(! feof($file)) {
            $row = fgetcsv($file);
            if (strpos($row[1], '-')) {
                $count++;
                if ($count%1000 == 0 && $count > 0) $io->out( "Loaded ".$count." rows");
                $user = get_current_user();
                $tray_barcode = strtoupper($row[1]);
                $segs = explode('-', $tray_barcode);
                if (!isset($trays[$tray_barcode])) {
                    $shelf_barcode = implode('-', array_slice($segs, 0, 3));
                    fwrite($sql_file, "INSERT INTO trays (tray_barcode, modified_user, shelf_id, tray_title) SELECT '$tray_barcode', '$user', shelf_id, '$segs[3]' FROM shelves WHERE shelf_barcode = '$shelf_barcode';\n");
                    $trays[$tray_barcode] = 1;
                }
                fwrite($sql_file, "INSERT INTO books (tray_id,book_barcode)  SELECT tray_id, '$row[0]' FROM trays WHERE tray_barcode = '$tray_barcode';\n");
            }
        }

        $io->out("The process is done! Process ".$count." data into sql/".$sql_filename."Execute:\n mysql -u admin -p -f shelf_db < ".$sql_filename." > sql-error.txt");
        $time = (microtime(true) - $time_start)/60;
        $io->out("The process took ".round($time, 2). "minutes");
        if ($this->error_log) {
            $io->out("There are some failure results, please check ".$this->error_log_filename);
            fclose($this->error_log);
        }
        fclose($file);
        fclose($sql_file);
    }

    public function createRange($range_title, &$ranges)
    {
        $range = $this->Ranges->newEntity(['range_title' => $range_title]);
        $this->Ranges->save($range);
        $ranges[$range_title] = $range->range_id;
        return $range->range_id;
    }

    public function createModule($segs, $range_id, &$modules)
    {
        $module = $this->Modules->newEntity(['module_title' => $segs[1], 'range_id' => $range_id]);
        $this->Modules->save($module);
        $modules[$segs[0].'-'.$segs[1]] = $module->module_id;
        return $module->module_id;
    }

    public function createShelf($count, $row, $segs, $module_id, $traysize_id)
    {
        $obj = ['shelf_barcode' => $row[0],
                'shelf_title' => $segs[2],
                'shelf_height' => $row[1],
                'module_id' => $module_id];
        if ($traysize_id) {
            $obj['traysize_id'] = $traysize_id;
            $obj['tray_category'] = $row[2];
        }
        $shelf = $this->Shelves->newEntity($obj);
        if (!$this->Shelves->save($shelf)) {
            $this->addErrorLog($this->error_log, "row ".($count+1).": ".implode(",",$row)." => ".json_encode($obj)); // Q: How to get the reason for error?
        } else {
            $this->imported_count++;
        }
    }

    protected function createTray($barcode, $shelf_id, &$trays)
    {
        $segs = explode('-', $barcode);
        $obj = ['tray_barcode' => $barcode,
                'shelf_id' => $shelf_id,
                'tray_title' => $segs[3],
                'modified_user' => get_current_user()];
        $tray = $this->Trays->newEntity($obj);
        $this->Trays->save($tray);
        $trays[$barcode] = $tray->tray_id;
        return $tray->tray_id;
    }

    protected function createBook($count, $row, $book_barcode, $tray_id)
    {
        $obj = ['tray_id' => $tray_id, 'book_barcode' => $book_barcode];
        $book = $this->Books->newEntity($obj);
        if (!$this->Books->save($book)) {
            $this->addErrorLog($this->error_log, "row ".($count+1).": ".implode(",",$row)." => ".json_encode($obj)); // Q: How to get the reason for error?
        } else {
            $this->imported_count++;
        }
    }

    protected function createBooks($objs)
    {
        $books = $this->Books->newEntities($objs);
        if (!$this->Books->saveMany($books)) {
            // $this->addErrorLog($this->error_log, "segement: ".implode(",", $objs));
        } else {
            $this->imported_count++;
        }
    }

    protected function findShelf($barcode, &$shelves)
    {
        $segs = explode('-', $barcode);
        $shelf_barcode = implode('-', array_slice($segs, 0, 3));
        if (array_key_exists($shelf_barcode, $shelves))
            $id = $shelves[$shelf_barcode];
        else {
            $id = $this->Shelves->find('list')->where(['shelf_barcode' => $shelf_barcode])->first();
            if($id) {
                $shelves[$shelf_barcode] = $id;
            }
        }
        return $id;
    }

    protected function findTray($barcode, $shelf_id, &$trays)
    {
        if (array_key_exists($barcode, $trays))
            $id = $trays[$barcode];
        else {
            $id = $this->Trays->find('list')->where(['tray_barcode' => $barcode])->first();
            if ($id) {
                $trays[$barcode] = $id;
            } else {
                $id = $this->createTray($barcode, $shelf_id, $trays);
            }
        }
        return $id;
    }

    protected function addErrorLog($msg)
    {
        if (!$this->error_log) {
            $this->error_log = fopen($this->error_log_filename, 'w');
        }
        fwrite($msg);
    }

    protected function buildOptionParser(ConsoleOptionParser $parser)
    {
        $parser
        ->addArgument('file_name', [
            'help' => 'The *.csv file name.'
        ])
        ->addOption('shelves', [
            'short' => 's',
            'help' => 'Load shelves data from *.csv file, e.g. bin/cake FileLoader -s filename.csv',
            'boolean' => true
        ])
        ->addOption('trays', [
            'short' => 't',
            'help' => 'Load trays data from *.csv file, e.g. bin/cake FileLoader -t filename.csv',
            'boolean' => true
        ]);

        return $parser;
    }
}
