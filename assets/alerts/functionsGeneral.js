function number_format(amount, decimals) {

    amount += ''; // por si pasan un numero en vez de un string
    amount = parseFloat(amount.replace(/[^0-9\.-]/g, '')); // elimino cualquier cosa que no sea numero o punto

    decimals = decimals || 0; // por si la variable no fue fue pasada

    // si no es un numero o es igual a cero retorno el mismo cero
    if (isNaN(amount) || amount === 0) 
        return parseFloat(0).toFixed(decimals);

    // si es mayor o menor que cero retorno el valor formateado como numero
    amount = '' + amount.toFixed(decimals);

    var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

    while (regexp.test(amount_parts[0]))
        amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

    return amount_parts.join('.');
}

function nuevoAjax()
{ var xmlhttp=false;
  try {
      xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
  } catch (e) {
  try {
    xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  } catch (E) {
    xmlhttp = false;
  }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
  xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}



function ajaxIndicadoresReport(formu){
  var contenedor;
  contenedor = document.getElementById('divIndicador');
  ajax=nuevoAjax();
  var perspectiva=document.getElementById('perspectiva').value;
  var gestion=document.getElementById('gestion').value;

  ajax.open('GET', 'reportes/ajaxIndicadores.php?cod_perspectiva='+perspectiva+'&cod_gestion='+gestion,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)
}


function ajaxFuncionesCargos(combo, index){
  var contenedor;
  contenedor = document.getElementById('divFuncion'+index);
  ajax=nuevoAjax();
  var personal=combo.value;
  ajax.open('GET', 'poai/ajaxFuncionesCargos.php?cod_personal='+personal+"&index="+index,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)
}

//INDICADORES DETALLE PROPIEDAD
function ajaxPropiedad(objetivo, indicador){
  var contenedor;
  contenedor = document.getElementById('modal-body');
  ajax=nuevoAjax();
  ajax.open('GET', 'indicadores/ajaxPropiedad.php?cod_objetivo='+objetivo+'&cod_indicador='+indicador,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)
}

//INDICADORES REGISTRO DE METAS
function ajaxMetas(objetivo, indicador){
  var contenedor;
  contenedor = document.getElementById('modal-body2');
  ajax=nuevoAjax();
  ajax.open('GET', 'indicadores/ajaxMetas.php?cod_objetivo='+objetivo+'&cod_indicador='+indicador,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)
}

function ajaxIndicadores(objetivo)
{
    var objetivo_estrategico=objetivo.value;
    $("#div_indicadorest").html('<img src="loader.gif"/>');
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "objetivos_operativos/ajaxIndicadores.php",
        data: "objetivo_estrategico="+objetivo_estrategico,
        success: function(resp){
            $('#div_indicadorest').html(resp);
            $('.selectpicker_1').selectpicker(["refresh"]);
        }
    });
}

function ajaxArchivosSIS(anio, mes, id, divContenedor){
  var contenedor;
  contenedor = document.getElementById('modal-body');
  ajax=nuevoAjax();
  ajax.open('GET', 'solicitudFondosSIS/ajaxArchivos.php?anio='+anio+'&mes='+mes+'&idSIS='+id+'&divContenedor='+divContenedor,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)
}


function ajaxArchivosEj(nombreAct, id, divContenedor){
  var contenedor;
  contenedor = document.getElementById('modal-body');
  ajax=nuevoAjax();
  ajax.open('GET', 'poa/ajaxArchivos.php?nombre='+nombreAct+'&id='+id+'&divContenedor='+divContenedor,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)
}


function ajaxCargosPOAI(codigoIndicador){
  var contenedor;
  contenedor = document.getElementById('modal-body');
  ajax=nuevoAjax();
  ajax.open('GET', 'poai/ajaxCargosPOAI.php?codigo_indicador='+codigoIndicador,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)
}

function ajaxNormas(sector,priorizada,divX)
{
    var cod_sector=sector.value;
    $("#"+divX).html('<img src="loader.gif"/>');
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "poa/ajaxNormas.php",
        data: {'cod_sector':cod_sector,
              'priorizada':priorizada},
        success: function(resp){
            $('#'+divX).html(resp);
            $('.selectpicker_1').selectpicker(["refresh"]);
        }
    });
}

