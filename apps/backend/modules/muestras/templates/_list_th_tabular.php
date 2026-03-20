<?php slot('sf_admin.current_header') ?>
<th class="bs_admin_date bs_admin_list_th_fecha">
  <?php if ('fecha' == $sort[0]): ?>
    <?php echo link_to(__('Fecha', array(), 'messages'), '@muestra', array('query_string' => 'sort=fecha&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Fecha', array(), 'messages'), '@muestra', array('query_string' => 'sort=fecha&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="bs_admin_text bs_admin_list_th_numero">
  <?php if ('numero' == $sort[0]): ?>
    <?php echo link_to(__('Número de muestra', array(), 'messages'), '@muestra', array('query_string' => 'sort=numero&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Número de muestra', array(), 'messages'), '@muestra', array('query_string' => 'sort=numero&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="bs_admin_text bs_admin_list_th_lugar_extraccion">
  <?php if ('lugar_extraccion' == $sort[0]): ?>
    <?php echo link_to(__('Lugar extraccion', array(), 'messages'), '@muestra', array('query_string' => 'sort=lugar_extraccion&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Lugar extraccion', array(), 'messages'), '@muestra', array('query_string' => 'sort=lugar_extraccion&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="bs_admin_text bs_admin_list_th_protocolo">
  <?php if ('protocolo' == $sort[0]): ?>
    <?php echo link_to(__('Protocolo', array(), 'messages'), '@muestra', array('query_string' => 'sort=protocolo&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Protocolo', array(), 'messages'), '@muestra', array('query_string' => 'sort=protocolo&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="bs_admin_text bs_admin_list_th_tipo_muestra">
  <?php if ('tipo_muestra' == $sort[0]): ?>
    <?php echo link_to(__('Tipo muestra', array(), 'messages'), '@muestra', array('query_string' => 'sort=tipo_muestra&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
    <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
  <?php else: ?>
    <?php echo link_to(__('Tipo muestra', array(), 'messages'), '@muestra', array('query_string' => 'sort=tipo_muestra&sort_type=asc')) ?>
  <?php endif; ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="bs_admin_text bs_admin_list_th_nmp_coliformes_totales_100_con_lim">
  <?php echo __('Nmp coliformes totales 100 con lim', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="bs_admin_text bs_admin_list_th_nmp_coliformes_fecales_100_con_lim">
  <?php echo __('Nmp coliformes fecales 100 con lim', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="bs_admin_text bs_admin_list_th_nmp_escherichia_coli_100_con_lim">
  <?php echo __('Nmp escherichia coli 100 con lim', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?><?php slot('sf_admin.current_header') ?>
<th class="bs_admin_text bs_admin_list_th_nmp_enterococos_fecales_100_con_lim">
  <?php echo __('Nmp enterococos fecales 100 con lim', array(), 'messages') ?>
</th>
<?php end_slot(); ?>
<?php include_slot('sf_admin.current_header') ?>
<?php if(sfContext::getInstance()->getUser()->hasCredential('muestra_mostrar')):?>
    <?php slot('sf_admin.current_header') ?>
    <th class="bs_admin_boolean bs_admin_list_th_mostrar">
      <?php if ('mostrar' == $sort[0]): ?>
        <?php echo link_to(__('Mostrar', array(), 'messages'), '@muestra', array('query_string' => 'sort=mostrar&sort_type='.($sort[1] == 'asc' ? 'desc' : 'asc'))) ?>
        <?php echo image_tag(sfConfig::get('sf_admin_module_web_dir').'/images/'.$sort[1].'.png', array('alt' => __($sort[1], array(), 'sf_admin'), 'title' => __($sort[1], array(), 'sf_admin'))) ?>
      <?php else: ?>
        <?php echo link_to(__('Mostrar', array(), 'messages'), '@muestra', array('query_string' => 'sort=mostrar&sort_type=asc')) ?>
      <?php endif; ?>
    </th>
    <?php end_slot(); ?>
    <?php include_slot('sf_admin.current_header') ?>
<?php endif?>