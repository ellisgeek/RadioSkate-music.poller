<?php
	###
	### This File Polls the directory ./mp3 in the same folder as this file
	### and returns json containing the track title, artist, length, and URL
	###
	
	foreach (new DirectoryIterator('./mp3') as $fileInfo) {
		if($fileInfo->isDot() || strtolower($fileInfo->getExtension) !== "mp3") continue;
		echo $fileInfo->getFilename() . "<br>\n";
	}
?>