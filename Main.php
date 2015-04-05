

<?php
if(!class_exists ('Main'))
{




   class Main
   {
       function register($login_redirect)
       {

			    if ( !empty ( $_POST ) )


				    {
				       	require_once('config.php');
						require_once('database.php');
						$test = new data_base();
						
						$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						$referrer = $_SERVER['HTTP_REFERER'];

					   	$table = 'personal_info';
					    $temp1 =  array('yash');
					    
					   
					    $first_name = $_POST['first_name'];
						$last_name = $_POST['last_name'];
						$birthdate = $_POST['birthdate'];
						$email = $_POST['email'];
						$password = $_POST['password'];
						$gender = $_POST['gender']; 
					    
					   

					    $nonce = sha1('registration-' . $first_name . $last_name . time() .NONCE_SALT );
					    $pass = $test->hash_password($password , $nonce); 
					 


					    $fields = array('email','gender','first_name','last_name','password','birthdate');			
					    $temp1 = array( $email, $gender ,$first_name , $last_name , $pass , $birthdate);

					 	$fields = $test->clean($fields); 
					 	$temp1 = $test->clean($temp1);




					    $test->insert($fields , $table , $temp1);
				    
				    /*	if(test != false)
				    	{
				        
				        	header('Location: http://www.example.com/');

				    	} */

				    }


		}

	
		function addstock($option)
		{
			 
			if ( !empty ( $_POST ) )


				    {
				       	require_once('config.php');
						require_once('database.php');
						$test = new data_base();
						
						$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						$referrer = $_SERVER['HTTP_REFERER'];

						$stock_name = $_POST['stock_name'];


						if ($option==0) 
						{
							$tablename = array('1','portfolio');
							$quantity = $_POST['quantity'];

							$field = array('stock_ticker', 'quantity');
							$value =array($stock_name, $quantity);

							$field = $test->clean($field); 
							$value = $test->clean($value); 

							$fields = implode(" , ", $field);
							$values = implode("', '", $value);
						} 
						else 
						{
							$tablename = array('1','watchlist');
							$fields= "stock_ticker";
							$values= $stock_name;
						}
						

						

						$table = implode("_", $tablename);

						$check=$test->check($table,"stock_ticker",$stock_name);

						if($check==0)
						{
							$test->insert($fields , $table , $values);
						}

						else
						{
							echo "It already exists in the database";
						}
				    


					}

		}

		function retrieve()
		{
			if ( !empty ( $_POST ) )

				{
						require_once('config.php');
						require_once('database.php');
						$test = new data_base();
						
						$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						$referrer = $_SERVER['HTTP_REFERER'];

						$file = fopen("list.csv","r");
						//$i=0;

						while(! feof($file))
  						{
  							$list=fgetcsv($file);
  							$table="prediction";
  							$field = array('stock_ticker','stock_name');
  							$input = array($list[2], $list[0]);

  							$fields = implode(" , ", $field);
							$inputs = implode("', '", $input);

  							$test->insert($fields,$table,$inputs);
  						}

						fclose($file);
				}

		}

		function removestock($option)
		{

			if ( !empty ( $_POST ) )

				{
						require_once('config.php');
						require_once('database.php');
						$test = new data_base();
						
						$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						$referrer = $_SERVER['HTTP_REFERER'];

						
						if ($option==0) 
						{
							$tablename = array('1','portfolio');
						} 
						else 
						{
							$tablename = array('1','watchlist');
						}
						


						$table = implode("_", $tablename);
						$field = "stock_ticker";
						

						foreach ($_REQUEST['stock'] as $input) 
						{
							$test->delete($table, $field, $input);
									
   							
						}

						
						
				}


		}
		function editprofile($login_redirect)
		{
			 if ( !empty ( $_POST ) )


				    {
				       
						$test = new data_base();
						
						$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						$referrer = $_SERVER['HTTP_REFERER'];
						$table = 'personal_info';
					        $temp1 =  array('yash');
					    
					    
					        $first_name = $_POST['first_name'];
						$last_name = $_POST['last_name'];
						$birthdate = $_POST['birthdate'];
						$email = $_POST['email'];
						$password = $_POST['password'];
						$gender = $_POST['gender']; 
					   
					   
					   		$timestamp = time();
						    $nonce = sha1('registration-' . $first_name . $last_name . $timestamp .NONCE_SALT );
						    $pass = $test->hash_password($password , $nonce); 
						 	
						 	$authmd5 = md5($birthdate.$last_name.$gender);
						    $auth = sha1($authmd5.'auth'.AUTH_SALT.$timestamp.'authorisation'.$email.$last_name);

						    $cookie = md5($last_name.$first_name.$first_name);

						   



						    $test->update( $table , $email, $gender , $timestamp ,$first_name , $last_name ,  $birthdate);

						    $to = $email;
						    $subject = "Account Verification";
						    $mail = "click on the redirect link ".$referrer."?auth_key=".$auth."  to verify your account.";
						    $mail_send = new mailsender();
						

				    }
		}
		function changepassword($login_redirect)
       {

			    if ( !empty ( $_POST ) )


				    {
				       
						$test = new data_base();
						
						$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						$referrer = $_SERVER['HTTP_REFERER'];

					   	$table = 'personal_info';
					        $temp1 =  array('yash');
					    
					   
					         $o_password = $_POST['o_password'];
						$n_password= $_POST['n_password'];
						$temp_password = $_POST['temp_password'];
						
					     $test->changepassword($table , $o_password,$n_password,$temp_password);

						   

				    }


		}
		function polling($login_redirect)
       {
					
			    if ( !empty ( $_POST ) )


				   {
				       
						$test = new data_base();
						
						$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						$referrer = $_SERVER['HTTP_REFERER'];

					   	$table = 'prediction';
					        $temp1 =  array('yash');
					        $stock_name = $_POST['stock_name'];
					         $test->polling( $table ,$stock_name);
                        
						   
						}

				    }
				    function suggest($login_redirect)
       {
						
			    if ( !empty ( $_POST ) )


				   {
				       
						$test = new data_base();
						
						$current = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
						$referrer = $_SERVER['HTTP_REFERER'];

					   	$table = 'prediction';
					        $temp1 =  array('yash');
					         $test->suggest( $table);
                        
						   
						}

				    }

   }


}


?>
