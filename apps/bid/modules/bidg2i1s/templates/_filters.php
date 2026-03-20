<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="bs_admin_filter">
  <?php if ($form->hasGlobalErrors()): ?>
    <?php echo $form->renderGlobalErrors() ?>
  <?php endif; ?>

  <form action="<?php echo url_for('bid_g2_i1_collection', array('action' => 'filter')) ?>" method="post">
    
    
    <?php foreach ($configuration->getFormFilterFields($form) as $name => $field): ?>
        <?php if ((isset($form[$name]) && $form[$name]->isHidden()) || (!isset($form[$name]) && $field->isReal())) continue ?>
          <?php include_partial('bidg2i1s/filters_field', array(
            'name'       => $name,
            //'attributes' => $field->getConfig('attributes', array('class'=>'form-control')),
            'attributes' => $field->getConfig('attributes', array()),
            'label'      => $field->getConfig('label'),
            'help'       => $field->getConfig('help'),
            'form'       => $form,
            'field'      => $field,
            'class'      => 'bs_admin_form_row bs_admin_'.strtolower($field->getType()).' bs_admin_filter_field_'.$name,
          )) ?>
    <?php endforeach; ?>
    
    
    <div class="form-group row">
      <div class="offset-sm-2 col-lg-10">
        <?php echo link_to(__('Reset', array(), 'sf_admin'), 'bid_g2_i1_collection', array('action' => 'filter'), array('query_string' => '_reset', 'method' => 'post')) ?>
            
        <button type="submit" class="btn btn-primary"><?php echo __('Filter', array(), 'sf_admin') ?></button>
      </div>
    </div>
    <?php echo $form->renderHiddenFields() ?>
    
  </form>
</div>
<div id="mapa">
	
</div>
<?php 
use_helper('JavascriptBase');
echo javascript_tag('
    var features=["'.join('","',$configuration->getRawValue()->features).'"];
    var features2=[];

var urltofepng  = "'.image_path('bidg2i1',true).'";
');
?>