<?php use_helper('I18N', 'Date', 'Number') ?>

  <?php if ($total==0): ?>
    <p style="font-size: large;"><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="bs_admin_text">Especie</th>
          <th class="bs_admin_text">Quincena</th>
          <th class="bs_admin_text">Cantidad</th>

        </tr>
      </thead>
      <tbody>
        <?php  $dp=array(); foreach ($resultado as $r): 
                if(!isset($dp[$r['especie_id']])){
                    $dp[$r['especie_id']]=array(
                        'especie'=>$r['especie'],
                        'puntos'=>array()
                    );
                }
                $dp[$r['especie_id']]['puntos'][]=sprintf('{ label: "%d %s", y: %d }',  $r['q'], format_date(  $r['y'].'-'.$r['m'].'-'.$r['q'], 'MMM/yyyy') ,  $r['cantidad']);
                ?>
         <tr class="bs_admin_row">
          	<td><?php echo $r['especie'];?></td>
          	<td><?php echo format_date(mktime(0,0,0,$r['q'],$r['m'],$r['y']), 'd MM/yyyy');?></td>
          	<td<?php if($r['cantidad']==0):?> class="rojo"<?php endif;?>><?php echo format_number($r['cantidad']);?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
