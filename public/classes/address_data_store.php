<?php
class addressDataStore {

	public $filename = '';

	function __construct($filename = 'data/address_book.csv') 
	{
		$this->filename = $filename;

	}

	function readCSV()
	{
		$address_book = [];
		$handle = fopen($this->filename, "r");
		while(!feof($handle)) {
		$line = fgetcsv($handle);
		if(!empty($line)) 
		{
	  		$address_book[] = $line;
			}
		}
		fclose($handle);
		return $address_book;

	}

	function writeCSV($entries)
	{
		$handle = fopen($this->filename, "w");

		foreach ($entries as $entry) 
		{
			fputcsv($handle, $entry);
		}

		fclose($handle);

	}

}
?>