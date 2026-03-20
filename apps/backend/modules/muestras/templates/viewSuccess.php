<?php use_helper('I18N')?>
<div class='container'>
<?php echo link_to('Volver al listado','@muestra')?>
<?php foreach ($view as $nombre=>$grupo):?>
	<div class="panel panel-default">
      <div class="panel-heading"><?php echo htmlspecialchars($nombre)?></div>
      <div class="panel-body">
      	<div class="container-fluid rayado">
        	<?php foreach ($grupo as $field=>$conf): //print_r($grupo); die()?>
              <div class="row" >
              <div class="col-lg-4">
                <?php echo __(sfInflector::humanize(str_ireplace('_con_lim', '', $field)))?>
				</div>
              <div class="col-lg-8">
                <?php 
                    $conf=$conf->getRawValue();
                    $m= array_shift($conf); 
                    $tmp=call_user_func_array(array($Muestra->getRawValue(),$m),$conf );
//                     echo empty($tmp)? '&nbsp;' : htmlspecialchars( $tmp );
                    echo empty($tmp)? '&nbsp;' :   $tmp;
                    ?>
              </div>
          	</div>
	        <?php endforeach?>
      		
        </div>
    </div>
</div>
<?php endforeach?>

</div>
