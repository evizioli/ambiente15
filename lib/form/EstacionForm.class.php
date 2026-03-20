<?php

/**
 * Estacion form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class EstacionForm extends BaseEstacionForm
{
    public function configure()
    {
        
        $this->widgetSchema ['the_geom'] = new MapaWidget ( array (
            'height' => '600px'
        ) );
        $this->widgetSchema->setLabel('the_geom','Ubicación');
        
    }
    public function updateTheGeomColumn($v) {
        if (empty ( $v )) {
            $this->getObject ()->setTheGeom ( null );
            return $v;
        }
        $r = null;
        try {
            $connection = Propel::getConnection ();
            $statement = $connection->prepare ( 'select St_GeomFromText( ? ,3857)  AS latlon ' );
            $statement->bindValue ( 1, $v );
            $statement->execute ();
            $resultset = $statement->fetch ( PDO::FETCH_OBJ );
            $r = $resultset->latlon;
        } catch ( Exception $e ) {
            throw $e;
        }
        
        $this->getObject ()->setTheGeom ( $r );
        
        return $v;
    }
}
