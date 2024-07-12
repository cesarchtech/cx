<?php  
					date_default_timezone_set('Brazil/East'); 
					$data = date('Y-m-d');
					if (date('d')> 13){
						$data = date('Y-m-d', strtotime("+1 month", strtotime($data)));
						echo strtotime($data);
						}
					else{
						echo strtotime($data);
						}
						 ?>
						 
						 
						 <?php  date_default_timezone_set('Brazil/East'); echo date('Y-m-d'); ?>