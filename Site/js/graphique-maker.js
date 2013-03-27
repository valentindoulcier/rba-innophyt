function makeMyPlot() {
	
	var plot4 = $.jqplot('plot', [[["a",0],["b",1],["c",.01]]], {
        seriesDefaults:{
            renderer:$.jqplot.PieRenderer, 
            rendererOptions:{ sliceMargin: 0 }
        },
        legend:{ show: true }      
    });
}


$(document).ready(function() {
	makeMyPlot();
});