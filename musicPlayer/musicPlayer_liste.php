<?php

session_start();
$initial_directory = $_SESSION["cloudDir"].$_SESSION["cloudMusicDir"]."/";

$allowed_ext = array('png', 'jpg', 'gif', 'pdf', 'mp4', 'avi','m4a', 'mp3', 'wma','txt','css','js','html','php','h','c','py','sh');

if(isset( $_GET["recherche"])) 
{
	$recherche = '#'.$_GET["recherche"]."#i";
}else{
	$recherche = '';
}

if(isset( $_GET["directories"]))
{
  
    echo "<div hidden id='cloud_directory'>".$initial_directory."</div>";
		$dir = scandir($initial_directory) or die($initial_directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
		foreach ($dir as $element) {   
			if($element != '.' && $element != '..') {
				if (is_dir($initial_directory.'/'.$element)) {
					?><li class="mv-item"><a onclick="afficher_music_file('<?php echo $element; ?>')"><?php echo $element ?></a></li><?php
				}
			}
		}
  
}else{


if(isset( $_GET["dossier"]) && $_GET["dossier"])
{
	$dir_name=urldecode($_GET["dossier"]);
	$directory = $initial_directory.$dir_name;

	$nb_fichier=0;
	$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
	foreach ($dir as $element) {   	
		if($element != '.' && $element != '..') {

			if(preg_match($recherche, $element) || $recherche==''){ 
				if (!is_dir($directory.'/'.$element)) {

					$extension = pathinfo($element, PATHINFO_EXTENSION);
					if ($extension=='mp3' || $extension=='m4a'){
						$fichier[] = $element;
						$nb_fichier++;
					}
				}
				else {	$dossier[] = $element;	}
			}
		}
	}

}else{
	$directory = $initial_directory; 
	$dir_name="";

	$nb_fichier=0;
	$dir = scandir($directory) or die($directory.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
	foreach ($dir as $element) {   	
		if($element != '.' && $element != '..') {
	
			 
				if (!is_dir($directory.'/'.$element)) {
					if(preg_match($recherche, $element) || $recherche==''){
						$extension = pathinfo($element, PATHINFO_EXTENSION);
						if ($extension=='mp3' || $extension=='m4a'){
							$fichier[] = $element;
							$nb_fichier++;
						}
					}
				}
				
					if (is_dir($directory.'/'.$element)) {			

						$dir2 = scandir($directory.'/'.$element) or die($directory.'/'.$element.' Erreur de listage : le répertoire n\'existe pas'); // on ouvre le contenu du dossier courant
						foreach ($dir2 as $element2) {   	
							if($element2 != '.' && $element2 != '..') {
						
								if(preg_match($recherche, $element2) || $recherche==''){ 
									if (!is_dir($directory.'/'.$element2)) {
						
										$extension = pathinfo($element2, PATHINFO_EXTENSION);
										if ($extension=='mp3' || $extension=='m4a'){
											$fichier[] = $element."/".$element2;
											$nb_fichier++;
										}
									}
								}
							}
						}
					}

			
		}
	}


	?><div id="titre_pages"><?php echo "Toutes les Musiques"; ?></div><?php
}


$titre = explode('/',$dir_name);
$titre_dir = $titre[sizeof($titre)-1];
$prec_dir = substr($dir_name,0,-strlen($titre_dir)-1);

// **************************************************************************************************************************************************************************

if( strlen($prec_dir)>0 ){
	?>
	<div id="titre_pages">
	<img onclick="afficher_music_file('<?php echo urlencode($prec_dir) ?>')" height="30px" src="img/cloud/precedent.png" style="float:left; cursor:pointer; padding-top:5px;"><?php echo $titre_dir; ?></div>
<?php }else{ ?>
	<div id="titre_pages"><?php echo $titre_dir; ?></div>
<?php } 

?><br><br><div class="nb_playlist"><?php echo $nb_fichier;?> Musique<?php if($nb_fichier>1) echo 's';?></div>



<?php	
if(!empty($dossier)){
	?><div class="music_header_title">Dossiers</div><?php

	foreach($dossier as $lien){
		
		?><div class="folder_title" title="<?php echo $lien ?>" onclick="afficher_music_file('<?php echo urlencode($dir_name."/".$lien) ?>')"><?php echo $lien ?></div><?php
	}
?><br><br><?php
}

?><div class="music_header_title">Titre</div><?php
$i=0;
if(!empty($fichier)){
	foreach($fichier as $lien) {
					
	?><div class="music_title" id="<?php echo $i ?>" name="<?php echo urlencode($dir_name.'/'.$lien) ?>" onclick="click_music(this.getAttribute('name'))" ondblclick="play_music( this.getAttribute('name'),this.innerHTML,this.id)" title="<?php echo $lien ?>"><?php echo substr(basename($lien),0,-4) ?></div><?php
	$i++;
	}
}
?><div style="height:150px; width:100%;"></div>


<?php } ?>

