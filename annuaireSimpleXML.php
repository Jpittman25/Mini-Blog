<?php
$xml = simplexml_load_file("annuaire.xml");
echo $xml->getName()."<br/><p>Listing :</p>";
foreach($xml->children() as $child) {
    echo $child->getName().": ".$child->nom."-".$child->prenom."<br/>";
}
?>
