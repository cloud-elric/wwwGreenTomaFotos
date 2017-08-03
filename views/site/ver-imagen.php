<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta property="og:site_name" content="Mi fotografía UFC"/>
<meta property="og:title" content="Mira mi genial fotografía."/>
<meta property="og:description" content="Descripción."/>
<meta property="og:image" content="<?=Url::base()?>/fotos-tomadas/<?=$usuario->txt_imagen?>" />
<meta property="og:url" content="<?=Url::base()?>/site/ver-imagen?token=<?=$usuario->txt_token?>" />

<title>Mi foto UFC</title>
</head>

<body>
    <a href="https://www.facebook.com/sharer/sharer.php?<?=Url::base()?>/site/ver-imagen?token=<?=$usuario->txt_token?>" target="_blank">
        Share on Facebook
    </a>
</body>

</html>