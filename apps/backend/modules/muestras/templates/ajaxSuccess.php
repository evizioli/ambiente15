		<h1>Muestra n&deg; <?php echo $muestra->getNumero() ?> Fecha <?php echo $muestra->getFecha('d/m/Y') ?> protocolo <?php echo $muestra->getProtocoloYe() ?></h1>
<div class="container-fluid">
		<ul class="nav nav-tabs">
			<li>
        		<a  href="#1" data-toggle="tab">Generalidades</a>
			</li>
			<li>
				<a href="#2" data-toggle="tab">Variables con valores m&aacute;ximos</a>
			</li>
			<li>
				<a href="#3" data-toggle="tab">Variables sin valores m&aacute;ximos</a>
			</li>
		</ul>
	
	<div class="tab-content ">
			  <div class="tab-pane active" id="1">
				<h3>Generalidades</h3>
				<table class="table table-striped">
					<tbody>
    					<tr>
    						<td>Localidad</td>
    						<td><?php echo $muestra->getLugarExtraccion()->getLocalidad()?></td>
    					</tr>
    					<tr>
    						<td>Tipo</td>
    						<td><?php echo $muestra->getTipoMuestra() ?></td>
    					</tr>
    					<tr>
    						<td>Solicitado por</td>
    						<td><?php echo $muestra->getSolicitadoPor()?></td>
    					</tr>
    					<tr>
    						<td>Lugar de extracci&oacute;n</td>
    						<td><?php echo $muestra->getLugarDeExtraccion()?></td>
    					</tr>
    					<tr>
    						<td>Observaciones</td>
    						<td><?php echo nl2br(htmlentities($muestra->getObservaciones()))?></td>
    					</tr>
					</tbody>
				</table>

				</div>
				<div class="tab-pane" id="2">
		          <h3>Variables con valores m&aacute;ximos</h3>
    				<table class="table table-striped">
    
    					<tr>
    						<td>NMP Coliformes totales / 100 ml</td>
    						<td class="derecha"><?php echo $muestra->getNmpColiformesTotales100()?></td>
    					</tr>
    					<tr>
    						<td>NMP Coliformes fecales / 100 ml</td>
    						<td class="derecha"><?php echo $muestra->getNmpColiformesFecales100()?></td>
    					</tr>
    					<tr>
    						<td>NMP Escherichia Coli / 100 ml</td>
    						<td class="derecha"><?php echo $muestra->getNmpEscherichiaColi100()?></td>
    					</tr>
    					<tr>
    						<td>NMP Enterococos Fecales / 100 ml</td>
    						<td class="derecha"><?php echo $muestra->getNmpEnterococosFecales100()?></td>
    					</tr>
    				</table>

		
				</div>
        <div class="tab-pane" id="3">
          <h3>Variables sin valores m&aacute;ximos</h3>
	
	
				<table class="table table-striped">
					<tbody>
    					<tr>
    						<td>Temperatura</td>
    						<td class="derecha"><?php echo $muestra->getTemperatura()?></td>
    					</tr>
    					<tr>
    						<td>Ph</td>
    						<td class="derecha"><?php echo $muestra->getPh()?></td>
    					</tr>
    					<tr>
    						<td>Conductividad el&eacute;ctrica</td>
    						<td class="derecha"><?php echo $muestra->getConductividadElectricaConUnidad();?></td>
    					</tr>
    					<tr>
    						<td>Turbiedad</td>
    						<td class="derecha"><?php echo $muestra->getTurbiedadUnt()?></td>
    					</tr>
    					<tr>
    						<td>O.D. (mg/l)</td>
    						<td class="derecha"><?php echo $muestra->getOdMgL()?></td>
    					</tr>
    					<tr>
    						<td>O.D. %</td>
    						<td class="derecha"><?php echo $muestra->getOdPorcentaje()?></td>
    					</tr>
    					<tr>
    						<td>Didymosphenia geminata</td>
    						<td class="derecha"><?php echo $muestra->getDidymospheniaGeminata()?></td>
    					</tr>
    					<tr>
    						<td>DBO 5 (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getDbo5MgL()?></td>
    					</tr>
    					<tr>
    						<td>DQO (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getDqoMgL()?></td>
    					</tr>
    					<tr>
    						<td>Dureza (CaCO3) (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getDurezaCaCo3MgL()?></td>
    					</tr>
    					<tr>
    						<td>Cloruros (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getClorurosMgL()?></td>
    					</tr>
    					<tr>
    						<td>Sulfatos(mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getSulfatosMgL()?></td>
    					</tr>
    					<tr>
    						<td>Calcio (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getCalcioMgL()?></td>
    					</tr>
    					<tr>
    						<td>Magnesio (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getMagnesioMgL()?></td>
    					</tr>
    					<tr>
    						<td>Sodio (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getSodioMgL()?></td>
    					</tr>
    					<tr>
    						<td>Potasio (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getPotasioMgL()?></td>
    					</tr>
    					<tr>
    						<td>Sol. Susp. Totales 103°-105°C (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getSolSupTot103105MgL()?></td>
    					</tr>
    					<tr>
    						<td>S&oacute;lidos Sedimentables 10 min. (ml/L)</td>
    						<td class="derecha"><?php echo $muestra->getSolidosSedimentables10minMgL()?></td>
    					</tr>
    					<tr>
    						<td>S&oacute;lidos Sedimentables 1h. (ml/L)</td>
    						<td class="derecha"><?php echo $muestra->getSolidosSedimentables1hMgL()?></td>
    					</tr>
    					<tr>
    						<td>S&oacute;lidos Sedimentables 2h. (ml/L)</td>
    						<td class="derecha"><?php echo $muestra->getSolidosSedimentables2hMgL()?></td>
    					</tr>
    					<tr>
    						<td>S&oacute;lidos Totales 105°C (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getSolTot105MgL()?></td>
    					</tr>
    					<tr>
    						<td>S&oacute;lidos Totales fijos (mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getSolTotalesFijosMgL()?></td>
    					</tr>
    					<tr>
    						<td>S&oacute;lidos Totales vol&aacute;tiles(mg/L)</td>
    						<td class="derecha"><?php echo $muestra->getSolTotalesVolatilesMgL()?></td>
    					</tr>

					</tbody>
				</table>
	
	
		</div>
	</div>
</div>
	