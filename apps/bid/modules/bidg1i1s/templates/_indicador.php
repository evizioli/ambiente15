<?php if ($total>0): ?>
	<?php use_helper('I18N', 'Date', 'Number') ?>
	<hr><h4>Pulpo Colorado Patagónico (Enteroctopus megalocyathus)<br/><small class="text-muted">Indicador: Status reproductivo en el intermareal rocoso</small></h4>
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="bs_admin_text bs_admin_list_th_sexo_madurez"><?php echo __('Sexo madurez', array(), 'messages') ?></th>
          <th class="bs_admin_text">Proporción</th>

        </tr>
      </thead>
      <tbody>
        <?php foreach ($grupos as $BidG1I1): ?>
				<?php 
				if($BidG1I1['s']/$total>0.2 && $BidG1I1['sexo_madurez']=='hm') $clase='rojo';
				elseif($BidG1I1['s']/$total>0.15 && $BidG1I1['sexo_madurez']=='mm') $clase='rojo';
				else $clase='';
				?>
 
         <tr class="bs_admin_row">
          	<td><?php echo BidG1I1Peer::$sexos_madureces[$BidG1I1['sexo_madurez']];?></td>
          	<td class="<?php echo $clase ?>"><?php echo format_currency($BidG1I1['s']/$total*100,'%');?></td>

          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <p>Actividad pesquera en los meses de verano: <?php if($actividad_pesquera):?><span class="rojo">SE REGISTRÓ ACTIVIDAD</span><?php else: ?>no hay registro<?php endif ?></p>
    <p>Detección de hembras en desove o desovadas provenientes del intermareal: <?php if($hembras_desove_intermareal):?><span class="rojo">SE DETECTARON</span><?php else: ?>no se detectaron<?php endif ?></p>
<?php endif; ?>