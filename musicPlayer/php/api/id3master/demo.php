<?php
require_once('./getid3/getid3.php');

// Initialize getID3 engine
$getID3 = new getID3;

$ThisFileInfo = $getID3->analyze("/var/www/html/id3master/bb.m4a");


  // $ThisFileInfo = $getID3->analyze("/home/cloud/Musique/calm/Caesars Home - Patrick Doyle.mp3");


getid3_lib::CopyTagsToComments($ThisFileInfo);



echo $ThisFileInfo[filename]." artist<br>"; // artist from any/all available tag formats

echo $ThisFileInfo['comments_html']['title'][0]."  <br>";  
echo $ThisFileInfo['comments_html']['artist'][0]." <br>"; 
echo $ThisFileInfo['comments_html']['year'][0]."  <br>"; 
echo $ThisFileInfo['comments_html']['album'][0]."  <br>"; 
echo $ThisFileInfo['comments_html']['genre'][0]." <br>";  
echo $ThisFileInfo['playtime_string']." <br>";

/* if you want to see ALL the output, uncomment this line:*/
//echo '<pre>'.print_r($ThisFileInfo, true).'</pre>';


$data=$ThisFileInfo['comments']['picture'][0]['data'];


if(strlen($data)>0)
    echo '<img src="data:image/png;base64,'.base64_encode($data).'" style="max-height:90%; max-width:96%; vertical-align:center;">';

?>
