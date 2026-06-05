<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 mapa" id="ANPPV">
            	
        </div>
        <div class="col-lg-6 mapa" id="PIMCPA">
            	
        </div>
    	
    </div>
    <div class="row">
        <div class="col-lg-6">
        </div>
        <div class="col-lg-6">
        </div>
    	
    </div>
	
</div>
<?php 
use_helper('JavascriptBase');
echo javascript_tag('
    var urltoanppv="'.url_for('indicadores/kml').'";
');