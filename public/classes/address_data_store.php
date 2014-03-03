<?php
require_once('classes/filestore.php');

class addressDataStore extends Filestore {


    function __construct($filename = '') 
    {
    	parent:: __construct(strtolower($filename));
    }

	function read_address_book()
	{
		$contents = $this->read_csv($this->filename);
		return $contents;

	}

	function write_address_book($entries)
	{
		$this->write_csv($entries);

	}

}
?>