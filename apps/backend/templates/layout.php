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
  <body class="menu">
  
  
       <?php  if($sf_user->isAuthenticated() ):?>
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          
          	<li>
			  <a href="<?php echo url_for('@homepage')?>" title="Inicio">
			    <span class="glyphicon glyphicon-home"></span>
			  </a>
			</li>
            <?php if($sf_user->hasCredential('muestras')):?>
				<li<?php if($sf_context->getModuleName()=='muestras'):?> class="active"<?php endif ?>><a href="<?php echo url_for('muestras/index')?>">Muestras</a></li>          
          	<?php endif ?>
            <?php if($sf_user->hasCredential('caudales')):?>
				<li<?php if($sf_context->getModuleName()=='caudales'):?> class="active"<?php endif ?>><a href="<?php echo url_for('caudales/index')?>">Caudales Dique F. Ameghino</a></li>          
          	<?php endif ?>
          
            <li class="dropdown<?php if( $sf_context->getModuleName()=='consultas' && in_array( $sf_context->getActionName(), array( 'algas', 'mapaTipo', 'graficos', 'ptlc', 'caudales' ))):?> active<?php endif ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reportes <span class="caret"></span></a>
              <ul class="dropdown-menu">
	            <li<?php if($sf_context->getActionName()=='caudales' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('consultas/caudales')?>">Caudales Dique F. Ameghino</a></li>
                <?php if($sf_user->hasCredential('reportes_mapa')):?>
    	            <li<?php if($sf_context->getActionName()=='mapaTipo' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('consultas/mapaTipo')?>">Mapa</a></li>
              	<?php endif ?>
                <?php if($sf_user->hasCredential('reportes_graficos')):?>
    	            <li<?php if($sf_context->getActionName()=='graficos' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('consultas/graficos')?>">Gr&aacute;ficos por localidad</a></li>
    	            <li<?php if($sf_context->getActionName()=='graficosTiempo' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('consultas/graficosTiempo')?>">Gr&aacute;ficos por fecha</a></li>
              	<?php endif ?>
                <?php if($sf_user->hasCredential('reportes_algas')):?>
    	            <li<?php if($sf_context->getActionName()=='algas' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('consultas/algas')?>">Microalgas</a></li>
              	<?php endif ?>
                <?php if($sf_user->hasCredential('reportes_canales')):?>
    	            <li<?php if($sf_context->getActionName()=='canales' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('consultas/canales')?>">Canales V.I.R.CH.</a></li>
              	<?php endif ?>
                <?php if($sf_user->hasCredential('reportes_ganaderia')):?>
    	            <li<?php if($sf_context->getActionName()=='ganaderia' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('consultas/ganaderia')?>">Ganader&iacute;a</a></li>
              	<?php endif ?>
   	           </ul>
            </li>
          
            <?php if($sf_user->hasCredential(array('lugares','tolerancias'),false)):?>
                <li class="dropdown<?php if( in_array( $sf_context->getModuleName(), array( 'lugares', 'tolerancias' ))):?> active<?php endif ?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Listas <span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <?php if($sf_user->hasCredential('responsables')):?>
    		            <li<?php if($sf_context->getActionName()=='responsables' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('responsables/index')?>">Responsables de carga de muestras</a></li>
                  	<?php endif ?>
                    <?php if($sf_user->hasCredential('lugares')):?>
    		            <li<?php if($sf_context->getActionName()=='lugares' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('lugares/index')?>">Lugares de extracci&oacute;n</a></li>
    		            <li<?php if($sf_context->getActionName()=='usos' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('usos/index')?>">Usos de Lugares de extracci&oacute;n</a></li>
                  	<?php endif ?>
                    <?php if($sf_user->hasCredential('tolerancias')):?>
    		            <li<?php if($sf_context->getActionName()=='tolerancias' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('tolerancias/index')?>">Niveles gu&iacute;a</a></li>
                  	<?php endif ?>
                  </ul>
                </li>
          	<?php endif ?>
          </ul>
          
          
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span> <?php echo $sf_user->getNombre() ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="<?php echo url_for('usuario/logout')?>">Salir</a></li>
                <li><a href="<?php echo url_for('usuario/cambio_clave')?>">Cambiar clave</a></li>
              </ul>
            </li>
          </ul>
           
          
          
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    
  <?php  endif;?>
  
    <?php echo $sf_content ?>

    
        <?php include_javascripts() ?>
    
    
    </body>
</html>