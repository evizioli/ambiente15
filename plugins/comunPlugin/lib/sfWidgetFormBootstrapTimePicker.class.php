<?php 

class sfWidgetFormBootstrapTimePicker extends sfWidgetFormBootstrapDatePicker
{
	protected function configure($options = array(), $attributes = array()) {
		parent::configure($options, $attributes);
		$this->addOption('include_time', true);
		$this->addOption('include_date', false);
		
	}
}