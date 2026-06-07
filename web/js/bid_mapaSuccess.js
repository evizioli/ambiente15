var anppv,pimcpa;
var sAnppv,sPimcpa;

const styles = [
  /* We are using two different styles for the polygons:
   *  - The first style is for the polygons themselves.
   *  - The second style is to draw the vertices of the polygons.
   *    In a custom `geometry` function the vertices of a polygon are
   *    returned as `MultiPoint` geometry, which will be used to render
   *    the style.
   */
  new  ol.style.Style({
    stroke: new ol.style.Stroke({
      color: 'blue',
      width: 3,
    }),
    fill: new  ol.style.Fill({
      color: 'rgba(0, 0, 255, 0.1)',
    }),
  }),
  new  ol.style.Style({
    image: new  ol.style.Circle({
      radius: 5,
      fill: new  ol.style.Fill({
        color: 'orange',
      }),
    }),
/*
        geometry: function (feature) {
      // return the coordinates of the first ring of the polygon
      const coordinates = feature.getGeometry().getCoordinates()[0];
      return new  ol.style.MultiPoint(coordinates);
    },
    */
  }),
];
const estiloTexto= function(feature){
  return   new ol.style.Text({ 
    offsetY: 3,

              font: '10px Calibri,sans-serif', 
              overflow:true,
              text: feature.get('name'),
              fill: new ol.style.Fill({
                    color: '#000',
                  }),
                  stroke: new ol.style.Stroke({
                    color: '#fff',
                    width: 4,
                  }) 
            });
};
const funPol =function(feature){ 
    return new ol.style.Style({
        stroke: new ol.style.Stroke({
          color: 'yellow',
          lineDash: [4],
          width: 3,
        }),
        fill: new ol.style.Fill({
          color: 'rgba(255, 255, 0, 0.1)',
        }),
        text: estiloTexto(feature) 
      });  
  };
const funPoint =function(feature){ 
    return   new ol.style.Style({
      image: image,
      text: estiloTexto(feature)
    });
    /*
    return  new ol.style.Style({
        stroke: new ol.style.Stroke({
          color: 'yellow',
          lineDash: [4],
          width: 3,
        }),
        fill: new ol.style.Fill({
          color: 'rgba(255, 255, 0, 0.1)',
        }),
        text: estiloTexto(feature) 
      });  
      */
  };

const image = new ol.style.Circle({
  radius: 5,
  fill: null,
  stroke: new ol.style.Stroke({color: 'red', width: 1}),
});

const styles2 = {
  'Point': funPoint,
  'LineString': new ol.style.Style({
    stroke: new ol.style.Stroke({
      color: 'green',
      width: 1,
    }),
  }),
  'MultiLineString': new ol.style.Style({
    stroke: new ol.style.Stroke({
      color: 'green',
      width: 1,
    }),
  }),
  'MultiPoint': new ol.style.Style({
    image: image,
  }),
  'MultiPolygon': new ol.style.Style({
    stroke: new ol.style.Stroke({
      color: 'yellow',
      width: 1,
    }),
    fill: new ol.style.Fill({
      color: 'rgba(255, 255, 0, 0.1)',
    }),
  }),
  'Polygon': funPol,
  'GeometryCollection': new ol.style.Style({
    stroke: new ol.style.Stroke({
      color: 'magenta',
      width: 2,
    }),
    fill: new ol.style.Fill({
      color: 'magenta',
    }),
    image: new ol.style.Circle({
      radius: 10,
      fill: null,
      stroke: new ol.style.Stroke({
        color: 'magenta',
      }),
    }),
  }),
  'Circle': new ol.style.Style({
    stroke: new ol.style.Stroke({
      color: 'red',
      width: 2,
    }),
    fill: new ol.style.Fill({
      color: 'rgba(255,0,0,0.2)',
    }),
  }),
};

