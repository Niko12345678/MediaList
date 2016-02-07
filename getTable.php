<?php
$mysqli = new MySQLi('localhost','kaptn','','my_kaptn');


if (mysqli_connect_errno()) {
    echo("Connect failed");
    exit();
}

$displayitems = 20;

$page = intval($_GET['page']);
$id = intval($_GET['id']);


if (intval($id) > 0) {

$resSet = $mysqli->query("select * from medialist Where id = ". $id );

}else{

$startindex = $page * $displayitems;
$resSet = $mysqli->query("select * from medialist order by date desc, id desc"); // LIMIT 30 OFFSET ". $startindex );

}

$datePrev = "";

if($resSet->num_rows != 0){
	
	$html = "";
	$html .= "<table class='table'>";
	$html .= "<tr>";
    $html .= "<td><b>Data</b></td>";
    $html .= "<td><b>Categoria</b></td>";
    $html .= "<td><b>Sottocategoria</b></td>";
    $html .= "<td><b>Titolo</b></td>";
	$html .= "<td><b>Stagione</b></td>";
    $html .= "<td><b>Episodio</b></td>";
	$html .= "<td><b>Anno</b></td>";
    $html .= "<td><b>Autore</b></td>";
	$html .= "</tr>";

	while($rows = $resSet->fetch_assoc())
	{
	
		$id = $rows['id'];
		$date = $rows['date'];
		$title = $rows['title'];
		$season = $rows['season'];
		$episode = $rows['episode'];
		$category = $rows['category'];
		$subcategory = $rows['subcategory'];
		$author = $rows['author'];
		$mediayear = $rows['year'];
		$logdata = $rows['logdata'];	
			
		$day = intval(substr($date,6,2));
		$month = intval(substr($date,4,2));
		$monthName = date("F", mktime(0, 0, 0, $month, 10));
		$year = intval(substr($date,0,4));
		
		$html .= "<tr>";
		$html .= "<td>$day/$month/$year</td>";
		$html .= "<td>$category</td>";
		$html .= "<td>$subcategory</td>";
		$html .= "<td>$title</td>";
		if ($season == 0) {
			$html .= "<td></td>";
		}else{
			$html .= "<td>$season</td>";
		}
		
		if ($episode == 0) {
			$html .= "<td></td>";
		}else{
			$html .= "<td>$episode</td>";
		}
		
		if ($mediayear == 0) {
			$html .= "<td></td>";
		}else{
			$html .= "<td>$mediayear</td>";
		}
		
		$html .= "<td>$author</td>";
		$html .= "</tr>";
		
		
	}
	$html .= "</table>";
	echo ($html);
}else{

echo "<div class='data'>No Results</div>";
}

?>