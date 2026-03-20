<?php
class importarKmlAction extends   sfAction {
    
    public function execute( $request) {

        $connection = Propel::getConnection();
        $q="
            insert into kml(nombre,descripcion,the_geom, tipo)
            values ( '%s', %s, ST_Transform( ST_GeomFromKML( '%s' ),'EPSG:4326','EPSG:3857'), %s )
        ";
//         $q="
//             insert into kml(nombre,descripcion,the_geom, tipo)
//             values ( '%s', %s, ST_Transform(St_GeomFromText( 'geometrycollection(point(%s %s))' ,4326),'EPSG:4326','EPSG:3857'), %s )
//         ";
        
        $kml = simplexml_load_file( '/home/enrique/git/ambiente/data/Ejidos_urbanos.kml' );

        foreach($kml->Document as $que){
            foreach($que as $type=>$folder){
                if($folder->name=='Ejidos_urbanos' && $type=='Folder'){
                    foreach ($folder->Placemark as  $ps){
                        
//                         print_r($ps);
//                         echo '<hr>';
//                         print_r($ps->ExtendedData->SchemaData->SimpleData[0].'');
//                          die();

                        $nombre= $ps->ExtendedData->SchemaData->SimpleData[0];
                        $descr="NULL";
//                         $descr="'".$ps->ExtendedData->SchemaData->SimpleData[0]."'";
                        
                        
//                         print_r($nombre);
//                         echo '<hr>';
//                         print_r($descr);
//                         die();
                        
                        
                        
                        if(isset($ps->Polygon)){
                            $aux=$ps->Polygon->outerBoundaryIs->LinearRing->coordinates;
                            $aux=str_ireplace(',0', '', $aux);
                            $aux=sprintf( '<Polygon><outerBoundaryIs><LinearRing><coordinates>%s</coordinates></LinearRing></outerBoundaryIs></Polygon>',$aux);
                        } elseif (isset($ps->MultiGeometry)){
                            $aux='<MultiGeometry>';
                            foreach ($ps->MultiGeometry->Polygon as $po){
                                $aux.=sprintf( '<Polygon><outerBoundaryIs><LinearRing><coordinates>%s</coordinates></LinearRing></outerBoundaryIs></Polygon>', $po->outerBoundaryIs->LinearRing->coordinates );
//                             foreach ($ps->MultiGeometry as $po){
//                                 if(count($po)>1){
//                                     foreach ($po as $po2){
//                                         $aux.=sprintf( '<LineString><coordinates>%s</coordinates></LineString>', $po2->coordinates );
//                                     }
//                                 } else {
//                                     $aux.=sprintf( '<LineString><coordinates>%s</coordinates></LineString>', $po->LineString->coordinates );
//                                 }
                            }
                            
                            
                            $aux.='</MultiGeometry>';


                        } else {
                            die('?????');
                        }
                        $connection->exec(sprintf($q,$nombre, $descr, $aux, KmlPeer::TIPO_EJIDOS_URBANOS));

                        
//                         list($lon,$lat)=explode(',',$ps->Point->coordinates->__toString());
//                         $connection->exec(sprintf($q,$nombre, $descr, $lon, $lat,KmlPeer::TIPO_PARCELARIO_RURAL));
                        
                    }
                }
            }
        }
        die('ok');
    }
}