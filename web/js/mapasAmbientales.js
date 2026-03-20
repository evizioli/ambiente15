//var fo={ extractStyles: false, extractAttributes: true };
//const re = /.*\=(.*)/;
var map, view, sidebar;
var layers= {};
var layers_girsu= [];
var layers_tratamiento= [];
var layers_kml= [];
var layers_mineria ;
var layers_local= [];
var attributions={

    'estacion': 'SRyCA-MAyCDS',
    'parque_eolico': 'DGEA-MAyCDS',
    'didymosphenia_geminata': 'DGEA-MAyCDS',
    'ANP': 'MTyAP',
    'OTBN': 'Secret. Bosques (<a href="https://www.argentina.gob.ar/justicia/derechofacil/leysimple/bosques" target="_blank">Ley 26331</a>)',
    'pa': 'DEyCA-MAyCDS',
    'le': 'DRySIA-MAyCDS',
    'canal':'Compañia de Riego V.I.R.Ch.',
    
    'girsu_bca':'UTP-GIRSU-MAyCDS', 
    'girsu_bca_saneado':'UTP-GIRSU-MAyCDS', 
    'girsu_pst':'UTP-GIRSU-MAyCDS', 
    'girsu_rs':'UTP-GIRSU-MAyCDS',

    'tratamiento_barro_activado':'SRyCA-MAyCDS', 
    'tratamiento_descarga':'SRyCA-MAyCDS', 
    'tratamiento_humedal':'SRyCA-MAyCDS', 
    'tratamiento_laguna_aireada':'SRyCA-MAyCDS', 
    'tratamiento_laguna_estabilizacion':'SRyCA-MAyCDS', 
    'tratamiento_sistema_anaerobico':'SRyCA-MAyCDS',
    
    'mineria_13':'DGEA-MAyCDS',
    'mineria_1':'DGEA-MAyCDS',
    'mineria_2':'DGEA-MAyCDS',
    'mineria_3':'DGEA-MAyCDS',
    'mineria_4':'DGEA-MAyCDS',
    'mineria_5':'DGEA-MAyCDS',
    'mineria_6':'DGEA-MAyCDS',
    'mineria_7':'DGEA-MAyCDS',
    'mineria_8':'DGEA-MAyCDS',
    'mineria_9':'DGEA-MAyCDS',
    'mineria_10':'DGEA-MAyCDS',
    'mineria_11':'DGEA-MAyCDS',
    'mineria_12':'DGEA-MAyCDS',
    
    'kml1':'Ministerio de Educación',
    'kml2':'MIEyP',
    'kml3':'MIEyP',
    'kml4':'MIEyP',
    'kml5':'MIEyP',
    'kml6':'MIEyP',
    'kml7':'MIEyP',
//    'kml8':'MIEyP',
//    'kml9':'MIEyP',
    'kml10':'MIEyP',
    'kml11':'MIEyP',
    'kml12':'MIEyP',
    'kml13':'MIEyP',
    'kml14':'MIEyP',
    'kml15':'MIEyP',
    'kml16':'MIEyP',
    'kml17':'MIEyP',
    
    'local_1':'MIEyP',
    'local_2':'MIEyP',
    'local_3':'MIEyP',
    'local_4':'MIEyP',
    'local_5':'MIEyP',
};


