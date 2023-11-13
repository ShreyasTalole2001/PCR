<?php

// THIS FUNCTION SEPERATES THE MULTIPLE JSON ROOT ELEMENTS INTO ARRAY FORM
function json_split_objects($json)
{
    $q = FALSE;
    $len = strlen($json);
    for($l=$c=$i=0;$i<$len;$i++)
    {   
        $json[$i] == '"' && ($i>0?$json[$i-1]:'') != '\\' && $q = !$q;
        if(!$q && in_array($json[$i], array(" ", "\r", "\n", "\t"))){continue;}
        in_array($json[$i], array('{', '[')) && !$q && $l++;
        in_array($json[$i], array('}', ']')) && !$q && $l--;
        (isset($objects[$c]) && $objects[$c] .= $json[$i]) || $objects[$c] = $json[$i];
        $c += ($l == 0);
    }   
    return $objects;
}


// Fetch log data from file
function fetchDataFromApiLogFile(){
    $myfile = fopen("apiLog.txt", "r");
    $fileData = fread($myfile,filesize("apiLog.txt")+1);
    print_r(json_split_objects($fileData));
    
}

fetchDataFromApiLogFile();


?>