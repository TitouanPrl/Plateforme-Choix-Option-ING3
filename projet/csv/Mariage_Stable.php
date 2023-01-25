<?php
/**
 *
 */
class Eleves
{
  public $_prenom;
  public $_nom;
  public $_mail;
  public $_etcs;
  public $_moyenne;
  public $_voeux;
  public $_choix;

  function __construct($arg)
  {
    $this->_prenom = $arg[0];
    $this->_nom = $arg[1];
    $this->_mail = $arg[2];
    $this->_etcs = $arg[3];
    $this->_moyenne = floatval(strtr($arg[4],",","."));
    $this->_voeux = array();

    $tmp = count($arg);
    $f=0;
    for($i=5;$i<$tmp;$i++) $this->_voeux[$f++] = strval(trim($arg[$i])); //trim supprime les espaces

    $this->_choix;
  }

  function rang() {

   foreach ($this->_voeux as $key => $value) {
     if($value == $this->_choix) return $key + 1;
   }

   return -1;
 }

}

//==============================================================================================//

/*
 *
 *Auteur    : Nicolas
 *Date      : 03/05/22 : 11h-13h
 *Version   : 1.0
 * ===============
 *Desc      : fonction qui lit un fichier .csv et le transforme en Tableau 2D
 * ==============
 *Pré-cond  : Le nom du fichier.csv
 *Post-cond : return un tableau 2D contenant les informations du csv
 *
 */
function CsvToArr($filename = 'NULL')
{
  //Vérification de l'existance du fichier sinon écrit dans les logs
  if( !file_exists($filename) ) return "ERROR";

  $i = 0;
  $arr = array();
  $file = fopen($filename, 'r');
  //boucle à travers chaque ligne du csv
  while( ($line = fgetcsv($file, ";", "\n")) != FALSE ) $arr[$i++] = explode(';',  $line[0]); //split chaque ligne en tableau 1D et l'affect au résultat

  return $arr;
}

//==============================================================================================//

/*
 *
 *Auteur    : Nicolas
 *Date      : 17/05/22
 *Version   : 1.0
 * ===============
 *Desc      : fonction qui trie un array d'Eleves en fonction de leurs moyenne
 * ==============
 *Pré-cond  : array d'Eleves  + longueur de l'array
 *Post-cond : retourn l'array trié
 *
 */
function sortEleves($arr, $len)
{

  for ($i=1; $i < $len; $i++) {
    $elt = $arr[$i];
    $j;

    for ($j=$i; $j > 0 && floatval($arr[$j - 1]->_moyenne) < floatval($elt->_moyenne); $j--) {
      $arr[$j] = $arr[$j-1];
    }

    $arr[$j] = $elt;
  }

  return $arr;
}

//==============================================================================================//

/*
 *
 *Auteur    : Nicolas
 *Date      : 16/05/22
 *Version   : 1.0
 * ===============
 *Desc      : fonction qui transforme un tableau de données en tableau d'Eleves
 * ==============
 *Pré-cond  : une tableau dont chaque ligne contient les informations de l'élève
 *Post-cond : retourne un tableau d'Eleves
 *
 */
function Array2Eleves($arrCsv)
{
  $res = array();
  $f = 0;
  $first = 0;

  //boucle a travers les données du CSV
  foreach ($arrCsv as $Eleve) {
    //on skip la 1ere ligne
    if($first == 0) $first = 1;

    else $res[$f++] = new Eleves( $Eleve );
  }

  return $res;
}

//==============================================================================================//

/*
 *
 *Auteur    : Nicolas
 *Date      : 17/05/22
 *Version   : 1.0
 * ===============
 *Desc      : fonction qui créer un tableau avec toutes les options disponible pour 1 spé
 * ==============
 *Pré-cond  : tableau des options + spé : GSI = 1 | MI : 2 | MF : 3
 *Post-cond : retourne un tableau avec toutes les options possible pour une spé
 *
 */
function SplitOption($arr, $spe)
{
  $first = 1;
  //pour résoudre un bug inconnue ou HPDA n'était pas reconnu
  $res = array("NULL");

  foreach ($arr as $intels) {

    //on saute la 1ere ligne
    if($first == 1){
      $first = 0;
    }


    else{
      //on ajoute n fois la spé (n étant le nombre de place dispo)
      for($i = 0; $i < intval($intels[$spe]); $i++) array_push($res, strval($intels[0]));

    }
  }

  return $res;
}

//==============================================================================================//

