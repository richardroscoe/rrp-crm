<?php
class ImportCSV
{

	
	// Just remember the filename
	public function ImportCSV()
	{
	}
	
	public function getItems(CUploadedFile $fileinfo)
	{
		$fname = $fileinfo->getTempName();
		$result = array();
		
		ini_set('auto_detect_line_endings',TRUE);
		
		if (($handle = fopen($fname, "r")) === FALSE) {
			echo "Error: Failed to open data file :".$fname."<br>";
			return;
		}	
		
		// The first row should be our list of column names
		if (($data = fgetcsv($handle, 1000, ",")) === FALSE) {
			echo "Error: No data to read in data file :".$fname."<br>";
			fclose($handle);
			return array("Oops1");
		}
		
		$numcols = count($data);
		$cols = $data;
		
		// Now to get the data lines
		$r = 0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				
			// Check the column names are as we expect
			for ($c = 0; $c < $numcols; $c++) {			
				$row[$cols[$c]] = $data[$c];
			}
			$result[$r]=$row;	
			
			$r++;
		}
	
		fclose($handle);
		return $result;
	
	}
	
	public function getItemObjects(CUploadedFile $fileinfo, $class)
	{
		$fname = $fileinfo->getTempName();
		$result = array();

		ini_set('auto_detect_line_endings',TRUE);
		
		if (($handle = fopen($fname, "r")) === FALSE) {
			echo "Error: Failed to open data file :".$fname."<br>";
			return;
		}	
		
		// The first row should be our list of column names
		if (($data = fgetcsv($handle, 1000, ",")) === FALSE) {
			echo "Error: No data to read in data file :".$fname."<br>";
			fclose($handle);
			return array("Oops1");
		}
		
		$numcols = count($data);
		$cols = $data;
		
		// Now to get the data lines
		$r = 0;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
				
			$obj = new $class();
			
			// Check the column names are as we expect
			for ($c = 0; $c < $numcols; $c++) {			
			//	$row[$cols[$c]] = $data[$c];
				
				$obj->setFieldValue($c, $data[$c]);
				
//				$obj->$cols[$c] = $data[$c];
			}
			$result[$r]=$obj;	
			
			$r++;
		}
	
		fclose($handle);
		return $result;
	
	}
	
	// Private helper functions
	
	private function _check_file()
	{
	}
}
?>