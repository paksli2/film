<?php 
	
	class Tasks{
		const SHOW_BY_DEFAULT = 3;
		const WIDTH = 320;
		const HEIGHT = 240;
		const UPLOAD_DIR = './photos';

		public static function getTaskList($page = 1){
			$page = intval($page);

			$offset = ($page - 1)*self::SHOW_BY_DEFAULT;

			$db = Db::getConnection();

			$tasks = array();
			$result = $db->query('
				SELECT* FROM tusks 
				LIMIT '.self::SHOW_BY_DEFAULT.'
				OFFSET '.$offset);

			$i = 0;
			while ($row = $result->fetch()) {
				$tasks[$i]['id'] = $row['id'];
				$tasks[$i]['name'] = $row['name'];
				$tasks[$i]['path'] = $row['path'];
				$tasks[$i]['img_width'] = $row['img_width'];
				$tasks[$i]['img_height'] = $row['img_height'];
				$tasks[$i]['email'] = $row['email'];
				$tasks[$i]['text'] = $row['text'];
				$tasks[$i]['category_id'] = $row['category_id'];
				$tasks[$i]['status'] = $row['status'];
				++$i;
			}
			return $tasks;

		}

		public static function getAllTaskList(){

			$db = Db::getConnection();

			$tasks = array();
			$result = $db->query('SELECT* FROM tusks');

			$i = 0;

			while ($row = $result->fetch()) {
				$tasks[$i]['id'] = $row['id'];
				$tasks[$i]['name'] = $row['name'];
				$tasks[$i]['path'] = $row['path'];
				$tasks[$i]['img_width'] = $row['img_width'];
				$tasks[$i]['img_height'] = $row['img_height'];
				$tasks[$i]['email'] = $row['email'];
				$tasks[$i]['text'] = $row['text'];
				$tasks[$i]['category_id'] = $row['category_id'];
				$tasks[$i]['status'] = $row['status'];
				++$i;
			}
			return $tasks;

		}

		public static function getTotalTusk(){
			$db = Db::getConnection();
			$result = $db->query('SELECT count(id) AS count FROM tusks');
			$row = $result->fetch();
			
			return $row['count'];
		}

		public static function registerTask($name, $email, $img_width, $img_height, $path, $text){

			$db = Db::getConnection();

			$sql = 'INSERT INTO tusks (name, email, img_width, img_height, path, text)
				VALUES (:name, :email, :img_width, :img_height, :path, :text)
			';

			$result = $db->prepare($sql);
			$result->bindParam(':name',$name, PDO::PARAM_STR);
			$result->bindParam(':email',$email, PDO::PARAM_STR);
			$result->bindParam(':img_width',$img_width, PDO::PARAM_INT);
			$result->bindParam(':img_height',$img_height, PDO::PARAM_INT);
			$result->bindParam(':path',$path, PDO::PARAM_STR);
			$result->bindParam(':text',$text, PDO::PARAM_STR);

			return $result->execute();

		}

		public static function checkExpension($expensionArray, $expension){
			foreach ($expensionArray as $k => $v) {
				if($v == $expension){
					return true;
				}
			}
			return false;
		}

		public static function resizeImage($w_orig,$h_orig,$width = self::WIDTH,$height = self::HEIGHT){
			if($w_orig > $h_orig){
				$height = ($h_orig*$width)/$w_orig;
			}elseif($h_orig > $w_orig){
				$width = ($w_orig * $height)/$h_orig;
			}
			$newSize = array('width' => $width,'height' => $height);
			return $newSize;
		}

		public static function checkEmail($email){
			if(filter_var($email, FILTER_VALIDATE_EMAIL)){
				return true;
			}
			return false;
		}

		public static function calcCount($array){
			$count = 0;
			foreach ($array as $key => $value) {
				$count++;
			}
			return $count;
		}

		public static function sortElem($param, $ids){
			$db = Db::getConnection();

			$result = $db->query('SELECT* FROM tusks WHERE id IN ('.$ids.') ORDER BY '.$param.' ASC');

			
			$tasks = array();
			$i = 0;
			while ($row = $result->fetch()) {
				$tasks[$i]['id'] = $row['id'];
				$tasks[$i]['name'] = $row['name'];
				$tasks[$i]['path'] = $row['path'];
				$tasks[$i]['img_width'] = $row['img_width'];
				$tasks[$i]['img_height'] = $row['img_height'];
				$tasks[$i]['email'] = $row['email'];
				$tasks[$i]['text'] = $row['text'];
				$tasks[$i]['category_id'] = $row['category_id'];
				$tasks[$i]['status'] = $row['status'];
				++$i;
			}
			return $tasks;
		}

		public static function getTaskById($id){
			$id = intval($id);

			if($id){
				$db = Db::getConnection();

				$sql = 'SELECT* FROM tusks WHERE id = :id';

				$result = $db->prepare($sql);
				$result->bindParam(':id',$id, PDO::PARAM_INT);
				$result->execute();

				return $result->fetch();
			}
		}

	}



?>