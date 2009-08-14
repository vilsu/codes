#!/usr/bin/php

<?php
  // Laaditaan html-valikko, josta voi valita luvun väliltä 0..vaihtoehtoja
  // Valikon nimi= lkm_x, missä x määräytyy parametrin jnro perusteella
  // Parametri valittu antaa nykyvalinnan
  function teevalikko($vaihtoehtoja, $valittu,$jnro) {
      echo("<selection name=\"lkm_$jnro\" size=\"1\">");
      for ($i=0; i<=vaihtoehtoja; $i++) {
         if ($i==$valittu) 
            $v="selected";
         else
            $v="";
         echo("<option value=\"$i\" $v>$i</option>");
      }    
      echo("</selection>");
      return;
   }
   
    // tietokantakyselyt
   $ryhmahaku = "select ryhma, lahjanumero from lahja order by lahjanumero";
   $vinsertti= "insert into varaus values (:varausnumero, sysdate, :varaajatunnus)";
   $rinsertti= "insert into varausrivi values(:varausnumero, :lahja, :kpl)";
   $lpaivitys= "update lahja set varattuja= varattuja + :kpl 
                where lahjanumero=:lahjanro and maara>= varattuja+:kpl";
   $lahjahaku= "select ryhmatunnus, ryhmanimi, listausjarjestys,
         lahjanumero, jarjestys, nimi, kuvaus, maara, varattuja, kuva
         from lahjaryhma, lahja
         where ryhmatunnus=ryhma
         order by listausjarjestys,jarjestys";
   $varauskysely= "select varausnumero, pvm, varaajatunnus from varaus where varaaja=:tunnus)";
   $varaussisalto= "select lahja, kpl from varausrivi
         where varausnumero=:numero";
   $poisto= "delete from varausrivi where varausnumero=:varausnumero and lahja=:lahjanro";

   
   $comment = "#";
   $counter = 0;
   // luetaan asetustiedosto: sisältää jotain ohjelman perusasetuksia ja 
   // käyttäjätunnuksen sekä salasanan
   $cfile="lahja.cnf";
   if (!($fp = fopen($cfile, "r"))) {                 // avataan tiedosto
      die("Asetustiedoston luku epäonnistui");
   }
   else {
      while (!feof($fp)) {                           //kunnes loppuu
      $line = trim(fgets($fp));                      // luetaan seuraava rivi
                                                     // tyhjät pois
      if ($line && !ereg("^$comment", $line)) {      // ei ole kommentti
         $pieces = explode("=", $line);              //jaetaan '=' erottamiin pätkiin
         $option = trim($pieces[0]);                 //ensimmäinen
         $value = trim($pieces[1]);                  //toinen
         $config_value[$option] = $value;            //viedään taulukkoon
         $counter++;
      }
   }
   fclose($fp); 
}                                                    //suljetaan tiedosto
?>

