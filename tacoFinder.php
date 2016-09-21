<!DOCTYPE = html>
<html>
<head> 
	<title>5C Taco Finder</title>
	<link rel="stylesheet" type="text/css" href="tacoStyle.css">
	<script>
		var colorTimer = window.setTimeout(strobeWhite,50);
		function strobeWhite() {
			window.clearTimeout(colorTimer);
			document.body.style.background = "linear-gradient(#1a75ff, #ff99bb)";
			whiteTimer = window.setTimeout(strobeColor, 50);
		}

		function strobeColor(){
			window.clearTimeout(whiteTimer);
			document.body.style.background = "linear-gradient(#ff99bb, #1a75ff)";
			whiteTimer = window.setTimeout(strobeWhite, 50);
		}
	</script>
</head>
	<body>
			<h1>Where are tacos?</h1>
			<div>
			<?php 
				//retrieve the day of the week
				date_default_timezone_set('America/Los_Angeles');
				$day = date("l");
				$day = strtolower($day);
				$day = substr($day, 0, 3);
				//Get the dining hall menus from the aspc API
				$menus = shell_exec("curl -H 'Authorization: Token 8227601fb7f5768fb6ccf9f5ab38c4700b884ea0' https://aspc.pomona.edu/api/menu/day/".$day."/");
				
				//Breaks menus into a JSON object of objects
				$menus = json_decode($menus);

				$tacoMeals = array();
				$lunchLocations = array();
				$dinnerLocations = array();

				for($i=0; $i<count($menus); $i++){
					$mealOptions = $menus[$i]->food_items;
					$tacoIndex = stripos($mealOptions, "taco");

					//Store taco locations & mealtimes 
					if($tacoIndex!==false){
						if($menus[$i]->meal == "lunch"){
							$lunchLocations[] = ucfirst($menus[$i]->dining_hall);
						}
						else{
							$dinnerLocations[] = ucfirst($menus[$i]->dining_hall);
						}
					}
					elseif ($menus[$i]->dining_hall=="frank" && $day=="tue" && $menus[$i]->meal=="lunch") {
						$tacoMeals[] = ("frank lunch");
					}
				}

				//Display lunch taco locations
				echo "<h2>Lunch</h2>";
				echo "<ul>";
				foreach ($lunchLocations as $meal) {
					echo "<p>";
					echo $meal;
					echo "</p>";
				}
				echo "</ul>";

				//Display dinner taco locations
				echo "<h2>Dinner</h2>";
				echo "<ul>";
				foreach ($dinnerLocations as $meal) {
					echo "<p>";
					echo $meal;
					echo "</p>";
				}
				echo "</ul>";

				//display taco tuesday gif
				echo "<img src='tacoDavid.jpg' alt='Dancing Taco' style='width:300px;height:450px;'>"
					
			?>
		</div>
		
	</body>
</html>