/*
 *
 *Auteur    : Nicolas
 *Date      : 03/05/22 : 11h-13h
 *Version   : 1.0
 * ===============
 *Desc      : fonction qui lit un fichier .csv et le transforme en Tableau 2D
 * ==============
 *Pré-cond  : Le nom du fichier.csv
 *Post-cond : return un tableau 2D contenant les informations du csv
 *
 */
function GaleShapley($Eleves = array(), $spe = array())
{
  $res = array();

  //on fait copie du tableau des Elèves
  $save = array();
  foreach ($Eleves as $key => $copy) {
    $save[$key] = $copy;
  }

  //tant qu'il reste un Elèves sans spé
  while( !empty($save)){

    $i = 0;
    //tant que l'élève avec la meilleur moyenne n'a pas de choix
    while ( !isset($save[ 0 ]->_choix) ) {

      //on cherche dans les spé si son ième voeux est disponible
      if( in_array($save[0]->_voeux[$i], $spe) ){
        $index_Spe = array_search($save[0]->_voeux[$i], $spe);

        //On lui affecte son voeux
        $save[ 0 ]->_choix = $spe[ $index_Spe ];

        //on enlève la spé qu'il a prit
        unset($spe[ $index_Spe ]);
      }

      //sinon on passe au prochain voeux
      $i++;
    }

    //on pousse dans res l'Eleves avec son choix
    array_push($res, array_shift($save));

  }

  return $res;
}

//==============================================================================================//


function MergeEleves($arrOfarr)
{
  $res = array();
  foreach ($arrOfarr as $groupe) {
    foreach ($groupe as $eleves) {
      array_push($res, $eleves);
    }
  }

  return sortEleves($res, count($res));
}




//set variable
$Option = CsvToArr($_POST["nbPlace"]);

$ElevesMI = Array2Eleves(CsvToArr($_POST["MI"]));
$ElevesMI = sortEleves($ElevesMI, count($ElevesMI));

$ElevesGSI = Array2Eleves(CsvToArr($_POST["GSI"]));
$ElevesGSI = sortEleves($ElevesGSI, count($ElevesGSI));

$ElevesMF = Array2Eleves(CsvToArr($_POST["MF"]));
$ElevesMF = sortEleves($ElevesMF, count($ElevesMF));


$MI = GaleShapley($ElevesMI, SplitOption($Option, 2));
$GSI = GaleShapley($ElevesGSI, SplitOption($Option, 1));
$MF = GaleShapley($ElevesMF, SplitOption($Option, 3));

  $option_rang = array();
  $option_moyenne = array();
  $option_last = array();
  $option_moyenne_rang = array();

  $fichier = fopen("Mariage_res.csv", "w+");
  fputcsv($fichier, array("nom", "prenom", "mail", "etcs", "moyenne", "choix", "attribué", "rang"), ";");

foreach (array("MI" => $MI, "GSI" => $GSI, "MF" => $MF) as $key => $value) {

  foreach ($value[0]->_voeux as $spe) {

    if(!isset($option_rang[$spe]) ) $option_rang[$spe]= 1;
    if(!isset($option_moyenne[$spe]) ) $option_moyenne[$spe] = 0;
    if(!isset($option_last[$spe]) ) $option_last[$spe] = array('Note' => 20 , "Eleve" => 0);
    if(!isset($option_moyenne_rang[$spe]) ) $option_moyenne_rang[$spe] = 0;
  }


  foreach($value as $eleve){
    $option_moyenne[$eleve->_choix] += $eleve->_moyenne;
    $option_moyenne_rang[$eleve->_choix] += $eleve->rang();
    if($eleve->_moyenne < $option_last[$eleve->_choix]["Note"]){
      $option_last[$eleve->_choix]["Note"] = $eleve->_moyenne;
      $option_last[$eleve->_choix]["Eleve"] = $eleve->_mail;
    }
		fputcsv($fichier, array($eleve->_nom, $eleve->_prenom, $eleve->_mail, $eleve->_etcs, $eleve->_moyenne, $eleve->_choix, $eleve->rang(), $option_rang[$eleve->_choix]++), ";");
	}

}

fclose($fichier);
  $fichier = fopen("Option_Stats.csv", "w+");
  fputcsv($fichier, array("Option", "Moyenne", "Rang", "dernier", "total"), ";");
  foreach ($option_moyenne as $spe => $moy) {
    fputcsv($fichier, array($spe, $moy/($option_rang[$spe]-1), $option_moyenne_rang[$spe]/($option_rang[$spe]-1), $option_last[$spe]["Note"], $option_rang[$spe]-1), ";");
    //echo ." ; ".$option_last[$spe]["Eleve"]." : ".$option_last[$spe]["Note"]." ; ".." | ";
  }
  fclose($fichier);



header("location: ../AccueilAdmission.php");
?>
