<?php use_helper('I18N', 'Date', 'Number') ?>
<?php include_partial('bidg1i1s/assets') ?>

<div class="container-fluid">
  <h1><?php echo __('Pulpo Colorado Patagónico<br/>Indicador: <i>Status reproductivo en el intermareal rocoso</i>', array(), 'messages') ?></h1>

  <?php include_partial('bidg1i1s/flashes') ?>
<!-- 
  <div class="page_header">
  </div>
 -->
    

  <div id="bs_admin_content">
	<div class="row">
	  
	  
	
	  <div class="col-lg-4">
	    
<?php use_stylesheets_for_form($filters) ?>
<?php use_javascripts_for_form($filters) ?>

<div class="bs_admin_filter">
  <?php if ($filters->hasGlobalErrors()): ?>
    <?php echo $filters->renderGlobalErrors() ?>
  <?php endif; ?>

  <form action="<?php echo url_for('bid_g1_i1_collection', array('action' => 'indicador')) ?>" method="post">
    
    
    <?php foreach ($configuration->getFormFilterFields($filters) as $name => $field): ?>
        <?php if ((isset($filters[$name]) && $filters[$name]->isHidden()) || (!isset($filters[$name]) && $field->isReal())) continue ?>
          <?php include_partial('bidg1i1s/filters_field', array(
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
        <?php echo link_to('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', 'bid_g1_i1_collection', array('action' => 'indicador'), array('query_string' => '_reset', 'method' => 'post', 'title'=>__('Reset', array(), 'sf_admin'))) ?>
            
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
</div>



		    
            
	  </div>
	
	    
	</div>
  </div>
  
<!-- 
  <div class="page_footer">
  </div>
 -->    

</div>
