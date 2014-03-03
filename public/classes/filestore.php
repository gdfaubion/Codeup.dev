<?php

class Filestore {

    public $filename = '';

    function __construct($filename = '') 
    {
        $this->filename = $filename;
    }

    /**
     * Returns array of lines in $this->filename
     */
    function read_lines()
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
    function write_lines($array)
    {
        $handle = fopen($this->filename, 'w');
        $itemstr = implode("\n", $array);
        fwrite($handle, $itemstr);
        fclose($handle);
    }

    /**
     * Reads contents of csv $this->filename, returns an array
     */
    function read_csv()
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
    function write_csv($arrays)
    {
        $handle = fopen($this->filename, "w");

        foreach ($arrays as $array) 
        {
            fputcsv($handle, $array);
        }

        fclose($handle);

    }

}

