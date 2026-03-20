<?php
use_helper('Date','Number');
use_stylesheets_for_form($filters);
use_javascripts_for_form($filters);
?>
<div class="container-fluid">
	<h1>Caudales y niveles Dique F. Ameghino</h1>
	
    
    	<div class="row">
    		<div class="col-lg-4">
    			<div class="bs_admin_filter">
            		  <?php if ($filters->hasGlobalErrors()): ?>
            		    <?php echo $filters->renderGlobalErrors() ?>
            		  <?php endif; ?>
    		
            		  <form action="<?php echo url_for('consultas/caudales') ?>" method="post">
            		    
            		    
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
							    <?php echo link_to('Limpiar', 'consultas/caudales', array('query_string' => 'limpiar=1', 'method' => 'post')) ?>

    						</div>
    					</div>
            		    
            		    <div  class="form-group row" style="margin: 5px;  text-align:justify; padding: 10px; background-image: linear-gradient( 180deg,#BFD4FE, #E5EFFF); border: 3px solid #4A7EBB; border-radius: 25px;" >
                            <div class="col-lg-12 lead align-middle" style="font-size: 1em; font-weight: bold;">
                            Al poner el rango de fecha y filtrar, aparecerá un gráfico con la información
        					del nivel del embalse (m) y el caudal emitido por la represa (m 3 /seg).
                            </div>
                        </div>
            		    <?php echo $filters->renderHiddenFields() ?>
            		    
            		  </form>
    			</div>
    		</div>
    		<div class="col-lg-8">
  
                    	<div class="row">
                    		<div class="col-lg-12">
            	  				<?php if(count($caudales)>0):  ?>
                    
                    				<div class="container-fluid">
                        				<div class="row">
                            				<div class="col-lg-2"><b>Fecha</b></div>
                            				<div class="col-lg-2" style="text-align: right;"><b>Caudal aporte</b></div>
                            				<div class="col-lg-2" style="text-align: right;"><b>Nivel embalse</b></div>
                            				<div class="col-lg-2" style="text-align: right;"><b>Caudal turbinado</b></div>
                            				<div class="col-lg-2" style="text-align: right;"><b>Caudal vertido</b></div>
                        				</div>
                    			<div style="height: 300px; width:100%; overflow-y: scroll; overflow-x: clip">
                    	  				<?php foreach ($caudales as $row):  ?>
                            				<div class="row">
                                				<div class="col-lg-2"><?php echo format_date( $row->getFecha(), 'dd/MM/yyyy')?></div>
                                				<div class="col-lg-2" style="text-align: right;"><?php echo format_number( $row->getCaudalAporte() )?></div>
                                				<div class="col-lg-2" style="text-align: right;"><?php echo format_number( $row->getNivelEmbalse() )?></div>
                                				<div class="col-lg-2" style="text-align: right;"><?php echo format_number( $row->getCaudalTurbinado() )?></div>
                                				<div class="col-lg-2" style="text-align: right;"><?php echo format_number( $row->getCaudalVertido() )?></div>
                            				</div>
                    	  				<?php endforeach ?>
                    				</div>
                    
                    			</div>
                    			<?php else:?>
                        		    <div  class="row" style="margin: 5px;  text-align:justify; font-size: 1.5em; padding: 20px; background-image: linear-gradient( 180deg,#BFD4FE, #E5EFFF); border: 3px solid #4A7EBB; border-radius: 80px;" >
                                        <div class="col-lg-12 lead align-middle" style="font-size: 1em; ">
        	                        		La siguiente información es aportada por Hidroeléctrica Ameghino S. A. (HASA).<br>
                                            El <b>caudal de aporte</b>, es el que alimenta el embalse. La medici&oacute;n se realiza en Los Altares.<br>  
                                            El <b>caudal vertido</b>, es el caudal que la presa emite sin generar energía eléctrica.<br>
                                            El <b>caudal turbinado</b> es el caudal emitido que pasa por las turbinas para generar energía.<br>
                                            La suma de los caudales vertido y turbinado se conoce como <b>caudal emitido</b> por la represa y es el que alimenta el Río Chubut.<br>
                                            
                                            <?php echo image_tag('embalse2',array('style'=>'width:100%'))?>
                                                        	                        				
                        				
                        				</div>
                    				
                    				</div>
                    			<?php endif?>
                    		</div>
                    	</div>


    		</div>
    	</div>

    	<div class="row">
    		<div class="col-lg-12">
        		<hr>
    			<div id="chart" style="display:inline-block; height: 400px; width: 100%;"></div>
    		</div>
    		
		</div>
		
		
		<?php include_partial('caudales/chartCaudales',array('nivel_embalse'=>$nivel_embalse, 'caudal_aporte'=>$caudal_aporte, 'caudal'=>$caudal))?>




</div>
