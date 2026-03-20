<?php include_partial('caudales/assets') ?>
<?php use_helper('I18N', 'Date') ?>

<div class="container">
  <h1>Importar datos desde planilla de cálculo</h1>

  <?php include_partial('caudales/flashes') ?>

<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<div class="bs_admin_form">


	  <?php echo $form->renderFormTag(url_for( 'caudales/importar'), array('class'=>'form-horizontal','role'=>'form')) ?>
		<div class="tab-content" style="margin-top: 15px">
		    <?php echo $form ?>


            <ul class="bs_admin_actions list-inline">

              <?php echo $helper->linkToSave(null, array(  'params' =>   array(  ),  'class_suffix' => 'save',  'label' => 'Save',)) ?>

            </ul>
		</div>
	  </form>
</div>

</div>
