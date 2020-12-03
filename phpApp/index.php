<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	include("model/api-property.php");
?>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Lewis Soutar - A Coding Solution</title>
</head>
<body>

	<?php
		$csvData = getArrayOfData('data/dataSet.csv');
		
		$dateArray = getActiveDates();
		
		$sortedList = sortTenantAppointments($csvData, $dateArray);
		
		$count1 = 0;
		$count2 = 0;
		$count3 = 0;
		$count4 = 0;
		foreach ($sortedList as $index => $type) {
			if($index == 0){
				$count1+= count($type);
			}else if($index == 1){
				$count2+= count($type);
			}else if($index == 2){
				$count3+= count($type);
			}else if($index == 3){
				$count4+= count($type);
			}
		}
		
		// echo "<pre>";
		// print_r ($sortedList);
		// echo "</pre>";
	?>
	
	<div style="display:flex;">
		<div id="firstManager" style="width:20%; margin-right:2.5%; margin-left:2.5%;">
			<h2 align="center">First Poperty Manager List</h2>
			<?php
				for($x=0; $x<sizeof($sortedList); $x++){
					if($x == 0){
						for($y=0; $y<$count1; $y++){
							echo "<b><u>".$sortedList[$x][$y][4]."</u> -- ".$sortedList[$x][$y][5]."</b><br>";
							echo "<i>Property: ".$sortedList[$x][$y][6]."</i><br>";
							echo $sortedList[$x][$y][1]." ".$sortedList[$x][$y][2]." (ID: ".$sortedList[$x][$y][0].")<br>";
							echo "(".$sortedList[$x][$y][3].")";
							echo "<br>";
							echo "<br>";
						}
					}
				}
			?>
		</div>
		
		<div id="secondManager" style="width:20%; margin-right:2.5%; margin-left:2.5%;">
			<h2 align="center">Second Poperty Manager List</h2>
			<?php
				for($x=0; $x<sizeof($sortedList); $x++){
					if($x == 1){
						for($y=0; $y<$count2; $y++){
							echo "<b><u>".$sortedList[$x][$y][4]."</u> -- ".$sortedList[$x][$y][5]."</b><br>";
							echo "<i>Property: ".$sortedList[$x][$y][6]."</i><br>";
							echo $sortedList[$x][$y][1]." ".$sortedList[$x][$y][2]." (ID: ".$sortedList[$x][$y][0].")<br>";
							echo "(".$sortedList[$x][$y][3].")";
							echo "<br>";
							echo "<br>";
						}
					}
				}
			?>
		</div>
		
		<div id="thirdManager" style="width:20%; margin-right:2.5%; margin-left:2.5%;">
			<h2 align="center">Third Poperty Manager List</h2>
			<?php
				for($x=0; $x<sizeof($sortedList); $x++){
					if($x == 2){
						for($y=0; $y<$count3; $y++){
							echo "<b><u>".$sortedList[$x][$y][4]."</u> -- ".$sortedList[$x][$y][5]."</b><br>";
							echo "<i>Property: ".$sortedList[$x][$y][6]."</i><br>";
							echo $sortedList[$x][$y][1]." ".$sortedList[$x][$y][2]." (ID: ".$sortedList[$x][$y][0].")<br>";
							echo "(".$sortedList[$x][$y][3].")";
							echo "<br>";
							echo "<br>";
						}
					}
				}
			?>
		</div>
		
		<div id="rescheduling" style="width:20%; margin-right:2.5%; margin-left:2.5%;">
			<h2 align="center">Rescheduling List</h2>
			<?php
				for($x=0; $x<sizeof($sortedList); $x++){
					if($x == 3){
						for($y=0; $y<$count4; $y++){
							echo "<b><u>".$sortedList[$x][$y][4]."</u> -- ".$sortedList[$x][$y][5]."</b><br>";
							echo "<i>Property: ".$sortedList[$x][$y][6]."</i><br>";
							echo $sortedList[$x][$y][1]." ".$sortedList[$x][$y][2]." (ID: ".$sortedList[$x][$y][0].")<br>";
							echo "(".$sortedList[$x][$y][3].")";
							echo "<br>";
							echo "<br>";
						}
					}
				}
			?>
		</div>
	
	</div>
	
	
</body>
</html>