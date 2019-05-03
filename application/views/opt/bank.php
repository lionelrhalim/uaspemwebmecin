<?php  
	foreach ($banks as $bank) {
		echo 
			"<option value=" . $bank['id'] . "'>" . 
				$bank['bank_name'] . 
			"</option>";
	}
