<?php 
	foreach ($fields as $field) {
		echo "<input type='checkbox' name='field_list[]' value='" . $field['id'] . "'>" . $field['field_category'] . "<br>";
	}