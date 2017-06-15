$(document).ready(function() {
	Highcharts.setOptions({
		lang: {
			months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',  'Julio', 'Agosto', 'Septiempbre', 'Octubre', 'Noviembre', 'Diciembre'],
			shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun',  'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			downloadJPEG: "Descargar JPEG",
			downloadPDF: "Descargar PDF",
			downloadPNG: "Descargar PNG",
			downloadSVG: "Descargar SVG",
			printChart: "Imprimir Gráfico",
		}
    });
});

function processLine(jd, vari) {
	os = new Array();
	var data = Array();
	$.each(jd, function (index, value) {
		var d = moment.unix(value.date.timestamp).format("DD");
		var m = moment.unix(value.date.timestamp).format("MM");
		var y = moment.unix(value.date.timestamp).format("YYYY");

		date = Date.UTC(y, m-1, d, 0, 0, 0);
		var val = eval('value.'+vari);
		if (jQuery.type(val) === "string") val = parseFloat(val);
 		data[index] = {
			'name': value.register.name,
			'date': date,
			'val': val, 
		};
	});

    data = dateSort(data);
    data = nameSort(data);

    var name = ''; var i = 0;
    $.each(data, function (index, value) {
    	if (name != value.name) {
    		os[i] = new Object();
			os[i].name = value.name;
			os[i].data = new Array();
			name = value.name;
			i++;
			os[i-1].data.push([value.date, value.val]);
			date = value.date;
    	} else {
    		if (date == value.date) {
    			var v = os[i-1].data[ os[i-1].data.length -1 ][1];
    			os[i-1].data[ os[i-1].data.length -1 ][1] = v + value.val;
    		} else {
    			os[i-1].data.push([value.date, value.val]);
    			date = value.date;
    		}
    	}
	});
    return os;
}

function dateSort(arr) {
	for(i = 0; i < (arr.length-1); i++){
		for(j = 0; j < (arr.length-1); j++){
			if(arr[j].date > arr[j+1].date){
			    aux = arr[j];
				arr[j] = arr[j+1];
				arr[j+1] = aux;
			}
		}
	}
	return arr
}

function nameSort(arr) {
	for(i = 0; i < (arr.length-1); i++){
		for(j = 0; j < (arr.length-1); j++){
			if(arr[j].name > arr[j+1].name){
			    aux = arr[j];
				arr[j] = arr[j+1];
				arr[j+1] = aux;
			}
		}
	}
	return arr
}

function processPie(jd, vari) {
	os = new Array();
	var data = Array(); var total = 0;
	$.each(jd, function (index, value) {
		var val = eval('value.'+vari);
		if (jQuery.type(val) === "string") val = parseFloat(val);
		data[index] = {
			'name': value.register.name,
			'val': val, 
		};
		total += data[index].val;
	});

    data = nameSort(data);

    os[0] = new Object();
    os[0].name = 'Porcentaje';
    os[0].type = 'pie';
    os[0].data = new Array();

    var name = ''; var i = 0; var sum = 0; var j = 0;
    $.each(data, function (index, value) {
    	j++;
    	if (name != value.name) {
    		os[0].data[i] = new Object();
			os[0].data[i].name = value.name;
			if (i > 0) os[0].data[i-1].y = sum*100/total;
			name = value.name;
			i++; sum = 0;
    	} 
    	sum += value.val;
    	if (j == data.length) os[0].data[i-1].y = sum*100/total;
	});
    return os;
}

function line_chart(lc) {
	var options = new Object();
	options.chart = new Object();
	options.chart.renderTo = lc.renderTo;
	options.chart.type = 'line';

	options.title = new Object();
	options.title.text = lc.title;

	options.xAxis = new Object();
	options.xAxis.type = 'datetime';

    options.yAxis = new Object();
    options.yAxis.title = { text: lc.yTitle };

    options.tooltip = lc.tooltip;

	options.series = processLine(lc.data, lc.type);
    new Highcharts.Chart(options);
}

function pie_chart(pc) {
	var options = new Object();
	options.chart = new Object();
	options.chart.renderTo = pc.renderTo;
	options.chart.type = 'pie';

    options.plotOptions = new Object();
    options.plotOptions.pie = {
        allowPointSelect: true,
        cursor: 'pointer',
        dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: {point.percentage:.2f} %',
        }
    };

	options.title = new Object();
	options.title.text = pc.title;

    options.tooltip = pc.tooltip;

	options.series = processPie(pc.data, pc.type);
    new Highcharts.Chart(options);
}
