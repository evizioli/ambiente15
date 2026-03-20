[?php use_stylesheets_for_form($form) ?]
[?php use_javascripts_for_form($form) ?]
<div class="bs_admin_form">

	[?php $grupos= $configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit'); if(count($grupos)>1): $activo=true; ?]

	<ul class="nav nav-tabs">
	  [?php foreach ($grupos as $fieldset => $fields): ?]
	  	[?php $tab_error=false; foreach ($fields as $name => $field) $tab_error = $tab_error || $form[$name]->hasError(); ?]
	  	<li class="[?php if($tab_error): ?] tabConError[?php endif ?][?php if($activo): ?] active[?php endif ?]">
	  		<a data-toggle="tab"  href="#[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">[?php echo __($fieldset, array(), '<?php echo $this->getI18nCatalogue() ?>') ?]</a>
	  	</li>
	  [?php $activo=false; endforeach; ?]
	</ul>
	[?php endif?]
	
	
	    [?php if ($form->hasGlobalErrors()): ?]
	      [?php echo $form->renderGlobalErrors() ?]
	    [?php endif; ?]
	
	  [?php echo form_tag_for($form, '@<?php echo $this->params['route_prefix'] ?>', array('class'=>'form-horizontal','role'=>'form')) ?]
		    [?php echo $form->renderHiddenFields(false) ?]

		<div class="tab-content" style="margin-top: 15px">
		
		    [?php $activo=true; foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?]
		    	<div class="tab-pane[?php if($activo): ?] in active[?php endif ?]" id="[?php echo preg_replace('/[^a-z0-9_]/', '_', strtolower($fieldset)) ?]">
		      	[?php include_partial('<?php echo $this->getModuleName() ?>/form_fieldset', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?]
		      	</div>
		    [?php $activo=false; endforeach; ?]
		
		    [?php include_partial('<?php echo $this->getModuleName() ?>/form_actions', array('<?php echo $this->getSingularName() ?>' => $<?php echo $this->getSingularName() ?>, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?]
		</div>
	  </form>
</div>
