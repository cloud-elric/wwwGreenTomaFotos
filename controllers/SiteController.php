<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\EntUsuarios;
use movemegif\domain\FileImageCanvas;
use movemegif\GifBuilder;
use app\models\Mensajes;

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
		

				return $this->redirect(['tomar-foto', 'token'=>$usuario->txt_token]);
			}

			
		}

		return $this->render ( 'registro', [
				'usuario' => $usuario
		] );
	}

	public function actionTomarFoto($token = null){
		 $usuario = EntUsuarios::find()->where(['txt_token'=>$token])->one();

		 if($usuario){

		 	return $this->render("cargar-foto", ['token'=>$usuario->txt_token]);
		 }
	}

	public function actionGuardarFoto($token = null){
		
		$usuario = EntUsuarios::find()->where(['txt_token'=>$token])->one();
		if($usuario){
			if(isset($_POST['imgBase64']) ){
				$data = $_POST['imgBase64'];
				

				$data = str_replace('data:image/png;base64,', '', $data);
				$data = str_replace(' ', '+', $data);
				$data = base64_decode($data);
				$nombreFoto = uniqid().".png";
				$file =  "fotos-tomadas/".$nombreFoto;
				$success = file_put_contents($file, $data);

				$usuario->txt_imagen = $nombreFoto;
				$usuario->save();


				$link = Yii::$app->urlManager->createAbsoluteUrl ( [ 
								'site/ver-imagen?token=' . $usuario->txt_token
				] );	
				$urlCorta = $this->getShortUrl($link);

				$message = urlencode ( "UFC. Comparte tu fotografía: " . $urlCorta );

				//print_r($this->sendSMS($usuario->txt_telefono_celular, $message));
				$mensajes = new Mensajes();
				$resp = $mensajes->mandarMensage($message, $usuario->txt_telefono_celular);
				print_r($resp);
				
			}
		}

	}

	public function actionVerImagen($token=null){
		$usuario = EntUsuarios::find()->where(['txt_token'=>$token])->one();
		if($usuario){
		
		return $this->renderAjax("ver-imagen", ['usuario'=>$usuario]);
		}
	}

	private function sendSMS($tel='', $message=''){
		
		$urlAutenticate = 'http://sms-tecnomovil.com/SvtSendSms?username=PIXERED&password=Pakabululu01&message=' . $message . '&numbers=' . $tel;
		//$sms = file_get_contents ( $url );	

		#$urlAutenticate = 'http://dgom.mobi';
		
		$ch = curl_init ();
		
		curl_setopt ( $ch, CURLOPT_URL, $urlAutenticate );
		
		curl_setopt ( $ch, CURLOPT_POSTREDIR, 3 );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
		
		// in real life you should use something like:
		// curl_setopt($ch, CURLOPT_POSTFIELDS,
		// http_build_query(array('postvar1' => 'value1')));
		
		// receive server response ...
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		
		$server_output = curl_exec ( $ch );
		
		curl_close ( $ch );
		
		return $server_output;			

	}

	private function getShortUrl($url) {
		$urlAutenticate = 'http://dgom.mobi';
		
		$ch = curl_init ();
		
		curl_setopt ( $ch, CURLOPT_URL, $urlAutenticate );
		curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, 'user=userGreenSaco&pass=passGreenSacro&app=GreenSacro&url=' . $url );
		curl_setopt ( $ch, CURLOPT_POSTREDIR, 3 );
		curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, true );
		
		// in real life you should use something like:
		// curl_setopt($ch, CURLOPT_POSTFIELDS,
		// http_build_query(array('postvar1' => 'value1')));
		
		// receive server response ...
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		
		$server_output = curl_exec ( $ch );
		
		curl_close ( $ch );
		
		return $server_output;
	}

	public function actionGif(){

		// just for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// include movemegif's namespace
		 require __DIR__.'\..\vendor\movegif\autoloader.php';


		 // no width and height specified: they will be taken from the first frame
$builder = new GifBuilder();
$builder->setRepeat();

for ($i = 1; $i <= 4; $i++) {

    $builder->addFrame()
        ->setCanvas(new FileImageCanvas(__DIR__ . '/../web/fotos-tomadas/' . $i . '.png'))
        ->setDuration(20);
}

$builder->output('horse.gif');
	}
	

}
