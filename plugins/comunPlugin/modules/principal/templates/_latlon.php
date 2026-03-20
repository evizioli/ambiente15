<?php use_javascript('/OpenLayers/OpenLayers.min.js') ?>
<?php use_javascript('backend') ?>
<?php use_stylesheet('/sfPropelORMPlugin/css/default.css', 'first') ?>
<?php $name='latlon' ?>
<div class="<?php echo 'sf_admin_form_row sf_admin_form_field_'.$name ?><?php $form[$name]->hasError() and print ' errors' ?>">
    <?php echo $form[$name]->renderError() ?>
    <div>
      <?php echo $form[$name]->renderLabel() ?>

      <div class="content">
      	<?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?>

      	<?php //use_helper('JavascriptBase'); echo link_to_function(image_tag('zoom'), 'posicionar_mapa()')

      	//http://www.heavens-above.com/LocationFromGoogleMaps.aspx
      	?>

      	</div>

      <?php if ($help = $form[$name]->renderHelp()): ?>
        <div class="help"><?php echo $help ?></div>
      <?php endif; ?>



      <div id="map" style="width: 400px; height: 400px;  background-color: rgb(229, 227, 223); overflow: hidden;"></div>

      <?php if($form[$name]->getValue()): ?>
	      <script type="text/javascript">
	      	var ll = [<?php echo implode(',',explode(' ',$form[$name]->getValue())) ?>];
	      </script>
        <?php endif ?>
	      <script type="text/javascript">
	        var g = new GoogleGeocode('<?php $gak = sfConfig::get('app_google_maps_api_keys'); echo $gak['default'] ?>');
                var fn = '<?php echo $form->getName() ?>';
	      </script>

    </div>
  </div>

