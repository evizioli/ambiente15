<?php
class TheGeomValidator extends sfValidatorBase
{
    protected function doClean($value)
    {
        
        try {
            $connection = Propel::getConnection ();
            $statement = $connection->prepare ( 'select St_GeomFromText( ? ,3857)  AS latlon ' );
            $statement->bindValue ( 1, $value );
            $statement->execute ();
            $resultset = $statement->fetch ( PDO::FETCH_OBJ );
            $r = $resultset->latlon;
        } catch ( Exception $e ) {
            throw new sfValidatorError($this, 'invalid', array('value' => $value));
        }
        return $value;

        
    }
}