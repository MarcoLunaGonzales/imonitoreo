<style type="text/css">

#chart-container9 {
    width: 100%;
}
</style>
<?php

//session_start();

//$fondoTemporal='1011|1020';//echo "hola como vamos";

?>
<script type="text/javascript" src="../assets/chartjs/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/Chart.bundle.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/utils.js"></script>


</head>

    <div id="chart-container8" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas9"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph9();
        });
        function showGraph9()
        {
            {
                console.log("antes de los datos Egresos;");
                $.get("dataResultsTendencia.php",
				{},
                function (data){
                    console.log("aqui mostramos los datos Egresos:"+data);
                    var mes = [];
                    var montoPres = [];
					var montoEj = [];						

                    for (var i in data) {
						mes.push(data[i].mes);
                        console.log(data[i].mes);
                        montoPres.push(data[i].montoPres);
                        montoEj.push(data[i].montoEj);                        
                    }
					//alert(labs);
                    var chartdata = {
                        labels: mes,
                        datasets: [
                            {
                                label: 'PresResultado.',
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,
                                data: montoPres
                            },
                            {
                                label: 'EjResultado.',
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgb(75, 192, 192)",
                                borderWidth:2,
                                data: montoEj
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas9");

                    var barGraph = new Chart(graphTarget, {
                        type: 'line',
                        data: chartdata,
						options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            }
                        }
                    });

                });
            }
        }
        </script>
