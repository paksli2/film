<?php 
	
	class Films{

		const SIZE = 500000;
		const UPLOAD_DIR = './txt';

		public static function checkExpension($exp, $exp_example){

			if($exp == $exp_example){
				return true;
			}

			return false;

		}

		public static function checkFileSize($size){
			if($size < self::SIZE){

				return true;
			}

			return false;
		}

		public static function getAllFilmList(){
			$db = Db::getConnection();
			$filmList = array();

			$result = $db->query('SELECT id,title,year FROM films');

			$i = 0;

			while($row = $result->fetch()){
				$filmList[$i]['id'] = $row['id'];
				$filmList[$i]['title'] = $row['title'];
				$filmList[$i]['year'] = $row['year'];
				$i++;
			}

			return $filmList;

		}

		public static function deleteFilmFromDB($id){

			$db = Db::getConnection();

			$sql = ('DELETE FROM films WHERE id = :id');
			$result = $db->prepare($sql);
			$result->bindParam(':id',$id, PDO::PARAM_INT);
			return $result->execute();

		}

		public static function deleteFilmLink($id){
			$db = Db::getConnection();

			$sql = ('DELETE FROM films2actors WHERE film_id = :id');
			$result = $db->prepare($sql);
			$result->bindParam(':id',$id, PDO::PARAM_INT);
			return $result->execute();
		}

		public static function addFilmToDB($title, $year, $format){

			$db = Db::getConnection();

			$title = $db->quote($title);
			$year = $db->quote($year);
			$format = $db->quote($format);

			$result = $db->query('
					INSERT INTO films SET
					title = '.$title.',
					year = '.$year.',
					format = '.$format.'
				');

			return $db->lastInsertId();
		}

		public static function addFilmsToDB($films){
			$filmsIds = array();
			if(is_array($films)){
				foreach ($films as $key => $value) {
					if(!self::checkFilmInDB($value['title'])){
						$filmsIds[] = self::addFilmToDB($value['title'], $value['year'], $value['format']);
					}
				}
			}

			return $filmsIds;

		}

		public static function checkFilmInDB($film_name){

			$db = Db::getConnection();

			$sql = ('SELECT* FROM films WHERE title = :film_name');
			$result = $db->prepare($sql);
			$result->bindParam(':film_name',$film_name, PDO::PARAM_STR);
			$result->execute();
			$row = $result->fetch();
			$array = array();
			$array = $row;

			if($row){
				return true;
			}else{
				return false;
			}


		}

		public static function getFilmByTitle($title){
			$db = Db::getConnection();

			$sql = ('SELECT* FROM films WHERE title = :title');
			$result = $db->prepare($sql);
			$result->bindParam(':title',$title, PDO::PARAM_STR);
			$result->execute();
			return $result->fetch();
		}

		public static function getFilmById($id){

			$db = Db::getConnection();

			$sql = ('SELECT* FROM films WHERE id = :id');
			$result = $db->prepare($sql);
			$result->bindParam(':id',$id, PDO::PARAM_INT);
			$result->execute();
			return $result->fetch();
		}

		public static function getFilmByActorId($actor_id){
			$actor_id = intval($actor_id);
			$db = Db::getConnection();

			$filmsId = array();
			// $result = $db->query('SELECT* FROM films2actors WHERE actor_id = '.$actor_id);
			$sql = ('SELECT* FROM `films2actors` WHERE actor_id = :actor_id');
			$result = $db->prepare($sql);
			$result->bindParam(':actor_id',$actor_id, PDO::PARAM_INT);
			$result->execute();

			while ($row = $result->fetch()) {
				$filmsId[] = $row['film_id'];
			}

			return $filmsId;

		}

		public static function getFilmByAlphabet($param){
			$db = Db::getConnection();

			$sql = "SELECT* FROM films ORDER BY title ".$param;
			// $result = $db->prepare($sql);
			// $result->bindParam(':param',$param, PDO::PARAM_STR);
			// $result->execute();
			$result = $db->query($sql);
			$filmList = array();

			$i = 0;
			while($row = $result->fetch()){
				$filmList[$i]['id'] = $row['id'];
				$filmList[$i]['title'] = $row['title'];
				$i++;
			}

			return $filmList;

		}

		public static function getActorId($actor_name){

			$db = Db::getConnection();
			// $sql = "SELECT* FROM actors WHERE name = ".$actor_name;
			// $result = $db->query($sql);
			$sql = "SELECT* FROM actors WHERE `name` = :actor_name";
			$result = $db->prepare($sql);
			$result->bindParam(':actor_name',$actor_name, PDO::PARAM_STR);
			$result->execute();
			$row = $result->fetch();
			// $row = $result->fetch();
			if($row){
				return $row['id'];
			}
			return false;
		}

		public static function getFilmByActor($actor_name){

			$id = self::getActorId($actor_name);
			// return $id;
			$films = self::getFilmByActorId($id);
			// return $films;
			$filmsId = implode(',', $films);
			// return $filmsId;
			$db = Db::getConnection();				
			$result = $db->query('SELECT* FROM films WHERE id IN ('.$filmsId.')');
			// $sql = ("SELECT* FROM `films` WHERE id IN (:filmsId)");
			// $result = $db->prepare($sql);
			// $result->bindParam(':filmsId',''$filmsId, PDO::PARAM_INT);
			// $result->execute();
			// $filmsArr = array();

			$i = 0;
			while($row = $result->fetch()){
				$filmsArr[$i]['id'] = $row['id'];
				$filmsArr[$i]['title'] = $row['title'];
				++$i;
			}

			return $filmsArr;

		}

		public static function calcCount($array){
			$count = 0;
			foreach ($array as $key => $value) {
				$count++;
			}
			return $count;
		}

	}


?>