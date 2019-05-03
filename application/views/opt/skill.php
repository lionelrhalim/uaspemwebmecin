<?php 
	foreach ($skills as $skill) {
		echo "<input type='checkbox' value='" . $skill['id'] . "'>" . $skill['skill'] . "<br>"
	}