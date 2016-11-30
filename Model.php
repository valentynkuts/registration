<?php

/**
* 
*/
class Model
{

	private static $link;

	public static function db_connection()
	{
		$host ='localhost';
		$dbname ='protest14';
		$user = 'bloguser';
		$password = '123';
		$charset = 'utf8';

		self::$link = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user , $password);


	}

//**********************************************************
	public static function close_db_connection()
	{
		self::$link = null;
	}


//*************************************************

	public static function getPersonData($email){


		$result = self::$link->query("SELECT*FROM checked_in_people WHERE email = '$email'");
		$data = [];
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$data['id'] = $row['id'];
			$data['name'] = $row['name'];
			$data['email'] = $row['email'];
			$data['territory'] = $row['territory'];

		}

		return $data;

	}



//***************************************************
	public static function get_Person_Data($email){




		$sql = 'SELECT * FROM checked_in_people WHERE email = :email';

		$result = self::$link->prepare($sql);
		$result->bindParam(':email', $email, PDO::PARAM_STR);
		$result->execute();
		$arr=$result->fetchAll(PDO::FETCH_ASSOC);
		$data=[];
		foreach ($arr as $key => $value){
			$data = $value;

		} 


		return $data;


	}

//******************************


	public static function getRegion() 
	{        

		$result = self::$link->query("SELECT ter_name FROM t_koatuu_tree WHERE ter_pid IS NULL");
		$regionList = [];


		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$regionList[] = $row['ter_name'];
		}


		return $regionList;
	}
//*************************************************************
	public static function getPlace_by_id($id) 
	{
		
        $result = self::$link->query("SELECT ter_id FROM t_koatuu_tree WHERE ter_name = '$id'");
        $ter_id = $result->fetch();
		$ter_pid = $ter_id['ter_id'];

		
		return $ter_pid;


	}

//******************************************************
	public static function getList_places($id){


		$result = self::$link->query("SELECT ter_name FROM t_koatuu_tree WHERE ter_pid = '$id'");
		$placeList = [];
		while($row = $result->fetch()) {
			$placeList[] = $row['ter_name'];

		}

		return $placeList;

	}
//*********************************************************

	public static function addPerson($full_name, $e_mail, $region, $city, $area){


		$territory ="$region, $city, $area";

		$sql = 'INSERT INTO checked_in_people (name,email,territory)' 
		.'VALUES (:name, :email, :territory)';

		$result = self::$link->prepare($sql);
		$result->bindParam(':name', $full_name, PDO::PARAM_STR);
		$result->bindParam(':email', $e_mail, PDO::PARAM_STR);
		$result->bindParam(':territory', $territory, PDO::PARAM_STR);

		return $result->execute();

	}

//*********************************************************
	public static function getEmailList(){


		$result = self::$link->query("SELECT email FROM checked_in_people");
		$email = [];
		while($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$email[] = $row['email'];

		}

		return $email;
	}

//*****************************************
	

}