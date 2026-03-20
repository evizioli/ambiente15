<nav aria-label="Page navigation">
  <ul class="pagination">
    <li>
      <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=1" aria-label="[?php echo __('First page', array(), 'sf_admin') ?]">
        <span aria-hidden="true">&brvbar;&laquo;</span>
      </a>
    </li>
    <li>
      <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getPreviousPage() ?]" aria-label="[?php echo __('Previous page', array(), 'sf_admin') ?]">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
	  [?php foreach ($pager->getLinks() as $page): ?]
	    <li>
		    [?php if ($page == $pager->getPage()): ?]
		      <span>[?php echo $page ?]</span>
		    [?php else: ?]
		      <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $page ?]">[?php echo $page ?]</a>
		    [?php endif; ?]
	    </li>
	  [?php endforeach; ?]
    
    <li>
      <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getNextPage() ?]" aria-label="[?php echo __('Next page', array(), 'sf_admin') ?]">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
    <li>
      <a href="[?php echo url_for('@<?php echo $this->getUrlForAction('list') ?>') ?]?page=[?php echo $pager->getLastPage() ?]" aria-label="[?php echo __('Last page', array(), 'sf_admin') ?]">
        <span aria-hidden="true">&raquo;&brvbar;</span>
      </a>
    </li>
  </ul>
</nav>