<div class="et_pb_row et_pb_row_0">
	<?php echo image_tag('frontend-cabecera')?>
    <?php echo image_tag('frontend-index')?>
    
    <div style="border: 7px solid green; display: flex; border-radius: 33px;">
    	<div style="width: 100%;margin: 20px;">
    		<?php echo image_tag('frontend-mapas-ambientales-2')?>
    	</div>
    	<div style="font-size: 110%;margin: 30px; font-weight: bold; text-align: justify;">
    		Este espacio está creado para facilitar el acceso público a la información ambiental disponible en mapas del Ministerio de Ambiente y Control del Desarrollo Sustentable.
            La información cargada fue provista por diferentes organismos provinciales que suman para lograr un sistema ambiental integral de información, de uso público.
            Para visualizar la información se puede desplegar el menú de las capas, al hacer clic en las tres líneas horizontales que están en la esquina superior izquierda del mapa. Si delante del nombre de la capa hay un símbolo “>” significa que es capa tiene subcapas asociadas. Haciendo clic en el mismo, se despliegan y se puede seleccionar la de su interés. 
            Una vez activa la capa o subcapa, se puede cliquear en el punto de interés sobre el mapa y la información asociada se desplegará en el margen izquierdo de la pantalla.
        </div>
    </div>
	<div class="et_pb_module et_pb_code et_pb_code_0"  >
    
    	<div  class="et_pb_code_inner">
    
				<!-- 
				<div id="side_bar" class="sidebar collapsed">
				 -->     
				<div id="side_bar" class="sidebar">
                  <!-- Nav tabs -->
                  <div class="sidebar-tabs">
                    <ul role="tablist">
                      <li><a href="#home" role="tab"><i class="fa fa-bars"></i></a></li>
                      <li><a href="#profile" role="tab"><i class="fa fa-info-circle"></i></a></li>
                    </ul>
                  </div>
            
                  <!-- Tab panes -->
                  <div class="sidebar-content">
                    <div class="sidebar-pane active" id="home">
                      	<h1 class="sidebar-header">
                        	Mapas Ambientales
                        	<span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
                      	</h1>
            			<div id="layers" class="layer-switcher"></div>
            		</div>
            
                    <div class="sidebar-pane" id="profile">
                      <h1 class="sidebar-header">
                        Datos de la ubicación<span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
                      </h1>
                      <div id="datos">
                      </div>
                    </div>
            
                  </div>
                </div>
            				
				<div id="map" class="sidebar-map"></div>
        </div>
				<div><?php echo link_to('descargar como KMZ','common/descargarKmz')?></div>
         <div  class="et_pb_code_inner" style="display:flex; margin: 1em;">
         	<div style="">
             	<?php echo link_to(image_tag('link_backend', array('style'=>'height: 100%')),'/backend.php',array('absolute'=>true))?>
         	</div>
         	<div style="">
         		<span style="font-size: 130%;min-height: 100px; display: inline-flex; align-items: center;">
             	<?php echo link_to('Acceso&nbsp;','/backend.php',array('absolute'=>true))?>
         	 personalizado a la carga de información ambiental que actualiza los mapas ambientales
         		</span>
         	</div>
        </div>
    
    </div>

	<h2 class="blah">Acceso a otras bases de información ambiental:</h2>
	
	<a href="https://ciam.ambiente.gob.ar/" target="_blank" title="Centro de Información Ambiental"><?php echo image_tag('boton-centro-info-ambiental',array('width'=>'19%'))?></a>
	<a href="https://simarcc.ambiente.gob.ar/" target="_blank" title="Sistema de Mapa de Riesgo del Cambio Climático"><?php echo image_tag('boton-simarcc',array('width'=>'19%'))?></a>
	<a href="http://estadisticas.ambiente.gob.ar/" target="_blank" title="Sistema de Estadística Ambiental"><?php echo image_tag('boton-estadistica-ambiental.jpeg',array('width'=>'19%'))?></a>
	<a href="https://ambiente.mercosur.int/" target="_blank" title="Sistema de Información Ambiental del Mercosur"><?php echo image_tag('boton-siam',array('width'=>'19%'))?></a>
	<a href="https://mapa.idera.gob.ar/" target="_blank" title="Infraestructura de datos espaciales de la República Argentina"><?php echo image_tag('boton-idera.jpeg',array('width'=>'19%'))?></a>

</div>

<?php
use_helper('JavascriptBase');
echo javascript_tag("
var urltomarkers ='" . url_for('common/lugares', true) . "';
var urltowms ='" . url_for('common/wms', true) . "';
var urltoows ='" . url_for('common/ows', true) . "';
var urltokml='" . url_for('common/kml', true) . "';

var urltofepng='".image_path('frontend-*',true)."';
");
?>