<?php
use_helper('JavascriptBase');
echo javascript_tag('

	var chartData = [
	

        {
			type: "line",
			color: "#FF0000",
			name: "Nivel embalse",
			showInLegend: true,
            lineThickness: 5,
            markerType: "none",
			dataPoints: '.html_entity_decode($nivel_embalse).'
		},
	        {
			type: "line",
			color: "#00FF00",
			name: "Caudal emitido",
			axisYType: "secondary",
			showInLegend: true,
			markerType: "none",
			dataPoints: '.html_entity_decode($caudal).'
		},
	        {
			type: "line",
			color: "#0000FF",
			name: "Caudal aporte",
			axisYType: "secondary",
			showInLegend: true,
			markerType: "none",
			dataPoints: '.html_entity_decode($caudal_aporte).'
		}
	];



');