function ajaxNormasS(sector,priorizada,divX,indice)
{
    var cod_sector=sector.value;
    $("#"+divX).html('<img src="loader.gif"/>');
    $.ajax({
        type: "POST",
        dataType: 'html',
        url: "poa/ajaxNormasS.php",
        data: {'cod_sector':cod_sector,
              'priorizada':priorizada,
              'indice':indice},
        success: function(resp){
            $('#'+divX).html(resp);
            $('.selectpicker').selectpicker(["refresh"]);
        }
    });
}

var numFilas=0;
var cantidadItems=0;

//AJAX ADD ACTIVIDADES POA
function addActividad(obj, cod_indicador, cod_unidad, cod_area) {
      numFilas++;
      cantidadItems++;
      
      document.getElementById("cantidad_filas").value=numFilas;

      console.log("num: "+numFilas+" cantidadItems: "+cantidadItems);
      fi = document.getElementById('fiel');
      contenedor = document.createElement('div');
      contenedor.id = 'div'+numFilas;  
      fi.type="style";
      fi.appendChild(contenedor);
      var divDetalle;
      divDetalle=document.getElementById("div"+numFilas);
      ajax=nuevoAjax();
      ajax.open("GET","poa/ajaxActividades.php?cod_indicador="+cod_indicador+"&cod_unidad="+cod_unidad+"&cod_area="+cod_area+"&codigo="+numFilas,true);
      ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
          divDetalle.innerHTML=ajax.responseText;
          $('.selectpicker').selectpicker(["refresh"]);
       }
      }   
      ajax.send(null);
}

function addActividadPOAI(obj,cod_indicador,cod_unidad,cod_area,cod_actividad,cod_personal) {
      numFilas++;
      cantidadItems++;

      console.log("codindicador: "+cod_indicador);
      console.log("cod_unidad: "+cod_unidad);
      console.log("cod_area : "+cod_area);
      console.log("cod_actividad : "+cod_actividad);

      document.getElementById("cantidad_filas").value=numFilas;

      console.log("num: "+numFilas+" cantidadItems: "+cantidadItems);
      fi = document.getElementById('fiel');
      contenedor = document.createElement('div');
      contenedor.id = 'div'+numFilas;  
      fi.type="style";
      fi.appendChild(contenedor);
      var divDetalle;
      divDetalle=document.getElementById("div"+numFilas);
      ajax=nuevoAjax();
      ajax.open("GET","poai/ajaxActividadesPOAI.php?cod_indicador="+cod_indicador+"&cod_unidad="+cod_unidad+"&cod_area="+cod_area+"&codigo="+numFilas+"&cod_actividad="+cod_actividad+"&cod_personal="+cod_personal,true);
      ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
          divDetalle.innerHTML=ajax.responseText;
          $('.selectpicker').selectpicker(["refresh"]);
       }
      }   
      ajax.send(null);
}


function addActividadPOAIAsignacion(codigoPadre, codUnidad, codArea, codIndicador, indice) {
      numFilas++;
      cantidadItems++;
      
      document.getElementById("cantidad_filas").value=numFilas;

      console.log("num: "+numFilas+" cantidadItems: "+cantidadItems);
      fi = document.getElementById('fiel'+indice);
      contenedor = document.createElement('div');
      contenedor.id = 'div'+numFilas;  
      fi.type="style";
      fi.appendChild(contenedor);
      var divDetalle;
      divDetalle=document.getElementById("div"+numFilas);
      ajax=nuevoAjax();
      ajax.open("GET","poai/ajaxActividadesPOAIAsignacion2.php?cod_indicador="+codIndicador+"&cod_unidad="+codUnidad+"&cod_area="+codArea+"&codActividad="+codigoPadre+"&codigo="+numFilas,true);
      ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
          divDetalle.innerHTML=ajax.responseText;
          $('.selectpicker').selectpicker(["refresh"]);
       }
      }   
      ajax.send(null);
}

function minusActividad(numero) {
  cantidadItems--;
  console.log("TOTAL ITEMS: "+numFilas);
  console.log("NUMERO A DISMINUIR: "+numero);
  if(numero==numFilas){
    numFilas=parseInt(numFilas)-1;
  }
  fi = document.getElementById('fiel');
  fi.removeChild(document.getElementById('div'+numero));

  document.getElementById("cantidad_filas").value=numFilas;
}