var layer_names={

    'estacion': 'Estaciones de Servicio',
    'parque_eolico': 'Parques eólicos',
    'didymosphenia_geminata': 'Monitoreo de Didymosphenia Geminata',
    'ANP': 'Áreas Naturales Protegidas',
    'OTBN': 'Bosques',
    'pa': 'Promotores ambientales',
    'le': 'Sitios de toma de muestras',
    'canal':'Canales de riego V.I.R.Ch.',

    'girsu_bca':'Basural a cielo abierto', 
    'girsu_bca_saneado':'Basural saneado', 
    'girsu_pst':'Planta de separación y transferencia', 
    'girsu_rs':'Relleno sanitario',

    'tratamiento_barro_activado':'Barro activado', 
    'tratamiento_descarga':'Descarga', 
    'tratamiento_humedal':'Humedal / Filtro fitoterrestre', 
    'tratamiento_laguna_aireada':'Laguna aireada mecánicamente', 
    'tratamiento_laguna_estabilizacion':'Laguna de estabilización', 
    'tratamiento_sistema_anaerobico':'Sistema anaeróbico',
    
    'mineria_13':'Minería Categoría I, Exploración Vigentes',
    'mineria_1':'Minería Categoría I, Exploración Vencidos',
    'mineria_2':'Minería Categoría I, Explotación Vigentes',
    'mineria_3':'Minería Categoría I, Explotación Vencidos',
    'mineria_4':'Minería Categoría II, Explotación Vigentes',
    'mineria_5':'Minería Categoría II, Explotación Vencidos',
    'mineria_6':'Minería Categoría III, Áridos Vigentes',
    'mineria_7':'Minería Categoría III, Áridos Vencidos',
    'mineria_8':'Minería Categoría III, Pórfidos Vigentes',
    'mineria_9':'Minería Categoría III, Pórfidos Vencidos',
    'mineria_10':'Minería Categoría III, Calizas Vigentes',
    'mineria_11':'Minería Categoría III, Calizas Vencidos',
    'mineria_12':'Minería Categoría III, Bancos en Río',
    
    'kml1':'Escuelas',
    'kml2':'Cuencas hidrográficas',
    'kml3':'Subcuencas',
    'kml4':'Cuerpos de agua',
    'kml5':'Cobertura de suelos',
    'kml6':'Aeropuertos',
    'kml7':'Puertos',
//    'kml8':'Aldeas escolares y parajes',
 //   'kml9':'Localidades',
    'kml10':'Estancias',
    'kml11':'Establecimientos rurales',
    'kml12':'Generadores eléctricos',
    'kml13':'Parcelario rural',
    'kml14':'Departamentos de Chubut',
    'kml15':'Rutas nacionales',
    'kml16':'Rutas provinciales',
    'kml17':'Ejidos urbanos',
    
    'kml19':'Estaciones reguladoras de gas',
    'kml20':'Cañerías de gas de Transportadora Gas del Sur',
    'kml21':'Cañerías de gas de alta presión',
    
    'local_1':'Municipios de 1ra cat.',
    'local_2':'Municipios de 2da cat.',
    'local_3':'Comunas rurales',
    'local_4':'Aldeas escolares',
    'local_5':'Parajes',
};


function initMap() {}


function recu(layers){
    var r=[];
    layers.forEach(function(l ){ 
        if( l instanceof ol.layer.Image && l.getVisible() ){
            r.push(l.values_.source.params_.LAYERS);
        } else if(l instanceof ol.layer.Group){
            r=r.concat( recu(l.values_.layers));
        }
    });
    return r;
}


