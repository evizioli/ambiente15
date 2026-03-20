[?php use_helper('I18N', 'Date') ?]
[?php include_partial('<?php echo $this->getModuleName() ?>/assets') ?]

<div class="container-fluid">
  <h1>[?php echo <?php echo $this->getI18NString('list.title') ?> ?]</h1>

  [?php include_partial('<?php echo $this->getModuleName() ?>/flashes') ?]

  <div class="page_header">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_header', array('pager' => $pager)) ?]
  </div>
  <div id="bs_admin_content">
	<div class="row">
	  
	  
	
	<?php if ($this->configuration->hasFilterForm()): ?>
	  <div class="col-lg-4">
	    [?php include_partial('<?php echo $this->getModuleName() ?>/filters', array('form' => $filters, 'configuration' => $configuration)) ?]
	  </div>
	<?php endif; ?>
	
	  <div class="col-lg-<?php echo $this->configuration->hasFilterForm() ? '8' : '12' ?>">
	<?php if ($this->configuration->getValue('list.batch_actions')): ?>
	    <form action="[?php echo url_for('<?php echo $this->getUrlForAction('collection') ?>', array('action' => 'batch')) ?]" method="post">
	<?php endif; ?>
	    [?php include_partial('<?php echo $this->getModuleName() ?>/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?]
	    <ul class="bs_admin_actions list-inline">
	      [?php include_partial('<?php echo $this->getModuleName() ?>/list_batch_actions', array('helper' => $helper)) ?]
	      [?php include_partial('<?php echo $this->getModuleName() ?>/list_actions', array('helper' => $helper)) ?]
	    </ul>
	<?php if ($this->configuration->getValue('list.batch_actions')): ?>
	    </form>
	<?php endif; ?>
	  </div>
	
	    
	</div>
  </div>
  
  <div class="page_footer">
    [?php include_partial('<?php echo $this->getModuleName() ?>/list_footer', array('pager' => $pager)) ?]
  </div>
</div>
