<style type="text/css">

#chart-container7 {
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

    <div id="chart-container7" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas7"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph7();
        });
        function showGraph7()
        {
            {
                console.log("antes de los datos;");
                $.get("dataIngresosTendencia.php",
				{},
                function (data){
                    console.log("aqui mostramos los datos:"+data);
                    var mes = [];
                    var montoPresIngreso = [];
					var montoEjIngreso = [];						

                    var montoPresIngresoAnt = [];
                    var montoEjIngresoAnt = [];                        

                    for (var i in data) {
						mes.push(data[i].mes);
                        console.log(data[i].mes);
                        montoPresIngreso.push(data[i].montoPresIngreso);
                        montoEjIngreso.push(data[i].montoEjIngreso);   
                        montoPresIngresoAnt.push(data[i].montoPresIngresoAnt);
                        montoEjIngresoAnt.push(data[i].montoEjIngresoAnt);   
                    }
					//alert(labs);
                    var chartdata = {
                        labels: mes,
                        datasets: [
                            {
                                label: 'Presupuesto GA',
                                backgroundColor: "rgba(241, 227, 17, 0.2)",
                                borderColor: "rgb(241, 227, 17)",
                                borderWidth:2,
                                data: montoPresIngresoAnt
                            },
                            {
                                label: 'Ejecutado GA',
                                backgroundColor: "rgba(16, 242, 47, 0.2)",
                                borderColor: "rgb(16, 242, 47)",
                                borderWidth:2,
                                data: montoEjIngresoAnt
                            },
                            {
                                label: 'Presupuesto',
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,
                                data: montoPresIngreso
                            },
                            {
                                label: 'Ejecutado',
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgb(75, 192, 192)",
                                borderWidth:2,
                                data: montoEjIngreso
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas7");

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
