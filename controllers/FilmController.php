<?php 


	class FilmController{

		public function actionView($id){
			$id = intval($id);

			if($id){
				$film = array();
				$film = Films::getFilmById($id);
				$actors = Actors::getActorsByFilmId($id);

				require_once(ROOT.'/views/film/index.php');
				return true;
			}

		}

		public function actionSort(){


			if(isset($_POST['search_word'], $_POST['key'])){
				$key = $_POST['key'];
				$search = $_POST['search_word'];
				if($search == 'title'){
					$film = array();
					$film[0] = Films::getFilmByTitle($key);
					$film['count'] = Films::calcCount($film);
					echo json_encode($film);
				}elseif ($search == 'name') {
					$film = array();
					$film = Films::getFilmByActor($key);
					$film['count'] = Films::calcCount($film);
					echo json_encode($film);
				}
			}

			return true;

		}

		public function actionSorts(){
			if(isset($_POST['sort'])){
				$sort = $_POST['sort'];
				$films = array();
				$films = Films::getFilmByAlphabet($sort);
				$films['count'] = Films::calcCount($films);
				echo json_encode($films);
			}

			return true;
						
		}

	}


?>