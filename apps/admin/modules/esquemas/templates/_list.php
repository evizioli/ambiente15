<?php
include_component('principal', 'esquemaStylesheets');
?>
<div class="bs_admin_list">
  <?php if (count($pager)): ?>
    	<div id="tree">
    	</div>    
    
  <?php else: ?>
    <p style="font-size: large;"><?php echo __('No result', array(), 'sf_admin') ?></p>
  <?php endif; ?>
</div>
<script type="text/javascript">
/* <![CDATA[ */

var data=<?php echo json_encode( $pager->getRawValue()) ?>;
	
	
/* ]]> */
</script>
