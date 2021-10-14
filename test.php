<?php
include("includes/config.php");

$s = new Site();

$s->updateSite(1, "Projektsida 2", "integoogle", "Blablabla..");

echo "<pre>";
var_dump($s->getSites());
echo "</pre>";