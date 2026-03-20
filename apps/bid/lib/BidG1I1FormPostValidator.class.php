<?php
class BidG1I1FormPostValidator extends sfValidatorSchema
{
    protected function doClean($values)
    {
        if($values['sitio_id'] && $values['ubicacion'] ){

            $s= BidSitioQuery::create()->findPk($values['sitio_id']);
        
            
            $connection = Propel::getConnection();
            $statement = $connection->prepare("SELECT ST_Contains(the_geom, ST_GeomFromText('".$values['ubicacion']."')) c from bid_sitio where id=".$values['sitio_id']);
            $statement->execute();
            $resultset = $statement->fetch(PDO::FETCH_OBJ);
            $r = $resultset->c;
            if(!$r)  throw  new sfValidatorError($this, 'El punto marcado no está dentro del sitio seleccionado');
        
        }
        return $values;
        
    }
        
}