
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-12">
			<div id="map" style="height: 800px; width: 100%;"></div>
			
		</div>

	</div>
</div>

<script src="https://maps.google.com/maps/api/js?key=<?php echo ProjectConfiguration::GM_API_KEY ?>&language=es"></script>

<?php 

use_helper('JavascriptBase');
echo javascript_tag('
var urltogota  = "'.image_path('gota',true).'";
var urltowfs = "'.url_for('consultas/wfs').'";
var urltowms = "'.url_for('consultas/wms').'";
var urltoows = "'.url_for('consultas/ows').'";
');