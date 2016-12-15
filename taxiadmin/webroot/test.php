<?php


include( __DIR__ . '/config.php');

$a = new CPdfToText();
$a->setFilename('roster.pdf');
$a->decodePDF();
echo "\nhär startar det\n";
echo $a->output();