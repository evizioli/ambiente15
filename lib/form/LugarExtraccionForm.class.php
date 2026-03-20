<?php

/**
 * LugarExtraccion form.
 *
 * @package    ambiente
 * @subpackage form
 * @author     Your name here
 */
class LugarExtraccionForm extends BaseLugarExtraccionForm
{

    public function configure()
    {
        $this->widgetSchema['localidad_id']->setOption('add_empty', true);
        $this->widgetSchema['localidad_id']->setAttribute('class', 's2');
        $this->widgetSchema['localidad_id']->setOption('order_by', array('Nombre','asc'));

        $this->widgetSchema['lugar_uso_list']->setOption('order_by', array('Nombre','asc'));
        $this->widgetSchema['lugar_uso_list']->setOption('expanded', true);
  
        $this->widgetSchema['the_geom'] = new MapaWidget(array(
            'height' => '600px'
        ));
        $this->widgetSchema['tipo_id']->setOption('order_by', array('Nombre','asc'));

        $this->widgetSchema->setLabel('the_geom', 'Ubicación');
    }

    public function updateTheGeomColumn($v)
    {
        if (empty($v)) {
            $this->getObject()->setTheGeom(null);
            return $v;
        }
        $r = null;
        try {
            $connection = Propel::getConnection();
            $statement = $connection->prepare('select St_GeomFromText( ? ,3857)  AS latlon ');
            $statement->bindValue(1, $v);
            $statement->execute();
            $resultset = $statement->fetch(PDO::FETCH_OBJ);
            $r = $resultset->latlon;
        } catch (Exception $e) {
            throw $e;
        }

        $this->getObject()->setTheGeom($r);

        return $v;
    }
}
