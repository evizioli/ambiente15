<div class="container">
<h1>Confirmar nueva de clave de usuario</h1>

 
  <form action="<?php echo url_for('usuario/check?reset='.$form->getWidget('reset')->getDefault());?>" method="post">

    <?php if ($form->hasGlobalErrors()): ?>
      <?php echo $form->renderGlobalErrors() ?>
    <?php endif; ?>

  

					<div	class="row control-group<?php $form['password']->hasError() and print ' errors' ?>">
						
						<?php echo $form['password']->renderLabel(null,array('class'=>'control-label col-lg-2')) ?>
						
					    <div class="col-lg-3 controls">
						
							<?php echo $form['password']->renderError() ?>

							<?php echo $form['password']->render(array('class'=>'form-control')) ?>
						</div>
					</div>
  

					<div	class="row control-group<?php $form['password_check']->hasError() and print ' errors' ?>">
						
						<?php echo $form['password_check']->renderLabel(null,array('class'=>'control-label col-lg-2')) ?>
						
					    <div class="col-lg-3 controls">
						
							<?php echo $form['password_check']->renderError() ?>

							<?php echo $form['password_check']->render(array('class'=>'form-control')) ?>
						</div>
					</div>




    
    
    <?php echo $form->renderHiddenFields(false)  ?>
    
    <button type="submit" class="btn btn-primary" >Cambiar clave</button>
    <?php echo link_to( '<span class="glyphicon glyphicon-list" aria-hidden="true"></span> Ir al Inicio', '@homepage') ?>
  </form>

</div>
