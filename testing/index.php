<?php

// $filename = '../index.php';
$filename = '../index.php';
$searchfor = 'site_name';
$file = file_get_contents($filename);
if(strpos($file, $searchfor)) 
{
   echo "String found";
}