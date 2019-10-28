	<?php 
		// Include need file(s):
		include($_SERVER['DOCUMENT_ROOT']."/include/prog_head.php");
	?>
	
	<div id="displayTableForTranslatedWordsInAllLanguages">
		<div style="width: 1090px; overflow-x: auto" >
        <table class="tableRowColoring" style="width: 100%; margin-top: 50px" id="translatedTable">
            <tr class="table_header">
                <th align="center">English</th>
                <th align="center">Deutsch</th>
                <th align="center">Español</th>
                <th align="center">Italiano</th>
                <th align="center">Português</th>
                <th align="center">Русский язык</th>
                <th align="center">中文</th>
                <th align="center">Srpski </th>
                <th align="center">Svenska</th>
                <th align="center">Français</th>
                <th align="center">Hrvatski</th>
                <th align="center">Slovenščina</th>
                <th align="center">Čeština / Český jazyk</th>
                <th align="center">Slovenčina</th>
                <th align="center">Magyar</th>
                <th align="center">Dutch</th>
                <th align="center">اللغة العربية</th>
                <th align="center">עברית</th>
                <th align="center">Türkçe</th>
                <th align="center">Român</th>
                <th align="center">Bãlgarski</th>
                <th align="center">Dansk</th>
                <th align="center">Suomi / Suomen kieli</th>
                <th align="center">Norsk</th>
                <th align="center">ελληνικά</th>
                <th align="center">Save</th>
            </tr>

            <?php
            $count=count($words['en']);
            for($i=0;$i<$count; $i++)
            {

                echo "<tr>";
                    echo "<td align=\"center\">".$words['en'][$i]."</td>";
                    echo "<td align=\"center\">".$words['de'][$i]."</td>";
                    echo "<td align=\"center\">".$words['es'][$i]."</td>";
                    echo "<td align=\"center\">".$words['it'][$i]."</td>";
                    echo "<td align=\"center\">".$words['pt'][$i]."</td>";
                    echo "<td align=\"center\">".$words['ru'][$i]."</td>";
                    echo "<td align=\"center\">".$words['zh'][$i]."</td>";
                    echo "<td align=\"center\">".$words['sr'][$i]."</td>";
                    echo "<td align=\"center\">".$words['sv'][$i]."</td>";
                    echo "<td align=\"center\">".$words['fr'][$i]."</td>";
                    echo "<td align=\"center\">".$words['hr'][$i]."</td>";
                    echo "<td align=\"center\">".$words['sk'][$i]."</td>";
                    echo "<td align=\"center\">".$words['cs'][$i]."</td>";
                    echo "<td align=\"center\">".$words['sl'][$i]."</td>";
                    echo "<td align=\"center\">".$words['hu'][$i]."</td>";
                    echo "<td align=\"center\">".$words['nl'][$i]."</td>";
                    echo "<td align=\"center\">".$words['ar'][$i]."</td>";
                    echo "<td align=\"center\">".$words['el'][$i]."</td>";
                    echo "<td align=\"center\">".$words['tr'][$i]."</td>";
                    echo "<td align=\"center\">".$words['ro'][$i]."</td>";
                    echo "<td align=\"center\">".$words['bg'][$i]."</td>";
                    echo "<td align=\"center\">".$words['da'][$i]."</td>";
                    echo "<td align=\"center\">".$words['fi'][$i]."</td>";
                    echo "<td align=\"center\">".$words['no'][$i]."</td>";
                    echo "<td align=\"center\">".$words['el'][$i]."</td>";
                    echo "<td align=\"center\"><input type='button' onclick='saveTranslatedWords()' value='Save'></td>";
                echo "</tr>";
            }


            ?>
        </table>
    </div>
	</div>