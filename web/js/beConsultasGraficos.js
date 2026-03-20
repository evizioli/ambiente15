$(document).ready(function(){

for(i in chartData) {
	var options = {
	       backgroundColor: "#FAFAF0",
			zoomEnabled: true, 
			zoomType: "xy", 
			dataPointMinWidth: 5,
			title:{ 
			     text: tit[i].fecha,
                fontSize: 25
			},
			legend: {
                fontSize: 12
            },
			axisX:{  
               labelAngle: 0,
                labelFontSize: 12,
//		    	labelMaxWidth: 300,
//                labelWrap: true
		    },

		    axisY: {
		    
                maximum: maximo[i],
                labelFontSize: 12,
	    		valueFormatString: "0#",
	    		title: "NMP en 100/ml",
		    	includeZero: false
	    	},

			data:  chartData[i]
			 
		};
	new CanvasJS.Chart("chart_"+tit[i].f, options).render();
	
}	

});
