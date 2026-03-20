<fieldset class="form-group" id="sf_fieldset_[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">
  [?php if ('NONE' != $fieldset): ?]
  <!-- 
    <legend class="col-form-legend">[?php echo __($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</legend>
   -->
  [?php endif; ?]

  [?php foreach ($fields as $name => $field): ?]
    [?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?]
    [?php include_partial('<?php echo $this->getModuleName() ?>/form_field', array(
      'name'       => $name,
//      'attributes' => $field->getConfig('attributes', array('class'=>'form-control')),
      'attributes' => $field->getConfig('attributes', array()),
      'label'      => $field->getConfig('label'),
      'help'       => $field->getConfig('help'),
      'form'       => $form,
      'field'      => $field,
      'class'      => 'bs_admin_'.strtolower($field->getType()).' bs_admin_form_field_'.$name,
    )) ?]
  [?php endforeach; ?]
</fieldset>
