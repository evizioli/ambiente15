<?php 
include_javascripts_for_form($form);
include_stylesheets_for_form($form);

?>
<div class="container">
	<h1>Subir manual del usuario</h1>
	
	    <?php if ($form->hasGlobalErrors()): ?>
	      <?php echo $form->renderGlobalErrors() ?>
	    <?php endif; ?>
	
	<?php echo $form->renderFormTag(url_for('mas/manualDelUsuario'), array('class'=>'form-horizontal','role'=>'form'))?>
		<?php echo $form ?>
		<button type="submit">Guardar</button>
	</form>
	<hr>
	<?php echo link_to('Descargar manual actual del usuario de Consulta','mas/tutorial?manual=consulta',array('target'=>'_blank'))?>
	<br>
	<?php echo link_to('Descargar manual actual del usuario con Acceso','mas/tutorial?manual=acceso',array('target'=>'_blank'))?>
	<br>
	<?php echo link_to('Descargar manual actual del usuario de municipio','mas/tutorial?manual=muni',array('target'=>'_blank'))?>
</div>