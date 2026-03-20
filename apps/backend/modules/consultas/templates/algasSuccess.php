<?php
use_stylesheets_for_form($filters);
use_javascripts_for_form($filters);
use_helper('Date','JavascriptBase');
echo javascript_tag('
var resp='.json_encode((object)$resp->getRawValue()).';
var chartData = '.html_entity_decode($chart).';
');
?>
<div class="container-fluid">
	<h1>Microalgas</h1>
	
    
    	<div class="row">
    		<div class="col-lg-4">
    			<div class="bs_admin_filter">
            		  <?php if ($filters->hasGlobalErrors()): ?>
            		    <?php echo $filters->renderGlobalErrors() ?>
            		  <?php endif; ?>
    		
            		  <form action="<?php echo url_for('consultas/algas') ?>" method="post">
            		    
            		    
            		    <?php foreach ($filters as $field): if($field->isHidden()) continue; ?>
            
            				<div class="form-group row">
								<?php echo $field->renderLabel(null, array('class'=>'col-lg-3 col-form-label')) ?>
            				    <div class="col-lg-9">
            				      	<?php echo $field->renderError() ?>
            				      	<?php echo $field->render() ?>
            				  	</div>
            				</div>
            				  
            				  
            		    <?php endforeach; ?>
            		    
            		    
            		    <div class="form-group row">
            						<div class="offset-sm-2 col-lg-10">

            							<button type="submit" class="btn btn-primary">Graficar</button>
       								    <?php echo link_to('Limpiar', 'consultas/algas', array('query_string' => 'limpiar=1', 'method' => 'post')) ?>
        
            						</div>
            					</div>
            		    <?php echo $filters->renderHiddenFields() ?>
            		    
            		  </form>
    			</div>
    		</div>
    		<div class="col-lg-8">
    			<?php if($lugar):?>
            		<h3><?php echo $lugar ?></h3>
                    <?php if( count($resp)>0):?>
                    	<div class="row">
                    		<div class="col-lg-12">
                				<table class="table table-stripped"  id="tdata">
                				</table>
                    		</div>
                    	</div>
                    <?php else:?>      
                    	<h3>No hay resultados cargados según los parámetros de búsqueda seleccionados</h3>
                    <?php endif?>      
            	<?php elseif($hay):?>
            		<div class="caja-redondeada azul">
                    	Seleccionar un lugar 
					</div>
            	<?php else:?>
            		<div class="caja-redondeada azul">
                    	No hay datos de microalgas disponibles
					</div>
            	<?php endif?>
    		</div>
    	</div>

    	<?php if($lugar):?>
    		<hr>
        	<div class="row">
        		<div class="col-lg-12">
        			<div id="chart" style="display:inline-block; height: 400px; width: 100%;"></div>
	    		</div>
			</div>
			
    	<?php endif?>

</div>
