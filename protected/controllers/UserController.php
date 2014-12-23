<?php

class UserController extends Controller
{
        public function actionIndex()
	{
            if(isset(Yii::app()->request->cookies['connected']) && Yii::app()->request->cookies['connected']) {
                $this->redirect('/index.php');
            } else {
                $this->layout = 'connexion';
                $this->render('index');
            }
	}
	
        public function actionLogin()
	{
            $login = Yii::app()->request->getPost('inputLogin');
            $pwd = Yii::app()->request->getPost('inputPassword');
            if(isset($login) && $login != null) {
                $user = Users::model()->find('login=:login AND password=:password', array(
                    ':login' => $login,
                    ':password' => md5($pwd)
                ));
                
                var_dump($user);

                if($user == null) {
                    Yii::app()->session['error'] = true;
                    Yii::app()->session['alertMessage'] = 'Echec de connexion...';
                    $this->redirect('/index.php');
                } else {
                    $uConnected = new CHttpCookie('connected', true);
                    $uConnected->expire = time()+60*60*24*180; 
                    Yii::app()->request->cookies['connected'] = $uConnected;
                    
                    $uLogin = new CHttpCookie('login', $user->login);
                    $uLogin->expire = time()+60*60*24*180; 
                    Yii::app()->request->cookies['login'] = $uLogin;

                    $this->redirect('/index.php/serie');
                }
            } else {
                #$this->redirect('/index.php/');
            }
	}
        
        public function actionLogout() {
            unset(Yii::app()->request->cookies['connected']);
            unset(Yii::app()->request->cookies['user']);
            $this->redirect('/index.php');
        }
        
        /**
         * Check if login exist in Users table
         * @uses $_POST, Users::model()
         */
        public function actionCheckLogin() {
            $ajax = Yii::app()->request->getPost('ajax');
            if(isset($ajax) && $ajax) {
                $login = Yii::app()->request->getPost('l');
                $user = Users::model()->find('login=:login', array(
                    'login' => $login
                ));
                
                if(isset($user) && $user != null) {
                    echo 't';
                } else {
                    echo 'f';
                }
            }
        }
}