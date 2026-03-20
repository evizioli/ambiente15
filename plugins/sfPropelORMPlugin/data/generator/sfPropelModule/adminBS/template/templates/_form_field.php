[?php if ($field->isPartial()): ?]
  [?php include_partial('<?php echo $this->getModuleName() ?>/'.$name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php elseif ($field->isComponent()): ?]
  [?php include_component('<?php echo $this->getModuleName() ?>', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?]
[?php else: ?]
  <div class="row control-group [?php echo $class ?][?php $form[$name]->hasError() and print ' error' ?]">
    
      [?php echo $form[$name]->renderLabel($label, array('class'=>'control-label col-lg-4')) ?]

    <div class="col-lg-8 controls">
    [?php echo $form[$name]->renderError() ?]
      [?php echo $form[$name]->render($attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes) ?]

      [?php if ($help): ?]
        <small class="form-text text-muted">[?php echo __($help, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</small>
      [?php elseif ($help = $form[$name]->renderHelp()): ?]
        <small class="form-text text-muted">[?php echo $help ?]</small>
      [?php endif; ?]
    </div>
  </div>
[?php endif; ?]