<!doctype html public "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title><?php echo $config_value['otsikko'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css" media="all">
<!--
h1 {text-align:center; background-color:silver}
.tavara {width:80%}
.tv {width:100%}
.ip {vertical-align:top;}
.pots {width:100%}
.rots {color:blue;padding-top:3px;padding-bottom:3px}
.ots {font-weight:bold; padding-left:10px}
.sis {padding-left:20px; font-style:italic;border-bottom:dotted}
.ins {margin-left:24px}
.oikea {margin-left:20px}
.err {color:red; font-weight:bold}
-->
</style>
</head>
<body> 
<div class="pots">
<h1><?php echo $config_value["otsake"]; ?></h1>
</div>
<?php 
  // luodaan tietokantayhteys
  $connection= OCILogon($config_value["tunnus"],
                        $config_value["salasana"],
                        $config_value["kanta"]); 
  if (!$connection) {
      // lopetetaan jos tietokanta tökkii
      echo("<p class=\"error\">Tietokantahäiriö, yritä myöhemmin uudestaan.</p>
      </body></html>");
      exit;          
  }
?>     
<table>
<tr>
 <td><img src="<?php echo $config_value["kukat"];?>"></td>
 <td> 

<div class="oikea">
<p>Tämän sivun kautta voit tehdä varauksia lahjalistan kohteisiin.
Varauksen teet valitsemalla kohteiden lukumäärät 
riveillä olevista valikoista.</p> 
<?php    
  $toiminto=$_REQUEST["submit"];
  // mahdolliset toiminnot Hae varaus, Tee varaus, Muuta varausta ja tyhja
  if (!$toiminto) $toiminto="Uusi";   
  if ($toiminto=="Hae varaus" || $toiminto=="Muuta varausta") {
     $varausnumero=$_REQUEST["vno"];
     if (!$varausnumero) {
        $toiminto="Uusi";
        echo("<P><span class=\"err\">Antamallasi varausnumerolla 
              ei löydy varausta.</span></P> ");
     }         
  }
  if ($toiminto=='Hae varaus' ) {
     echo("<p>Alla olevassa listassa näkyvät varausnumerollasi
                   <b>$tunnus</b> 
                   tehdyn varauksen tiedot.</p> 
                   <p>Voit muuttaa varaustasi kirjaamalla kenttiin uudet arvot. 
                   Jos haluat poistaa jonkin kohteen varauksen, valitse 
                   lukumääräksi 0.</p>");
  }      
?>    
 
<form name="muutos" method="post" action="<?php echo($_SERVER[PHP_SELF]);?>">
<fieldset>
<legend> Varauksen muuttaminen</legend>
<div class="ins">
  <p>Pääset muuttamaan varaustasi antamalla varausnumeron. 
     Jos olet hukannut numeron ja haluat muuttaa varaustasi, 
     soita numeroon 
     <?php echo "$config_value[puhelin] ( $config_value[agentti] )";?>.</p>

  <p>Varausnumero: 
    <input type="text" size="10" value="<?php echo $varausnumero; ?>">
    <input type="submit" name="submit" value="Hae varaus"></p>
</div>
</fieldset>
</form>
</td>
</tr>
</table>
</div>

<?php 
  if ($varausnumero){
     // jos on annettu varausnumero haetaan siihen liittyvät 
     // määrät varattu taulukkoon
       while (OCIFetch($stm)){
              $kohde= OCIReonnection,$vinsertti);
    $smtp= OCIParse($connection,$rinse= OCIParse($connection,$lpaivitys);
    if ($stm && $smtp && $CIBindByName($upd,":kpl",$maara);
       OCIBindByName($upd,":lade);
       OCIBindByName($stm,":varausnumero",$varausnumero);
    Rows($upd)==1) {
                      if (!OCIExecute($stmp,OCI_se($connection,$poisto);  
    if ($smtp && $upd && $del) {
       Ousnumero);
       OCIBindByName($stm,":varaajatunnus",$tunnus);
     );   
       OCIBindByName($del,":varausnumero",$varausnumero);
     reach ($tilattu as $kohde => $maara ) { 
          if ($maara!=$vaif ($toimii) {
                $uusi=$maara-$varattu[kohde];
              
               }   
               else {
                  $osittain=true            else {
               $toimii=false;
                    }    
mukaan[$ryhma[$kohde]]=true;
          }   
       }  
       if ($toimi,      
       }
       OCIFreeStatement($stm);
       OCIFreeStatement($   }
   }                        
  $nykyinen="START";
 
  if (!toi      
<form name="lista" method="post" action="#">
<fieldset> atunnus=OCIResult($stm,"RYHMATUNNUS");
         $ryhmanimi=OCIR, "LAHJANUMERO");
         $nimi=OCIResult($stm, "NIMI");
     aara=OCIResult($stm,"MAARA"); 
         $varattuja=OCIResult($sstm,"KUVA");
         if ($ryhmanimi!=$nykyinen && 
           a[$ryhmatunnus])) {
            echo("<tr><td colspan=\"2\" cla</b></td></tr>");
     }    
         if ($toiminto=="Uusi" || $toi {
            echo ("<tr><td  class=\"tavara\">
              uva) {
           echo("<a href=\"$kuva\" target=\"_blank\">$nimi<        }
               else
                  echo("varattu $}      
  ?>
   </table>
   <div class="ins">
  
  <?php
  if (a varausta") {
     echo("<p>Varausnumerosi on: <b>$varausnumerttamaan varaustasi.");
  }   
  if ($toiminto=="Uusi" || $toimi{
    echo("<input type=\"hidden\" name=\"vno\" value=\"$varausnumlse
        $nappi="Tee varaus";
  }  
  ?>         
  <input typemit">
  &nbsp; <input type="reset" value="Tyhjennä lomake">
</div>
</fieldset> 
</form>   

</body>
</html>
