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
          
           <li class="dropdown<?php if( in_array( $sf_context->getModuleName(), array( 'bidg1i1s', 'bidg2i1s', 'bidg3i1s', 'bidg4i1s', 'bidci2s', 'bidg5i1s' , 'bidci3s', 'bidg6i1s', 'bidg8i1s', 'bidg9i1s'  ))):?> active<?php endif ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tablas de datos de indicadores<span class="caret"></span></a>
              <ul class="dropdown-menu">
        			<li><b>P.I.M.C.P.A.</b></li>          
        			<li<?php if($sf_context->getModuleName()=='bidg1i1s'):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidg1i1s/index')?>">Pulpo Colorado Patagónico</a></li>          
        			<li<?php if($sf_context->getModuleName()=='bidg2i1s'):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidg2i1s/index')?>">Mara</a></li>          
        			<li<?php if($sf_context->getModuleName()=='bidg3i1s'):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidg3i1s/index')?>">Pato Vapor Cabeza Blanca No Volador</a></li>          
        			<li<?php if($sf_context->getModuleName()=='bidci1s'):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidci1s/index')?>">Abundancia de Aves Playeras</a></li>          
   	           
   	          
   	            <li><hr class="dropdown-divider"></li>
   	            
        			<li><b>A.N.P.P.V.</b></li>          
        			<li<?php if($sf_context->getModuleName()=='bidci2s'):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidci2s/index')?>">Abundancia de Aves Playeras</a></li>          
        			<li<?php if($sf_context->getModuleName()=='bidg5i1s'):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidg5i1s/index')?>">Elefante marino del sur</a></li>          
        			<li<?php if($sf_context->getModuleName()=='bidg6i1s'):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidg6i1s/index')?>">Lobo marino de un pelo</a></li>          
        			<li<?php if($sf_context->getModuleName()=='bidci3s'):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidci3s/index')?>">Ensamble de mamíferos carnívoros terrestres</a></li>          
        			<li<?php if($sf_context->getModuleName()=='bidg8i1s'):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidg8i1s/index')?>">Ballena Franca Austral</a></li>          
        			<li<?php if($sf_context->getModuleName()=='bidg9i1s'):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidg9i1s/index')?>">Pulpito Tehuelche</a></li>          
   	           </ul>
            </li>
          
           <li class="dropdown<?php if( in_array( $sf_context->getModuleName(), array( 'especies', 'sitios' ))):?> active<?php endif ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Tablas referenciales<span class="caret"></span></a>
              <ul class="dropdown-menu">
        			<li<?php if($sf_context->getModuleName()=='especies'):?> class="active"<?php endif ?>><a href="<?php echo url_for('especies/index')?>">Especies</a></li>          
        			<li<?php if($sf_context->getModuleName()=='sitios'):?> class="active"<?php endif ?>><a href="<?php echo url_for('sitios/index')?>">Sitios</a></li>          
   	           </ul>
            </li>
            

           <li class="dropdown<?php if(  $sf_context->getModuleName()=='indicadores' && $sf_context->getActionName()!='index'):?> active<?php endif ?>">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Indicadores<span class="caret"></span></a>
              <ul class="dropdown-menu">
        			<li><b>P.I.M.C.P.A.</b></li>          
        			<li<?php if($sf_context->getModuleName()=='bidg1i1s' && $sf_context->getActionName()=='indicador' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidg1i1s/indicador')?>">Status reproductivo en el intermareal rocoso</a></li>          
        			<li<?php if($sf_context->getModuleName()=='bidg2i1s' && $sf_context->getActionName()=='indicador' ):?> class="active"<?php endif ?>><a href="<?php echo url_for('bidg2i1s/indicador')?>">Densidad mínima de individuos maduros / Éxito reproductivo</a></li>          
       	            <li><hr class="dropdown-divider"></li>
        			<li><b>A.N.P.P.V.</b></li>          
   	           </ul>
            </li>
            

          </ul>
          
          
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $sf_user->getNombre() ?> <span class="caret"></span></a>
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