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
