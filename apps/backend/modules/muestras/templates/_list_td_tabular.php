<td class="bs_admin_date bs_admin_list_td_fecha">
  <?php echo false !== strtotime($Muestra->getFecha()) ? format_date($Muestra->getFecha(), "dd/MM/yyyy") : '&nbsp;' ?>
</td>
<td class="bs_admin_text bs_admin_list_td_numero">
  <?php echo $Muestra->getNumero() ?>
</td>
<td class="bs_admin_text bs_admin_list_td_lugar_extraccion">
  <?php echo $Muestra->getLugarExtraccion() ?>
</td>
<td class="bs_admin_text bs_admin_list_td_protocolo">
  <?php echo get_partial('muestras/protocolo', array('type' => 'list', 'Muestra' => $Muestra)) ?>
</td>
<td class="bs_admin_text bs_admin_list_td_tipo_muestra">
  <?php echo $Muestra->getTipoMuestra() ?>
</td>
<td class="bs_admin_text bs_admin_list_td_nmp_coliformes_totales_100_con_lim">
  <?php echo $Muestra->getNmpColiformesTotales100ConLim() ?>
</td>
<td class="bs_admin_text bs_admin_list_td_nmp_coliformes_fecales_100_con_lim">
  <?php echo $Muestra->getNmpColiformesFecales100ConLim() ?>
</td>
<td class="bs_admin_text bs_admin_list_td_nmp_escherichia_coli_100_con_lim">
  <?php echo $Muestra->getNmpEscherichiaColi100ConLim() ?>
</td>
<td class="bs_admin_text bs_admin_list_td_nmp_enterococos_fecales_100_con_lim">
  <?php echo $Muestra->getNmpEnterococosFecales100ConLim() ?>
</td>
<?php if(sfContext::getInstance()->getUser()->hasCredential('muestra_mostrar')):?>
    
    <td class="bs_admin_boolean bs_admin_list_td_mostrar">
      <?php echo get_partial('muestras/list_field_boolean', array('value' => $Muestra->getMostrar())) ?>
    </td>
<?php endif?>