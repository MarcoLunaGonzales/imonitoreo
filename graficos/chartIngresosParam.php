<?php
$aleatorio=rand(2000,4000);
$codFondoX=$codFondoX;
$codOrganismoX=$codOrganismoX;
?>

<style type="text/css">

#chart-container<?=$aleatorio;?> {
    width: 70%;
}
</style>

<script type="text/javascript" src="../assets/chartjs/js/jquery.min.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/Chart.bundle.js"></script>
<script type="text/javascript" src="../assets/chartjs/js/utils.js"></script>


</head>

    <div id="chart-container<?=$aleatorio;?>" style="margin-left:auto; margin-right:auto">
        <canvas id="graphCanvas<?=$aleatorio;?>"></canvas>
    </div>

    <script>
        $(document).ready(function () {
            showGraph<?=$aleatorio;?>();
        });
        function showGraph<?=$aleatorio;?>()
        {
            {
                console.log("variablesIngresos: "+<?=$codFondoX?>+" "+<?=$codOrganismoX;?>);
                $.get("dataIngresosParam.php",
                {codFondoX:"<?=$codFondoX;?>",codOrganismoX:"<?=$codOrganismoX;?>"},
                function (data,status){
                    //console.log("data POA:"+data);
                    var mes = [];
                    var presupuesto = [];
                    var ejecutado = [];
                    console.log("estado...: "+status);                     
                    for (var i in data) {
                        mes.push(data[i].mes);
                        console.log(data[i].mes+" "+data[i].presupuesto);
                        presupuesto.push(data[i].presupuesto);
                        ejecutado.push(data[i].ejecutado); 
                    }
                    //alert(labs);
                    var chartdata = {
                        labels: mes,
                        datasets: [
                            {
                                label: 'Presupuestado.',
                                backgroundColor: "rgba(255, 99, 132, 0.2)",
                                borderColor: "rgb(255, 99, 132)",
                                borderWidth:2,
                                data: presupuesto
                            },
                            {
                                label: 'Ejecutado.',
                                backgroundColor: "rgba(75, 192, 192, 0.2)",
                                borderColor: "rgb(75, 192, 192)",
                                borderWidth:2,
                                data: ejecutado
                            }
                        ]
                    };

                    var graphTarget = $("#graphCanvas<?=$aleatorio;?>");

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