$(document).ready(  function() {
    layers_mineria =[];
    
    ol.inherits = function inherits(childCtor, parentCtor) {
      childCtor.prototype = Object.create(parentCtor.prototype);
      childCtor.prototype.constructor = childCtor;
    };

    var areas=['kml2','kml3','kml4','kml5','kml13','kml14','kml15','kml16','kml17','kml20','kml21','ANP','OTBN','didymosphenia_geminata','parque_eolico', 'estacion','canal'];
    let l;
    for( x in layer_names){
        if(areas.indexOf(x)>=0){
            l= new ol.layer.Image({
                    title: layer_names[x],
                    visible: false,
                    source: new ol.source.ImageWMS({
                        url: urltowms,
                        params: {'LAYERS': 'ambiente:'+x },
                        serverType: 'geoserver',
                        attributions: ['Fuente: '+attributions[x]+' - ']
                    })
                }); 
            
        } else {
            l= new ol.layer.Vector({
                title: layer_names[x],
                visible: false,
                source: new ol.source.Cluster({  
                    distance: 50,
                    source: new ol.source.Vector({
                        url: urltoows+'?service=WFS&version=1.0.0&request=GetFeature&typeName=ambiente:'+x+'&maxFeatures=10000000',
                        format: new ol.format.GML(),
                        attributions: ['Fuente: '+attributions[x]+' - ']
                    })
                }),  
                style: function(feature, resolution){
                    
                    let size = feature.get('features').length;
        
                    return new ol.style.Style({
                        image:  new ol.style.Icon({
    //                                size: [36,30],
                                    scale:  (1+size/100)*0.8,
                //                    crossOrigin: 'anonymous',
                                    src: urltofepng.replace('*',feature.get('features')[0].id_.substring(0,feature.get('features')[0].id_.indexOf('.')))
                                }),
                        text: new ol.style.Text({ text: size>1? size.toString():'' })
                    });
                }
            });    
            
        }
        layers[x]=l;
        if(x.substring(0,x.indexOf('_'))=='girsu'){
            layers_girsu.push(l);
        } else if(x.substring(0,x.indexOf('_'))=='tratamiento'){
            layers_tratamiento.push(l);
        } else if(x.substring(0,x.indexOf('_'))=='mineria'){
            layers_mineria[parseInt(x.substring(8))]=l;
        } else if(x.substring(0,x.indexOf('_'))=='local'){
            layers_local[parseInt(x.substring(6))]=l;
        } else if(x.substring(0,3)=='kml'){
            layers_kml[parseInt(x.substring(3))]=l;
        }
        
    }
    

    layers_mineria = [
        new ol.layer.Group({
           'title': 'Minería Categoría I',
           fold: 'close',
           layers:  [
                new ol.layer.Group({
                   'title': 'Exploración',
                   fold: 'close',
                   layers:  [
                        layers_mineria[13],
                        layers_mineria[1]
                    ]
                }),
                new ol.layer.Group({
                   'title': 'Explotación',
                   fold: 'close',
                   layers:  [
                        layers_mineria[2],
                        layers_mineria[3],
                    ]
                })
            
            ]
        }),
        new ol.layer.Group({
           'title': 'Minería Categoría II',
           fold: 'close',
           layers:  [
            
                new ol.layer.Group({
                   'title': 'Explotación',
                   fold: 'close',
                   layers:  [
                        layers_mineria[4],
                        layers_mineria[5],
                    ]
                })
            
            ]
        }),
        new ol.layer.Group({
           'title': 'Minería Categoría III',
           fold: 'close',
           layers:  [
                new ol.layer.Group({
                   'title': 'Áridos',
                   fold: 'close',
                   layers:  [
                        layers_mineria[6],
                        layers_mineria[7]
                    ]
                }),
                new ol.layer.Group({
                   'title': 'Pórfidos',
                   fold: 'close',
                   layers:  [
                        layers_mineria[8],
                        layers_mineria[9]
                    ]
                }),
                new ol.layer.Group({
                   'title': 'Calizas',
                   fold: 'close',
                   layers:  [
                        layers_mineria[10],
                        layers_mineria[11]
                    ]
                }),
                layers_mineria[12]
            
            ]
        })
    
    ];
    
    layers_local= new ol.layer.Group({
        title: 'Localidades',
        layers: [ 
            layers_local[1],
            layers_local[2],
            layers_local[3],
            layers_local[4],
            layers_local[5],
        ] 
    });
    
    view = new ol.View({
        center: ol.proj.fromLonLat([-67.7, -44]),
        zoom: 7
    });
    
    map = new ol.Map({
        target: 'map',
        controls: ol.control.defaults({ attributionOptions: { collapsible: false } }),
        layers: [
        
            // capas base
            new ol.layer.Group({
               'title': 'División Política',
               layers:  [
                    new ol.layer.Tile({
                        title: 'Google Maps',
                        type: 'base',
                        visible: true,
                        source: new ol.source.XYZ({
                            url: 'http://mt0.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}&s=Ga'
                        })
                    }),
                    
                    new ol.layer.Vector({
                        title: 'Comarcas de Chubut',
                        visible: true,
                        source: new ol.source.Vector({
                            url: urltokml+'?nombre=comarcas',
                            format: new ol.format.KML(),
                        }),
                    }),
                    layers_kml[14],
                    layers_kml[17]

               ]
            }),

            ///AGUA
           new ol.layer.Group({
               'title': 'Agua',
               layers:  [
                    layers['le'],
                    layers_kml[2],
                    layers_kml[3],
                    layers_kml[4],
                    layers['canal'],
               ]
            }),

            ////BIODIVERSIDAD
            new ol.layer.Group({
               'title': 'Biodiversidad y áreas protegidas',
               layers:  [
                    layers['pa'],
                    layers['didymosphenia_geminata'],
                    layers['ANP'],
                    layers['OTBN']
               ]
            }),

            ///GESTIÓN DE RESIDUOS
            new ol.layer.Group({
                'title': 'Gestión de efluentes y residuos',
                //fold: 'close',
                layers:  [
                    new ol.layer.Group({
                        'title': 'Gestión Integral de Residuos Sólidos Urbanos (GIRSU)',
                        fold: 'close',
                        layers:  layers_girsu
                    }),
  
                    new ol.layer.Group({
                       'title': 'Plantas de Tratamiento de Líquidos Cloacales (PTLC)',
                       fold: 'close',
                       layers:  layers_tratamiento
                    })
                    
               ]
            }),                  
           
            /// ACTIVIDADES ECONÓMICAS
            
           new ol.layer.Group({
                'title': 'Actividades económicas, generación de energía',
                layers:  [
                    new ol.layer.Group({
                        'title': 'Minería',
                        fold: 'close',
                        layers:  layers_mineria
                    }),
                    layers['parque_eolico'],
                    layers['kml19'],
                    layers['kml20'],
                    layers['kml21'],
                ]
            }),

            ////    SUELO
           new ol.layer.Group({
               'title': 'Suelo',
               layers:  [
                   layers_kml[5]
               ]
           }),
           
           layers_local,
           
           /// INFRAESTRUCTURA
            new ol.layer.Group({
               'title': 'Infraestructura urbana y rural',
               layers:  [
                    layers_kml[16],
                    layers_kml[15],
                    layers_kml[6],
                    layers_kml[7],
                    layers['estacion'],
 //                   layers_kml[8],
 //                   layers_kml[9],

                    layers_kml[1],
                    layers_kml[13],

                    layers_kml[11],                    
                    layers_kml[10],
                    layers_kml[12]
               ]
           }),
             
        ],
        view: view
    });
    
    sidebar = new ol.control.Sidebar({
        element: 'side_bar',
        position: 'left'
    });
    var toc = document.getElementById('layers');

    ol.control.LayerSwitcher.renderPanel(map, toc, { reverse: false, collapsed : false });
    map.addControl(sidebar);
        
        
        ///////////////////////////////////////////////////////
        
        
    map.on('singleclick', function (evt) {
        var mostrar=[];

        $.each(this.getFeaturesAtPixel(evt.pixel,{ checkWrapped: true} ), function(i,e){
            mostrar=mostrar.concat(e.get('features'));
        });
        let c=recu(map.getLayers());
        if(c.length>0){
            
            c=c.join(',');
    
            let url = layers_kml[14].getSource().getFeatureInfoUrl(
                evt.coordinate,
                view.getResolution(),
                'EPSG:3857',
                {
                    'INFO_FORMAT': 'application/json',
                    'LAYERS':c, 
                    'QUERY_LAYERS':c,
                    'FEATURE_COUNT':100000
                }
            );        
            if (url) {
                fetch(url).then(function (response) { 
                    return response.text(); 
                }).then(function (html) {
                    let j=JSON.parse(html);
                 //   mostrar=mostrar.concat(j.features);
                    $.each(j.features, function(i,f){
                        f.id_=f.id;
                        mostrar.push(f);
                    });
                }).then(function(que){
                    lateral(mostrar);
                });
            } else {
                lateral(mostrar);
            }
        } else {
            lateral(mostrar);
        }
        
      
    });

});

