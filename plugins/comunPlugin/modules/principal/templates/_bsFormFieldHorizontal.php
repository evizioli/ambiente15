<?php foreach($form as $fila): if($fila->isHidden() ) continue;?>
<div class="form-group<?php if($fila->hasError()):?>  has-error<?php endif ?>">
	<?php echo $fila->renderError() ?>
    <?php echo $fila->renderLabel(null,array('class'=>"col-sm-2 control-label"))?>
    <div class="col-sm-10">
	    <?php echo $fila->render(array('class'=>"form-control"))?>
    </div>
    <?php if($help = $fila->renderHelp()):?>
	    <span class="help-block"><?php echo $help?></span>
    <?php endif?>
</div>
<?php endforeach; ?>