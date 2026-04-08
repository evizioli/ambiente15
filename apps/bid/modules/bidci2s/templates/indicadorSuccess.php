<?php use_helper('I18N', 'Date', 'Number') ?>
<?php include_partial('bidci2s/assets') ?>

<div class="container-fluid">


  <h1>Abundancia de Aves Playeras A.N.P.P.V.</h1>

  <p class="lead">
</p>
   
  <div id="bs_admin_content">
	<div class="row">
	  
	  
	
	  <div class="col-lg-4">
	    
<?php use_stylesheets_for_form($filters) ?>
<?php use_javascripts_for_form($filters) ?>

<div class="bs_admin_filter">
  <?php if ($filters->hasGlobalErrors()): ?>
    <?php echo $filters->renderGlobalErrors() ?>
  <?php endif; ?>

  <form action="<?php echo url_for('bid_conteo_indicador_bidci2s_collection', array('action' => 'indicador')) ?>" method="post">
    
    
    <?php foreach ($configuration->getFormFilterFields($filters) as $name => $field): ?>
        <?php if ((isset($filters[$name]) && $filters[$name]->isHidden()) || (!isset($filters[$name]) && $field->isReal())) continue ?>
          <?php include_partial('bidci2s/filters_field', array(
            'name'       => $name,
            //'attributes' => $field->getConfig('attributes', array('class'=>'form-control')),
            'attributes' => $field->getConfig('attributes', array()),
            'label'      => $field->getConfig('label'),
            'help'       => $field->getConfig('help'),
            'form'       => $filters,
            'field'      => $field,
            'class'      => 'bs_admin_form_row bs_admin_'.strtolower($field->getType()).' bs_admin_filter_field_'.$name,
          )) ?>
    <?php endforeach; ?>
    
    
    <div class="form-group row">
      <div class="offset-sm-2 col-lg-10">
        <?php echo link_to('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', 'bid_conteo_indicador_bidci2s_collection', array('action' => 'indicador'), array('query_string' => '_reset', 'method' => 'post', 'title'=>__('Reset', array(), 'sf_admin'))) ?>
            
        <button type="submit" class="btn btn-primary" title="<?php echo __('Filter', array(), 'sf_admin') ?>"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
	   <ul class="bs_admin_actions list-inline">
              <?php echo $helper->linkToList(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Back to list',)) ?>
        </ul>
      </div>
    </div>
    <?php echo $filters->renderHiddenFields() ?>
    
  </form>
</div>



		</div>
		
	  <div class="col-lg-8">
		    


        <div class="bs_admin_list">
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
//                 $dp[$r['especie_id']]['puntos'][]=sprintf('{ x: new Date(%d,%d,%d), y: %d }', $r['y'], $r['m']-1, $r['q'], $r['cantidad']);
                $dp[$r['especie_id']]['puntos'][]=sprintf('{ label: "%d %s", y: %d }',  $r['q'], format_date(  $r['y'].'-'.$r['m'].'-'.$r['q'], 'MMM/yyyy') ,  $r['cantidad']);
                ;
                
                format_date($date)
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
        </div>
            
	  </div>
	
	    
	</div>
  </div>
  
  <div class="page_footer">
  	<div id="chart" style="display:inline-block; height: 300px; width: 100%;"></div>
  </div>


</div>
<script type="text/javascript">

	var chartData = [
	<?php foreach ($dp as $linea):?>
	
    	{
			type: "spline",
			name: "<?php echo $linea['especie']?>",
//			axisYType: "secondary",
			showInLegend: true,
//			markerType: "none",
			dataPoints: [<?php echo join(',',$linea['puntos'])?>]
		},
		<?php endforeach;?>
	];

</script>