function minusActividadPOAIAsignacion(numero) {
  cantidadItems--;
  console.log("TOTAL ITEMS: "+numFilas);
  console.log("NUMERO A DISMINUIR: "+numero);
  if(numero==numFilas){
    numFilas=parseInt(numFilas)-1;
  }
  fi = document.getElementById('fiel'+numero);
  fi.removeChild(document.getElementById('div'+numero));
  document.getElementById("cantidad_filas").value=numFilas;
}

function completaActividad(combo, fila) {
  var combo=combo.options[combo.selectedIndex].text;
  var fila=fila;
  document.getElementById("actividad"+fila).value=combo;
  console.log(combo+" "+fila);
}

//ESTAS FUNCIONES SON DEL POA
function verificaModalArea(){
  $('#myModal').modal('show');
}

function enviarAreaPOA(indicador){
  var comboarea=document.getElementById('areaModal');
  var areaUnidad=comboarea.options[comboarea.selectedIndex].value;
  location.href='index.php?opcion=registerPOAGroup&codigo='+indicador+'&areaUnidad='+areaUnidad;
}

function enviarAreaPOAI(indicador){
  var comboarea=document.getElementById('areaModal');
  var areaUnidad=comboarea.options[comboarea.selectedIndex].value;
  location.href='index.php?opcion=registerPOAI&codigo='+indicador+'&areaUnidad='+areaUnidad;
}

function enviarAreaPOAPON(indicador){
  var comboarea=document.getElementById('areaModal');
  var areaUnidad=comboarea.options[comboarea.selectedIndex].value;
  location.href='index.php?opcion=registerPOAPONGroup&codigo='+indicador+'&areaUnidad='+areaUnidad;
}

function enviarAsignarPOA(indicador){
  var comboarea=document.getElementById('areaModal');
  var areaUnidad=comboarea.options[comboarea.selectedIndex].value;
  location.href='index.php?opcion=asignarPOA&codigo='+indicador+'&areaUnidad='+areaUnidad;
}

function enviarAsignarPOAI(indicador){
  var comboarea=document.getElementById('areaModal');
  var areaUnidad=comboarea.options[comboarea.selectedIndex].value;
  location.href='index.php?opcion=asignarPOAI&codigo='+indicador+'&areaUnidad='+areaUnidad;
}

function enviarFiltroAreaUnidadPOA(indicador,indicadorPON){
  var comboarea=document.getElementById('areaModal');
  var combounidad=document.getElementById('unidadModal');
  var area=comboarea.options[comboarea.selectedIndex].value;
  var unidad=combounidad.options[combounidad.selectedIndex].value;
  location.href='index.php?opcion=listActividadesPOA&codigo='+indicador+'&codigoPON='+indicadorPON+'&area='+area+'&unidad='+unidad;
}

function enviarFiltroAreaUnidadPOA2(indicador,indicadorPON){
  var comboarea=document.getElementById('areaModal');
  var combounidad=document.getElementById('unidadModal');
  var area=comboarea.options[comboarea.selectedIndex].value;
  var unidad=combounidad.options[combounidad.selectedIndex].value;
  location.href='index.php?opcion=listActividadesPOAEjecucion&codigo='+indicador+'&codigoPON='+indicadorPON+'&area='+area+'&unidad='+unidad;
}

function enviarFiltroAreaUnidadPOA3(indicador,indicadorPON){
  console.log("llega1");
  var comboarea=document.getElementById('areaModal');
  var combounidad=document.getElementById('unidadModal');
  var area=comboarea.options[comboarea.selectedIndex].value;
  var unidad=combounidad.options[combounidad.selectedIndex].value;
  location.href='index.php?opcion=registerPOAEjecucion&codigo='+indicador+'&codigoPON='+indicadorPON+'&area='+area+'&unidad='+unidad;
  console.log("llega2");
}

function enviarDefinicionAreaUnidad(){
  var comboarea=document.getElementById('areaModal');
  var combounidad=document.getElementById('unidadModal');
  var area=comboarea.options[comboarea.selectedIndex].value;
  var unidad=combounidad.options[combounidad.selectedIndex].value;
  location.href='index.php?opcion=listPOAEjecucion&area='+area+'&unidad='+unidad;
}

function enviarDefinicionAreaUnidadSector(){
  var comboarea=document.getElementById('areaModal');
  var combounidad=document.getElementById('unidadModal');
  var combosector=document.getElementById('sectorModal');
  var area=comboarea.options[comboarea.selectedIndex].value;
  var unidad=combounidad.options[combounidad.selectedIndex].value;
  var sector=combosector.options[combosector.selectedIndex].value;

  location.href='index.php?opcion=listPOA&area='+area+'&unidad='+unidad+'&sector='+sector;
}

