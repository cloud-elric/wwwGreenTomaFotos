<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;



class SiteController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
				'access' => [
						'class' => AccessControl::className (),
						'only' => [
								'logout'
						],
						'rules' => [
								[
										'actions' => [
												'logout'
										],
										'allow' => true,
										'roles' => [
												'@'
										]
								]
						]
				],
				'verbs' => [
						'class' => VerbFilter::className (),
						'actions' => [
								'logout' => [
										'post'
								]
						]
				]
		];
	}

	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
				'error' => [
						'class' => 'yii\web\ErrorAction'
				],
				'captcha' => [
						'class' => 'yii\captcha\CaptchaAction',
						'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null
				]
		];
	}

	/**
	 * Displays homepage.
	 *
	 * @return string
	 */
	public function actionIndex() {
		$usuario = new EntUsuarios ();

		return $this->render ( 'inicio' );
	}

	public function actionRegistro(){
		$usuario = new EntUsuarios ();

		

		if ($usuario->load ( Yii::$app->request->post () )) {

			$usuario->txt_token = "usr_" . md5 ( uniqid ( "usr_" ) ) . uniqid ();
			if ($usuario->save ()) {
		

				return $this->redirect(['capturar-foto', 'token'=>$usuario->txt_token]);
			}

			
		}

		return $this->render ( 'registro', [
				'usuario' => $usuario
		] );
	}

	public function actionTomarFoto(){

		return $this->render("cargar-foto");

	}

	public function actionGuardarFoto(){
		

		if(isset($_POST['imgBase64']) ){
			$data = $_POST['imgBase64'];
			

			$data = str_replace('data:image/png;base64,', '', $data);
			$data = str_replace(' ', '+', $data);
			$data = base64_decode($data);
			$idFoto = uniqid();
			$file =  "fotos-tomadas/".$idFoto . '.png';
			$success = file_put_contents($file, $data);
		
		}


	}

	

}
