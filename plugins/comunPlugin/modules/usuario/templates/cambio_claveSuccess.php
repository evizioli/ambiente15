<?php use_stylesheets_for_form($oForm) ?>
<?php use_javascripts_for_form($oForm) ?>

<div class="container">
<h1>Camvio de clave de usuario</h1>
<div class="sf_admin_form">

<div id="sf_admin_content">

 
  <form action="<?php echo url_for('usuario/cambio_clave');?>" method="post">

    <?php if ($oForm->hasGlobalErrors()): ?>
      <?php echo $oForm->renderGlobalErrors() ?>
    <?php endif; ?>

			    
		<div class="row control-group<?php $oForm['password_vieja']->hasError() and print ' errors' ?>">
			
			<?php echo $oForm['password_vieja']->renderLabel(null,array('class'=>'control-label col-lg-2')) ?>
			
		    <div class="col-lg-6 controls">
			
				<?php echo $oForm['password_vieja']->renderError() ?>

				<?php echo $oForm['password_vieja']->render(array('class'=>'form-control')) ?>
			</div>
		</div>

		<div class="row control-group<?php $oForm['password']->hasError() and print ' errors' ?>">
			
			<?php echo $oForm['password']->renderLabel(null,array('class'=>'control-label col-lg-2')) ?>
			
		    <div class="col-lg-6 controls">
			
				<?php echo $oForm['password']->renderError() ?>

				<?php echo $oForm['password']->render(array('class'=>'form-control')) ?>
			</div>
		</div>

		<div class="row control-group<?php $oForm['password_check']->hasError() and print ' errors' ?>">
			
			<?php echo $oForm['password_check']->renderLabel(null,array('class'=>'control-label col-lg-2')) ?>
			
		    <div class="col-lg-6 controls">
			
				<?php echo $oForm['password_check']->renderError() ?>

				<?php echo $oForm['password_check']->render(array('class'=>'form-control')) ?>
			</div>
		</div>
    
        <?php echo $oForm->renderHiddenFields()  ?>
        
				
	    <button type="submit" class="btn btn-primary"  >Guardar</button>
	    <?php echo link_to( '<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Ir al Inicio', '@homepage') ?>

  </form>
</div>
</div>

</div>
