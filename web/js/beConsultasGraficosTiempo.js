$(document).ready(function(){

CanvasJS.addCultureInfo("es",
                {
                    decimalSeparator: ".",
                    digitGroupSeparator: ",",
                    days: ["domingo", "lunes", "martes", "miércoles", "jueves", "viernes", "sábado"],
                    shortMonths: ["ene","feb","mar","abr","may","jun","jul","ago","sep","oct","nov","dic"]
               });
for(i in chartData) {
	var options = {
           backgroundColor: "#FAFAF0",
        	 culture:  "es",
			zoomEnabled: true, 
			zoomType: "xy", 
			dataPointMinWidth: 5,
			legend: {
                fontSize: 12
            },
			axisX:{  
//		    	 labelAngle: -90,
                labelFontSize: 12,
                valueFormatString: "DD/MM/YYYY",
		    },

		    axisY: {
		    
              //  maximum: maximo[i],
                labelFontSize: 12,
	    		valueFormatString: "0#",
	    		title: "NMP en 100/ml",
	//	    	includeZero: false
	    	},

            data:  chartData[i]
			 
		};
	new CanvasJS.Chart("chart_"+i, options).render();
	
}

});
