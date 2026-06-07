<?php use_helper('I18N', 'Date', 'Number') ?>
<?php include_partial('bidci1s/assets') ?>

<div class="container-fluid">


  <h1>Abundancia de Aves Playeras PIMCPA</h1>

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

  <form action="<?php echo url_for('bid_conteo_indicador_collection', array('action' => 'indicador')) ?>" method="post">
    
    
    <?php foreach ($configuration->getFormFilterFields($filters) as $name => $field): ?>
        <?php if ((isset($filters[$name]) && $filters[$name]->isHidden()) || (!isset($filters[$name]) && $field->isReal())) continue ?>
          <?php include_partial('bidci1s/filters_field', array(
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
        <?php echo link_to('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', 'bid_conteo_indicador_collection', array('action' => 'indicador'), array('query_string' => '_reset', 'method' => 'post', 'title'=>__('Reset', array(), 'sf_admin'))) ?>
            
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
                  	<?php include_partial('indicador', array('total'=>$total, 'resultado'=>$resultado))?>
 
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
