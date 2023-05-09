<?
	include_once $_SERVER["DOCUMENT_ROOT"]."/Core/core.php";

	$kind = $_REQUEST["kind"];

	$SQL = "SELECT * FROM categoryB WHERE categoryA_idx = '$kind'";
	$RLT = mysql_query($SQL);
	$i = 0;
	while($ROW = mysql_fetch_array($RLT))
	{
		$val[$i]["idx"] = $ROW["idx"];
		$val[$i]["title"] = $ROW["titleB"];

		$i++;
	}

	$output = json_encode($val);
	echo $output;
?>