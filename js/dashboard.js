function generate_COChart(L, T, A, M) {
  // $("#sales-chart").html("");
  // $("#changeCOG").innerHTML = "";
  $("#sales-chart").remove(); // this is my <canvas> element
  $("#changeCOG").append('<canvas id="sales-chart"><canvas>');
  canvas = document.querySelector("#sales-chart");
  var SalesChartCanvas = $("#sales-chart").get(0).getContext("2d");
  var SalesChart = new Chart(SalesChartCanvas, {
    type: "bar",
    data: {
      labels: L, //["2015-2019", "2016-2020", "2017-2021", "2018-2022", "2019-2023"],
      datasets: [
        {
          label: "Total    CO's",
          data: T, //[480, 230, 470, 210, 330],
          backgroundColor: ["#316FFF", "#de25da", "#c86558", "#76c8c8"],
        },
        {
          label: "Attained CO's",
          data: A, //[400, 340, 550, 480, 170],
          backgroundColor: ["#8EB0FF", "#ff80ff", "#df8879", "#badbdb"],
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 20,
          bottom: 0,
        },
      },
      scales: {
        yAxes: [
          {
            display: true,
            gridLines: {
              display: true,
              drawBorder: true,
            },
            ticks: {
              display: true,
              min: 0,
              max: M,
            },
          },
        ],
        xAxes: [
          {
            stacked: false,
            ticks: {
              beginAtZero: true,
              fontColor: "#9fa0a2",
            },
            gridLines: {
              color: "rgba(0, 0, 0, 0)",
              display: true,
            },
            barPercentage: 1,
          },
        ],
      },
      legend: {
        display: false,
      },
      elements: {
        point: {
          radius: 0,
        },
      },
    },
  });
  // document.getElementById("sales-legend").innerHTML =
  //   SalesChart.generateLegend();
}

