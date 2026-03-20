<?php
class TreeWidget extends sfWidgetFormInput
{
	
	protected function configure($options = array(), $attributes = array())
	{
		$this->addRequiredOption('data');
	
		parent::configure($options, $attributes);
	}
	
	
	
	public function render($name, $value = null, $attributes = array(), $errors = array())
	{
		return $this->renderTag('input', array('type' => 'hidden', 'name' => $name, 'value' => $value)).
		sprintf(<<<EOF
				
				<div id="jstree_%s_div"></div>
<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery("#jstree_%s_div")
				.on('select_node.jstree', function (e, data) {
				    for(i = 0, j = data.selected.length; i < j; i++) {
				      jQuery('#%s').val(data.instance.get_node(data.selected[i]).id);
				    }
				  })
				.on('ready.jstree', function (e, data) {
					jQuery.jstree.reference('#'+e.target.id).select_node(%s);
				  })
				.jstree(%s);
  });
</script>
EOF
				,
				$this->generateId($name),
				$this->generateId($name),
				$this->generateId($name),
				//$this->generateId($name),
				$value,
				$this->getOption('data')
		);
	}
	
	public function getStylesheets()
	{
		return array('/jquery/jstree/themes/default/style.min.css' => 'all');
	}
	
	public function getJavascripts()
	{
		return array('/jquery/jstree/jstree.min.js');
	}
}