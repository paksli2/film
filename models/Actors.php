<?php

	class Actors{

		public static function checkActorsInDB($actor_name){

				$db = Db::getConnection();				

				$sql = ('SELECT* FROM actors WHERE name = :actor_name');
				$result = $db->prepare($sql);
				$result->bindParam(':actor_name',$actor_name, PDO::PARAM_STR);
				$result->execute();
				$row = $result->fetch();

				if($row){
					return true;
				}else{
					return false;
				}


		}

		public static function getActorsLinkId($film_id){
			$db = Db::getConnection();				

			$sql = ('SELECT* FROM films2actors WHERE film_id = :film_id');
			$result = $db->prepare($sql);
			$result->bindParam(':film_id',$film_id, PDO::PARAM_INT);
			$result->execute();
			$actors_id = array();

			$i = 0;

			while($row = $result->fetch()){
				$actors_id[$i] = $row['actor_id'];
				$i++;
			}

			return $actors_id;
		}

		public static function getActorsByFilmId($film_id){

			$actors_id = self::getActorsLinkId($film_id);

			$actors_id = implode(',', $actors_id);


			$db = Db::getConnection();				
			$result = $db->query('SELECT* FROM actors WHERE id IN ('.$actors_id.')');

			$actors_name = array();


			while($row = $result->fetch()){
				$actors_name[] = $row['name'];
			}

			return $actors_name;

		}


		public static function addActorsToDB($cast){
			if(is_string($cast)){
				// $actors_id = array();
				$db = Db::getConnection();
				$cast = explode(',', $cast);

				foreach ($cast as $name) {

					if(!self::checkActorsInDB($name)){
						// $db->query('INSERT INTO actors SET name = '.$name);
						$name = trim($name);
						$sql = ('INSERT INTO actors SET name =:name');
						$result = $db->prepare($sql);
						$result->bindParam(':name',$name, PDO::PARAM_STR);
						$result->execute();
					}
					// $actors_id[] = $db->lastInsertId();
				}

			}

			return $cast;
		}

		public static function getActorsId($cast){

			if(is_array($cast)){
				// print_r($cast);
				// die();
				$db = Db::getConnection();
				$actors_id = array();
				foreach ($cast as $value) {
					$value = trim($value);
					$sql = ('SELECT* FROM actors WHERE name =:value');
					$result = $db->prepare($sql);
					$result->bindParam(':value',$value, PDO::PARAM_STR);
					$result->execute();
					$row = $result->fetch();
					$actors_id[] = $row['id'];
				}
			}

			return $actors_id;

		}

		public static function addLinkInDB($film_id, $cast){
			$film_id = intval($film_id);
			if(is_array($cast)){
				$db = Db::getConnection();
				$actors_id = self::getActorsId($cast);
				// print_r($actors_id);
				// die();
				foreach ($actors_id as $id) {
					$sql = ('INSERT INTO films2actors SET 
						film_id = :film_id, 
						actor_id = :id');
					$result = $db->prepare($sql);
					$result->bindParam(':film_id',$film_id, PDO::PARAM_INT);
					$result->bindParam(':id',$id, PDO::PARAM_INT);
					$result->execute();
					// $db->query('INSERT INTO films2actors SET 
					// 	film_id = '.$film_id.', 
					// 	actor_id = '.$id);
				}

			}

			return true;

		}

		public static function getActorId($actor_name){

			$db = Db::getConnection();

			$sql = ('SELECT* FROM actors WHERE name = :actor_name');
			$result = $db->prepare($sql);
			$result->bindParam(':actor_name',$actor_name, PDO::PARAM_STR);
			$result->execute();
			$row = $result->fetch();
			return $row['id'];
		}

	}

?>