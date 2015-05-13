<?php

	//this program is meant to parse a txt file to get the necessary fields to
	//create mongodb ready documents


	//recId|seqNumber|seqLength|displayLatitude|displayLongitude|district|county|city|postalCode|state|country

	if (($handle = fopen("mexico.txt", "r")) !== FALSE) {
	  while (($data = fgetcsv($handle, 1000, "|")) !== FALSE) {
			//remove first line
			if($data[0] != "recId")
			{

				setlocale(LC_ALL, 'en_US.UTF8');

				//STATE FILES
				//checking if state field is not null
				if($data[9] != null)
				{					
					//creating files with different names
					//preg_replace substitutes the spaces for underscores 
					//(mongoimport doesnt accept document names with spaces)
					$state_file = fopen("state_documents/" . preg_replace('/\s+/', '_', $data[9]) ."_document.json", "w");

					$converted_state = iconv('UTF-8', 'ASCII//TRANSLIT', $data[9]);
					$state_string = array('state_name' => str_replace("'", "", $converted_state));
					$json_state = json_encode($state_string);
					fwrite($state_file, $json_state);
				}

				//MUNICIPALITY FILES
				//checking if state field and municipality are not null
				if($data[7] != null && $data[9] != null){
					//creating files with different names
					//preg_replace substitutes the spaces for underscores 
					//(mongoimport doesnt accept document names with spaces)
					$municipality_file = fopen("municipality_documents/" . preg_replace('/\s+/', '_', $data[7]) . "_document.json", "w");

					$converted_state_id = iconv('UTF-8', 'ASCII//TRANSLIT', $data[9]);
					$converted_municipality = iconv('UTF-8', 'ASCII//TRANSLIT', $data[7]);

					$municipality_string = array('municipality_name' => str_replace("'", "", $converted_municipality), 
						'state_id' => str_replace("'", "", $converted_state)
						);
					$json_municipality = json_encode($municipality_string);
					fwrite($municipality_file, $json_municipality);
				}

				//SUBURB FILES
				//checking if suburb field and municipality are not null
				if($data[7] != null && $data[5] != null){
					//creating files with different names
					//preg_replace substitutes the spaces for underscores 
					//(mongoimport doesnt accept document names with spaces)
					$suburb_file = fopen("suburb_documents/" . preg_replace('/\s+/', '_', $data[5]) . "_" . uniqid() . "_document.json", "w");

					$converted_municipality_id = iconv('UTF-8', 'ASCII//TRANSLIT', $data[7]);
					$converted_suburb = iconv('UTF-8', 'ASCII//TRANSLIT', $data[5]);

					$suburb_string = array('suburb_name' => str_replace("'", "", $converted_suburb), 
						'municipality_id' => str_replace("'" , "", $converted_municipality_id)
						);
					$json_suburb = json_encode($suburb_string);
					fwrite($suburb_file, $json_suburb);
				}

				//ZIP CODE FILES
				//checking if suburb field and zip code are not null
				if($data[8] != null && $data[3] != null && $data[4] != null){
					//creating files with different names
					//preg_replace substitutes the spaces for underscores 
					//(mongoimport doesnt accept document names with spaces)
					$zip_code_file = fopen("zip_code_documents/" . preg_replace('/\s+/', '_', $data[8]) ."_". uniqid() ."_document.json", "w");

					$converted_suburb_id = iconv('UTF-8', 'ASCII//TRANSLIT', $data[5]);
					$converted_municipality_sub = iconv('UTF-8', 'ASCII//TRANSLIT', $data[7]);

					if($data[5] != null)
					{
						$zip_code_string = array('zip_code' => $data[8], 
							'suburb_id' => str_replace("'", "", $converted_suburb_id),
							//convert the coords to float for geospatial use in mongo
							'loc' => array('type' => 'Point', 'coordinates' => [(float)$data[4], (float)$data[3]])
							);
						$json_zip_code = json_encode($zip_code_string);
						fwrite($zip_code_file, $json_zip_code);
					}
					else
					{
						$zip_code_string = array('zip_code' => $data[8], 
							'municipality_id' => str_replace("'", "", $converted_municipality_sub),
							//convert the coords to float for geospatial use in mongo
							'loc' => array('type' => 'Point', 'coordinates' => [(float)$data[4], (float)$data[3]])
							);
						$json_zip_code = json_encode($zip_code_string);
						fwrite($zip_code_file, $json_zip_code);
					}
				}

				//closing all documents
				fclose($state_file);
				fclose($zip_code_file);
				fclose($municipality_file);
				fclose($suburb_file);
			}
		}
		fclose($handle);
	}
	
?>