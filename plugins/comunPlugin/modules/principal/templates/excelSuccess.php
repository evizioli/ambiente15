<div id="sf_admin_container">

  <div id="sf_admin_content">

	<div class="sf_admin_list">
	    <table cellspacing="0">
	      <thead>
	        <tr>
	          
	          <?php 
	          $configuration =$configuration->getRawValue();
	          $aux = $configuration->getFieldsList();
	          $def = $configuration->getFieldsDefault();
	          foreach($aux as  $col=>$f):
	          	
	          	if( !isset($def[$col]['is_real']) || $def[$col]['is_real'] ): 
	          	$label= isset($f['label']) ? $f['label'] : $col
	          ?>
	          	<th><?php echo sfInflector::humanize(  $label ) ?></th>
	          <?php endif; endforeach ?>
	        </tr>
	      </thead>
	      <tbody>
	        <?php foreach ($rows as  $ProyectoScti):  ?>
	          <tr >
	          	
	          	<?php foreach($aux as  $col=>$f): 
	          		if( !isset($def[$col]['is_real']) || $def[$col]['is_real'] ): 
	          		$metodo='get'.sfInflector::camelize(  $col ); 
	          	?>
	          	<td><?php echo utf8_decode($ProyectoScti->$metodo()) ?></td>
	          <?php endif; endforeach ?>
	          </tr>
	        <?php endforeach; ?>
	      </tbody>
	    </table>
	</div>




  </div>


</div>
