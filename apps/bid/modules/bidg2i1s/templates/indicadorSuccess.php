<?php use_helper('I18N', 'Date', 'Number') ?>
<?php include_partial('bidg2i1s/assets') ?>
<div class="container-fluid">
  <h1><?php echo __('Mara Patagónica', array(), 'messages') ?></h1>

  <?php include_partial('bidg2i1s/flashes') ?>
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

  <form action="<?php echo url_for('bid_g2_i1_collection', array('action' => 'indicador')) ?>" method="post">
    
    
    <?php foreach ($configuration->getFormFilterFields($filters) as $name => $field): ?>
        <?php if ((isset($filters[$name]) && $filters[$name]->isHidden()) || (!isset($filters[$name]) && $field->isReal())) continue ?>
          <?php include_partial('bidg2i1s/filters_field', array(
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
        <?php echo link_to('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', 'bid_g2_i1_collection', array('action' => 'indicador'), array('query_string' => '_reset', 'method' => 'post', 'title'=>__('Reset', array(), 'sf_admin'))) ?>
            
        <button type="submit" class="btn btn-primary" title="<?php echo __('Filter', array(), 'sf_admin') ?>"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
	   <ul class="bs_admin_actions list-inline">
              <?php echo $helper->linkToList(array(  'params' =>   array(  ),  'class_suffix' => 'list',  'label' => 'Back to list',)) ?>
        </ul>
      </div>
    </div>
    <?php echo $filters->renderHiddenFields() ?>
    
  </form>
</div>

<div id="mapa">
	
</div>
<?php 
use_helper('JavascriptBase');
echo javascript_tag('
    var features=[];
    var features2=["'.join('","',$configuration->getRawValue()->features).'"];

var urltofepng  = "'.image_path('bidg2i1',true).'";
');
?>

		</div>
		
	  <div class="col-lg-8">
		    


<div class="bs_admin_list">
  <?php if (count( $resultado )==0): ?>
    <p style="font-size: large;"><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
  	<h3>Indicador: <i>Densidad mínima de individuos maduros</i></h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="bs_admin_text">Sitio</th>
          <th class="bs_admin_text">Año</th>
          <th class="bs_admin_text">Superficie (HA)</th>
          <th class="bs_admin_text">Nro de individuos adultos</th>
          <th class="bs_admin_text">Proporción</th>

        </tr>
      </thead>
      <tbody>
        <?php $anterior=null; foreach( $resultado as  $BidG2I1): ?>
      	<?php 
      	$clase='';
      	 $actual =$BidG2I1['adultos']/$BidG2I1['hectareas']*100; 
      	 if($anterior ){
      	     if($anterior >$actual){
      	         if($anterior >0 && $actual/$anterior>.3) $clase='rojo';
      	         
      	     } else {
      	         if($actual>0 && $anterior/$actual>.3) $clase='rojo';
      	         
      	     }
      	 }
      	 ?>
         <tr class="bs_admin_row">
          	<td><?php echo $BidG2I1['nombre'];?></td>
          	<td><?php echo $BidG2I1['ye'];?></td>
          	<td><?php echo format_currency($BidG2I1['hectareas'], '');?></td>
          	<td><?php echo $BidG2I1['adultos'];?></td>
          	<td class="<?php echo $clase ?>"><?php echo format_currency($actual,'%');  ?></td>
          </tr>
        <?php $anterior=$actual; endforeach; ?>
      </tbody>
    </table>

  	<h3>Indicador: <i>Éxito reproductivo</i></h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="bs_admin_text">Sitio</th>
          <th class="bs_admin_text">Año</th>
          <th class="bs_admin_text">Adultos</th>
          <th class="bs_admin_text">Crías clase 1</th>
          <th class="bs_admin_text">Crías clase 2</th>
          <th class="bs_admin_text">Crías clase 3</th>
          <th class="bs_admin_text">Crías clase 4</th>
          <th class="bs_admin_text">Observaciones</th>

        </tr>
      </thead>
      <tbody>
        <?php $anterior=null; foreach( $res2 as  $BidG2I1): ?>
      	<?php 
      	$clase='';
      	$actual =abs( $BidG2I1->getNumeroCriasClase2()-$BidG2I1->getNumeroCriasClase3()); 
      	 if($anterior ){
      	     if($anterior!=$actual){
      	         $clase='rojo';
          	 }
      	 }
      	 ?>
         <tr class="bs_admin_row">
          	<td><?php echo $BidG2I1->getBidSitio()->getNombre();?></td>
          	<td><?php echo $BidG2I1->getFecha('Y');?></td>
          	<td><?php echo $BidG2I1->getNumeroAdultos();?></td>
          	<td><?php echo $BidG2I1->getNumeroCriasClase1();?></td>
          	<td class="<?php echo $clase ?>"><?php echo $BidG2I1->getNumeroCriasClase2();?></td>
          	<td class="<?php echo $clase ?>"><?php echo $BidG2I1->getNumeroCriasClase3();?></td>
          	<td><?php echo $BidG2I1->getNumeroCriasClase4();?></td>
          	<td><?php echo nl2br(htmlspecialchars( $BidG2I1->getObservaciones()));?></td>
          </tr>
        <?php $anterior=$actual; endforeach; ?>
      </tbody>
    </table>
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
