<?php use_helper('I18N', 'Date', 'Number') ?>
<?php include_partial('bidg6i1s/assets') ?>
<?php use_stylesheets_for_form($filters) ?>
<?php use_javascripts_for_form($filters) ?>
<div class="container-fluid">
  <h1>LOBO MARINO DE UN PELO (Otaria flavescens)<br/><small class="text-muted">INDICADOR 1: Número total de individuos por clase de edad</small></h1>

  <p class="lead">

  </p>
    

  <div id="bs_admin_content">
	<div class="row">
	  
	  
	
	  <div class="col-lg-4">
	    
        
        <div class="bs_admin_filter">
          <?php if ($filters->hasGlobalErrors()): ?>
            <?php echo $filters->renderGlobalErrors() ?>
          <?php endif; ?>
        
          <form action="<?php echo url_for('bid_g6_i1_collection', array('action' => 'indicador')) ?>" method="post">
            
            
            <?php foreach ($configuration->getFormFilterFields($filters) as $name => $field): ?>
                <?php if ((isset($filters[$name]) && $filters[$name]->isHidden()) || (!isset($filters[$name]) && $field->isReal())) continue ?>
                  <?php include_partial('bidg6i1s/filters_field', array(
                    'name'       => $name,
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
                <?php echo link_to('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', 'bid_g6_i1_collection', array('action' => 'indicador'), array('query_string' => '_reset', 'method' => 'post', 'title'=>__('Reset', array(), 'sf_admin'))) ?>
                    
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
  <?php if (count( $resultado )==0): ?>
    <p style="font-size: large;"><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php else: ?>
  	<h3>Indicador: <i>Densidad mínima de individuos maduros</i></h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="bs_admin_text">Sitio</th>
          <th class="bs_admin_text">Año</th>
          <th class="bs_admin_text">Machos adultos</th>
          <th class="bs_admin_text">Machos sub-adultos</th>
          <th class="bs_admin_text">Hembras adultas</th>
          <th class="bs_admin_text">Juveniles ambos sexos</th>
          <th class="bs_admin_text">Crías</th>
          <th class="bs_admin_text">Hembras + Juveniles</th>
          <th class="bs_admin_text">Total de individuos</th>

        </tr>
      </thead>
      <tbody>
        <?php 
        $ant_mad=null; 
        $ant_msa=null; 
        $ant_h=null; 
        $ant_j=null; 
        $ant_c=null; 
        $ant_hj=null; 
        $ant_t=null; 
        foreach( $resultado as  $data): ?>
      	<?php 
      	$clase='';
      	$act_mad =$data['mad']; 
      	$act_msa =$data['msa']; 
      	$act_h =$data['h']; 
      	$act_j =$data['j']; 
      	$act_c =$data['c']; 
      	$act_hj =$data['hj']; 
      	
      	$act_t =$data['mad']+$data['msa']+$data['h']+$data['j']+$data['c']+$data['hj']; 
      	?>
         <tr class="bs_admin_row">
          	<td><?php echo $data['sitio'];?></td>
          	<td><?php echo $data['ye'];?></td>
          	<td<?php if( $ant_mad>0 && ($act_mad-$ant_mad)/$ant_mad<0.1 ): ?> class="rojo"<?php endif;?>><?php echo  $act_mad ?></td>
          	<td<?php if( $ant_msa>0 && ($act_msa-$ant_msa)/$ant_msa<0.1 ): ?> class="rojo"<?php endif;?>><?php echo $act_msa ?></td>
          	<td<?php if( $ant_h>0 && ($act_h-$ant_h)/$ant_h<0.1 ): ?> class="rojo"<?php endif;?>><?php echo $act_h ?></td>
          	<td<?php if( $ant_j>0 && ($act_j-$ant_j)/$ant_j<0.1 ): ?> class="rojo"<?php endif;?>><?php echo $act_j ?></td>
          	<td<?php if( $ant_c>0 && ($act_c-$ant_c)/$ant_c<0.1 ): ?> class="rojo"<?php endif;?>><?php echo $act_c ?></td>
          	<td<?php if( $ant_hj>0 && ($act_hj-$ant_hj)/$ant_hj<0.1 ): ?> class="rojo"<?php endif;?>><?php echo $act_hj ?></td>
          	<td<?php if( $ant_t>0 && ($act_t-$ant_t)/$ant_t<0.1 ): ?> class="rojo"<?php endif;?>><?php echo $act_t ?></td>
          </tr>
        <?php 
        $ant_mad=$act_mad; 
        $ant_msa=$act_msa; 
        $ant_h= $act_h; 
        $ant_j= $act_j; 
        $ant_c= $act_c; 
        $ant_hj=$act_hj; 
        $ant_t= $act_t; 
        
        
        endforeach; ?>
      </tbody>
    </table>

  <?php endif; ?>
</div>



		    
            
	  </div>
	
	    
	</div>
  </div>
</div>