function enviarDefinicionAreaUnidadSectorPOAI(){
  var comboarea=document.getElementById('areaModal');
  var combounidad=document.getElementById('unidadModal');
  var combosector=document.getElementById('sectorModal');
  var area=comboarea.options[comboarea.selectedIndex].value;
  var unidad=combounidad.options[combounidad.selectedIndex].value;
  var sector=combosector.options[combosector.selectedIndex].value;

  location.href='index.php?opcion=listPOAI&area='+area+'&unidad='+unidad+'&sector='+sector;
}

/*FUNCIONES AJAX PARA LAS SOLICITUDES DE FONDOS SIS*/
function addSolicitudFondo(obj) {
      numFilas++;
      cantidadItems++;
      
      document.getElementById("cantidad_filas").value=numFilas;

      console.log("num: "+numFilas+" cantidadItems: "+cantidadItems);
      fi = document.getElementById('fiel');
      contenedor = document.createElement('div');
      contenedor.id = 'div'+numFilas;  
      fi.type="style";
      fi.appendChild(contenedor);
      var divDetalle;
      divDetalle=document.getElementById("div"+numFilas);
      ajax=nuevoAjax();
      ajax.open("GET","solicitudFondosSIS/ajaxSolicitud.php?codigo="+numFilas,true);
      ajax.onreadystatechange=function(){
        if (ajax.readyState==4) {
          divDetalle.innerHTML=ajax.responseText;
          $('.selectpicker').selectpicker(["refresh"]);
       }
      }   
      ajax.send(null);
}
function minusSolicitudFondo(numero) {
  cantidadItems--;
  console.log("TOTAL ITEMS: "+numFilas);
  console.log("NUMERO A DISMINUIR: "+numero);
  if(numero==numFilas){
    numFilas=parseInt(numFilas)-1;
  }
  fi = document.getElementById('fiel');
  fi.removeChild(document.getElementById('div'+numero));

  document.getElementById("cantidad_filas").value=numFilas;
}
//FUNCION PARA VER EL DETALLE DE UNA SOLICITUD DE FONDO SIS
function ajaxDetalleSolicitudFondoSIS(solicitud){
  var contenedor;
  contenedor = document.getElementById('modal-body');
  ajax=nuevoAjax();
  ajax.open('GET', 'solicitudFondosSIS/ajaxDetalleSolicitud.php?codigo='+solicitud,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = ajax.responseText
    }
  }
  ajax.send(null)
}

//FUNCION PARA PONER TOTALES A LAS TABLAS (SEGUIMIENTO SIS)
function totalesSIS(){
   var main=document.getElementById('main');   
   var numFilas=main.rows.length;
   var numCols=main.rows[1].cells.length;
   
   for(var j=2; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=2; i<=numFilas-2; i++){
          if(main.rows[i].cells[0].className.indexOf('primary')>0){
            //alert(main.rows[i].cells[j].innerHTML+" i:"+i+" j:"+j+" "+main.rows[i].cells[0].className);
            var datoS=main.rows[i].cells[j].innerHTML;
            datoS=datoS.replace(/,/g,'');
            //console.log(datoS);
            var dato=parseFloat(datoS);
            //console.log(dato);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,2); 
            console.log("si dato: "+dato);
          }
      }
      var fila=document.createElement('TH');
      main.rows[numFilas-1].appendChild(fila);
      main.rows[numFilas-1].cells[j].className='text-right'; 
      main.rows[numFilas-1].cells[j].innerHTML=subtotalF;      
   }   
   var datoPresS=main.rows[numFilas-1].cells[2].innerHTML;
   datoPresS=datoPresS.replace(/,/g,'');
   console.log(datoPresS);
   var datoEjeS=main.rows[numFilas-1].cells[numCols-3].innerHTML;
    datoEjeS=datoEjeS.replace(/,/g,'');
   console.log(datoEjeS);
    var porcentajeTotal=(parseFloat(datoEjeS)/parseFloat(datoPresS))*100;
    var porcentajeTotalF=number_format(porcentajeTotal,2);
   main.rows[numFilas-1].cells[numCols-1].innerHTML=porcentajeTotalF+" %";

    //ACA OCULTAMOS LAS FILAS QUE TIENEN 0
    for(var j=2; j<=numFilas-1; j++){
      var bandera=0;
      for(var i=2; i<=numCols-1; i++){
            var datoS=main.rows[j].cells[i].innerHTML;
            datoS=datoS.replace(/,/g,'');
            var dato=parseFloat(datoS);
            if(dato!=0){
              bandera=1;  
            }
      }
      if(bandera==0){
        console.log("ocultando fila X: "+main.rows[j].cells[0].innerHTML);
        main.rows[j].style.display = 'none';
      }
    }
}

