/*
 Template Name: Zinzer - Responsive Bootstrap 4 Admin Dashboard
 Author: Themesdesign
 Website: www.themesdesign.in
 File: C3 Chart init js
 */

!function($) {
    "use strict";

    var ChartC3 = function() {};

    ChartC3.prototype.init = function () {
        //generating chart 
        c3.generate({
            bindto: '#chart',
            data: {
                columns: [
                    ['Desktop', 150, 80, 70, 152, 250, 95],
                    ['Mobile', 200, 130, 90, 240, 130, 220],
                    ['Tablet', 300, 200, 160, 400, 250, 250]
                ],
                type: 'bar',
                colors: {
                    Desktop: '#4bbbce',
                    Mobile: '#46cd93',
                    Tablet: '#5985ee'
                }
            }
        });

        //combined chart
        c3.generate({
            bindto: '#combine-chart',
            data: {
                columns: [
                    ['SonyVaio', 30, 20, 50, 40, 60, 50],
                    ['iMacs', 200, 130, 90, 240, 130, 220],
                    ['Tablets', 300, 200, 160, 400, 250, 250],
                    ['iPhones', 200, 130, 90, 240, 130, 220],
                    ['Macbooks', 130, 120, 150, 140, 160, 150]
                ],
                types: {
                    SonyVaio: 'bar',
                    iMacs: 'bar',
                    Tablets: 'spline',
                    iPhones: 'line',
                    Macbooks: 'bar'
                },
                colors: {
                    SonyVaio: '#46cd93',
                    iMacs: '#5985ee',
                    Tablets: '#4bbbce',
                    iPhones: '#f75285',
                    Macbooks: '#78ceff'
                },
                groups: [
                    ['SonyVaio','iMacs']
                ]
            },
            axis: {
                x: {
                    type: 'categorized'
                }
            }
        });
        
        //roated chart
        c3.generate({
            bindto: '#roated-chart',
            data: {
                columns: [
                ['Revenue', 30, 200, 100, 400, 150, 250],
                ['Pageview', 50, 20, 10, 40, 15, 25]
                ],
                types: {
                    Revenue: 'bar'
                },
                colors: {
                    Revenue: '#46cd93',
                    Pageview: '#5985ee'
	            }
            },
            axis: {
                rotated: true,
                x: {
                type: 'categorized'
                }
            }
        });

        //stacked chart
        c3.generate({
            bindto: '#chart-stacked',
            data: {
                columns: [
                    ['Revenue', 130, 120, 150, 140, 160, 150, 130, 120, 150, 140, 160, 150],
                    ['Pageview', 200, 130, 90, 240, 130, 220, 200, 130, 90, 240, 130, 220]
                ],
                types: {
                    Revenue: 'area-spline',
                    Pageview: 'area-spline'
                    // 'line', 'spline', 'step', 'area', 'area-step' are also available to stack
                },
                colors: {
                    Revenue: '#dddddd',
                    Pageview: '#5985ee'
                }
            }
        });
        
        //Donut Chart
        c3.generate({
             bindto: '#donut-chart',
            data: {
                columns: [
                    ['Desktops', 78],
                    ['Smart Phones', 55],
                    ['Mobiles', 40],
                    ['Tablets', 25]
                ],
                type : 'donut'
            },
            donut: {
                title: "Candidates",
                width: 30,
				label: { 
					show:false
				}
            },
            color: {
            	pattern: ['#5985ee', "#ebeff2", '#46cd93', '#4bbbce']
            }
        });
        
        //Pie Chart
        c3.generate({
             bindto: '#pie-chart',
            data: {
                columns: [
                    ['Desktops', 78],
                    ['Smart Phones', 55],
                    ['Mobiles', 40],
                    ['Tablets', 25]
                ],
                type : 'pie'
            },
            color: {
                pattern: ["#5985ee", "#ebeff2","#4bbbce","#46cd93"]
            },
            pie: {
		        label: {
		          show: false
		        }
		    }
        });

    },
    $.ChartC3 = new ChartC3, $.ChartC3.Constructor = ChartC3

}(window.jQuery),

//initializing 
function($) {
    "use strict";
    $.ChartC3.init()
}(window.jQuery);



