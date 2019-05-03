<?php 
	foreach ($fields as $field) {
		echo "<input type='checkbox' value='" . $field['id'] . "'>" . $field['field_category'] . "<br>"
	}