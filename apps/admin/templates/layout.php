<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
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
            
			<li<?php if($sf_context->getModuleName()=='tipos_muestra'):?> class="active"<?php endif ?>><a href="<?php echo url_for('tipos_muestra/index')?>">Tipos de lugares</a></li>          
			<li<?php if($sf_context->getModuleName()=='usuarios'):?> class="active"<?php endif ?>><a href="<?php echo url_for('usuarios/index')?>">Usuarios</a></li>          
			<li<?php if($sf_context->getModuleName()=='grupos'):?> class="active"<?php endif ?>><a href="<?php echo url_for('grupos/index')?>">Grupos</a></li>          
			<li<?php if($sf_context->getModuleName()=='mas'):?> class="active"<?php endif ?>><a href="<?php echo url_for('mas/manualDelUsuario')?>">Manual del usuario</a></li>          
          
           <li class="dropdown<?php if( in_array( $sf_context->getModuleName(), array( 'kmls', 'girsus', 'promotores', 'tratamientos', 'parques', 'estaciones', 'minerias' ))):?> active<?php endif ?>">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Capas para el frontend<span class="caret"></span></a>
                  <ul class="dropdown-menu">
            			<li<?php if($sf_context->getModuleName()=='kmls'):?> class="active"<?php endif ?>><a href="<?php echo url_for('kmls/index')?>">Elementos de capas</a></li>          
            			<li<?php if($sf_context->getModuleName()=='esquemas'):?> class="active"<?php endif ?>><a href="<?php echo url_for('esquemas/index')?>">Jerarquía de capas</a></li>          
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