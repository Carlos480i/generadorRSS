<?php
	header('Content-type: application/zip');
	header('Content-Disposition: attachment; filename="RSS.zip"');

	ignore_user_abort(true);

	$text = "";
	$url = $_POST['url'];
	@$resize = $_POST['resize'];
	if (empty($resize)){
		$resize = 'false';
	}
	
	$text .= "url= $url
resize_buttons= $resize";

	$zipName = 'RSS_'+date_timestamp_get(date_create())+rand()+'.zip';
	copy('baseRSS.zip',$zipName);
	$zip = new ZipArchive;
	$res = $zip->open($zipName, ZipArchive::CREATE);
	if ($res === TRUE) {
		$zip->addFromString('preferences.txt', $text);
		
		$zip->close();
	} else {
		echo 'Error';
	}
	
	$context = stream_context_create();
	$file = fopen($zipName, 'rb', FALSE, $context);
	while(!feof($file)) echo stream_get_contents($file, 2014);
	fclose($file);
	flush();
	if (file_exists($zipName)) unlink( $zipName );
	
