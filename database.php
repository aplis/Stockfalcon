<?php
	require_once('config.php');
	if(!class_exists('data_base'))
	{
		class data_base 
		{

			function data_base() 
			{
				$db=$this->connect();
				return $db;
			}

			function connect() 
			{
				
				$link = mysql_connect('localhost', DB_USER, DB_PASS);
				if (!$link) 
				{
					die('Could not connect: ' . mysql_error());
				}
				$db_selected = mysql_select_db(DB_NAME, $link);
				if (!$db_selected) 
				{
					die('Can\'t use ' . DB_NAME . ': ' . mysql_error());
				}
			}

			function insert($values , $table , $input )
			{
			    $sql= "INSERT INTO ".DB_NAME.".".$table." (".$values.") VALUES ('". $input. "')";
			    $result = mysql_query($sql);
			    return $result;
			}
			

			function delete($table, $field, $input)
			{
				$sql = "DELETE FROM ".DB_NAME.".".$table." WHERE (".$field.") = ('".$input."')";
				$result = mysql_query($sql);
			    return $result;
			}

			function check($table, $field, $input)
			{
				$sql = "SELECT ".$field." FROM ".DB_NAME.".".$table."";
				$result = mysql_query($sql);
				$flag=0;

			   		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
					{
        				if ($row["stock_ticker"]==$input) 
        				{
        					$flag=1;
        				}
    				}
				

				return $flag;
			}
			function update( $table , $email,$gender,$timestamp,$first_name,$last_name,$birthdate)
			{
				
				$sql="UPDATE ".DB_NAME.".".$table." SET email='".$email."',gender='".$gender."',first_name='".$first_name."',last_name='".$last_name."',birthdate='".$birthdate."' where email='".$email."'";
			        echo $sql;
				$result = mysql_query($sql);
			        return $result;
			}
			function changepassword( $table , $o_password,$n_password,$temp_password)
			{
				if($n_password==$temp_password)
				$sql="UPDATE ".DB_NAME.".".$table." SET password='".$n_password."' where password='".$o_password."'";
				$result = mysql_query($sql);
			        return $result;
			}
			function polling( $table ,$stock_name)
			{

				if(isset($_POST['submit1'])){
                               
                                $sql="UPDATE ".DB_NAME.".".$table." SET buy_poll=buy_poll+1,total=buy_poll+sell_poll+hold_poll where stock_name='".$stock_name."'";
                                $result = mysql_query($sql);
				return $result;

   				 }
   			        elseif(isset($_POST['submit2']))
                                 {
                           	$sql="UPDATE ".DB_NAME.".".$table." SET sell_poll=sell_poll+1,total=buy_poll+sell_poll+hold_poll where  stock_name='".$stock_name."'";
			        $result = mysql_query($sql);
			    	return $result;
                           }
  								  
  				elseif(isset($_POST['submit3']))
                                 {
                          	$sql="UPDATE ".DB_NAME.".".$table." SET hold_poll=hold_poll+1,total=buy_poll+sell_poll+hold_poll where  stock_name='".$stock_name."'";
				$result = mysql_query($sql);
			    	return $result;
                                   }
                          elseif(isset($_POST['submit4']))
                          {
                          	 $sql2= "SELECT * from  ".DB_NAME.".".$table." where stock_name='".$stock_name."'" ;
                                 $result2 = mysql_query($sql2);
                                 $user = mysql_fetch_assoc($result2);
                              	if($user['total']!=0)
				{
					echo "The % of user who had polled buying the stock ";
					echo ($user['buy_poll']/$user['total'])*100; 
						
    					}
                          }
              
			}
			function suggest( $table )

			{
				$sql2= "SELECT * from  ".DB_NAME.".".$table." order by predicted_value desc limit 10" ; 
                                $result2 = mysql_query($sql2);
                              
                              while($row = mysql_fetch_array($result2, MYSQL_ASSOC) ) 
					{
					echo $row['stock_name'];
        				echo " ";
    				}
                              return $result2;
                        }

			function hash_password($password, $nonce) 
			{
		  		$secureHash = hash_hmac('sha512', $password . $nonce, SITE_KEY);
		 		return $secureHash;
		 	}


		 	function clean($array) 
		 	{
				return array_map('mysql_real_escape_string', $array);
		   	}

		

		    function temp()
		    {
		    	echo 'parthgghgh';
		    }
		}

	}
?>
