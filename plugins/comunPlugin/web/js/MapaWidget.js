var mapas=[], vector=[], draw=[], controls=[]; 
var wkt = new ol.format.WKT();

const styles = {
   Point:   new ol.style.Style({
    image: new ol.style.Icon({
                                src: marker_png
                            })

           }),
   LineString:    new ol.style.Style({
           
             stroke: new ol.style.Stroke({
               color: '#FFF',
             })
         }),
   Polygon:         new ol.style.Style({
                    fill: new ol.style.Fill({
                        color: [255,255,255,.3]
                    }),
                    stroke: new ol.style.Stroke({
                      color: '#ffcc33',
                      width: 2,
                    })
                }),
   Circle: new ol.style.Style({
        image: new ol.style.Circle({
          radius: 5,
          stroke: new ol.style.Stroke({
            color: '#FF0',
          }),
          fill: new ol.style.Fill({
            color: [255,255,0,0.4],
          }),
        })
      })
 };


const raster = new ol.layer.Tile({
       type: 'base',
       visible: true,
       title: 'Google Maps',
       source: new ol.source.XYZ({
           url: 'http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}&s=Ga'
       })
   });

$(document).ready(function() {
	$("div.mapa").each(function(i){
	
    vector[this.id] = new ol.source.Vector();

    mapas[this.id] = new ol.Map({
        target: this.id,
        controls: ol.control.defaults({ attributionOptions: { collapsible: false } }).extend([        new ol.control.MousePosition({
          coordinateFormat: ol.coordinate.createStringXY(2),
          projection: 'EPSG:4326',
          // comment the following two lines to have the mouse position
          // be placed within the map.
          className: 'coordexterne',
          target: document.getElementById('pos_mapa_'+this.id.substring(9)),
        })]),
        layers:  [ 
          raster, 
          new ol.layer.Vector({
                title: 'Marcado',
                source: vector[this.id],
                style: new ol.style.Style({
                    fill: new ol.style.Fill({
                      color: 'rgba(255, 255, 255, .3)',
                    }),
                    stroke: new ol.style.Stroke({
                      color: '#ffcc33',
                      width: 2,
                    }),
                    image: new ol.style.Icon({
                        src: marker_png
                    })
                    
                    ,
                  }),
              })
           
        ],
        view: new ol.View({
              center: ol.proj.fromLonLat([-67.8, -44]),
              zoom: 6.9,
              maxZoom:22
          }),
    });
    


		if($("#"+this.id.substring(9)).val()!='') {

			vector[this.id].addFeatures([ wkt.readFeature($("#"+this.id.substring(9)).val()) ]);
			mapas[this.id].getView().fit(vector[this.id].getExtent());
		}

    vector[this.id].on("addfeature", function(e) {
      let dis=this;
      for(i in vector){
        if(dis===vector[i]){
          $("#"+i.substring(9)).val(wkt.writeFeaturesText(dis.getFeatures()));
          break;;
        }
      }
      return true;
    });
        
    vector[this.id].on("changefeature", function(e) {
      let dis=this;
      for(i in vector){
        if(dis===vector[i]){
          $("#"+i.substring(9)).val(wkt.writeFeaturesText(dis.getFeatures()));
          break;;
        }
      }
      return true;
    });

	});

});
function toggleControl(element,id) {
     mapas[id].removeInteraction(draw[id]);
    
    switch(event.target.value){
      case 'None':
        break;

      case 'Modify':
        draw[id]=new ol.interaction.Modify({ source: vector[id] });
        mapas[id].addInteraction(draw[id]);
        break;
      default:
        draw[id] = new ol.interaction.Draw({
          source: vector[id],
          type: event.target.value,
          style: styles[event.target.value],
        });
        mapas[id].addInteraction(draw[id]);

    }
}

function borrar(id) {
  vector['div_mapa_'+id].clear();
  $("#"+id).val(''); 
}

function aGMS(ll) { 
	tmp =Math.abs(ll.lat);
	g = parseInt(tmp);
	tmp =(tmp-g)*60;
	m = parseInt(tmp);
	s = (tmp-m)*60;
	r= (ll.lat <0? 'S ':'N ')+ g+'° '+m+ "' "+ s.toFixed(1) + '" - ';
	
	tmp =Math.abs(ll.lon);
	g = parseInt(tmp);
	tmp =(tmp-g)*60;
	m = parseInt(tmp);
	s = (tmp-m)*60;
	
	return r  +(ll.lon <0? 'O ': 'E ')+ g+'° '+m+ "' " +s.toFixed(1)+ '"';
}

function especificar(){
	var re=/(N|W|O|S|E)\s+(\d+)\s?°\s?(\d+)\s?('{1}|’{1}|´{1})\s?(\d+\.?\,?\d*?)("|'{2}|’{2}|´{2})/gmi;
	var coincidencias = Array.from(event.target.value.matchAll(re));
	lat=null;
	lon=null;
	if(coincidencias.length==2){
		for(i in coincidencias){
			v= (parseInt(coincidencias[i][2])+(parseInt(coincidencias[i][3])/60)+(parseFloat(coincidencias[i][5])/3600));
			switch(String(coincidencias[i][1]).toUpperCase()){
				case 'S':
					lat=v*-1;
					break;
				case 'N':
					lat=v;
					break;
				case 'O':
				case 'W':
					lon= v*-1;
					break;
				case 'E':
					lon= v;
					break;
			}
		}
		if(lat && lon){
			id= event.target.id.replace('literal_','div_mapa_');
			ll=ol.proj.transform([lon, lat], 'EPSG:4326', mapas[id].getView().getProjection());
			
      vector[id].addFeatures([ wkt.readFeature('POINT( '+ll.join(' ')+' )') ]);
      mapas[id].getView().fit(vector[id].getExtent(),{ maxZoom:22 });
		}
		
	}
}
