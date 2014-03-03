<?php

class Filestore {

    public $filename = '';

    private $is_csv = FALSE;

    function __construct($filename = '') 
    {
        $this->filename = $filename;

        if (strtolower((substr($filename, -3))) == 'csv') {
            $this->is_csv = TRUE;
        }

    }

    public function read() {
        if($this->is_csv == TRUE) {
           return $this->read_csv();
        } else {
           return $this->read_lines();
        }
    }

    public function write($array) {
        if($this->is_csv == TRUE) {
           return $this->write_csv($array);
        } else {
           return $this->write_lines($array);
        }
    }

    /**
     * Returns array of lines in $this->filename
     */
    private function read_lines()
    {
        if(filesize($this->filename) > 0) 
        {
            $handle = fopen($this->filename, "r");
            $contents = fread($handle, filesize($this->filename));
            fclose($handle);
            return explode("\n", $contents);
        } else {
            return array();
        }
    }

    /**
     * Writes each element in $array to a new line in $this->filename
     */
    private function write_lines($array)
    {
        $handle = fopen($this->filename, 'w');
        $itemstr = implode("\n", $array);
        fwrite($handle, $itemstr);
        fclose($handle);
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    private function read_csv()
    {
        $address_book = [];
        $handle = fopen($this->filename, "r");
        while(($data = fgetcsv($handle)) !== FALSE) {
            if(!empty($data)) 
            {
                $address_book[] = $data;
            } 
        }
        fclose($handle);
        return $address_book;

    }

    /**
     * Writes contents of $array to csv $this->filename
     */
    private function write_csv($arrays)
    {
        $handle = fopen($this->filename, "w");
        foreach ($arrays as $array) 
        {
            fputcsv($handle, $array);
        }
        fclose($handle);

    }

}

