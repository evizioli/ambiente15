<style><?php 
    foreach ($esquemas as $e) {
        list($width, $height, $type, $attr) = getimagesize(sfConfig::get('sf_web_dir').'/'.ProjectConfiguration::DIRECTORIO_ESQUEMA.'/'.$e->getArchivo());
        echo sprintf(".esquema-%d { background-image: url(%s); width: %dpx !important; height: %dpx !important; }\n", $e->getId(),image_path('esquema/'.$e->getArchivo()), $width, $height);
    }
?></style>