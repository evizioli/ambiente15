<?php use_helper('Number')?>
<table class="derecha table table-striped">
	<tr>
		<th>&nbsp;</th>
		<th>&Uacute;ltimo</th>
		<th>M&iacute;nimo</th>
		<th>M&aacute;ximo</th>
		<th>Promedio</th>
	</tr>	
	
	<tr>
		<th>Coliformes totales (nmp/100ml)</th>
		<td class='derecha'><?php echo format_number( $nmp_coliformes_totales_100['ulti']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_coliformes_totales_100['mini']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_coliformes_totales_100['maxi']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_coliformes_totales_100['prom']) ?></td>
	</tr>	
	<tr>
		<th>Coliformes fecales (nmp/100ml)</th>
		<td class='derecha'><?php echo format_number( $nmp_coliformes_fecales_100['ulti']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_coliformes_fecales_100['mini']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_coliformes_fecales_100['maxi']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_coliformes_fecales_100['prom']) ?></td>
	</tr>	
	<tr>
		<th>Escherichia coli (nmp/100ml)</th>
		<td class='derecha'><?php echo format_number( $nmp_escherichia_coli_100['ulti']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_escherichia_coli_100['mini']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_escherichia_coli_100['maxi']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_escherichia_coli_100['prom']) ?></td>
	</tr>	
	<tr>
		<th>Enterococos fecales (nmp/100ml)</th>
		<td class='derecha'><?php echo format_number( $nmp_enterococos_fecales_100['ulti']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_enterococos_fecales_100['mini']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_enterococos_fecales_100['maxi']) ?></td>
		<td class='derecha'><?php echo format_number( $nmp_enterococos_fecales_100['prom']) ?></td>
	</tr>	
	<tr>
		<th>Temperatura (&deg;C)</th>
		<td class='derecha'><?php echo format_number( $temperatura['ulti']) ?></td>
		<td class='derecha'><?php echo format_number( $temperatura['mini']) ?></td>
		<td class='derecha'><?php echo format_number( $temperatura['maxi']) ?></td>
		<td class='derecha'><?php echo format_number( $temperatura['prom']) ?></td>
	</tr>	
	<tr>
		<th>PH</th>
		<td class='derecha'><?php echo format_number( $ph['ulti']) ?></td>
		<td class='derecha'><?php echo format_number( $ph['mini']) ?></td>
		<td class='derecha'><?php echo format_number( $ph['maxi']) ?></td>
		<td class='derecha'><?php echo format_number( $ph['prom']) ?></td>
	</tr>	
</table>
