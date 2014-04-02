<?php

/**
 *   @file
 *   @brief
 *
 *   @author adarby
 *   @date
 *   @todo
 */

$subcat = "guides";
$header = "noshow";

include("../../includes/header.php");

$add_info = "";
$results = "";

if (isset($_POST['shortform'])) {

	$q = "SELECT DISTINCT p.pluslet_id, LEFT(p.title, 75), p.type
			FROM pluslet p INNER JOIN pluslet_tab pt
			ON p.pluslet_id = pt.pluslet_id
			INNER JOIN tab t
			ON pt.tab_id = t.tab_id
			INNER JOIN subject s
			ON t.subject_id = s.subject_id
			WHERE s.shortform = '" . $_POST["shortform"] . "'
			AND p.type != 'Special'";

} elseif ($_POST["search_terms"]) {

	$q = "SELECT distinct p.pluslet_id, LEFT(p.title, 75), p.type FROM pluslet p
	WHERE p.title LIKE '%" . addslashes($_POST["search_terms"]) .  "%' AND p.type != 'Special'
	ORDER BY p.title
	";

}

 //print $q;

$r = $db->query($q);

$row_count = 0;

if (count($r) != 0) {
	foreach ($r as $myrow){

		$colour1 = "#fff";
		$colour2 = "#F6E3E7";
		$row_colour = ($row_count % 2) ? $colour1 : $colour2;

			if (isset($_POST["search_terms"])) {
				$add_info = "";
				// get the subject
				$q2 = "SELECT s.subject
						FROM subject s INNER JOIN tab t
						ON s.subject_id = t.subject_id
						INNER JOIN pluslet_tab pt
						ON t.tab_id = pt.tab_id
						INNER JOIN pluslet p
						ON pt.pluslet_id = p.pluslet_id
						WHERE p.pluslet_id = $myrow[0]";
				$r2 = $db->query($q2);
				$this_sub = mysql_fetch_row($r2);
				$add_info = "<span style=\"font-size: 10px;\">($this_sub[0])</span>";
			}
		$results .= "<div style=\"background-color:$row_colour ; padding: 2px;\"><img src=\"$IconPath/list-add.png\" name=\"add-$myrow[0]-$myrow[2]\" border=\"0\" alt=\"add\" /> $myrow[1] $add_info</div>";

		//$viewer .= "<div id=\"show-$myrow[0]\" style=\"display: none;\">$myrow[2]</div>";
		$row_count++;

	}
} else {
	$results = "<p>There were no results.  Drat!</p>";
}

print "<div style=\"clear: both; float: left; \">$results </div>";
?>