function totalesSIS3(){
   var main=document.getElementById('main');   
   var numFilas=main.rows.length;
   var numCols=main.rows[1].cells.length;
   
   for(var j=2; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=2; i<=numFilas-2; i++){
          if(main.rows[i].cells[0].className.indexOf('primary')>0){
            var datoS=main.rows[i].cells[j].innerHTML;
            datoS=datoS.replace(/,/g,'');
            var dato=parseFloat(datoS);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,2); 
            console.log("si dato: "+dato);
          }
      }
      var fila=document.createElement('TH');
      main.rows[numFilas-1].appendChild(fila);
      main.rows[numFilas-1].cells[j].className='text-right'; 
      main.rows[numFilas-1].cells[j].innerHTML=subtotalF;      
   }   
    //ACA OCULTAMOS LAS FILAS QUE TIENEN 0
    for(var j=1; j<=numFilas-1; j++){
      var datoS=main.rows[j].cells[2].innerHTML;
      datoS=datoS.replace(/,/g,'');
      var dato=parseFloat(datoS);

      if(dato==0){
        console.log("ocultando fila: "+j);
        main.rows[j].style.display = 'none';
      }
    }
}


function totalesSIS2(){
   var main=document.getElementById('main');   
   var numFilas=main.rows.length;
   var numCols=main.rows[1].cells.length;
   
   for(var j=2; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=1; i<=numFilas-2; i++){
            var datoS=main.rows[i].cells[j].innerHTML;
            datoS=datoS.replace(/,/g,'');
            console.log(datoS);
            var dato=parseFloat(datoS);
            console.log(dato);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,2); 
            //console.log("si dato: "+dato);
      }
      var fila=document.createElement('TH');
      main.rows[numFilas-1].appendChild(fila);
      main.rows[numFilas-1].cells[j].className='text-right'; 
      main.rows[numFilas-1].cells[j].innerHTML=subtotalF;      
  }   
}


function totalesRptSec(){
   var main=document.getElementById('main');   
   var numFilas=main.rows.length;
   var numCols=main.rows[2].cells.length;
   
   for(var j=1; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=2; i<=numFilas-2; i++){
            var datoS=main.rows[i].cells[j].innerHTML;
            datoS=datoS.replace(/,/g,'');
            console.log(datoS);
            var dato=parseFloat(datoS);
            console.log(dato);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,0); 
            //console.log("si dato: "+dato);
      }
      var fila=document.createElement('th');
      console.log("totalfilas: "+numFilas+" j: "+j);
      main.rows[numFilas-1].appendChild(fila);
      main.rows[numFilas-1].cells[j].className='text-right'; 
      main.rows[numFilas-1].cells[j].innerHTML=subtotalF;      
  }   
}

function totalesRptOIServ1(){
   var main=document.getElementById('main');   
   var numFilas=main.rows.length;
   var numCols=main.rows[2].cells.length;
   
   for(var j=2; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=2; i<=numFilas-2; i++){
            var datoS=main.rows[i].cells[j].innerHTML;
            if(datoS=="-"){
              datoS="0";
            }
            datoS=datoS.replace(/,/g,'');
            datoS=datoS.replace(/-/g,'0');
            console.log("despues del reemplazo:"+datoS);
            var dato=parseFloat(datoS);
            console.log("float: "+dato);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,0); 
            //console.log("si dato: "+dato);
      }
      var fila=document.createElement('th');
      console.log("totalfilas: "+numFilas+" j: "+j);
      main.rows[numFilas-1].appendChild(fila);
      main.rows[numFilas-1].cells[j].className='text-right'; 
      main.rows[numFilas-1].cells[j].innerHTML=subtotalF;      
  }   
}


