<?php
use yii\helpers\Url;
 $this->registerJsFile ( '@web/webAssets/js/tomar-foto.js', [
		'depends' => [
				\app\assets\AppAsset::className ()
		]
] );
?>
<script>
var basePath = '<?=Url::base()?>';
</script>
<input id="token" type="hidden" value="<?=$token?>"/>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
                                
                            
            <div class="panel-body">

                    

                    <div class="row">
                        <div class="col-md-12">
                            <video style="width:100%;" class="embed-responsive-item" id="v"></video>
                            <button class="btn btn-primary btn-block" id="take">
                                Tomar foto
                            </button>
                        </div>
                         
                    </div>


                    <div class="row">
                         <div class="col-md-12" id="js-contenedor-imagenes">

                        </div>
                    </div>

                   
                                    
                    <canvas id="canvas" style="display:none;"></canvas>
            </div>
        </div>
    </div>
</div>