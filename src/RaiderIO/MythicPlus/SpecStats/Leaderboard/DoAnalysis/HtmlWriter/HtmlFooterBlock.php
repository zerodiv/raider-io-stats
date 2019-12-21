<?php

namespace RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;

use RaiderIO\MythicPlus\SpecStats\Leaderboard\DoAnalysis\HtmlWriter;

class HtmlFooterBlock
{
    public static function create(HtmlWriter $writer): string
    {
        return <<<'FOOTER'
        <div id="footer">
        <hr>  
        <center>
        <table>        
        <tr>
        <th>Credits:</th>
        <td><a href="https://discord.gg/wf6RvZ">Team: Fetch and Carry</a></td>
        <td><a href="https://raider.io/">Raider IO</a></td>
        <td><a href="https://www.icy-veins.com/">Icy Veins</a></td>
        <td><a href="http://www.github.com">Hosted on GitHub Pages</a></td>
        <td><a href="https://thomasf.github.io/solarized-css/">Solarized Dark CSS</a></td>
        </tr>
        </table>
        </center>
        </div>
  
<script>switchClass("#death_knight_blood");<