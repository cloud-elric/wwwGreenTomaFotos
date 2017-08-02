<?php
 $this->registerJsFile ( '@web/webAssets/js/tomar-foto.js', [
		'depends' => [
				\app\assets\AppAsset::className ()
		]
] );
?>
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <div class="panel panel-default">
                                
                            
            <div class="panel-body">

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 text-center">
                            <button class="btn btn-primary btn-block" id="take">
                                Tomar foto
                            </button>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-4 col-md-offset-2">
                            <video style="width:100%;" class="embed-responsive-item" id="v"></video>
                        </div>

                        <div class="col-md-4">
                            <img style="width:100%;"  id="photo" alt="photo">    
                        </div>
                    </div>

                    <br>
                    <br>

                    <div class="row">
                        <div class="col-md-8 col-md-offset-2 text-center">
                            <button data-style="zoom-in" id="btn-guardar" class="btn btn-success btn-block ladda-button">
                                <span class="ladda-label">    
                                    Guardar foto
                                </span>    
                            </button>
                        </div>
                    </div>
                                    
                    <canvas id="canvas" style="display:none;"></canvas>
            </div>
        </div>
    </div>
</div>