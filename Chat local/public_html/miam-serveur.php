<?php
ini_set("xdebug.overload_var_dump", "off");
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$data=lire_fichier_data();

if(isset($_GET['clickChatX']) && 
   isset($_GET['clickChatY'])){
	$data['clickChat']=['x'=>floatval($_GET['clickChatX']),
						'y'=>floatval($_GET['clickChatY'])];
}

if(isset($_GET['clickSourisX']) && 
   isset($_GET['clickSourisY'])){
	$data['clickSouris']=['x'=>floatval($_GET['clickSourisX']),
						  'y'=>floatval($_GET['clickSourisY'])];
}

if(isset($data['clickChat']) || isset($data['clickSouris'])){
	ecrire_fichier_data($data);
}

if(!isset($data['clickChat']) && !isset($data['clickSouris'])){
	erreur('Pas de click fourni.');
}

// Attendre que l'autre joueur clique et que le processus PHP correspondant écrive les autres coordonnées dans le fichier
$maxAttente=500;
for($i=0;isset($data['clickChat']) !== isset($data['clickSouris']) && $i<$maxAttente;$i++){
	usleep(100*1000);
	$data=lire_fichier_data();
}

$output=$data;

// Cas particulier. Si l'utilisateur a cliqué plusieurs fois, certains des processus en attente risquent de voir un fichier déjà vidé.
if(!isset($data['clickChat']) && !isset($data['clickSouris'])){
	$output=[];
}

// Timeout.
if($i===$maxAttente){
	erreur('Delai d\'attente pour l\'autre click dépasé.');
}

unset($data['clickChat'  ]);
unset($data['clickSouris']);

// Attendre pour que l'autre processus ait le temps de lire, avant qu'on éfface.
// Pas très joli, mais efficace.
usleep(150*1000); 
ecrire_fichier_data($data);

echo json_encode($output);

function lire_fichier_data(){
	$fichier=@file_get_contents('data.json');
	if($fichier===false){$fichier='[]';}
	$res=json_decode($fichier, JSON_OBJECT_AS_ARRAY);
	if($res===null){$res=[];}
	return $res;
}

function ecrire_fichier_data($data){
	$ok=@file_put_contents('data.json',json_encode($data));
	if(!$ok){
		erreur('Problème d\'écriture dans data.json. Avez-vous crée le fichier et donné les droits requis ?');
	}
}

function erreur($message){
	http_response_code(500);
	echo json_encode(['erreur'=>$message]);
	die(1);
}

// Debugger (il faut d'abord créer un fichier "log" avec les droits d'écriture)
function log_dump(...$args)
{
	ob_start();
	var_dump(...$args);	
	$content = ob_get_contents();
	ob_end_clean();
	file_put_contents('log','######'.date('r').':'.getmypid().': '.$content,FILE_APPEND);
}

?>