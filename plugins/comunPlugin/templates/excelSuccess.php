<div id="sf_admin_container">

  <div id="sf_admin_content">

	<div class="sf_admin_list">
	    <table cellspacing="0">
	      <thead>
	        <tr>
	          
	          <?php 
	          $configuration =$configuration->getRawValue();
	          $aux = $configuration->getFieldsList();
	          foreach($configuration->getListDisplay() as  $col): 
	          	$label= isset($aux[str_replace('=','',$col)]['label']) ? $aux[str_replace('=','',$col)]['label'] : $col
	          ?>
	          	<th><?php echo sfInflector::humanize(  $label ) ?></th>
	          <?php endforeach ?>
	        </tr>
	      </thead>
	      <tbody>
	        <?php foreach ($rows as  $row):  ?>
	          <tr >
	          	
	          	<?php foreach($configuration->getListDisplay() as $col): 
	          		$metodo='get'.sfInflector::camelize(  str_replace('=','',$col)); 
	          	?>
	          	<td><?php echo utf8_decode($row->$metodo()) ?></td>
	          <?php endforeach ?>
	          </tr>
	        <?php endforeach; ?>
	      </tbody>
	    </table>
	</div>




  </div>


</div>