function totalesDetallePOA(){
   var main=document.getElementById('tablePaginatorReport');   
   var numFilas=main.rows.length;
   var numCols=main.rows[2].cells.length;
   
   for(var j=3; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=2; i<=numFilas-2; i++){
            var datoS=main.rows[i].cells[j].innerHTML;
            datoS=datoS.trim();
            console.log(datoS+" "+typeof(datoS));
            if(datoS=="-"){
              datoS="0";
            }
            datoS=datoS.replace(/,/g,'');
            console.log(datoS);
            var dato=parseFloat(datoS);
            //console.log(dato);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,0); 
            console.log("subtotal: "+subtotalF);
      }
      var fila=document.createElement('TH');
      main.rows[numFilas-1].appendChild(fila);
      if(j%2==0){
        main.rows[numFilas-1].cells[j].className='text-right text-primary'; 
      }else{
        main.rows[numFilas-1].cells[j].className='text-right'; 
      }
      main.rows[numFilas-1].cells[j].innerHTML=subtotalF;      
  }   
}


function totalesDetallePOA2(){
   var main=document.getElementById('tablePaginatorReport');   
   var numFilas=main.rows.length;
   var numCols=main.rows[2].cells.length;
   
   for(var j=6; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=2; i<=numFilas-2; i++){
            var datoS=main.rows[i].cells[j].innerHTML;
            datoS=datoS.trim();
            console.log(datoS+" "+typeof(datoS));
            if(datoS=="-"){
              datoS="0";
            }
            datoS=datoS.replace(/,/g,'');
            console.log(datoS);
            var dato=parseFloat(datoS);
            //console.log(dato);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,0); 
            console.log("subtotal: "+subtotalF);
      }
      var fila=document.createElement('TH');
      main.rows[numFilas-1].appendChild(fila);
      if(j%2==0){
        main.rows[numFilas-1].cells[j].className='text-right text-primary'; 
      }else{
        main.rows[numFilas-1].cells[j].className='text-right'; 
      }
      main.rows[numFilas-1].cells[j].innerHTML=subtotalF;      
  }   
}


function totalesPlanificacion(){
   var main=document.getElementById('tablePaginatorFixed');   
   var numFilas=main.rows.length;
   var numCols=main.rows[1].cells.length;
   
   for(var j=5; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=1; i<=numFilas-2; i++){
            var datoS=main.rows[i].cells[j].innerHTML;
            datoS=datoS.trim();
            console.log(datoS+" "+typeof(datoS));
            if(datoS=="-"){
              datoS="0";
            }
            datoS=datoS.replace(/,/g,'');
            console.log(datoS);
            var dato=parseFloat(datoS);
            //console.log(dato);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,0); 
            console.log("subtotal: "+subtotalF);
      }
      var fila=document.createElement('TH');
      main.rows[numFilas-1].appendChild(fila);
      main.rows[numFilas-1].cells[j].className='text-right'; 
      main.rows[numFilas-1].cells[j].innerHTML=subtotalF;      
  }   
}


function totalesPlanificacionPOASector(){
   var main=document.getElementById('tablePaginatorFixed');   
   var numFilas=main.rows.length;
   var numCols=main.rows[1].cells.length;
   
   for(var j=6; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=1; i<=numFilas-2; i++){
            var datoS=main.rows[i].cells[j].innerHTML;
            datoS=datoS.trim();
            console.log(datoS+" "+typeof(datoS));
            if(datoS=="-"){
              datoS="0";
            }
            datoS=datoS.replace(/,/g,'');
            console.log(datoS);
            var dato=parseFloat(datoS);
            //console.log(dato);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,0); 
            console.log("subtotal: "+subtotalF);
      }
      var fila=document.createElement('TH');
      main.rows[numFilas-1].appendChild(fila);
      main.rows[numFilas-1].cells[j].className='text-right'; 
      main.rows[numFilas-1].cells[j].innerHTML=subtotalF;      
  }   
}

function totalesPlanificacionPOA(){
   var main=document.getElementById('tablePaginatorFixed');   
   var numFilas=main.rows.length;
   var numCols=main.rows[1].cells.length;
   
   for(var j=5; j<=numCols-1; j++){
    var subtotal=0;
      for(var i=1; i<=numFilas-2; i++){
            var datoS=main.rows[i].cells[j].innerHTML;
            datoS=datoS.trim();
            console.log(datoS+" "+typeof(datoS));
            if(datoS=="-"){
              datoS="0";
            }
            datoS=datoS.replace(/,/g,'');
            console.log(datoS);
            var dato=parseFloat(datoS);
            //console.log(dato);
            subtotal=subtotal+dato;
            var subtotalF=number_format(subtotal,0); 
            console.log("subtotal: "+subtotalF);
      }
      var fila=document.createElement('TH');
      main.rows[numFilas-1].appendChild(fila);
      main.rows[numFilas-1].cells[j].className='text-right'; 
      main.rows[numFilas-1].cells[j].innerHTML=subtotalF;      
  }   
}