const styleFunction = function (feature) {
//  return styles2[feature.getGeometry().getType()];
  const type = feature.getGeometry().getType();
    const estiloOFuncion = styles2[type];

    // Si lo que devuelve el diccionario es una función (como en el caso de Polygon)
    if (typeof estiloOFuncion === 'function') {
      return estiloOFuncion(feature); // La ejecutamos pasándole el feature actual
    }
    
    // Si es un estilo normal (Point, LineString, etc.), lo devolvemos directo
    return estiloOFuncion; 
};

$(document).ready(  function() {

  pimcpa  =   new ol.source.Vector({
    url: urltoKml+"?nombre=PIMCPA",
    format: new ol.format.KML( { extractStyles: false } ),
  });

  anppv=   new ol.source.Vector({
    url: urltoKml+"?nombre=ANPPV",
    format: new ol.format.KML( { extractStyles: false } ),
  });

  sPimcpa  =   new ol.source.Vector({
    url: urltoGml+"?area_protegida=PIMCPA",
    format: new ol.format.GeoJSON(  ),
  });

  sAnppv=   new ol.source.Vector({
    url: urltoGml+"?area_protegida=ANPPV",
    format: new ol.format.GeoJSON(  ),
  });

/*      
      anppv.on('featuresloadend', function() {
        map.getView().fit( anppv.getExtent(), { padding: [10, 10, 10, 10] });
      });
  */    
      anppv.on('addfeature', function(e) {
        mapANPPV.getView().fit( anppv.getExtent(), { padding: [10, 10, 10, 10] });
      });
      pimcpa.on('addfeature', function(e) {
        mapPIMCPA.getView().fit( pimcpa.getExtent(), { padding: [10, 10, 10, 10] });
      });
      
  mapPIMCPA = new ol.Map({
        target: 'PIMCPA',
        controls: ol.control.defaults({ attributionOptions: { collapsible: false } }),
        layers:   [
          new ol.layer.Tile({
               type: 'base',
               visible: true,
               title: 'Google Maps',
               source: new ol.source.XYZ({
                   url: 'https://mt0.google.com/vt/lyrs=s&hl=en&x={x}&y={y}&z={z}&s=Ga'
               })
          }),
          new ol.layer.Vector({
            type: 'base',
            visible: true,
            title: '',
            source: pimcpa,
            style: styles,
          }),
          new ol.layer.Vector({
              title: '',
              source: sPimcpa,                          
              style: styleFunction,
              visible: true
          })
          
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([-67.7, -44]),
          zoom: 6
        })
    });

      mapPIMCPA.on('singleclick', function (evt) {
        const coordinate = evt.coordinate;
        var mostrar='';
        tipos={};
        para_propietarios=[];
        $.each(this.getFeaturesAtPixel(evt.pixel,{ hitTolerance: 3 }), function(i,e){

          $.ajax({
            url: urltoData,
            dataType : "html",
            data: { 
              sitio_id: e.getId(), 
              area: "PIMCPA"
            },
            
          }).done(function( data, textStatus, jqXHR ) {
            $( "#data-pimcpa" ).html( data );
          });

        });
      });
      

    
    mapANPPV = new ol.Map({
            target: 'ANPPV',
            controls: ol.control.defaults({ attributionOptions: { collapsible: false } }),
            layers:   [
              new ol.layer.Tile({
                   type: 'base',
                   visible: true,
                   title: 'Google Maps',
                   source: new ol.source.XYZ({
                       url: 'https://mt0.google.com/vt/lyrs=s&hl=en&x={x}&y={y}&z={z}&s=Ga'
                   })
              }),
              new ol.layer.Vector({
                      type: 'base',
                      visible: true,
                      title: '',
                      source: anppv,
                      style: styles,
                    }),

              
              new ol.layer.Vector({
                title: '',
                source: sAnppv                ,                          
                style: styleFunction,                         
                visible: true
              })
              
            ],
            view: new ol.View({
              center: ol.proj.fromLonLat([-67.7, -44]),
              zoom: 6
            })
        });
});

