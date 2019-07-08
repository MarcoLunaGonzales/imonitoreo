<style type="text/css">

#chart-container8 {
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
        <canvas id="graphCanvas8"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph8();
        });
        function showGraph8()
        {
            {
                console.log("antes de los datos Egresos;");
                $.get("dataEgresosTendencia.php",
				{},
                function (data){
                    console.log("aqui mostramos los datos Egresos:"+data);
                    var mes = [];
                    var montoPres = [];
                    var montoEj = [];                       

                    var montoPres2 = [];
                    var montoEj2 = [];                       

                    for (var i in data) {
						mes.push(data[i].mes);
                        console.log(data[i].mes);
                        montoPres.push(data[i].montoPres);
                        montoEj.push(data[i].montoEj);    
                        montoPres2.push(data[i].montoPres2);
                        montoEj2.push(data[i].montoEj2);                        
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
                                data: montoPres2
                            },
                            {
                                label: 'Ejecutado GA',
                                backgroundColor: "rgba(16, 242, 47, 0.2)",
                                borderColor: "rgb(16, 242, 47)",
                                borderWidth:2,
                                data: montoEj2
                            },
                            {
                                label: 'Presupuesto',
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,
                                data: montoPres
                            },
                            {
                                label: 'Ejecutado',
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgb(75, 192, 192)",
                                borderWidth:2,
                                data: montoEj
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas8");

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
