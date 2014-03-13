<?php
	//Get new instance of MySQLi object
	$mysqli = @new mysqli('127.0.0.1', 'codeup', 'password', 'codeup_mysqli_test_db');

	// Check for errors
	if ($mysqli->connect_error) {
	    echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	} else {
		echo $mysqli->host_info . "\n";
	}

	// Create the query and assign to var
	// $query = 'CREATE TABLE national_parks (
	//     id INT NOT NULL AUTO_INCREMENT,
	//     name VARCHAR(50) NOT NULL,
	//     location VARCHAR(25) NOT NULL,
	//     description TEXT NOT NULL,
	//    	date_established DATE NOT NULL,
	//    	area_in_acres FLOAT(10,2) NOT NULL, 
	//     PRIMARY KEY (id)
	// );';

	// // Run query, if there are errors then display them
	// if (!$mysqli->query($query)) {
	//     throw new Exception("Table creation failed: (" . $mysqli->errno . ") " . $mysqli->error);
	// }

		$parks = [
			['name' => 'Acadia',
			 'location' => 'Maine',
			 'description' => 'Covering most of Mount Desert Island and other coastal islands, Acadia features the tallest mountain on the Atlantic coast of the United States, granite peaks, ocean shoreline, woodlands, and lakes. There are freshwater, estuary, forest, and intertidal habitats.',
			 'date_established' => '1919-02-26',
			 'area_in_acres' =>'47389.67'
				],
			['name' => 'Arches',
			 'location' => 'Utah',
			 'description' => 'This site features more than 2,000 natural sandstone arches, including the Delicate Arch. In a desert climate millions of years of erosion have led to these structures, and the arid ground has life-sustaining soil crust and potholes, natural water-collecting basins. Other geologic formations are stone columns, spires, fins, and towers.',
			 'date_established' => '1971-11-12',
			 'area_in_acres' =>'76518.98'
			 	],
			['name' => 'Badlands',
			 'location' => 'South Dakota',
			 'description' => 'The Badlands are a collection of buttes, pinnacles, spires, and grass prairies. It has the worlds richest fossil beds from the Oligocene epoch, and there is wildlife including bison, bighorn sheep, black-footed ferrets, and swift foxes.',
			 'date_established' => '1978-11-10',
			 'area_in_acres' =>'242755.94'
			 	],
			['name' => 'Big Bend',
			 'location' => 'Texas',
			 'description' => 'Named for the Bend of the Rio Grande along the US–Mexico border, this park includes a part of the Chihuahuan Desert. A wide variety of Cretaceous and Tertiary fossils as well as cultural artifacts of Native Americans exist within its borders.',
			 'date_established' => '1944-06-12',
			 'area_in_acres' =>'801163.21'
			 	],
			['name' => 'Canyonlands',
			 'location' => 'Utah',
			 'description' => 'This landscape was eroded into canyons, buttes, and mesas by the Colorado River, Green River, and their tributaries, which divide the park into three districts. There are rock pinnacles and other naturally sculpted rock, as well as artifacts from Ancient Pueblo Peoples.',
			 'date_established' => '1964-09-12',
			 'area_in_acres' =>'241904.26'
			 	],
			['name' => 'Capitol Reef',
			 'location' => 'Utah',
			 'description' => 'The parks Waterpocket Fold is a 100-mile (160 km) monocline that shows the Earths geologic layers. Other natural features are monoliths and sandstone domes and cliffs shaped like the United States Capitol.',
			 'date_established' => '1971-12-18',
			 'area_in_acres' =>'337597.83'
			 	],
			['name' => 'Carlsbad Caverns',
			 'location' => 'New Mexico',
			 'description' => 'Carlsbad Caverns has 117 caves, the longest of which is over 120 miles (190 km) long. The Big Room is almost 4,000 feet (1,200 m) long, and the caves are home to over 400,000 Mexican Free-tailed Bats and sixteen other species. Above ground are the Chihuahuan Desert and Rattlesnake Springs.',
			 'date_established' => '1930-05-14',
			 'area_in_acres' =>'46766.45'
			 	],
			['name' => 'Crater Lake',
			 'location' => 'Ohio',
			 'description' => 'This park along the Cuyahoga River has waterfalls, hills, trails, and displays about early rural living. The Ohio and Erie Canal Towpath Trail follows the Ohio and Erie Canal, where mules towed canal boats. The park has numerous historic homes, bridges, and structures.[21] The park also offers a scenic train ride with various trips available.',
			 'date_established' => '1902-05-22',
			 'area_in_acres' =>'32860.73 '
			 	],
			['name' => 'Death Valley',
			 'location' => 'California',
			 'description' => 'Death Valley is the hottest, lowest, and driest place in the United States. Daytime temperatures have topped 130°F (54°C) and it is home to Badwater Basin, the lowest point in North America. There are canyons, colorful badlands, sand dunes, mountains, and over 1000 species of plants in this graben on a fault line. Further geologic points of interest are salt flats, springs, and buttes.',
			 'date_established' => '1994-10-31',
			 'area_in_acres' =>'3372401.96 '
			 	],
			['name' => 'Dry Tortugas',
			 'location' => 'Florida',
			 'description' => 'The Dry Tortugas on the west end of the Florida Keys are the site of Fort Jefferson, the largest masonry structure in the Western Hemisphere. With most of the park being water, it is the home of coral reefs and shipwrecks and is only accessible by plane or boat.',
			 'date_established' => '1992-10-26',
			 'area_in_acres' =>'64701.22 '
			 	]
		];



		foreach($parks as $park) {
			$query = "INSERT INTO national_parks (name, location, description, date_established, area_in_acres) VALUES ('{$park['name']}', '{$park['location']}', '{$park['description']}', '{$park['date_established']}', '{$park['area_in_acres']}');";
			$mysqli->query($query);

		}

		
?>