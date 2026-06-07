<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 mapa" id="ANPPV">
        </div>
        <div class="col-lg-6 mapa" id="PIMCPA">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6" id="data-anppv">
        </div>
        <div class="col-lg-6" id="data-pimcpa">
        </div>
    </div>
</div>
<?php 
use_helper('JavascriptBase');
echo javascript_tag('
    var urltoData="'.url_for('indicadores/data').'";
    var urltoKml="'.url_for('indicadores/kml').'";
    var urltoGml="'.url_for('sitios/gml').'";
');