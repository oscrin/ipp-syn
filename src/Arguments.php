<?php
/* Faculty of Information Technology, Brno University of Technology
*  IPP (Principles of Programming Languages) - Project 1 - SYN version
*  Date created: February 2017
*  Author: Jan Kubica
*  Login: xkubic39
*  Email: xkubic39@stud.fit.vutbr.cz
*  File: Arguments.php - Module for parsing console arguments
*/

class Arguments {
    protected $cmdLine;
   
    public $isHelp         = false;
    public $isFormatFile   = false;
    public $formatFile     = "";
    public $isInputFile    = false;
    public $inputFile      = "";
    public $isOutputFile   = false;
    public $outputFile     = "";
    public $isBr           = false;

    public function __construct( $cmdLine ) {
        $this->cmdLine = array_slice($cmdLine, 1);
    }
   
    public function parseArg() {
        if (count($this->cmdLine) == 0)
            return true;
        if (in_array("--help", $this->cmdLine) ) {
            if (count($this->cmdLine) == 1) {
                $this->isHelp = true;
                return true;
            } else
                return false;
       }
        else if (count($this->cmdLine) > 5)
           return false;
        else {
            foreach ($this->cmdLine as $arg) {
                if ((strlen($arg) > 9) && !substr_compare($arg,"--format=", 0, 9) ) {
                    if (empty($this->formatFile)) {
                        $this->formatFile = str_replace("--format=", "", $arg);
                        $this->isFormatFile = true;
                    } else
                        return false;
                } else if ((strlen($arg) > 8) && !substr_compare($arg,"--input=", 0, 8) ) {
                    if (empty($this->inputFile)) {
                        $this->inputFile = str_replace("--input=", "", $arg);
                        $this->isInputFile = true;
                    } else
                        return false;
                } else if ((strlen($arg) > 9) && !substr_compare($arg,"--output=", 0, 9) ) {
                    if (empty($this->outputFile)) {
                        $this->outputFile = str_replace("--output=", "", $arg);
                        $this->isOutputFile = true;
                    } else
                        return false;
                } else if ($arg == "--br" && empty($isBr)) {
                    if(empty($this->isBr))
                        $this->isBr = true;
                    else
                        return false;
                }
                else
                    return false;
            }
        }
//        if (!$this->isInputFile || !$this->isOutputFile )
//            return false;

        return true;
    }
}

?>