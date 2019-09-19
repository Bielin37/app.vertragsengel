<?php
	$i=1;
	foreach($kategorie as $v) {
		echo "<p>".$v."</p>";
		$n = 1;
		while ($n < 5) {
			echo 	"<label id=\"engel".$i."_".$n."\">";
			echo		"<input class=\"input_engel\" type=\"radio\" name=\"engel".$i."\" value=\"".$n."\" onchange=\"engelPicChangeList('engel".$i."')\">";
			echo		"<img class=\"engelImage".$n."\" src=\"\">";
			echo	"</label>";
			$n++;
		}
	$i++;

	}
?>