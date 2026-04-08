<?php use_helper('I18N', 'Date', 'Number') ?>
<?php include_partial('bidg8i1s/assets') ?>
<?php use_stylesheets_for_form($filters) ?>
<?php use_javascripts_for_form($filters) ?>
<div class="container-fluid">
  <h1>BALLENA FRANCA AUSTRAL (Eubalaena australis)<br/><small class="text-muted">INDICADOR: Abundancia de pares madre-cría</small></h1>

  <p class="lead">

  </p>
    

  <div id="bs_admin_content">
	<div class="row">
	  
	  
	
	  <div class="col-lg-4">
	    
        
        <div class="bs_admin_filter">
          <?php if ($filters->hasGlobalErrors()): ?>
            <?php echo $filters->renderGlobalErrors() ?>
          <?php endif; ?>
        
          <form action="<?php echo url_for('bid_g8_i1_collection', array('action' => 'indicador')) ?>" method="post">
            
            
            <?php foreach ($configuration->getFormFilterFields($filters) as $name => $field): ?>
                <?php if ((isset($filters[$name]) && $filters[$name]->isHidden()) || (!isset($filters[$name]) && $field->isReal())) continue ?>
                  <?php include_partial('bidg8i1s/filters_field', array(
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
                <?php echo link_to('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', 'bid_g8_i1_collection', array('action' => 'indicador'), array('query_string' => '_reset', 'method' => 'post', 'title'=>__('Reset', array(), 'sf_admin'))) ?>
                    
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
  	
    <table class="table table-striped">
      <thead>
        <tr>
          <th class="bs_admin_text">Sitio</th>
          <th class="bs_admin_text">Año</th>
          <th class="bs_admin_text">Pares</th>
          <th class="bs_admin_text">Crías huérfanas</th>

        </tr>
      </thead>
      <tbody>
        <?php 
        $anterior=null; 
        foreach( $resultado as  $data): ?>
      	<?php 
      	$clase='';
      	$actual =$data['pares']; 

      	if( !is_null($anterior ) && $anterior >0 && $actual/$anterior<.2) $clase='rojo';
      	
      	
      	
      	?>
         <tr class="bs_admin_row">
          	<td><?php echo $data['sitio'];?></td>
          	<td><?php echo $data['ye'];?></td>
          	<td class="<?php echo $clase ?>"><?php echo  $actual ?></td>
          	<td<?php if( $data['crias_huerfanas']>0 ): ?> class="rojo"<?php endif;?>><?php echo $data['crias_huerfanas']?></td>
          </tr>
        <?php 
        $anterior=$actual;
        
        
        endforeach; ?>
      </tbody>
    </table>

  <?php endif; ?>
</div>



		    
            
	  </div>
	
	    
	</div>
  </div>
</div>
