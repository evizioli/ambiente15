<?php use_helper('I18N', 'Date', 'Number') ?>
<?php include_partial('bidci3s/assets') ?>

<div class="container-fluid">


  <h1>Carnívoros terrestres</h1>

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
            
              <form action="<?php echo url_for('bid_conteo_indicador_bidci3s_collection', array('action' => 'indicador')) ?>" method="post">
                
                
                <?php foreach ($configuration->getFormFilterFields($filters) as $name => $field): ?>
                    <?php if ((isset($filters[$name]) && $filters[$name]->isHidden()) || (!isset($filters[$name]) && $field->isReal())) continue ?>
                      <?php include_partial('bidci3s/filters_field', array(
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
                    <?php echo link_to('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', 'bid_conteo_indicador_bidci3s_collection', array('action' => 'indicador'), array('query_string' => '_reset', 'method' => 'post', 'title'=>__('Reset', array(), 'sf_admin'))) ?>
                        
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
        
        
          <?php if (count($resultado)==0): ?>
            <p style="font-size: large;"><?php echo __('No result', array(), 'sf_admin') ?></p>
          <?php else: ?>
              <h3>Indicador 1: Presencia / Ausencia de carnívoros</h3>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="bs_admin_text">Especie</th>
                  <th class="bs_admin_text">Estado</th>
        
                </tr>
              </thead>
              <tbody>
                <?php $i2=array(); foreach ($resultado as $r): ?>
        				
         
                 <tr class="bs_admin_row">
                  	<td><?php echo $r['especie'];?></td>
                  	<td<?php if($r['pa']=='A'):?> class="rojo"<?php $i2[$r['especie_id']]=$r['especie']; endif;?>><?php echo $r['pa']=='A'?'Ausente' : 'Presente' ;?></td>
        
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
            
              <h3>Indicador 2: Riqueza específica de especies de carnívoros<br>
              	<small></small>
              </h3>
            <p>Cantidad de especies detectadas: <?php echo count($i2)?></p>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="bs_admin_text">Especie</th>
        
                </tr>
              </thead>
              <tbody>
                <?php foreach ($i2 as $e): ?>
        				
         
                 <tr class="bs_admin_row">
                  	<td><?php echo $e;?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
        
              <h3>Indicador 3: Índice de abundancia relativa</h3>
            <table class="table table-striped">
              <thead>
                <tr>
                  <th class="bs_admin_text">Especie</th>
                  <th class="bs_admin_text">I.A.R.</th>
        
                </tr>
              </thead>
              <tbody>
                <?php $i2=array(); foreach ($resultado3 as $r): ?>
        				
         
                 <tr class="bs_admin_row">
                  	<td><?php echo $r['especie'];?></td>
                  	<td><?php echo format_currency( $r['c']/$r['em']*100 );?></td>
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
  </div>


</div>
