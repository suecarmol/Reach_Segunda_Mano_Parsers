<?php

	function httpGet($url)
	{
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		//curl_setopt($ch,CURLOPT_HEADER, false); 
 
    $output=curl_exec($ch);
 
    curl_close($ch);

    if($output === false)
  	{
      echo "Error Number:".curl_errno($ch)."<br>";
      echo "Error String:".curl_error($ch);
  	}

  	return $output;
	}
	 
	echo httpGet("http://batch.geocoder.cit.api.here.com/6.2/jobs/Pmv8IULO4HCMb5Yhf6D9tpiuCYJJZgkB/all?app_code=bDsF80_TmRgKywxQlXFgTg&amp;app_id=xKm59owTXnvSZ5zyQdXN");

?>