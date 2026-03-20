<?xml version="1.0" encoding="UTF-8"?>
<markers>
	<?php foreach ($lugares as $l):?>
        <marker id="<?php echo $l->getId()?>" name="<?php echo htmlspecialchars($l->getNombre()) ?>" address="<?php echo $l->getLocalidad()?>" lat="<?php echo $l->getVirtualColumn('lat')?>" lng="<?php echo $l->getVirtualColumn('lon')?>" type="" />
	<?php endforeach;?>
</markers>
