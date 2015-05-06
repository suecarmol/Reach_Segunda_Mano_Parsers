<?php

	//this program is meant to parse an xml file to get the necessary fields to
	//run a geocoding batch in the Nokia Here platform


	//recId|searchText|country (MEX)
	libxml_use_internal_errors(false);
	$xml_file = simplexml_load_file("CPdescarga.xml") or die("Error: no se encontro el archivo");
	libxml_use_internal_errors(false);
	//print_r($xml_file);

	$counter = 0;
	$file_string = "";

	foreach ($xml_file->NewDataSet as $row) {
		$counter++;

		//dividing rural and urban areas 

		if($row->d_zona == "Rural")
		{	
			$file_string = "00" . $counter . "|";
			$file_string .= $row->D_mnpio . " ";
			$file_string .= $row->d_estado . " ";
			$file_string .= $row->d_CP . "|";
			$file_string .= "MEX \n";
		}	
		else
		{
			$file_string = "00" . $counter . "|";
			$file_string .= $row->d_ciudad . " ";
			$file_string .= $row->D_mnpio . " ";
			$file_string .= $row->d_estado . " ";
			$file_string .= $row->d_CP . "|";
			$file_string .= "MEX \n";
		}

	}

	$file = fopen("batch_ xml.txt", "w");
	fwrite($file, $file_string);
	fclose($file);

?>