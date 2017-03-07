<?php
/* Faculty of Information Technology, Brno University of Technology
*  IPP (Principles of Programming Languages) - Project 1 - SYN version
*  Date created: March 2017
*  Author: Jan Kubica
*  Login: xkubic39
*  Email: xkubic39@stud.fit.vutbr.cz
*  File: RegexConverter.php - Module for modifying regular expression from format file.
*/


function regexAdjust($reg) {

    $regArr = array();                      // pole regexu
    $strLen = mb_strlen($reg, 'UTF-8');     // delka regexu ve znacich v UTF-8
    for ($j = 0; $j < $strLen; $j++) {      // rozdeleni regexu do pole po jednotlivych znacich
        $regArr[$j] = mb_substr($reg, $j, 1, 'UTF-8');
    }
    
    $neg = "";
    $finReg = $reg;

    for ($i = 0; $i < $strLen; $i++) {
  //      var_dump($i);
        if ($regArr[$i] === "!") {
            if ($neg === "") {
                $neg = "^";
                $finReg = substr_replace($finReg, "\037", -$strLen+$i, 1);
                continue;
            } else {
                $finReg = "error";
                return false;
            }
        }
        if ($regArr[$i] === "%") {
            $i++;
            switch ($regArr[$i]) {
            case "s": 
            //    $finReg = preg_replace("/%s/", "[" . $neg . "\s]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "\s]", -$strLen+$i-1, 2);
                break;
            case "a":
            //    $finReg = preg_replace("/%a/", "[" . $neg . "\s\S]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "\s\S]", -$strLen+$i-1, 2);
                break;
            case "d": 
            //    $finReg = preg_replace("/%d/", "[" . $neg . "0-9]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "0-9]", -$strLen+$i-1, 2);
                break;
            case "l": 
            //    $finReg = preg_replace("/%l/", "[" . $neg . "a-z]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "a-z]", -$strLen+$i-1, 2);
                break;
            case "L": 
            //    $finReg = preg_replace("/%L/", "[" . $neg . "A-Z]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "A-Z]", -$strLen+$i-1, 2);  
                break;
            case "w": 
            //    $finReg = preg_replace("/%w/", "[" . $neg . "a-zA-Z]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "a-zA-Z]", -$strLen+$i-1, 2);
                break;
            case "W": 
            //    $finReg = preg_replace("/%W/", "[" . $neg . "a-zA-Z0-9]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "a-zA-Z0-9]", -$strLen+$i-1, 2);
                break;
            case "t":
            //    $finReg = preg_replace("/%t/", "[" . $neg . "\t]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "\t]", -$strLen+$i-1, 2);
                break;
            case "n":
            //    $finReg = preg_replace("/%n/", "[" . $neg . "\n]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "\n]", -$strLen+$i-1, 2);
                break;
            case ".": 
            //    $finReg = preg_replace("/%\./", "[" . $neg . ".]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . ".]", -$strLen+$i-1, 2);
                break;
            case "|": 
            //    $finReg = preg_replace("/%\|/", "[" . $neg . "|]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "|]", -$strLen+$i-1, 2);
                break;
            case "!": 
            //    $finReg = preg_replace("/%!/", "[" . $neg . "!]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "!]", -$strLen+$i-1, 2);
                break;
            case "*": 
            //    $finReg = preg_replace("/%\*/", "[" . $neg . "*]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "*]", -$strLen+$i-1, 2);
                break;
            case "+": 
            //    $finReg = preg_replace("/%\+/", "[" . $neg . "+]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "+]", -$strLen+$i-1, 2);
                break;
            case ")": 
            //    $finReg = preg_replace("/%\)/", "[" . $neg . ")]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . ")]", -$strLen+$i-1, 2);
                break;
            case "(":
            //    $finReg = preg_replace("/%\(/", "[" . $neg . "(]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "(]", -$strLen+$i-1, 2);
                break;
            case "%":
            //    $finReg = preg_replace("/%%/", "[" . $neg . "%]", $finReg, 1);
                $finReg = substr_replace($finReg, "[" . $neg . "%]", -$strLen+$i-1, 2);
                break;
            default:  
                return false;
            }
        }
        if ($neg == "^") {
            $finReg = substr_replace($finReg, "[^" . $regArr[$i] . "]", -$strLen+$i, 1);
            $neg = "";
        }
        if ($regArr[$i] === "(" || $regArr[$i] === ")") {
            $finReg = substr_replace($finReg, "\037", -$strLen+$i, 1);
        }
        $neg = "";
//        var_dump($finReg);
    }
    $finReg = str_replace("\037", '', $finReg);

//    $finReg = implode("", $finArr); // spojeni finalniho pole s regexem do stringu
    
    return $finReg;
}
$str = 'resi prekryvani';
$b = regexAdjust($str);
if ($b === false) {
    echo "False\n";
} else {
    echo "$b\n";
}

?>