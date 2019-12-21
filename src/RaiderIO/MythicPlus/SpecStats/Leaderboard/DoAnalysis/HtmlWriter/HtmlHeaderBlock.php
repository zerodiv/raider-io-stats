<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;

class HtmlHeaderBlock
{
    public static function create(HtmlWriter $writer, string $title = ''): string
    {
        $titleString = 'RaiderIO Stats';

        if ($title !== '') {
            $titleString = ': ' . $title;
        }

        //var_dump($titleString);

        return <<<HEADER
<!doctype html>
<html lang="en-US">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
        
<title>$titleString| zerodiv.github.io</title>
<meta property="og:locale" content="en_US" />
<link href="https://thomasf.github.io/solarized-css/solarized-dark.min.css" rel="stylesheet"></link>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>var whTooltips = {colorLinks: false, iconizeLinks: true, renameLinks: true};</script>
<script src="https://wow.zamimg.com/widgets/power.js"></script>
<style>
body {
    max-width: none;
}

td, th {
    border: 1px solid white;
    background-color: #268bd2;
    color: #000000;
    padding: 6px;  
}
th {
  background: #b58900;
  color: #000000;
  font-weight: bold;
}
.goodTalent {
    background-color: #268bd2;
    color: #000000;
    font-weight: bold;
}
.marginalTalent {
    background-color: #2aa198;
    color: #000000;
    font-weight: bold;
}
.badTalent {
    background-color: #6c71c4;
    color: #000000;
    font-weight: bold;
}

td a, a:visited {
    color: #000000;
}

</style>
<script>

function switchClass(className) {
    $("#death_knight_blood").hide();
    $("#death_knight_frost").hide();
    $("#death_knight_unholy").hide();
    $("#demon_hunter_havoc").hide();
    $("#demon_hunter_vengeance").hide();
    $("#druid_balance").hide();
    $("#druid_feral").hide();
    $("#druid_guardian").hide();
    $("#druid_restoration").hide();
    $("#hunter_beast_mastery").hide();
    $("#hunter_marksmanship").hide();
    $("#hunter_survival").hide();
    $("#mage_arcane").hide();
    $("#mage_fire").hide();
    $("#mage_frost").hide();
    $("#monk_brewmaster").hide();
    $("#monk_mistweaver").hide();
    $("#monk_windwalker").hide();
    $("#paladin_holy").hide();
    $("#paladin_protection").hide();
    $("#paladin_retribution").hide();
    $("#priest_discipline").hide();
    $("#priest_holy").hide();
    $("#priest_shadow").hide();
    $("#rogue_assassination").hide();
    $("#rogue_outlaw").hide();
    $("#rogue_subtlety").hide();
    $("#shaman_elemental").hide();
    $("#shaman_enhancement").hide();
    $("#shaman_restoration").hide();
    $("#warlock_affliction").hide();
    $("#warlock_demonology").hide();
    $("#warlock_destruction").hide();
    $("#warrior_arms").hide();
    $("#warrior_fury").hide();
    $("#warrior_protection").hide();
    $(className).show();
}
</script>

</head>
<body>

<div id="title">
  <h1>$titleString</h1>
</div>

HEADER;
    }
}
