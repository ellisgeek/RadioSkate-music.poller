<?php
	###
	### This File Polls the directory ./mp3 in the same folder as this file
	### and returns json containing the track title, artist, length, and URL
	### This script relies on getID3: http://www.getid3.org/
	###
	
	header("Content-Type: application/json");
	
	require_once("./getid3/getid3.php");
	
	$output = array();
	$getID3 = new getID3;
	
	foreach (new DirectoryIterator('./mp3') as $fileInfo) {
		if($fileInfo->isDot() || strtolower($fileInfo->getExtension()) !== "mp3") continue;
		
		$songmeta = $getID3->analyze($fileInfo->getPathname());
		getid3_lib::CopyTagsToComments($songmeta);
		
		$output[] = array("artist"   => str_replace('&amp;', '&', $songmeta['comments_html']['artist'][0]),
						  "title"    => str_replace('&amp;', '&', $songmeta['comments_html']['title'][0]),
						  "album"    => str_replace('&amp;', '&', $songmeta['comments_html']['album'][0]),
						  "duration" => $songmeta['playtime_string'],
						  "url"      => "http://clients.rootwerk.systems/sean/server/mp3/" . $fileInfo->getFilename());
	}

	echo(json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
?>