var dynamicColors = function() {
    var r = Math.floor(Math.random() * 255);
    var g = Math.floor(Math.random() * 255);
    var b = Math.floor(Math.random() * 255);
    var arrayColors = new Array();
    arrayColors[0]="rgb(" + r + "," + g + "," + b + ",0.2)";
    arrayColors[1]="rgb(" + r + "," + g + "," + b + ")";
    return arrayColors;
}

function calcularTotalEj(){
  var suma=0;
  var formulariop = document.getElementById("form1");
  for (var i=0;i<formulariop.elements.length;i++){
    console.log()
    if (formulariop.elements[i].id.indexOf("ejecutado") !== -1 ){        
      suma += (formulariop.elements[i].value) * 1;
    }
  }  
  document.getElementById("totalEj").value=suma;  
}


function calcularTotalPlanificado(indice, mes){
  var suma=0;
  var sumaVertical=0;
  var sumaTotal=0;
  var formulariop = document.getElementById("form1");
  for (var i=0;i<formulariop.elements.length;i++){
    if (formulariop.elements[i].id.indexOf("planificado"+indice)!=-1){        
      suma += (formulariop.elements[i].value) * 1;
    }
    if(formulariop.elements[i].id.indexOf("mes"+mes)!=-1){
      sumaVertical += (formulariop.elements[i].value) * 1;
    }
    //aqui sumamos los totales
    if( (formulariop.elements[i].id.indexOf("planificado"))!=-1 ||  (formulariop.elements[i].id.indexOf("mes"))!=-1 ){
      sumaTotal += formulariop.elements[i].value * 1;
    }
  }  
  document.getElementById("totalPlani"+indice).value=number_format(suma,2);  
  document.getElementById("totalMes"+mes).value=number_format(sumaVertical,2);
  document.getElementById("totalTotal").value=number_format(sumaTotal,2);
}

//CON ESTE PROCESO ENVIAMSO LOS ARCHIVOS AJAX A LA LIBRERIA DEL ING. WILLY
    $(function(){
        $("#formuploadajaxsis").on("submit", function(e){
            e.preventDefault();
            var f = $(this);
            var divContenedor=document.getElementById('divContenedor').value;
            console.log("DIV A AFECTAR: "+divContenedor);
            var formData = new FormData(document.getElementById("formuploadajaxsis"));
            $.ajax({
                url: "http://ibnored.ibnorca.org/itranet/documentos/guardar_archivo.php",
                type: "post",
                dataType: "html",
                data: formData,
                cache: false,
                contentType: false,
       processData: false
            })
                .done(function(res){
                    //$("#mensaje").html("Respuesta: " + res);
                    document.getElementById(divContenedor).innerHTML="<i class='material-icons' style='color:green'>attachment</i>";
                    $('#myModal').modal('hide');
                    //location.reload();
                });
        });
    });


//FUNCION QUE LLAMA A BORRAR ARCHIVOS DEL ING. WILLY
function ajaxDeleteArchivo(urlServer, idArchivo, divContenedor, idDir, id){
  var contenedor;
  contenedor = document.getElementById(divContenedor);
  ajax=nuevoAjax();
  ajax.open('GET', urlServer+'eliminar.php?idD='+idDir+'&idR='+idArchivo+'&r=http://www.google.com&idRe='+id,true);
  ajax.onreadystatechange=function() {
    if (ajax.readyState==4) {
      contenedor.innerHTML = "ArchivoBorrado"
    }
  }
  ajax.send(null)
}
function obtenerHoraFechaActualFormato(){
  var meses = new Array ("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
  var diasSemana = new Array("Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado");
  var f=new Date();
  var hora = f.getHours() + ':' + f.getMinutes() + ':' + f.getSeconds();

  return diasSemana[f.getDay()] + ", " + f.getDate() + " de " + meses[f.getMonth()] + " de " + f.getFullYear()+"  "+hora;
}