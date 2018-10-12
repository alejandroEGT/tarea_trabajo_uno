<?php 


		// if ($temp = $this->config->getSystemValue('tempdirectory', null)) { 
 	// 		$directories[] = $temp; 
 	// 	} 
 	// 	if ($temp = \OC::$server->getIniWrapper()->get('upload_tmp_dir')) { 
 	// 		$directories[] = $temp; 
 	// 	} 
 	// 	if ($temp = getenv('TMP')) { 
 	// 		$directories[] = $temp; 
 	// 	} 
 	// 	if ($temp = getenv('TEMP')) { 
 	// 		$directories[] = $temp; 
 	// 	} 
 	// 	if ($temp = getenv('TMPDIR')) { 
 	// 		$directories[] = $temp; 
 	// 	} 
 	// 	if ($temp = sys_get_temp_dir()) { 
 	// 		$directories[] = $temp; 
 	// 	}

	include_once "../PHP_XLSXWriter-master/xlsxwriter.class.php";

	$data = array(
    	array('year','month','amount'),
    	array('2003','1','220'),
    	array('2003','2','153.5'),
	);
	 $writer = new XLSXWriter();
	 $writer->writeSheet($data);
	 $writer->writeToFile('output.xlsx');


 ?>