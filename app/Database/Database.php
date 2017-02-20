<?php
namespace App\Database;

class database {
	static function createConnection()
	{
		 $connection = mysqli_connect('localhost','root','piyumirameshka','busfinal');
    if (mysqli_connect_errno())
    {
         echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
	return $connection;
		
	}

	}


?>