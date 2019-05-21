<style type="text/css">

#chart-container10 {
    width: 80%;
}
</style>
<?php

?>
<script type="text/javascript" src="../assets/chartjs/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/Chart.bundle.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/utils.js"></script>


</head>

    <div id="chart-container10" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas10"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph10();
        });
        function showGraph10()
        {
            {
                console.log("antes CHART PIE;");
                $.get("dataComposicionIngresos.php",
				{},
                function (data){
                    console.log("AQUI CHART PIE:"+data);
                    var area = [];
                    var resultado = [];

                    for (var i in data) {
						area.push(data[i].area);
                        console.log(data[i].area);
                        resultado.push(data[i].resultado);
                    }
					//alert(labs);
                    var chartdata = {
                        labels: area,
                        datasets: [
                            {
                                label: 'Area.',
                                /*backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,*/
                                data: resultado,
                                backgroundColor: [
                                    "#FF6384",
                                    "#63FF84",
                                    "#84FF63",
                                    "#8463FF",
                                    "#6384FF"
                                ]
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas10");

                    var barGraph = new Chart(graphTarget, {
                        type: 'pie',
                        data: chartdata,
						
                        options: {
                            responsive: true,
                            legend: {
                              position: 'top',
                            },
                            title: {
                              display: false,
                              text: 'Chart.js Doughnut Chart'
                            },
                            animation: {
                              animateScale: true,
                              animateRotate: true
                            },
                            tooltips: {
                              callbacks: {
                                label: function(tooltipItem, data) {
                                    var dataset = data.datasets[tooltipItem.datasetIndex];
                                  var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                    return previousValue + currentValue;
                                  });
                                  var currentValue = dataset.data[tooltipItem.index];
                                  var percentage = Math.floor(((currentValue/total) * 100)+0.5);         
                                  return percentage + "%";
                                }
                              }
                            }
                          }

                    });

                });
            }
        }
        </script>
