<?php

/**
 * Project form base class.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
abstract class BaseFormPropel extends sfFormPropel
{
    public function setup()
    {
        unset($this['created_at'],$this['updated_at'],$this['created_by'],$this['updated_by']);
        
    }
    public function save($con = null)
    {
        
        try {
            if($this->getObject()->isNew()) $this->getObject()->setCreatedBy((integer)sfContext::getInstance()->getUser()->getId());
        } catch (Exception $e) {
        }
        
        try {
            $this->getObject()->setUpdatedBy((integer)sfContext::getInstance()->getUser()->getId());
        } catch (Exception $e) {
        }
        
        return parent::save($con);
    }
    
    public function updateObjectEmbeddedForms($values, $forms = null)
    {
        
        
        if (null === $forms)
        {
            $forms = $this->embeddedForms;
        }
        
        foreach ($forms as $name => $form)
        {
            if (!isset($values[$name]) || !is_array($values[$name]))
            {
                continue;
            }
            
            if ($form instanceof sfFormObject)
            {
                
                if(sfContext::getInstance()->getUser()->getId()) {
                    try {
                        if($form->getObject()->isNew()) $values[$name]['created_by'] =(integer)sfContext::getInstance()->getUser()->getId();
                    } catch (Exception $e) {
                    }
                    try {
                        $values[$name]['updated_by'] =(integer)sfContext::getInstance()->getUser()->getId();
                    } catch (Exception $e) {
                    }
                }
                $form->updateObject($values[$name]);
                
            }
            else
            {
                $this->updateObjectEmbeddedForms($values[$name], $form->getEmbeddedForms());
            }
        }
    }
    
    
    public function addOptionalForms($taintedValues = null)
    {
        
        
        foreach ($this->optionalForms as $name => $form) {
            $i = 1;
            if (strpos($name, '/') === false)
            {
                // The form must be added to the main form
                while (array_key_exists($name . $i, $taintedValues))
                {
                    $this->embedForm($name . $i, clone $form);
                    $this->getWidgetSchema()->moveField($name . $i, sfWidgetFormSchema::BEFORE, $name);
                    $i++;
                }
            }
            else
            {
                // The form must be added to an embedded form
                list($parent, $name) = explode('/', $name);
                
                if (!isset($taintedValues[$parent]))
                {
                    continue;
                }
                
                
                $taintedValuesCopy = $taintedValues[$parent];
                
                $target = $this->embeddedForms[$parent];
                //while (array_key_exists($name . $i, $taintedValuesCopy))
                foreach( array_keys($taintedValuesCopy) as $sub )
                {
                    if(substr($sub, 0,3)!='new'){
                        continue;
                    }
                    $target->embedForm($sub, clone $form);
                    $target->getWidgetSchema()->moveField($sub, sfWidgetFormSchema::BEFORE, $name);
                    $i++;
                    // the parent form schema is not updated when updating an embedded form
                    // so we must embed it again
                    $this->embedForm($parent, $target);
                }
            }
        }
    }
    
    
}
