<?php

class SerieController extends Controller
{
    
        protected function beforeAction($action) {
            if(isset(Yii::app()->request->cookies['connected']) && Yii::app()->request->cookies['connected']) {
                Yii::app()->session['activeTab'] = 'seriesTab';
                return parent::beforeAction($action);
            } else {
                $this->redirect('/index.php/user');
            }
        }
        
        public function actionIndex()
	{
            $series = Series::model()->findAll();
            $this->render('index', array(
                'series' => $series
             ));
	}
        
        public function actionAdd() {
            $getTitle = Yii::app()->request->getPost('inputTitle');
            if(isset($getTitle) && $getTitle != null) {
                $serie = new Series;
                $serie->title = $getTitle;
                $serie->status = Yii::app()->request->getPost('selectStatus');
                
                if($serie->save()) {
                    Yii::app()->session['success'] = true;
                    Yii::app()->session['alertMessage'] = $serie->title.' added';
                } else {
                    Yii::app()->session['error'] = true;
                    Yii::app()->session['alertMessage'] = 'Error during during adding : '.$getTitle;
                }
                $this->redirect('/index.php/serie');
            } else {
                $this->redirect('/index.php/serie');
            }
        }
        public function actionUpdate() {
            $getId = Yii::app()->request->getPost('idSerie');
            if(isset($getId) && $getId != null) {
                $serie = Series::model()->findByPk($getId);
                
                $serie->title = Yii::app()->request->getPost('inputTitle');
                $serie->season = Yii::app()->request->getPost('inputSeason');
                $serie->episode = Yii::app()->request->getPost('inputEpisode');
                $serie->status = Yii::app()->request->getPost('selectStatus');
                $serie->wikiLink = Yii::app()->request->getPost('inputWikipedia');
                //$serie->torrent = Yii::app()->request->getPost('inputTorrent');
                if(!empty($_FILES['fichier']['name'])) {
                    if($this->uploadImg($getId)) {
                        $extension  = pathinfo($_FILES['fichier']['name'], PATHINFO_EXTENSION);
                        $serie->image = $getId.'.'.$extension;
                    }
                }
                
                if($serie->save()) {
                    Yii::app()->session['success'] = true;
                    Yii::app()->session['alertMessage'] = '<a href="/index.php/serie/details?id='.$serie->id.'">'.$serie->title.'</a> updated';
                } else {
                    Yii::app()->session['error'] = true;
                    Yii::app()->session['alertMessage'] = 'Error during update : <a href="/index.php/serie/details?id='.$getId.'"> Show_'.$getId.'</a>';   
                }
                $this->redirect('/index.php/serie');
            } else {
                $this->redirect('/index.php/serie');
            }
        }
        
        public function actionDetails() {
            $getId = Yii::app()->request->getQuery('id');
            if(isset($getId) && $getId != null) {
                $serie = Series::model()->findByPk($getId);
                
                if(isset($serie) && $serie != null) {
                    $this->render('details', array(
                        'serie' => $serie 
                    ));
                } else {
                    $this->redirect('/index.php/serie');
                }
            } else {
                $this->redirect('/index.php/serie');
            }
        }
        
        public function actionUpdateSeason() {
            if(isset($_POST) && $_POST != null) {
                $serie = Series::model()->findByPk(Yii::app()->request->getPost('id'));
                $serie->season = Yii::app()->request->getPost('nv');
                
                if($serie->save()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->redirect('/index.php/serie');
            }
        }
        
        public function actionUpdateEpisode() {
            if(isset($_POST) && $_POST != null) {
                $serie = Series::model()->findByPk(Yii::app()->request->getPost('id'));
                $serie->episode = Yii::app()->request->getPost('nv');
                
                if($serie->save()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                $this->redirect('/index.php/serie');
            }
        }
        
        public function actionDelete() {
            $ajax = Yii::app()->request->getPost('ajax');
            if(isset($ajax) && $ajax == true) {
                $getId = Yii::app()->request->getPost('idSerie');
                if(isset($getId) && $getId != null) {
                    $serie = Series::model()->findByPk($getId);

                    if($serie->delete()) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                $this->redirect('/index.php/serie');
            }
        }
        
        protected function uploadImg($id) {
            /************************************************************
             * Definition des constantes / tableaux et variables
             *************************************************************/
            // Constantes
            define('TARGET', 'ressources/upload/images/series/');    // Repertoire cible
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
                          $this->redirect('/index.php/serie/details?id='.$id);
                          return false;
                        }
                      }
                      else
                      {
                          $_SESSION['error'] = true;
                          $_SESSION['alertMessage'] = 'Une erreur interne a empÃªchÃ© l\'uplaod de l\'image';
                          $this->redirect('/index.php/serie/details?id='.$id);
                          return false;
                      }
                    }
                    else
                    {
                        $_SESSION['error'] = true;
                        $_SESSION['alertMessage'] = 'Erreur dans les dimensions de l\'image !';
                        $this->redirect('/index.php/serie/details?id='.$id);
                        return false;
                    }
                  }
                  else
                  {
                    $_SESSION['error'] = true;
                    $_SESSION['alertMessage'] = 'Le fichier Ã  uploader n\'est pas une image !';
                    $this->redirect('/index.php/serie/details?id='.$id);
                    return false;
                  }
                }
        }
}