<?php  
	foreach ($banks as $bank) {
		echo 
			"<option value='" . $bank['bank_name'] . "'>" . 
				$bank['bank_name'] . 
			"</option>";
	}
