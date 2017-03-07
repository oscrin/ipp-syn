<?php
/* Faculty of Information Technology, Brno University of Technology
*  IPP (Principles of Programming Languages) - Project 1 - SYN version
*  Date created: February 2017
*  Author: Jan Kubica
*  Login: xkubic39
*  Email: xkubic39@stud.fit.vutbr.cz
*  File: xkubic39.php - Main file for running the script
*/

require 'src/Arguments.php';
require 'src/Error.php';


function printHelp() {
    echo ( "\033[93m                              Syntax Highlighting\n\033[0m" );
    echo ( "Basic program made for simple text highlighting, adding HTML tags to the input \nfile. " );
    echo ( "Changes are processed according to specific regular expressions included \nin the format file. " );
    echo ( "For more information please read the project documentation.\n\n" );
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

function parseInputFile($args) {
    if (is_readable($args->inputFile)) {
        global $inFileContent;
        $inFileContent  = file_get_contents($args->inputFile);
        if ($args->formatFile) {
            $len = strlen($inFileContent);
            global $contentArray;
            $contentArray = array_fill(0, $len, "0");
            array_push($contentArray, "X");
        //   var_dump($inFileContent);
        //   var_dump($contentArray);
        }
    } else
        error(2, "Input file failure!");
}

function parseFormatFile($args) {
    if (is_readable($args->formatFile)) {
        global $FFRows;
        $FFRows = array();
        $handle = fopen($args->formatFile, "r");
        while (($line = fgets($handle)) == true) {
            if ($line != "\n") {
                $line = str_replace("\n", '', $line);
                array_push($FFRows, $line);
            }
        }
        fclose($handle);
        foreach ($FFRows as &$row) {
            $row = preg_split("/[\t]+/", $row);
        }
        //  var_dump($FFRows);
    }
}

$args = new Arguments($argv);
$opt = $args->parseArg();

if (!$opt)
    error(1, "Console argument Error!");

if ($args->isHelp)
    printHelp();
if ($args->isInputFile)
    parseInputFile($args);
if ($args->isFormatFile)
    parseFormatFile($args);
if ($args->isOutputFile) {
    if (!file_exists($args->outputFile)) {
        $succ = file_put_contents($args->outputFile, $inFileContent);
        if (!$succ)
            error(3, "Output file failure!");
//    } else {
//        error(3, "Output file failure!");
    }
} else {
    fwrite(STDOUT, $inFileContent);
}
?>
