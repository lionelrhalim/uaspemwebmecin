<?php 
	foreach ($jobs as $job) {
		echo "<input type='checkbox' value='" . $job['id'] . "'>" . $job['job_category'] . "<br>"
	}

 ?>