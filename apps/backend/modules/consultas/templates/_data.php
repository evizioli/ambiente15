<?php
if($lugar->count()==0): include_partial('comoHacer');
else: 
use_helper('Date', 'Number','I18N');
?>

	<h2>Lugar de monitoreo</h2>
	<ul style="height: 100px; overflow-y: auto;">
		<?php foreach ($nombres as $id=>$n):?>
			<li><a href="#" onclick="centrar(<?php echo $id?>)" title="Centrar en el mapa"><span class="glyphicon glyphicon-screenshot" aria-hidden="true"></span> <?php echo $n?></a></li>
		<?php endforeach;?>
	</ul>
    
<h3>Muestras (Cantidad de resultados de la siguiente tabla: <?php echo $muestras_count?>)</h3>
<p>
En la tabla a continuación se listan los resultados de los muestreos que dan origen a la estadística anterior. En caso de seleccionar un tipo de uso, los valores que se pongan en color rojo indican que se supera el nivel establecido en la normativa vigente.
</p>

    
    <table class='table table-bordered table-hover' id="tdata">
    
    </table>

<?php endif ?>