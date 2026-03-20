
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-4">
			<div id="datos" style="height: 800px; width: 100%;overflow-y: auto"></div>
		</div>
		<div class="col-lg-8">
			<div id="map" style="height: 800px; width: 100%;"></div>
            <div>
            	<table>
            		<tr>
            			<td>Ovinos</td>
            			<td>Bovinos</td>
            			<td>Engorde</td>
        			</tr>
            		<tr>
            			<td><?php echo image_tag('be_ganaderia_ovinos.jpg')?></td>
            			<td><?php echo image_tag('be_ganaderia_bovinos.jpg')?></td>
            			<td><?php echo image_tag('be_ganaderia_engorde.jpg')?></td>
        			</tr>
            	</table>
            	
            	
            	
            </div>
            
		</div>

	</div>
</div>

<script src="https://maps.google.com/maps/api/js?key=<?php echo ProjectConfiguration::GM_API_KEY ?>&language=es"></script>

<?php 

use_helper('JavascriptBase');
echo javascript_tag('
var urltofepng  = "'.image_path('frontend-*',true).'";
var urltowms ="' . url_for('consultas/wms', true) . '";
var urltoows ="' . url_for('consultas/ows', true) . '";
var urltokml="' . url_for('consultas/kml', true) . '";
');