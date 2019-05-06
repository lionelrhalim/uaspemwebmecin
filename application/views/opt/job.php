<?php 
	foreach ($jobs as $job) {
		echo "<input type='checkbox' name='job_list[]' value='" . $job['id'] . "'>" . $job['job_category'] . "<br>";
	}

 ?>