function generate_POChart(D, L) {
  // console.log(L, T, A, M);
  $("#Pos-chart").remove(); // this is my <canvas> element
  $("#changePOG").append('<canvas id="Pos-chart"><canvas>');
  canvas = document.querySelector("#Pos-chart");
  var SalesChartCanvas = $("#Pos-chart").get(0).getContext("2d");
  var SalesChart = new Chart(SalesChartCanvas, {
    type: "bar",
    data: {
      labels: [
        "PO1",
        "PO2",
        "PO3",
        "PO4",
        "PO5",
        "PO6",
        "PO7",
        "PO8",
        "PO9",
        "PO10",
        "PO11",
        "PO12",
        "PSO1",
        "PSO2",
      ], //["2015-2019", "2016-2020", "2017-2021", "2018-2022", "2019-2023"],
      datasets: [
        {
          label: L, // "2018-2022",
          data: D, //[2, 4, 5, 6, 7, 3, 9, 2, 6, 8, 3, 5, 1, 4], //[480, 230, 470, 210, 330],
          backgroundColor: [
            "#b30000",
            "#7c1158",
            "#4421af",
            "#1a53ff",
            "#0d88e6",
            "#00b7c7",
            "#5ad45a",
            "#8be04e",
            "#d0ee11",
            "#ffee65",
            "#ebdc78",
            "#e1a692",
            "#de6e56",
            "#e14b31",
          ],
          //["#71c016", "#8caaff", "#248afd"], //"#316FFF",
        },
        // {
        //   label: "PO2",
        //   data: [5], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PO3",
        //   data: [6], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PO4",
        //   data: [4], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PO5",
        //   data: [5], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PO6",
        //   data: [1], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PO7",
        //   data: [7], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PO8",
        //   data: [3], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PO9",
        //   data: [8], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PO10",
        //   data: [9], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PO11",
        //   data: [5], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PO12",
        //   data: [7], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PSO1",
        //   data: [4], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
        // {
        //   label: "PSO2",
        //   data: [1], //[400, 340, 550, 480, 170],
        //   backgroundColor: "#8EB0FF",
        // },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: true,
      layout: {
        padding: {
          left: 0,
          right: 0,
          top: 20,
          bottom: 0,
        },
      },
      scales: {
        yAxes: [
          {
            display: true,
            gridLines: {
              display: true,
              drawBorder: true,
            },
            ticks: {
              display: true,
              min: 0,
              max: 3,
            },
          },
        ],
        xAxes: [
          {
            stacked: false,
            ticks: {
              beginAtZero: true,
              fontColor: "#9fa0a2",
            },
            gridLines: {
              color: "rgba(0, 0, 0, 0)",
              display: true,
            },
            barPercentage: 1,
          },
        ],
      },
      legend: {
        display: false,
      },
      elements: {
        point: {
          radius: 0,
        },
      },
    },
  });
  document.getElementById("PO-legend").innerHTML = SalesChart.generateLegend();
}

(function ($) {
  "use strict";
  $(function () {
    if ($("#order-chart").length) {
      var areaData = {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
        datasets: [
          {
            data: [175, 200, 130, 210, 40, 60, 25],
            backgroundColor: ["rgba(255, 193, 2, .8)"],
            borderColor: ["transparent"],
            borderWidth: 3,
            fill: "origin",
            label: "services",
          },
          {
            data: [175, 145, 190, 130, 240, 160, 200],
            backgroundColor: ["rgba(245, 166, 35, 1)"],
            borderColor: ["transparent"],
            borderWidth: 3,
            fill: "origin",
            label: "purchases",
          },
        ],
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
          filler: {
            propagate: false,
          },
        },
        scales: {
          xAxes: [
            {
              display: false,
              ticks: {
                display: true,
              },
              gridLines: {
                display: false,
                drawBorder: false,
                color: "transparent",
                zeroLineColor: "#eeeeee",
              },
            },
          ],
          yAxes: [
            {
              display: false,
              ticks: {
                display: true,
                autoSkip: false,
                maxRotation: 0,
                stepSize: 100,
                min: 0,
                max: 260,
              },
              gridLines: {
                drawBorder: false,
              },
            },
          ],
        },
        legend: {
          display: false,
        },
        tooltips: {
          enabled: true,
        },
        elements: {
          line: {
            tension: 0.45,
          },
          point: {
            radius: 0,
          },
        },
      };
      var salesChartCanvas = $("#order-chart").get(0).getContext("2d");
      var salesChart = new Chart(salesChartCanvas, {
        type: "line",
        data: areaData,
        options: areaOptions,
      });
    }

    if ($("#sales-chart").length) {
      // generate_COChart();
    }

    if ($("#north-america-chart").length) {
      var areaData = {
        labels: ["Jan", "Feb", "Mar"],
        datasets: [
          {
            data: [100, 50, 50],
            backgroundColor: ["#71c016", "#8caaff", "#248afd"],
            borderColor: "rgba(0,0,0,0)",
          },
        ],
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 78,
        elements: {
          arc: {
            borderWidth: 4,
          },
        },
        legend: {
          display: false,
        },
        tooltips: {
          enabled: true,
        },
        legendCallback: function (chart) {
          var text = [];
          text.push('<div class="report-chart">');
          text.push(
            '<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' +
              chart.data.datasets[0].backgroundColor[0] +
              '"></div><p class="mb-0">Offline sales</p></div>'
          );
          text.push('<p class="mb-0">22789</p>');
          text.push("</div>");
          text.push(
            '<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' +
              chart.data.datasets[0].backgroundColor[1] +
              '"></div><p class="mb-0">Online sales</p></div>'
          );
          text.push('<p class="mb-0">94678</p>');
          text.push("</div>");
          text.push(
            '<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="me-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' +
              chart.data.datasets[0].backgroundColor[2] +
              '"></div><p class="mb-0">Returns</p></div>'
          );
          text.push('<p class="mb-0">12097</p>');
          text.push("</div>");
          text.push("</div>");
          return text.join("");
        },
      };
      var northAmericaChartPlugins = {
        beforeDraw: function (chart) {
          var width = chart.chart.width,
            height = chart.chart.height,
            ctx = chart.chart.ctx;

          ctx.restore();
          var fontSize = 3.125;
          ctx.font = "600 " + fontSize + "em sans-serif";
          ctx.textBaseline = "middle";
          ctx.fillStyle = "#000";

          var text = "63",
            textX = Math.round((width - ctx.measureText(text).width) / 2),
            textY = height / 2;

          ctx.fillText(text, textX, textY);
          ctx.save();
        },
      };
      var northAmericaChartCanvas = $("#north-america-chart")
        .get(0)
        .getContext("2d");
      var northAmericaChart = new Chart(northAmericaChartCanvas, {
        type: "doughnut",
        data: areaData,
        options: areaOptions,
        plugins: northAmericaChartPlugins,
      });
      document.getElementById("north-america-legend").innerHTML =
        northAmericaChart.generateLegend();
    }
  });
})(jQuery);
