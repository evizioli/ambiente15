[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]

<div class="bs_admin_filter">
  [?php if ($form->hasGlobalErrors()): ?]
    [?php echo $form->renderGlobalErrors() ?]
  [?php endif; ?]

  <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter')) ?]" method="post">
    
    
    [?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?]
        [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
          [?php include_partial('<?php echo $this->getModuleName() ?>/filters_field', array(
            'name'       => $name,
            //'attributes' => $field->getConfig('attributes', array('class'=>'form-control')),
            'attributes' => $field->getConfig('attributes', array()),
            'label'      => $field->getConfig('label'),
            'help'       => $field->getConfig('help'),
            'form'       => $form,
            'field'      => $field,
            'class'      => 'bs_admin_form_row bs_admin_'.strtolower($field->getType()).' bs_admin_filter_field_'.$name,
          )) ?]
    [?php endforeach; ?]
    
    
    <div class="form-group row">
      <div class="offset-sm-2 col-lg-10">
        [?php echo link_to('<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>', '<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post', 'title'=>__('Reset', array(), 'sf_admin'))) ?]
            
        <button type="submit" class="btn btn-primary" title="[?php echo __('Filter', array(), 'sf_admin') ?]"><span class="glyphicon glyphicon-filter" aria-hidden="true"></span></button>
      </div>
    </div>
    [?php echo $form->renderHiddenFields() ?]
    
  </form>
</div>
