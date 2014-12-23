<?php

class MangaController extends Controller
{
	 protected function beforeAction($action) {
            if(isset(Yii::app()->request->cookies['connected']) && Yii::app()->request->cookies['connected']) {
                Yii::app()->session['activeTab'] = 'mangasTab';
                return parent::beforeAction($action);
            } else {
                $this->redirect('/index.php/user');
            }
        }
        
        public function actionIndex()
	{
            $mangas = Mangas::model()->findAll();
            $this->render('index', array(
                'mangas' => $mangas
             ));
	}
        
        public function actionAdd() {
            $getTitle = Yii::app()->request->getPost('inputTitle');
            if(isset($getTitle) && $getTitle != null) {
                $mangas = new Mangas;
                $mangas->title = $getTitle;
                $mangas->status = Yii::app()->request->getPost('selectStatus');
                
                if($mangas->save()) {
                    Yii::app()->session['success'] = true;
                    Yii::app()->session['alertMessage'] = $mangas->title.' added';
                } else {
                    Yii::app()->session['error'] = true;
                    Yii::app()->session['alertMessage'] = 'Error during during adding : '.$getTitle;
                }
                $this->redirect('/index.php/manga');
            } else {
                $this->redirect('/index.php/manga');
            }
        }
        public function actionUpdate() {
            $getId = Yii::app()->request->getPost('idManga');
            if(isset($getId) && $getId != null) {
                $mangas = Mangas::model()->findByPk($getId);
                
                $mangas->title = Yii::app()->request->getPost('inputTitle');
                $mangas->episode = Yii::app()->request->getPost('inputEpisode');
                $mangas->status = Yii::app()->request->getPost('selectStatus');
                $mangas->wikiLink = Yii::app()->request->getPost('inputWikipedia');
                $mangas->streamLink = Yii::app()->request->getPost('inputStream');
                if(!empty($_FILES['fichier']['name'])) {
                    if($this->uploadImg($getId)) {
                        $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
                        $mangas->image = $getId.'.'.$extension;
                    }
                }
                
                if($mangas->save()) {
                    Yii::app()->session['success'] = true;
                    Yii::app()->session['alertMessage'] = '<a href="/index.php/manga/details?id='.$mangas->id.'">'.$mangas->title.'</a> updated';
                } else {
                    Yii::app()->session['error'] = true;
                    Yii::app()->session['alertMessage'] = 'Error during update : <a href="/index.php/manga/details?id='.$getId.'"> Show_'.$getId.'</a>';   
                }
                $this->redirect('/index.php/manga');
            } else {
                $this->redirect('/index.php/manga');
            }
        }
        
        public function actionDetails() {
            $getId = Yii::app()->request->getQuery('id');
            if(isset($getId) && $getId != null) {
                $manga = Mangas::model()->findByPk($getId);
                
                if(isset($manga) && $manga != null) {
                    $this->render('details', array(
                        'manga' => $manga 
                    ));
                } else {
                    $this->redirect('/index.php/manga');
                }
            } else {
                $this->redirect('/index.php/manga');
            }
        }
                
        public function actionUpdateEpisode() {
            if(isset($_POST) && $_POST != null) {
                $mangas = Mangas::model()->findByPk(Yii::app()->request->getPost('id'));
                $mangas->episode = Yii::app()->request->getPost('nv');
                
                if($mangas->save()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->redirect('/index.php/manga');
            }
        }
        
        public function actionDelete() {
            $ajax = Yii::app()->request->getPost('ajax');
            if(isset($ajax) && $ajax == true) {
                $getId = Yii::app()->request->getPost('idManga');
                if(isset($getId) && $getId != null) {
                    $mangas = Mangas::model()->findByPk($getId);

                    if($mangas->delete()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                $this->redirect('/index.php/manga');
            }
        }
        
        protected function uploadImg($id) {
            /************************************************************
             * Definition des constantes / tableaux et variables
             *************************************************************/
            // Constantes
            define('TARGET', 'ressources/upload/images/mangas/');    // Repertoire cible
            define('MAX_SIZE', 409600);    // Taille max en octets du fichier
            define('WIDTH_MAX', 1920);    // Largeur max de l'image en pixels
            define('HEIGHT_MAX', 1080);    // Hauteur max de l'image en pixels

            // Tableaux de donnees
            $tabExt = array('jpg','gif','png','jpeg');    // Extensions autorisees
            $infosImg = array();

            // Variables
            $extension = '';
            $message = '';
            $nomImage = '';

                // Recuperation de l'extension du fichier
                $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);

                // On verifie l'extension du fichier
                if(in_array(strtolower($extension),$tabExt))
                {
                  // On recupere les dimensions du fichier
                  $infosImg = getimagesize($_FILES['fichier']['tmp_name']);

                  // On verifie le type de l'image
                  if($infosImg[2] >= 1 && $infosImg[2] <= 14)
                  {
                    // On verifie les dimensions et taille de l'image
                    if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['fichier']['tmp_name']) <= MAX_SIZE))
                    {
                      // Parcours du tableau d'erreurs
                      if(isset($_FILES['fichier']['error']) && UPLOAD_ERR_OK === $_FILES['fichier']['error']) {
                        // On renomme le fichier
                        $nomImage =  $id.'.'. $extension;

                        // Si c'est OK, on teste l'upload
                        if(move_uploaded_file($_FILES['fichier']['tmp_name'], TARGET.$nomImage))
                        {
                            echo 'move_uploaded';
                            var_dump($_FILES);
                            return true;
                        }
                        else
                        {
                          $_SESSION['error'] = 'ProblÃ¨me lors de l\'upload !';
                          $this->redirect('/index.php/manga/details?id='.$id);
                          return false;
                        }
                      }
                      else
                      {
                          $_SESSION['error'] = true;
                          $_SESSION['alertMessage'] = 'Une erreur interne a empÃªchÃ© l\'uplaod de l\'image';
                          $this->redirect('/index.php/manga/details?id='.$id);
                          return false;
                      }
                    }
                    else
                    {
                        $_SESSION['error'] = true;
                        $_SESSION['alertMessage'] = 'Erreur dans les dimensions de l\'image !';
                        $this->redirect('/index.php/manga/details?id='.$id);
                        return false;
                    }
                  }
                  else
                  {
                    $_SESSION['error'] = true;
                    $_SESSION['alertMessage'] = 'Le fichier Ã  uploader n\'est pas une image !';
                    $this->redirect('/index.php/manga/details?id='.$id);
                    return false;
                  }
                }
        }
}