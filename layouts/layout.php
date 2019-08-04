<?php 
	include("head.php");
  include("librerias.php");
  require_once('functions.php');

	$tipoLogin=obtieneValorConfig(-1);

  if($tipoLogin==1){
    include("menu.php");
  }else{
    include("menuService.php");
  }
?>    
    <div class="main-panel">
      <div class="content">

      <?php 
          include("cabecera.php");

          require_once('routing.php');
      ?>

      </div>      
    </div>

<?php 
?>