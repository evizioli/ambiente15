<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="container">

<div class="page-header">
	<h1>Restablecer clave de acceso de usuario</h1>


	Si olvid&oacute; su clave y necesita una nueva, introduzca la direcci&oacute;n de correo electr&oacute;nico vinculada a su cuenta<br/>
	Le ser&aacute; enviado a esa direcci&oacute;n un v&iacute;nculo a tal efecto
</div>

<?php if ($sf_user->hasFlash('notice')): ?>
  <div class="alert alert-success" role="alert"><?php echo $sf_user->getFlash('notice') ?></div>
<?php endif; ?>


<?php if ($sf_user->hasFlash('error')): ?>
  <div class="error"><?php echo $sf_user->getFlash('error') ?></div>
<?php endif; ?>

			<form action="<?php echo url_for('usuario/reset');?>" method="post">
								
				    <?php if ($form->hasGlobalErrors()): ?>
				      <?php echo $form->renderGlobalErrors() ?>
				    <?php endif; ?>
				    
				    
					<div class="row control-group<?php $form['email']->hasError() and print ' errors' ?>">
						
						<?php echo $form['email']->renderLabel(null,array('class'=>'control-label col-lg-2')) ?>
						
					    <div class="col-lg-6 controls">
						
							<?php echo $form['email']->renderError() ?>

							<?php echo $form['email']->render(array('class'=>'form-control')) ?>
						</div>
					</div>
  
				    
					<div class="row control-group<?php $form['captcha']->hasError() and print ' errors' ?>">
						
						<?php //echo $form['email']->renderLabel(null,array('class'=>'control-label col-lg-2')) ?>
						
					    <div class="col-lg-6 col-lg-offset-2  controls">
						
							<?php echo $form['captcha']->renderError() ?>

							<?php echo $form['captcha']->render() ?>
						</div>
					</div>
  

				
				
				    <button type="submit" class="btn btn-primary"  >Enviar email</button>
				    <?php echo link_to( '<span class="glyphicon glyphicon-home" aria-hidden="true"></span> Ir al Inicio', '@homepage') ?>


				
   				<?php echo $form->renderHiddenFields(false)  ?>
    
				
			</form>

</div>