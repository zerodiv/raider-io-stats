<?php

$specFile = $argv[1];

$fh = fopen($specFile, 'r');

$inTalentBlock = false;

$spellsInOrder = array();
$spellsToNames = array();

$spellId = 0;
$spellName = '';
while ($line = fgets($fh)) {
    echo "$line\n";

    
    if (preg_match('/<td class="talent"/', $line)) {
        $inTalentBlock = true;
        echo "inTalentBlock\n";
    }

    $pregs = array();
    if ($inTalentBlock == true && preg_match('/<span class="talent_name">(.*)</', $line, $pregs)) {
        $spellName = $pregs[1];
        echo "found spell name=$spellName\n";
    }

    $pregs = array();
    if ($inTalentBlock == true && preg_match('/<a href=".*\/spells\/(\d+)\">/', $line, $pregs)) {
        $spellId = intval($pregs[1]);
        echo "found spellId=$spellId\n";
    }

    if ($inTalentBlock == true && preg_match('/<\/td>/', $line)) {
        $inTalentBlock = false;
        echo "exitingTalentBlock\n";
        $spellsInOrder[] = $spellId;
        $spellsToNames[$spellId] = $spellName;
        $spellId = '';
        $spellName = '';
    }
}
fclose($fh);

$talentBlock = '';

$col = 0;
$spellBlock = array();
foreach ($spellsInOrder as $spellId) {
    $col++;

    $spellBlock[] = $spellId;

    if ($col == 3) {
        $row = '';
        $row = implode(', ', $spellBlock) . ', // ';

        $s = 0;
        foreach ($spellBlock as $tSpellId) {
            if ($s != 0) {
                $row .= ', ';
            }
            $row .= $spellsToNames[$tSpellId];
            $s++;
        }
        $talentBlock .= $row . "\n";
        $row = '';
        $spellBlock = array();
        $col = 0;
    }
}

echo "talentBlock:\n$talentBlock\n";

echo "spellToNameArray=\n";
foreach ($spellsToNames as $spellId => $name) {
    echo $spellId . ' => "' . $name . '", ' . "\n";
}
//var_dump($spellsInOrder);
//var_dump($spellsToNames);
