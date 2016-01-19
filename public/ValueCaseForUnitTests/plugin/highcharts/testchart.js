window["render_testchart"] = function() {
    
    $('#testchart_container').highcharts({

        title: {
            text: 'Cost to fix issues',
            //x: -20 //center
            style: { fontSize: '40px' }
        },
        /*subtitle: {
            text: 'Source: WorldClimate.com',
            //x: -20
        }, */
        xAxis: {
        /*    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] */
            title: {
                text: 'Time',
                style: {fontSize: '36px'},
            }
        },
        yAxis: {
            title: {
                text: 'Cost',
                style: { fontSize: '36px' }
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            //valueSuffix: '°C'
        },
        /*legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        }, */
        series: [{
            //name: 'Time',
            
            //data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            
            data: [0.77, 0.86, 0.99, 1.16, 1.38, 1.65, 1.98, 2.38, 2.86, 3.44, 4.12, 4.93, 5.90, 7.04, 8.41] 
        },]
    });
};