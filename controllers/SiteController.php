<?php 
	
	class SiteController{

		public function actionIndex($page = 1){

			if(isset($_FILES['file']['name'])){

				$error = false;
				$expension = 'text/plain';

				if(!Films::checkExpension($_FILES['file']['type'], $expension)){
					$error[] = 'Не подходящий тип файла';
				}

				if(!Films::checkFileSize($_FILES['file']['size'])){
					$error[] = 'Слишком большой размер файла';
				}

				if($error == false){
					// $path = Films::UPLOAD_DIR.'/'.date('Ymd-His').'txt'.rand(100,1000).'.txt';
					// move_uploaded_file($_FILES['file']['tmp_name'], $path);
					// $section = file_get_contents($path, NULL, NULL, 20, 14);
					$section = file($_FILES['file']['tmp_name'], FILE_SKIP_EMPTY_LINES);
					$count = count($section);
					// echo $count;

					$films = array();
					$index = 0;
					for($i = 0; $i< ($count-3); $i+=5){
						$films[$index]['title'] = trim(substr(strrchr($section[$i], ":"), 1));
						$films[$index]['year'] = trim(substr(strrchr($section[$i+1], ":"), 1));
						$films[$index]['format'] = trim(substr(strrchr($section[$i+2], ":"), 1));
						$films[$index]['cast'] = trim(substr(strrchr($section[$i+3], ":"), 1));

						$index++;
					}
					// var_dump($films);
					// echo "<pre>".print_r($films,1)."</pre>";

					$filmIds = Films::addFilmsToDB($films);
					// echo '<pre>'.print_r($filmIds,1).'</pre>';
					// die();
					if($filmIds){
						$castArr = Actors::addArrActorsToDB($films);
						// echo '<pre>'.print_r($castArr,1).'</pre>';
						// die();
						$result = Actors::addArrLinkInDB($filmIds, $castArr);
						if($result){
							$_SESSION['info'] = 'Фильмы успешно импортированы из файла в ваше хранилище';
							header("Location: /film/");
							exit();
						}
					}else{
						$_SESSION['info'] = 'Фильм(ы) с таким(и) именем(ами) уже существует(ют)';
							header("Location: /film/");
							exit();
					}

					// var_dump($section);
					// $section = stristr($section, ': ');
					// $array = explode(': ',$section);

					// foreach ($array as $key => $value) {
					// 	echo $key." : ".$value."<br>";
					// }
				}else{
					$_SESSION['info'] = $error;
					header("Location: /film/");
					exit();
				}


				// foreach ($_FILES['file'] as $key => $value) {
				// 	echo $key." : ".$value."<br>";
				// }
			}


			$films = Films::getAllFilmList();

			require_once(ROOT.'/views/site/index.php');
			return true;
		}


		public function actionDelete($id){
			$id = intval($id);

			if($id){
				$delete1 = Films::deleteFilmFromDB($id);
				$delete2 = Films::deleteFilmLink($id);
				if($delete1 && $delete2){
					$_SESSION['info'] = 'Фильм удален из каталога';
					header("Location: /film/");
					exit();
				}
			}

		}


		public function actionAdd(){

			if(isset($_POST['submit'], $_POST['title'], $_POST['year'], $_POST['format'], $_POST['cast'])){
				$title = $_POST['title'];
				$year = $_POST['year'];
				$format = $_POST['format'];
				$cast = $_POST['cast'];
				if(!Films::checkFilmInDB($title)){
					$film_id = Films::addFilmToDB($title, $year, $format);
					$cast = Actors::addActorsToDB($cast);
					$result = Actors::addLinkInDB($film_id, $cast);

					if($result){
						$_SESSION['info'] = 'Фильм <i>'.$title.'</i> успешно добавлен в каталог';
						header("Location: /film/");
						exit();
					}
				}else{
					$_SESSION['info'] = 'Такой фильм уже существует!';
					header("Location: /film/");
					exit();
				}

			}


			require_once(ROOT.'/views/site/add.php');
			return true;
		}

	}

?>