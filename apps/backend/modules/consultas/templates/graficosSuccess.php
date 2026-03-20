<?php
use_helper('Date');
$nf = new sfNumberFormat();
use_stylesheets_for_form($filters);
use_javascripts_for_form($filters);
?>
<div class="container-fluid">
	<h1>Gr&aacute;ficos por localidad</h1>
	
    
    	<div class="row">
    	
    		<div class="col-lg-4">
    
    			<div class="bs_admin_filter">
            		  <?php if ($filters->hasGlobalErrors()): ?>
            		    <?php echo $filters->renderGlobalErrors() ?>
            		  <?php endif; ?>
    		
            		  <form action="<?php echo url_for('consultas/graficos') ?>" method="post">
            		    
            		    
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
            							<?php echo link_to('Limpiar', 'consultas/graficos', array('query_string' => 'limpiar=1', 'method' => 'post')) ?>
        
            						</div>
            					</div>
            		    <?php echo $filters->renderHiddenFields() ?>
            		    
            		  </form>
    			</div>
    
    		</div>
    		
    		
    		<div class="col-lg-8">
            	<?php if($localidad ):?>
            		

            		<h3><?php echo $localidad ?></h3>
                    <?php foreach($resultado as $f=>$aux):?>
	        			<div id="chart_<?php echo $f?>" style="height: 500px; width: 75%;"></div>
	        			<hr>
	        			<br>
					<?php endforeach;?>
        
        			<script>
        				var chartData = [], tit=[], maximo=[];
                        <?php $i=0; foreach($resultado as $f=> $aux):  ?>
							chartData[<?php echo $i?>]=  [<?php echo join(',', $aux->getRawValue());?>];
							tit[<?php echo $i?>]= { f: "<?php echo $f ?>", fecha: "<?php echo format_date($f )?>"}; 
							maximo[<?php echo $i?>]= <?php echo $maximo[$f] ?>; 
    					<?php $i++; endforeach;?>
						

        			</script>
            	<?php else:?>
            		<div class="caja-redondeada azul">
            		En esta pantalla podrá acceder a la visualización de la información bacteriológica por medio de un gráfico. Para ello debe seleccionar a continuación la localidad de la que desea visualizar la información, y luego hacer clic en Graficar. 
            		<br>
            		<br>
					En el sector derecho de la página en lugar de esta leyenda aparecerán los gráficos de ese lugar para cada fecha y en la parte inferior de la pantalla la tabla correspondiente. 
					</div>
            		
        			<script>
        				var chartData = [], tit=[];

        			</script>
            	<?php endif?>
    		</div>
    
    
    	</div>
    <?php if(isset($tabla)):?>
    	<?php if(count($tabla)>0):?>
            <hr>
        	<div class="row">
        		<div class="col-lg-12">
        			<div style="height: 500px; overflow-y: scroll">
        
        				<table class="table table-stripped">
        					<thead>
        						<tr>
        							<th>Fecha</th>
                						<?php foreach (ToleranciaPeer::$campos_bactereologicos as $i=> $c) :?>
                		  					<th><?php echo ToleranciaPeer::$tipos[$i] ?></th>
                		  				<?php endforeach;?>
        							<th>Lugar</th>
        						</tr>
        					</thead>
        					<tbody>
            	  				<?php foreach ($tabla as $row):  ?>
            	  					<tr>
        								<td><?php echo format_date( $row['f'],'dd/MM/yyyy')?></td>
                						<?php foreach (ToleranciaPeer::$campos_bactereologicos as  $c) :?>
                	  						<td style="text-align: right;<?php if( is_numeric($row[$c.'_maximo']) && $row[$c]>=$row[$c.'_maximo']) echo ' color: white; background-color: red;'?>"><?php echo $nf->format( $row[$c],'#')?></td>
                		  				<?php endforeach;?>
            	  						<td><?php echo $row['l']?></td>
        							</tr>
            	  				<?php endforeach ?>
            	  			</tbody>
        				</table>
        			</div>
        		</div>
        	</div>
        <?php else:?>      
        	<h3>No hay resultados cargados según los parámetros de búsqueda seleccionados</h3>
        <?php endif?>      
    <?php endif?>      
    
</div>
