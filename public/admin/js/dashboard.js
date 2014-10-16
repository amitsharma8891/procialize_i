jQuery(document).ready(function() {

    var uploads = [[0, 2], [1, 6], [2, 3], [3, 8], [4, 5], [5, 13], [6, 8]];
    var downloads = [[0, 5], [1, 4], [2, 4], [3, 1], [4, 9], [5, 10], [6, 13]];

//	 var plot = jQuery.plot(jQuery("#basicflot"),
//		[ { data: uploads,
//          label: "Uploads",
//          color: "#1CAF9A"
//        },
//        { data: downloads,
//          label: "Downloads",
//          color: "#428BCA"
//        }
//      ],
//      {
//		  series: {
//			 lines: {
//            show: true,
//            fill: true,
//            lineWidth: 1,
//            fillColor: {
//              colors: [ { opacity: 0.5 },
//                        { opacity: 0.5 }
//                      ]
//            }
//          },
//			 points: {
//            show: true
//          },
//          shadowSize: 0
//		  },
//		  legend: {
//          position: 'nw'
//        },
//		  grid: {
//          hoverable: true,
//          clickable: true,
//          borderColor: '#ddd',
//          borderWidth: 1,
//          labelMargin: 10,
//          backgroundColor: '#fff'
//        },
//		  yaxis: {
//          min: 0,
//          max: 15,
//          color: '#eee'
//        },
//        xaxis: {
//          color: '#eee'
//        }
//		});
//		
    var previousPoint = null;
    jQuery("#basicflot").bind("plothover", function(event, pos, item) {
        jQuery("#x").text(pos.x.toFixed(2));
        jQuery("#y").text(pos.y.toFixed(2));

        if (item) {
            if (previousPoint != item.dataIndex) {
                previousPoint = item.dataIndex;

                jQuery("#tooltip").remove();
                var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                showTooltip(item.pageX, item.pageY,
                        item.series.label + " of " + x + " = " + y);
            }

        } else {
            jQuery("#tooltip").remove();
            previousPoint = null;
        }

    });

    jQuery("#basicflot").bind("plotclick", function(event, pos, item) {
        if (item) {
            plot.highlight(item.series, item.datapoint);
        }
    });





    jQuery('#sparkline').sparkline([4, 3, 3, 1, 4, 3, 2, 2, 3, 10, 9, 6], {
        type: 'bar',
        height: '30px',
        tooltipFormat: {},
        barColor: '#428BCA'
    });


    jQuery('#sparkline2').sparkline([9, 8, 8, 6, 9, 10, 6, 5, 6, 3, 4, 2], {
        type: 'bar',
        height: '30px',
        tooltipFormat: {},
        barColor: '#999'
    });
    jQuery('#sparkline3').sparkline([4, 3, 3, 1, 4, 3, 2, 2, 3], {
        type: 'pie',
        height: '33px',
        tooltipFormat: {},
        sliceColors: ['#F0AD4E', '#428BCA', '#D9534F', '#1CAF9A', '#5BC0DE']
    });
    jQuery('#sparkline5').sparkline([4, 3, 3, 1, 4, 3, 2, 2, 3], {
        type: 'pie',
        height: '33px',
        tooltipFormat: {},
        sliceColors: ['#F0AD4E', '#428BCA', '#D9534F', '#1CAF9A', '#5BC0DE']
    });


    jQuery('#table1').dataTable({
        "iDisplayLength": 5,
        "bLengthChange": false
    });

    // Chosen Select
    jQuery("select").chosen({
        'width': '100%',
        //     'white-space': 'nowrap',
        //   disable_search_threshold: 10
    });

});