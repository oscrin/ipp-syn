<?php
/* Faculty of Information Technology, Brno University of Technology
*  IPP (Principles of Programming Languages) - Project 1 - SYN version
*  Date created: February 2017
*  Author: Jan Kubica
*  Login: xkubic39
*  Email: xkubic39@stud.fit.vutbr.cz
*  File: xkubic39.php - Main file for running the script
*/

include 'src/Arguments.php';
include 'src/Error.php';

function printHelp() {
	echo ( "\033[93m                              Syntax Highlighting\n\033[0m" );
	echo ( "Basic program made for simple text highlighting, adding HTML tags to the input \nfile. " );
	echo ( "Changes are processed according to specific regular expressions included \nin the format file. " );
	echo ( "For more information, please, read the documentation given.\n\n" );
	echo ( "\e[1mAuthor:\e[0m Jan Kubica, xkubic39@stud.fit.vutbr.cz\n" );
	echo ( "\e[1mDate created:\e[0m February 2017\n\n" );
	echo ( "\e[96mUsage: \e[39mphp syn.php \e[2m--help\e[0m\n" );
	echo ( "       php syn.php \e[2m[--format=filename] [--input=filename] [--output=filename] [--br]\e[0m\n\n" );
	echo ( "\e[96mOptions:\e[39m\n" );
	echo ( "     \e[1m--help \e[0m                Prints help to stdout.\n" );
	echo ( "     \e[1m--format=filename \e[0m     Format file. If missing, no changes are made.\n" );
	echo ( "     \e[1m--input=filename \e[0m      Input file in UTF-8. If missing, stdin is considered.\n" );
	echo ( "     \e[1m--output=filename \e[0m     Output file in UTF-8. If missing, stdout is considered.\n" );
	echo ( "     \e[1m--br \e[0m                  Adds a <br /> element at the end of each line.\n\n" );
}

$args = new Arguments($argv);
$opt = $args->parseArg();
if ( !$opt )
	error(1, "Console argument Error!");
if ($args->isHelp == true)
	printHelp();
else if ($args->isFormatFile == true) {
	$FFRows = array();
	if (is_readable($args->formatFile)) {
		$handle = fopen($args->formatFile, "r");
		while(($line = fgets($handle)) == true) {
			if ($line != "\n")
				array_push($FFRows, $line);
		}
		fclose($handle);
		var_dump($FFRows);
	}
}
 
?>
