<?php
	
	//this program is meant to parse a txt file to get the necessary fields to
	//run a geocoding batch in the Nokia Here platform


	//recId|searchText|country (MEX)
	//recID = unique ID
	//search text = address
	//country = MEX will be hard-coded since the locations will be
	//exclusively from Mexico

	$counter = 0;
	$file_string = "";

	$file = fopen("batch_txt.txt", "w");
	//$file_string = "recId|searchtext \n";

	if (($handle = fopen("CPdescarga.txt", "r")) !== FALSE) {
	    while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
	    		//remove first line
	    		if($data[1] != null || $data[3] != null || $data[5] != null || $data[4] != null || $data[6] != null) 
	    		{
	    			//remove second line
	    			if($data[1] != "d_asenta")
	    			{
		    			$counter++;
			    		$file_string = $counter . "|";
			    		$file_string .= $data[1] . " ";
			    		$file_string .= $data[3] . " ";
			    		$file_string .= $data[5] . " ";
			    		$file_string .= $data[4] . " ";
			    		$file_string .= $data[6] . " MEX \n";
							fwrite($file, $file_string);
						}
					}
	    }
	    fclose($file);
	    fclose($handle);
	}

?>
