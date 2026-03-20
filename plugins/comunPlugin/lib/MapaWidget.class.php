<?php

class MapaWidget extends sfWidgetForm
{

    public function __construct($options = array(), $attributes = array())
    {
        $this->addOption('height', '300px');
        $this->addOption('width', '100%');

        parent::__construct($options, $attributes);
    }

    public function getJavascripts()
    {
        return array(
//             'patch_scroll_openlayers.js',
//             '../OpenLayers/OpenLayers.min.js',
//             '../comunPlugin/js/proj4.js',
                '../ol/ol.js',
             '../comunPlugin/js/MapaWidget.js'
        );
    }

    public function getStylesheets()
    {
        return array(
            '../ol/ol.css' => 'screen',
            '../comunPlugin/css/MapaWidget.css' => 'screen'
        );
    }

    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        if ($value) {
            $value = Dummy::geomToWkt($value);
            list ($lat, $lon) = Dummy::getLatLon(Dummy::getCentroid($value));
            $lvalue = Dummy::aGMS($lat, $lon);
        } else {
            $lvalue=null;
        }
        $h = new sfWidgetFormInputHidden();
        $o = $this->getOptions();
        unset($o['height'], $o['width']);
        $l = new sfWidgetFormInputText($o, array_merge($attributes, array(
            'onchange' => 'especificar()'
        )));
        return '
  		<script type="text/javascript">
  			var marker_png = "' . image_path('marker') . '";
  		</script>
		<div id="div_mapa_' . $h->generateId($name) . '" class="mapa" style="width: ' . $this->getOption('width') . '; height: ' . $this->getOption('height') . '">
		</div>
				<div style="width: ' . $this->getOption('width') . 'px">&nbsp;
			         <div class="coordexterne"  id="pos_mapa_' . $h->generateId($name) . '" ></div>		
				</div>
		<ul id="controlToggle">
			<li><input type="radio" name="type['.$h->generateId($name) .']" value="None" id="noneToggle_' . $h->generateId($name) . '"  onclick="toggleControl(this,\'div_mapa_' . $h->generateId($name) . '\');" checked="checked" /><label for="noneToggle_' . $h->generateId($name) . '">Navegar</label></li>
			<li><input type="radio" name="type['.$h->generateId($name) .']" value="Point" id="pointToggle_' . $h->generateId($name) . '" onclick="toggleControl(this,\'div_mapa_' . $h->generateId($name) . '\');" /><label for="pointToggle_' . $h->generateId($name) . '">Dibujar punto</label></li>
			<li><input type="radio" name="type['.$h->generateId($name) .']" value="LineString" id="lineToggle_' . $h->generateId($name) . '" onclick="toggleControl(this,\'div_mapa_' . $h->generateId($name) . '\');" /><label for="lineToggle_' . $h->generateId($name) . '">Dibujar l&iacute;nea</label></li>
			<li><input type="radio" name="type['.$h->generateId($name) .']" value="Polygon" id="polygonToggle_' . $h->generateId($name) . '" onclick="toggleControl(this,\'div_mapa_' . $h->generateId($name) . '\');" /><label for="polygonToggle_' . $h->generateId($name) . '">Dibujar pol&iacute;gono</label></li>
			<li><input type="radio" name="type['.$h->generateId($name) .']" value="Circle" id="circleToggle_' . $h->generateId($name) . '" onclick="toggleControl(this,\'div_mapa_' . $h->generateId($name) . '\');" /><label for="circleToggle_' . $h->generateId($name) . '">Dibujar c&iacute;rculo</label></li>
			<li><input type="radio" name="type['.$h->generateId($name) .']" value="Modify" id="modifyToggle_' . $h->generateId($name) . '" onclick="toggleControl(this,\'div_mapa_' . $h->generateId($name) . '\');" /><label for="modifyToggle_' . $h->generateId($name) . '">Modificar</label></li>
			<li><a onclick="borrar(\'' . $h->generateId($name) . '\')" id="borrar_' . $h->generateId($name) . '" >Borrar</a></li>
		</ul>
		' . $l->render('literal_' . $name, $lvalue) . $h->render($name, $value);
    }
}