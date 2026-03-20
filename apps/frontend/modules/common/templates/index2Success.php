<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="<?php echo image_path('favicon/favicon.ico')?>" />
        <?php include_stylesheets() ?>
      
    
    </head>
	<body>


  		<nav class="navbar navbar-default navbar-fixed-top">
            <div  style="background-color: #2ea3f2; color: white; padding: 9px 30px;">


					<span class="glyphicon glyphicon-earphone"></span> Mesa de entradas (0280) 4481758 <a href="mailto:comunicacion.ambiente@chubut.gov.ar"><span class="glyphicon glyphicon-envelope"></span> comunicacion.ambiente@chubut.gov.ar</a>



            </div>    
            <div >
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                        <span class="sr-only">Toggle navigation</span> 
                        <span class="icon-bar"></span>  
                        <span class="icon-bar"></span>  
                        <span class="icon-bar"></span>               
                    </button>
                    
                    <a href="https://ambiente.chubut.gov.ar/">
						
						<img src="<?php echo image_path('logo-chubut-y-ambiente-2019')?>" alt="Ministerio de Ambiente y Control del Desarrollo Sustentable" id="logo" style="height: 4em;width: auto">
					</a>
                    
                </div>     

                <div id="navbar" class="navbar-collapse collapse navbar-right">
				    <ul class="nav navbar-nav">
                        <li><a href="<?php echo url_for('@homepage')?>">Inicio</a></li>
                        <li><a href="https://ambiente.chubut.gov.ar/que-hacemos/">Qué hacemos</a></li>
                        <li><a href="https://ambiente.chubut.gov.ar/nosotros/">Nosotros</a></li>
                        <li><a href="https://ambiente.chubut.gov.ar/noticias/">Noticias</a></li>
                        <li><a href="https://ambiente.chubut.gov.ar/contacto/">Contacto</a></li>
                        <li><a href="https://ambiente.chubut.gov.ar/denuncias/">Denuncias</a></li>
                    </ul>
                </div>                       

            </div>    
        </nav>	
        <div class="container-fluid">
        	<div class="row">
		    	<div class="col-lg-offset-2 col-lg-8 col-xs-12 cien">
            		<?php echo image_tag('frontend-cabecera')?>
        		</div>
        	</div>
        	<div class="row">
		    	<div class="col-lg-offset-2 col-lg-8 col-xs-12 cien">
        			<?php echo image_tag('frontend-index')?>
        		</div>
        	</div>
        	<div class="row">
		    	<div class="col-lg-offset-2 col-lg-8 col-xs-12">
                            		
                    <div style="border: 7px solid green;  border-radius: 33px;">
                    	<div class="cien">
                    		<?php echo image_tag('frontend-mapas-ambientales-2',array('style'=>'float: left; width: 8em; margin: 1em;'))?>
                    	</div>
                    	<p style="font-size: 1em; margin: 1em; font-weight: bold; text-align: justify;">
                    		Este espacio está creado para facilitar el acceso público a la información ambiental disponible en mapas del Ministerio de Ambiente y Control del Desarrollo Sustentable.
                            La información cargada fue provista por diferentes organismos provinciales que suman para lograr un sistema ambiental integral de información, de uso público.
                            Para visualizar la información se puede desplegar el menú de las capas, al hacer clic en las tres líneas horizontales que están en la esquina superior izquierda del mapa. Si delante del nombre de la capa hay un símbolo “>” significa que es capa tiene subcapas asociadas. Haciendo clic en el mismo, se despliegan y se puede seleccionar la de su interés. 
                            Una vez activa la capa o subcapa, se puede cliquear en el punto de interés sobre el mapa y la información asociada se desplegará en el margen izquierdo de la pantalla.
                        </p>
                    </div>
        		</div>
        	</div>

        	<div class="row">
		    	<div class="col-lg-12">
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
	       			
					<div><?php echo link_to('descargar como KMZ','common/descargarKmz')?></div>
	       			
	       		
	       		</div>
       		</div>
        	
        	<div class="row">
		    	<div class="col-lg-offset-2 col-lg-8 col-xs-12">
                            		
                 	<div style="width: 20%">
                     	<?php echo link_to(image_tag('link_backend', array('style'=>'height: 100%')),'/backend.php',array('absolute'=>true))?>
                 	</div>
                 	<div style="width: 80%">
                 		<span style="font-size: 130%;min-height: 100px; display: inline-flex; align-items: center;">
                         	<?php echo link_to('Acceso&nbsp;','/backend.php',array('absolute'=>true))?>
                     	 	personalizado a la carga de información ambiental que actualiza los mapas ambientales
                 		</span>
                 	</div>
	       		</div>
       		</div>
        	<div class="row">
		    	<div class="col-lg-offset-2 col-lg-8 col-xs-12">
                                            		
                	<h2 class="blah">Acceso a otras bases de información ambiental:</h2>
                	
                	<a href="https://ciam.ambiente.gob.ar/" target="_blank" title="Centro de Información Ambiental"><?php echo image_tag('boton-centro-info-ambiental',array('width'=>'19%'))?></a>
                	<a href="https://simarcc.ambiente.gob.ar/" target="_blank" title="Sistema de Mapa de Riesgo del Cambio Climático"><?php echo image_tag('boton-simarcc',array('width'=>'19%'))?></a>
                	<a href="http://estadisticas.ambiente.gob.ar/" target="_blank" title="Sistema de Estadística Ambiental"><?php echo image_tag('boton-estadistica-ambiental.jpeg',array('width'=>'19%'))?></a>
                	<a href="https://ambiente.mercosur.int/" target="_blank" title="Sistema de Información Ambiental del Mercosur"><?php echo image_tag('boton-siam',array('width'=>'19%'))?></a>
                	<a href="https://mapa.idera.gob.ar/" target="_blank" title="Infraestructura de datos espaciales de la República Argentina"><?php echo image_tag('boton-idera.jpeg',array('width'=>'19%'))?></a>

	       		</div>
       		</div>
        	<div class="row">
		    	<div class="col-lg-offset-2 col-lg-8 col-xs-12">

						<p style="text-align: left;">
							<span style="font-size: x-large;"><strong>Ministerio de Ambiente y Control del Desarrollo Sustentable</strong></span>
						</p>
						<p>Protegiendo el ambiente de nuestra provincia.</p>
						<div class="container-fluid">
            		    	<div class="col-lg-4">
            		    	
								<p style="text-align: left;">Rawson - Hipólito Irigoyen 42</p>
								<p>
									<i class="fa fa-phone-square " style="color: #07b085;"></i>
									(0280)&nbsp; 4481758
								</p>
								<p>
									<i class="fa fa-phone-square " style="color: #07b085;"></i>
									(0280)&nbsp; 4484558
								</p>
								<p>
									<i class="fa fa-phone-square " style="color: #07b085;"></i>
									(0280)&nbsp; 4484831
								</p>
								<p>
									<i class="fa fa-phone-square " style="color: #07b085;"></i>
									(0280)&nbsp; 4485389
								</p>
    						</div>
            		    	<div class="col-lg-4">
            		    		<div class="et_pb_blurb_container">
        							<h4 class="et_pb_module_header">
        								<span>Delegación Comarca Senguer - San Jorge</span>
        							</h4>
        							<div class="et_pb_blurb_description">
        								<p style="text-align: left;">Comodoro Rivadavia - Av. Rivadavia 264, 1° Piso</p>
        								<p> <i class="fa fa-phone-square " style="color: #07b085;"></i> (0297)&nbsp; 4464597 / 4465012 / 4465149 </p>
        							</div>
        						</div>
        						<hr>
        						<div class="et_pb_blurb_container">
        							<h4 class="et_pb_module_header">
        								<span>Delegación Comarca los Andes</span>
        							</h4>
        							<div class="et_pb_blurb_description">
        								<p style="text-align: left;">Trevelin - Av. San Martín
        									311</p>
        								<p>
        									<i class="fa fa-phone-square " style="color: #07b085;"></i>
        									(02945)&nbsp; 480924
        								</p>
        							</div>
        						</div>
        						<p>Seguinos en nuestras redes</p>
    						</div>
            		    	<div class="col-lg-4">
	            		    	<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d362.95647449312906!2d-65.10721395863887!3d-43.30061321406054!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xbe015720ea330fd7%3A0xc897fcae50e5ced4!2sHip%C3%B3lito%20Yrigoyen%2042%2C%20Rawson%2C%20Chubut!5e0!3m2!1ses-419!2sar!4v1620051929946!5m2!1ses-419!2sar" width="400" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    						</div>
						
						</div>
           		</div>
       		</div>
   		</div>

    <script  type="text/javascript" src="https://maps.google.com/maps/api/js?key=<?php echo ProjectConfiguration::GM_API_KEY ?>  id="google-maps-api-js"></script>
