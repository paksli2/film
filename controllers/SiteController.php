<?php 
	
	class SiteController{

		public function actionIndex($page = 1){
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
						$_SESSION['info'] = 'Фильм успешно добавлен в каталог';
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