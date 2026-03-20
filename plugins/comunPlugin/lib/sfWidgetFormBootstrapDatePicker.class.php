<?php 

class sfWidgetFormBootstrapDatePicker extends sfWidgetForm
{
	protected function configure($options = array(), $attributes = array()) {
		$this->addOption('useCurrent', 'false');
		$this->addOption('include_date', true);
		$this->addOption('include_time', false);
		$this->addOption('date_widget', new sfWidgetFormInput());
		$this->addOption('config', '{}');
		$this->addOption('on', array());
		parent::configure($options, $attributes);
	}
	
	public function render($name, $value = null, $attributes = array(), $errors = array()) {
		$includeDate = $this->getOption('include_date');
		$includeTime = $this->getOption('include_time');
		$dateWidget = $this->getOption('date_widget');
		if ($dateWidget instanceof sfWidgetFormInput) {
			$attributes = array_merge(array('data-provide'=>'datepicker'),$attributes);
		}
	
		$id = $this->generateId($name);
	
		
		if(!is_null($value)) {
			if($includeDate && $includeTime) {
				if(preg_match('/(?P<year>[0-9]{4})[\-](?P<month>[0-9]{2})[\-](?P<day>[0-9]{2}) (?P<hour>[0-9]{2})\:(?P<minute>[0-9]{2})\:(?P<second>[0-9]{2})/',$value,$match)) {
						
					$value=sprintf('%02d/%02d/%04d %02d:%02d',$match['day'],$match['month'],$match['year'],$match['hour'],$match['minute']);
				}
			} elseif($includeTime) {
				if(preg_match('/(?P<hour>[0-9]{2})\:(?P<minute>[0-9]{2})\:(?P<second>[0-9]{2})/',$value,$match)) {
				
					$value=sprintf('%02d:%02d',$match['hour'],$match['minute']);
				}
			} else {
				if(preg_match('/(?P<year>[0-9]{4})[\-](?P<month>[0-9]{2})[\-](?P<day>[0-9]{2})/',$value,$match)) {
	
					$value=sprintf('%02d/%02d/%04d',$match['day'],$match['month'],$match['year']);
				}
			}
		}
//		$code = '<div style="position: relative">'.$dateWidget->render($name, $value, $attributes, $errors).'</div>';
		$code = $dateWidget->render($name, $value, $attributes, $errors);
		$aon=array();
		foreach($this->getOption('on') as $picker_event => $handler) $aon[]="$picker_event: '$handler'";
		$aon= '{'.join(', ',$aon).'}';
		return sprintf('%s
				<script> 
					var bsdtp_%s_config = Object.assign({ locale: "es", useCurrent: %s, format: "%s%s%s" },%s);
					var bsdtp_%s_on = %s ;
				</script>',
				$code,
				$id,
				$this->getOption('useCurrent'),
				$includeDate ? 'DD/MM/YYYY' : '',
				$includeDate && $includeTime ? ' ' : '',
				$includeTime ? 'HH:mm' : '',
				$this->getOption('config'),
				$id,
				$aon
				);
	}
	public function getJavascripts()
	{
		return array_merge(parent::getJavascripts(),array(
				'../comunPlugin/js/moment-with-locales.js',
				'../bootstrap/datetimepicker/build/js/bootstrap-datetimepicker.min.js',
				'../comunPlugin/js/BootstrapDatePicker.js'
				
		));
	}
	public function getStylesheets()
	{
		return array_merge(parent::getStylesheets(),array(
				'../bootstrap/datetimepicker/build/css/bootstrap-datetimepicker.min.css'=> 'screen',
				'../comunPlugin/css/datepicker.css'=> 'screen' 
		));
	}
}