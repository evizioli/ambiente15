var anppv,pimcpa;

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

$(document).ready(  function() {

      pimcpa  =   new ol.source.Vector({
        url: urltoanppv+"?nombre=PIMCPA",
        format: new ol.format.KML( { extractStyles: false } ),
      });

      anppv=   new ol.source.Vector({
        url: urltoanppv+"?nombre=ANPPV",
        format: new ol.format.KML( { extractStyles: false } ),
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
      
    source2=  new ol.source.Vector({
    format: new ol.format.GML(),
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

          
                          /*  
          new ol.layer.Vector({
                          title: '',
                          source: source2,
                          style: function(feature ){
                              
                              let size = feature.get('features').length;
                  
                              return new ol.style.Style({
                                  image:  new ol.style.Icon({
              //                                size: [36,30],
                                              scale:  (1+size/100)*0.4,
                          //                    crossOrigin: 'anonymous',
//                                              src: urltofepng.replace('*','le')
                                              src: urltofepng
                                          }),
                                  text: new ol.style.Text({ text: size>1? size.toString():'' })
                              });
                          }
                      })
                          */
          
        ],
        view: new ol.View({
          center: ol.proj.fromLonLat([-67.7, -44]),
          zoom: 6
        })
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

              
                              /*  
              new ol.layer.Vector({
                              title: '',
                              source: source2,
                              style: function(feature ){
                                  
                                  let size = feature.get('features').length;
                      
                                  return new ol.style.Style({
                                      image:  new ol.style.Icon({
                  //                                size: [36,30],
                                                  scale:  (1+size/100)*0.4,
                              //                    crossOrigin: 'anonymous',
    //                                              src: urltofepng.replace('*','le')
                                                  src: urltofepng
                                              }),
                                      text: new ol.style.Text({ text: size>1? size.toString():'' })
                                  });
                              }
                          })
                              */
              
            ],
            view: new ol.View({
              center: ol.proj.fromLonLat([-67.7, -44]),
              zoom: 6
            })
        });
});

