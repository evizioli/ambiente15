
<div class="container-fluid">
	<div class="row">
		<div class="col-lg-6">
			<div id="tocar">
	        	<?php include_partial('comoHacer')?>
			</div>
    	</div>
		<div class="col-lg-6">
			<div id="map" style="height: 600px; width: 100%;"></div>
			<div style="padding: 15px;">
				<div id="leyenda_uso" style="text-align:justify; margin-bottom: 10px; padding: 10px; border: 3px solid #4A7EBB; border-radius: 10px;">
				
					Si selecciona a continuación un uso, pdrá observar si los valores de la tabla no cumplen con el nivel establecido en la normativa
					vigente para ese uso al mostrarse el rojo 
				</div>
				Uso: 
				<select id="uso" onchange="document.getElementById('leyenda_uso').style.display= this.value==0 ? '': 'none'; traer([]); ">
					<option value="0">(Sin especificar)</option>
					<?php foreach (UsoQuery::create()->orderByNombre()->find() as $u):?>
						<option value="<?php echo $u->getId()?>"><?php echo $u?></option>
					<?php endforeach;?>
				</select>
				<br>
				<h4>Referencias</h4>
				<div class="container-fluid">
					<?php while ($t=$tipos->getCurrent()):?>
						<div class="row">
							<div class="col-lg-6"><?php echo image_tag('tipo-muestra/'.$t->getArchivo(),array('size'=>'20x20')). ' '. $t?></div>
        					<?php $tipos->next(); if($t=$tipos->getCurrent()):?>
    							<div class="col-lg-6"><?php echo image_tag('tipo-muestra/'.$t->getArchivo(),array('size'=>'20x20')). ' '. $t?></div>
        					<?php endif; $tipos->next();?>
						</div>
					<?php endwhile;?>
				</div>

			</div>
			<div id='bacteriologicos'>
			</div>
		</div>

	</div>
</div>
<!-- 
<script src="https://maps.google.com/maps/api/js?v=3&amp;key=<?php echo ProjectConfiguration::GM_API_KEY ?>&amp;language=es"></script>
 -->

<?php 
$s=_compute_public_path('', ProjectConfiguration::DIRECTORIO_TIPO_MUESTRA, '', true);
$s=substr($s, 0, strlen($s)-1);
use_helper('JavascriptBase');
echo javascript_tag('
var urlToPrint = "'.url_for('muestras/ListProtocolo').'";
var urltogota  = "'.$s.'";
var urltowfs = "'.url_for('consultas/wfs').'";
var urltowms = "'.url_for('consultas/wms').'";
var urltoows = "'.url_for('consultas/ows').'";
var urlmuestrasajax = "'.url_for('consultas/ajaxConsultaMapaTipo').'";
var estas=[];	
var iconos='.json_encode((object)$iconos->getRawValue()).';	
');
