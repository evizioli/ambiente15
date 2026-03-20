<td>
    <?php if ($this->configuration->getValue('list.object_actions')): ?> 
	    <ul class="bs_admin_td_actions">
		    <?php foreach ($this->configuration->getValue('list.object_actions') as $name => $params): ?>
		        <?php if ( isset( $params['condition'] ) ): ?>
		            [?php if ( <?php echo ( isset( $params['condition']['invert'] ) && $params['condition']['invert'] ? '!' : '') . '$' . $this->getSingularName( ) . '->' . $params['condition']['function'] ?>( <?php echo ( isset( $params['condition']['params'] ) ? $params['condition']['params'] : '' ) ?> ) ): ?] 
		        <?php endif; ?>
		 
				        <?php if ('_delete' == $name): ?>
				            <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
				        <?php elseif ('_edit' == $name): ?>
				            <?php echo $this->addCredentialCondition('[?php echo $helper->linkToEdit($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>
				        <?php else: ?>
					    	<li class="list-inline-item bs_admin_action_<?php echo $name ?>">
					            <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>
				 			</li>
				        <?php endif; ?>
		        <?php if ( isset( $params['condition'] ) ): ?>
		            [?php endif; ?]
		        <?php endif; ?>
		        
		    <?php endforeach; ?>
	    </ul>
    <?php endif; ?>
</td>
 