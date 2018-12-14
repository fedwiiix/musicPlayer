<?php

session_start();
$initial_directory = $_SESSION["cloudDir"].$_SESSION["cloudMusicDir"]."/";

function secure($string){	return (urldecode( $string )); } // return urldecode( htmlentities(stripslashes($string),NULL,'UTF-8') );
$_ = array();
foreach($_POST as $key=>$val){	$_[$key]=secure($val); }
foreach($_GET as $key=>$val){	$_[$key]=secure($val); }


$file = $_['file'];

$result = "error";

switch($_['action']){ 
	
	case 'get_pn_music':

	$file = addslashes($file);
	
	$file = preg_replace("#\(#", "\(", $file);
	$file = preg_replace("#\)#", "\)", $file);
	$file = preg_replace("#\[#", "\[", $file);
	$file = preg_replace("#\]#", "\]", $file);
	$file = preg_replace("#\##", "\#", $file);
		
	$basename=basename($file);
	$recherche='#'.$basename."#i";

	$directory_return=substr( $file, 0, -strlen($basename) );
	$directory= $initial_directory.substr($file, 0, -strlen($basename) );
	$previous="";
	$next="";

	//echo $recherche .'<br>'.$directory;

	$nb=1;
	if (is_dir($directory)) {			

		$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
		foreach ($dir as $element) {   	
			if($element != '.' && $element != '..') {
		
				
				if (!is_dir($directory.'/'.$element)) {
	
					$extension = pathinfo($element, PATHINFO_EXTENSION);
					if ($extension=='mp3' || $extension=='m4a'){
						$fichier[$nb] = $element;
						$nb++;
						//echo $element."<br>";

						if(preg_match($recherche, $fichier[$nb-2])){ 
							$previous=$fichier[$nb-3];
							$next=$element;
						}
					}
				}
			}
		}
	}
	if(preg_match($recherche, $fichier[$nb-1])){ 		// the last one
		$previous=$fichier[$nb-2];
	}


	echo '{"result":"yes","previous_music":"'.urlencode( $directory_return.$previous).'","next_music":"'.urlencode($directory_return.$next).'"}';
	break;

	case 'get_music_tag':

	//$file = urldecode($_GET["file"]);
	$extension = pathinfo($file, PATHINFO_EXTENSION);
    //$type = mime_content_type($file);

	if( $extension=="mp3"  || $extension=="m4a" ){ 	

        require_once(dirname(__FILE__).'/id3master/getid3/getid3.php');
	   
        $getID3 = new getID3; // Initialize getID3 engine
        $ThisFileInfo = $getID3->analyze( $initial_directory.$file );
        getid3_lib::CopyTagsToComments($ThisFileInfo);

        $titre = $ThisFileInfo['comments_html']['title'][0];
        if($titre==''){ $titre = basename($ThisFileInfo['filename'],'.mp3'); }        

        $artist= $ThisFileInfo['comments_html']['artist'][0]; 
        $year= $ThisFileInfo['comments_html']['year'][0]; 
        $album= $ThisFileInfo['comments_html']['album'][0]; 
        $genre= $ThisFileInfo['comments_html']['genre'][0];  
        $time= $ThisFileInfo['playtime_string'];

        /* if you want to see ALL the output, uncomment this line:*/
        //echo '<pre>'.print_r($ThisFileInfo, true).'</pre>';

        $data=$ThisFileInfo['comments']['picture'][0]['data'];

        //if(strlen($data)>0)
        //echo '<img src="data:image/png;base64,'.base64_encode($data).'" style="max-height:90%; max-width:96%; vertical-align:center;">';

    }

	echo '{"result":"yes","titre":"'.urlencode($titre).'","artist":"'.urlencode($artist).'","year":"'.urlencode($year).'","album":"'.urlencode($album).'","genre":"'.urlencode($genre).'","time":"'.urlencode($time).'","image":"'.base64_encode($data).'"}';
	break;

}
//echo '{"result":"'.$result.'"}';




?>