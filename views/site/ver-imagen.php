<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta property="og:site_name" content="Mi fotografía UFC"/>
<meta property="og:title" content="Mira mi genial fotografía."/>
<meta property="og:description" content=""/>
<meta property="og:image" content="<?=Url::base()?>/fotos-tomadas/<?=$usuario->txt_imagen?>" />
<meta property="og:url" content="<?=Url::base()?>/site/ver-imagen?token=<?=$usuario->txt_token?>" />

<script>
window.fbAsyncInit = function() {
	FB.init({
		//appId : '1029875693761281',
		//appId:'171096896693553',
		appId:'108260376517644',
		cookie : true, // enable cookies to allow the server to access
		// the session
		xfbml : true, // parse social plugins on this page
		version : 'v2.6' // use any version
	});

};

// Load the SDK asynchronously
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id))
		return;
	js = d.createElement(s);
	js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

    function compartirFacebook() {

	var image = "<?=Url::base()?>/site/ver-imagen?token=<?=$usuario->txt_token?>";
	var description = "#campaña";
	var title = "Mira mi increible fotografía";
	
	FB.ui({
		method : 'feed',
		name : title,
		link : "<?=Url::base()?>/site/ver-imagen?token=<?=$usuario->txt_token?>",
		picture : image,
		caption : '2 Geeks one monkey',
		description : description

	}, function(response) {
		if (response && response.post_id) {
		} else {
		}
	});
}
</script>
<title>Mi foto UFC</title>
</head>

<body>
<img src="<?=Url::base()?>/fotos-tomadas/<?=$usuario->txt_imagen?>" />
   
   <button onclick="compartirFacebook();">Compartir en facebook</button>


</body>

</html>