function lateral(mostrar){
   if(mostrar.length==0 ){
            sidebar.close();
            $('#datos').empty();
            
        } else {
            o={};
            $.each(mostrar, function(i,f){
                l=f.id_.substring(0,f.id_.indexOf('.'));
                if( eval('o.'+l)==undefined ){
                    eval('o.'+l+'={ titulo: "'+layer_names[l]+'", features:[] }')
                }
                eval('o.'+l+'.features.push(f)');
                
            });
            
            let aux='';min='';
            let b1=true,m1=true,m2=true,m3=true;
            for(x in o) {
                aux+='<img src="'+urltofepng.replace('*',x)+'"/> '+o[x].titulo+'<dl>';
                
                switch(x){
                        case 'mineria_13':
                        case 'mineria_1':
                        case 'mineria_2':
                        case 'mineria_3':
                            if(m1){
                                m1=false;
                                min+="\n\n<b>Minería Categoría I</b>\n\nSegún el Código de minería (Ley Nac. N° 1919) – Título 1 – Art. 3: Corresponden a la primera categoría:\n"+
                                    "a) Las sustancias metalíferas siguientes: oro, plata, platino, mercurio, cobre, hierro, plomo, estaño, zinc, níquel, cobalto, bismuto, manganeso, antimonio, wolfram, aluminio, berilio, vanadio, cadmio, tantalio, molibdeno, litio y potasio;\n"+
                                    "b) Los combustibles: hulla, lignito, antracita e hidrocarburos sólidos;\n"+
                                    "c) El arsénico, cuarzo, feldespato, mica, fluorita, fosfatos calizos, azufre, boratos y wollastonita; (Inciso sustituido por art. 1° de la Ley N° 25.225 B.O. 29/12/1999.)\n"+
                                    "d) Las piedras preciosas.\n"+
                                    "e) Los vapores endógenos.";
                            } 
                            break;

                        case 'mineria_4':
                        case 'mineria_5':
                            if(m2){
                                m2=false;
                                min+="\n\n<b>Minería Categoría II</b>\n\nSegún el Código de minería (Ley Nac. N° 1919) – Título 1 – Art. 4: Corresponden a la segunda categoría:\n"+
                                    "a) Las arenas metalíferas y piedras preciosas que se encuentran en el lecho de los ríos, aguas corrientes y los placeres.\n"+
                                    "b) Los desmontes, relaves y escoriales de explotaciones anteriores, mientras las minas permanecen sin amparo y los relaves y escoriales de los establecimientos de beneficio abandonados o abiertos, en tanto no los recobre su dueño.\n"+
                                    "c) Los salitres, salinas y turberas.\n"+
                                    "d) Los metales no comprendidos en la primera categoría.\n"+
                                    "e) Las tierras piritosas y aluminosas, abrasivos, ocres, resinas, esteatitas, baritina, caparrosas, grafito, caolín, sales alcalinas o alcalino terrosas, amianto, bentonita, zeolitas o minerales permutantes o permutíticos.";
                            }
                            break;
                        
                        case 'mineria_6':
                        case 'mineria_7':
                        case 'mineria_8':
                        case 'mineria_9':
                        case 'mineria_10':
                        case 'mineria_11':
                        case 'mineria_12':
                            if(m3){
                                m3=false;
                                min+='\n\n<b>Minería Categoría III</b>\n\nSegún el Código de minería (Ley Nac. N° 1919) – Título 1 – Art. 5: Componen la tercera categoría las producciones minerales de naturaleza pétrea o terrosa, y en general todas las que sirven para materiales de construcción y ornamento, cuyo conjunto forma las canteras.';
                            }
                            break;
                }                    
                
                
                
                for(y in o[x].features){
                    switch(x){

                        case 'OTBN':
                            
                            if(b1){
                                b1=false;
                                desc='Sectores de muy alto valor de conservación que no deben transformarse. Son los que deben permanecer como bosques para siempre.';
                                aux+='<dt> Categoría I <span style="background-color: red; color: white">(rojo)</span></dt><dd>'+desc.replace(/(?:\r\n|\r|\n)/g, '<br>')+'</dd>';
                                desc='Sectores de mediano valor de conservación. Se trata de zonas que pueden estar degradadas, pero que con adecuadas actividades de restauración pueden tener un valor alto de conservación y ser usados para: aprovechamiento sostenible, turismo, recolección e investigación científica.';
                                aux+='<dt> Categoría II <span style="background-color: yellow; color: black">(amarillo)</span></dt><dd>'+desc.replace(/(?:\r\n|\r|\n)/g, '<br>')+'</dd>';
                                desc='Sectores de bajo valor de conservación que pueden transformarse parcialmente o en su totalidad.';
                                aux+='<dt> Categoría III <span style="background-color: green; color: black">(verde)</span></dt><dd>'+desc.replace(/(?:\r\n|\r|\n)/g, '<br>')+'</dd>';
                            }

                            break;
                        case 'ANP':
//                            aux+='<dt>'+decodeURIComponent(escape(o[x].features[y].properties.get('Nombre')))+'</dt><dd>';
                            aux+='<dt>'+decodeURIComponent(escape(o[x].features[y].properties.Nombre ))+'</dt><dd>';
//                            aux+=decodeURIComponent(escape(o.ANP.features[y].properties.get('Ins_Legal'))).replace(/(?:\r\n|\r|\n)/g, '<br>')+'<br>';
                            aux+=decodeURIComponent(escape(o.ANP.features[y].properties.Ins_Legal )).replace(/(?:\r\n|\r|\n)/g, '<br>')+'<br>';
//                            aux+=decodeURIComponent(escape(o.ANP.features[y].properties.get('Num_Ley'))).replace(/(?:\r\n|\r|\n)/g, '<br>');
                            aux+=decodeURIComponent(escape(o.ANP.features[y].properties.Num_Ley )).replace(/(?:\r\n|\r|\n)/g, '<br>');
                            aux+='</dd>';
                            break;
                        default:
                            if(o[x].features[y] instanceof ol.Feature){
                                aux+='<dt>'+o[x].features[y].get('nombre')+'</dt><dd>';
                                if(o[x].features[y].get('descripcion')){
                                    aux+=o[x].features[y].get('descripcion').replace(/(?:\r\n|\r|\n)/g, '<br>');
                                } else {
                                    aux+='&nbsp;'
                                }
                            } else {
                                aux+='<dt>'+o[x].features[y].properties.nombre+'</dt><dd>';
                                if(o[x].features[y].properties.descripcion){
                                    aux+=o[x].features[y].properties.descripcion.replace(/(?:\r\n|\r|\n)/g, '<br>');
                                } else {
                                    aux+='&nbsp;'
                                }
                            }
                            aux+='</dd>';
                    }
                }
                aux+='</dl>';
            }
            aux+=min.replace(/(?:\r\n|\r|\n)/g, '<br>');
            $('#datos').html(aux);
            sidebar.open('profile');
        }

}