<?php
use_helper('JavascriptBase');
echo javascript_tag("
var urltomarkers ='" . url_for('common/lugares', true) . "';
var urltowms ='" . url_for('common/wms', true) . "';
var urltoows ='" . url_for('common/ows', true) . "';
var urltokml='" . url_for('common/kml', true) . "';

var urltofepng='".image_path('frontend-*',true)."';
");

include_javascripts() 
?>
        <footer id="main-footer">



				<div id="footer-bottom">
					<div class="container clearfix">
						<ul class="et-social-icons">

							<li class="et-social-icon">
								<a href="https://www.facebook.com/pages/Ministerio-de-Ambiente-y-Control-del-Desarrollo-Sustentable/1374271226213166?ref=ts&amp;fref=ts">
									<i class="fa fa-facebook-f"></i>
								</a>
							</li>
							<li class="et-social-icon">
								<a href="https://twitter.com/MinAmbChubut"> 
									<i class="fa fa-twitter"></i>
								</a>
							</li>
							<li class="et-social-icon">
								<a href="https://www.youtube.com/channel/UC6XvQrECMQVCup0LzBC21HA">
									<i class="fa fa-youtube"></i>
								</a>
							</li>
						</ul>
					</div>
					<!-- .container -->
				</div>
			</footer>
        
    </body>
</html>
