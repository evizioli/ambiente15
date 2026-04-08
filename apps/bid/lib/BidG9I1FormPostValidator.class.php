<?php
class BidG9I1FormPostValidator extends sfValidatorSchema
{
    protected function doClean($values)
    {
        if($values['refugios'] && $values['puestas'] ){
            if($values['refugios'] < $values['puestas'])  throw  new sfValidatorError($this, 'La cantidad de refugios con puestas no puede ser mayor a la cantidad total de refugios');
        
        }
        return $values;
        
    }
        
}