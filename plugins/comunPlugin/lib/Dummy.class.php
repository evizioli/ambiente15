<?php
class Dummy
{
    public static $sexos=array(
        'm'=>'macho',    
        'h'=>'hembra'
    );
    
    public static function objetoAjson(Object $o)
    {
        return str_ireplace("'", "",  var_export( json_encode( $o ),true));
    }

	public static function aGMS($lat,$lon,$decimales=1)
	{
	
		$tmp =abs($lat);
		$g = intval($tmp);
		$tmp = ($tmp-$g)*60;
		$m = intval($tmp);
		$s = ($tmp-$m)*60;
			
		$r = ($lat<0 ? 'S ' : 'N ').$g.'° '.$m."' ".round($s,$decimales).'" - ';
	
		$tmp =abs($lon);
		$g = intval($tmp);
		$tmp = ($tmp-$g)*60;
		$m = intval($tmp);
		$s = ($tmp-$m)*60;
	
		return $r .($lon<0 ? 'O ' : 'E '). $g.'° '.$m."' ".round($s,$decimales).'"';
	
	}
	
	
	public static function getLatLon($geom, $de_srid='EPSG:3857', $a_srid='EPSG:4326')
	{
	    
	    if( !is_null($geom)) {
	        $connection = Propel::getConnection();
	        
	        $statement = $connection->prepare(
	            
	            "SELECT
                        ST_Y(ST_Transform(ST_Centroid('$geom'), '$de_srid', '$a_srid')) lon,
                        ST_X(ST_Transform(ST_Centroid('$geom'), '$de_srid', '$a_srid')) lat
                    "
	            );
	        $statement->execute();
	        return $statement->fetch(PDO::FETCH_BOTH);
	    }
	}
	
	public static function getCentroid($geom)
	{
		if( is_null($geom)) return null;
		/*
		 SELECT AsText(centroid(
    		 IF(
        		 GEOMETRYTYPE(@gc) =  'GEOMETRYCOLLECTION',
        		 GEOMETRYN(  @gc , 1 ) ,
        		 @gc
    		 )
		 ));
		 */
		$connection = Propel::getConnection();
	
		$statement = $connection->prepare(
// 			'SELECT
// 				ST_AsText(
// 				GeomFromText(
// 				ST_AsText(
// 				centroid( IF( GEOMETRYTYPE(:geom) =  "GEOMETRYCOLLECTION", GEOMETRYN(  :geom , 1 ), :geom ) )
// 				)
// 				,4326)
// 				)
// 				centro'

// 				"SELECT ST_AsText(
// 					ST_GeomFromText(
// 						ST_AsText(
// 							ST_Centroid( 
// 								CASE WHEN  
// 								ST_GeometryType(:geom) =  'ST_MultiPoint' THEN
// 								ST_GeometryN(  :geom , 1 ) ELSE
// 								:geom
// 								END 
// 							)
// 						)
// 					,4326)
// 				) centro"
				
// 				"SELECT ST_AsText(
// 					ST_GeomFromText(
// 						ST_AsText(
// 							ST_Centroid('$geom')
// 						)	
// 					,4326)
// 				) centro"
				
				"SELECT 
						ST_AsText(
							ST_Centroid('$geom')
						) centro"
				
				);
		$statement->execute();
		$resultset = $statement->fetch(PDO::FETCH_OBJ);
		return  $resultset->centro;
	
	
	}
	public static function geomToWkt($geom)
	{
		$r=null;
		if( !is_null($geom)) {
			try{
		
				$connection = Propel::getConnection();
	//			$statement = $connection->prepare('SELECT AsText( ? ) AS latlon ');
				//$statement = $connection->prepare('SELECT ST_AsText( ? ) AS latlon ');
				//$statement->bindValue(1, $geom );
				
				$statement = $connection->prepare("SELECT ST_AsText( '$geom' ) AS latlon ");
				
				$statement->execute();
				$resultset = $statement->fetch(PDO::FETCH_OBJ);
				$r = $resultset->latlon;
			} catch(Exception $e){
				throw $e;
			}
		}
		return $r;
	}
	
	public static function esPunto($validator, $value, $args)
	{
        $connection = Propel::getConnection();
        $statement = $connection->prepare("SELECT ST_GeometryType(ST_GeomFromText('$value')) = 'ST_Point' AS is_point;");
        $statement->execute();
        $resultset = $statement->fetch(PDO::FETCH_OBJ);
        $r = $resultset->is_point;
	    if($r) return $value;
	    throw new sfValidatorError($validator, 'Debe marcar un punto',$args);
	}
	
	public static function random( $length, $solo_numeros=FALSE )
	{
		$chars = '0123456789'. ($solo_numeros ? '': 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
		$str='';
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
	
		return $str;
	}
	
	
	
	public static function ordenar($a,$b)
	{
		return count($a['vi'])-count($b['vi']);
	}
	
	public static function addTime($time, $p, $i=0)
	{
		$f = new DateTime($time);
		$di=new DateInterval($p);
		$di->invert=$i;
		$f->add($di);
		return $f->format('Y-m-d');
	}
	
	public static function difDias($desde,$hasta, $format='%R%a')
	{
		$datetime1 = new DateTime($desde);
		$datetime2 = new DateTime($hasta);
		$interval = $datetime1->diff($datetime2);
		return $interval->format($format);
	}
	
	public static function es_cuit($strCuit)
	{

		$intBase=array();
		$intNumero=array();
		$intCalculo=0;
		$x = 5;
		for($i=0;$i<=3;$i++) $intBase[$i] = $x--;

		$x = 7;
		for($i=4;$i<=9;$i++) $intBase[$i] = $x--;

		if(strpos($strCuit,' ')==0) {
			if(strlen($strCuit)==11) {
				for($i=0;$i<=1;$i++) {
					$intNumero[$i] = substr($strCuit, $i , 1);
					$intCalculo = $intCalculo + ($intNumero[$i] * $intBase[$i]);
				}
				for($i=2;$i<=9;$i++) {
					$intNumero[$i] = substr($strCuit, $i, 1);
					$intCalculo = $intCalculo + ($intNumero[$i] * $intBase[$i]);
				}
				$intCalculo = 11 - ($intCalculo - (intval($intCalculo / 11) * 11));
				switch($intCalculo) {
					Case 11:
						$intCalculo = 0;
						break;
					Case 10:
						$intCalculo = 9;
						break;
				}
				return  $intCalculo == substr($strCuit, 10, 1);
			}
		}
		return false;
		
	}
}