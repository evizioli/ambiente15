<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <meta charset="utf-8">
        <?php 
            include_stylesheets() ;
            include_component('principal', 'esquemaStylesheets');
        ?>
      
    
    </head>
	<body style="padding-top: unset">
<!-- 
        <div class="container-fluid">
        	<div class="row">
		    	<div class="col-lg-12">
 -->
 <div>
 
            		<div id="side_bar" class="sidebar" style="margin-left:1em; z-index: 1; height: 95%">
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
    	       		            		
					<div id="map" class="sidebar-map" style="width: 100%; height: 50em"></div>
</div>	       			
	       			
<!-- 
	       		</div>
       		</div>
   		</div>
 -->	       		

    <script  type="text/javascript" src="https://maps.google.com/maps/api/js?key=<?php echo ProjectConfiguration::GM_API_KEY ?>  id="google-maps-api-js"></script>
<?php
use_helper('JavascriptBase');
echo javascript_tag("
var urltoows ='" . url_for('common/ows', true) . "';
var urltofepng='".image_path('esquema/*',true)."';
var urltofepngex='".image_path('*',true)."';
var esquema=".json_encode( $esquema->getRawValue()).";
");

include_javascripts() 
?>
       
    </body>
</html>
