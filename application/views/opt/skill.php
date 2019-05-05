<?php 
	foreach ($skills as $skill) {
		echo "<input type='checkbox' name='skill_list[]' value='" . $skill['id'] . "'>" . $skill['skill'] . "<br>";
	}