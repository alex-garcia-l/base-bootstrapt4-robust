<?php
    include('../controladores/FPDF/fpdf.php');
    include("../controladores/controlador_bd.php");
    session_start();

    // Obtenemos la Fecha y Hora Actual
    
    $objDB = new DB;
    $pdf = new FPDF('P','mm','Letter');
    $pdf->AddPage();
    $pdf->SetFillColor(200,200,200);
    $pdf->SetAutoPageBreak(true,1);
    
    
    $pedido = $_GET['folio'];
    
    /*$complemento = "";
    if($pedido <= 9) {
        $complemento = "000000";
    } else if($pedido <= 99) {
        $complemento = "00000";
    } else if($pedido <= 999) {
        $complemento = "0000";
    } else if($pedido <= 9999) {
        $complemento = "000";
    } else if($pedido <= 99999) {
        $complemento = "00";
    } else if($pedido <= 99999) {
        $complemento = "0";
    }*/
    
    $pdf->Image('../../img/comprobante.jpeg' , 0 ,0, 215 , 280,'JPG', '');
    
    $resPedido = $objDB->un_registro("SELECT * FROM pedidos ped, clientes clie, prioridades prio WHERE ped.clientes_id=clie.id AND ped.prioridades_id=prio.id AND ped.id=".$pedido);
    $fecha = new DateTime($resPedido[fecha]);
    
    /*$resAlumno = $objDB->un_registro("SELECT a.* , a.nombre AS nomAlumno, c.nombre, e.carrera FROM alumnos a, carrera c, escuelas e WHERE a.id =".$resPedido[alumnos_id]." AND a.carrera_id = c.id AND a.baja =0 AND c.escuelas_id = e.id");
    $resSemestre = $objDB->un_registro("SELECT * FROM semestre WHERE id=".$resPedido[semestre_id]);
    
    $resUsuario = $objDB->un_registro("SELECT CONCAT(nombre, ' ', ap_p,' ', ap_m) AS nombre FROM usuarios WHERE id=".$_SESSION["userIdVas"]);*/
    
    $pdf->SetFont('arial', '', 12);
    $pdf->SetTextColor(162, 21, 54);
    $pdf->Ln(5);
    $pdf->Cell(160);
    $pdf->Cell(20, 5,utf8_decode("Folio: ".$complemento.$pedido), 0, 0, 'L');
    $pdf->SetTextColor(70, 70, 70);
    $pdf->Ln(10);
    $pdf->Cell(77);
    $pdf->Cell(30, 10,utf8_decode($resPedido[nombre]), 0, 0, 'L');
    $pdf->Cell(58);
    $pdf->Cell(15, 10,utf8_decode($resPedido[telefono]), 0, 0, 'L');
    $pdf->Ln(7.5);
    $pdf->Cell(165.5);
    $pdf->Cell(92, 10,utf8_decode($fecha->format('d / m / Y')), 0, 0, 'L'); // H:i:s
    $pdf->Ln(8.5);
    
    $pdf->Ln(77);
    $pdf->Cell(78);
    $pdf->Cell(29, 10,utf8_decode($resPedido[total_anticipo]), 0, 0, 'C');
    $pdf->Cell(16);
    $pdf->Cell(29, 10,utf8_decode(($resPedido[total]-$resPedido[total_anticipo])), 0, 0, 'C');
    $pdf->Cell(15);
    $pdf->Cell(29, 10,utf8_decode($resPedido[total]), 0, 0, 'C');
    
    
    $pdf->SetTextColor(162, 21, 54);
    $pdf->Ln(36.3);
    $pdf->Cell(160);
    $pdf->Cell(20, 5,utf8_decode("Folio: ".$complemento.$pedido), 0, 0, 'L');
    $pdf->SetTextColor(70, 70, 70);
    $pdf->Ln(10);
    $pdf->Cell(77);
    $pdf->Cell(30, 10,utf8_decode($resPedido[nombre]), 0, 0, 'L');
    $pdf->Cell(58);
    $pdf->Cell(15, 10,utf8_decode($resPedido[telefono]), 0, 0, 'L');
    $pdf->Ln(7.5);
    $pdf->Cell(165.5);
    $pdf->Cell(92, 10,utf8_decode($fecha->format('d / m / Y')), 0, 0, 'L'); // H:i:s
    $pdf->Ln(8.5);
    
    $pdf->Ln(77);
    $pdf->Cell(78);
    $pdf->Cell(29, 10,utf8_decode($resPedido[total_anticipo]), 0, 0, 'C');
    $pdf->Cell(16);
    $pdf->Cell(29, 10,utf8_decode(($resPedido[total]-$resPedido[total_anticipo])), 0, 0, 'C');
    $pdf->Cell(15);
    $pdf->Cell(29, 10,utf8_decode($resPedido[total]), 0, 0, 'C');
    // Asignamos el Color de Relleno para las Celdas
    $pdf->SetFillColor(220,220,220);
    $pdf->SetDrawColor(127,127,127);

    // Para el Control de Impresion
    // Inicia la Variable de Separacion
    $separacion=49;
    $separacionCopia=188;
    
    // Inicia la Variable de No. Registros
    $limite=250;
    // Inicia la Variable de Contador
    $contador=0;
    // Inicia Variable de NO. Registros
    $noReg=1;

    $noTotalRegistro=1;
    
    // Obtenemos los Mensajes Enviados por Rango de Fechas
    $res = $objDB->fetch_object("SELECT * FROM detalle_pedido det, productos pro WHERE det.productos_id=pro.id AND det.pedidos_id=".$pedido);
    
    //$resultadoVenta = $objDB->fetch_object("SELECT a.nombre, a.codigo, dv.*  FROM detalle_venta dv, articulos a WHERE dv.productos_id=a.id AND dv.ventas_id=3");
    foreach ($res as $key => $value) {
    //for($i=0 ; $i<10 ; $i++) {
        // Evaluamos la Cantidad de Registros Impresos
        if ($separacion >= $limite) {
            // Agrega una Pagina Nueva
            $pdf->AddPage();
            // Reinicia la Variable de Contador
            $contador=0;
            // Reinicia la Variable de Separacion
            $separacion=49;
            $separacionCopia=210;
        }
        
        // Evaluamos Contador Para Encabezados
        /*if ($contador==0){
            
            // Agregamos los Encabezados
            // Define la Fuente a Usar
            $pdf->SetFont('Arial','B',11);
            
            // Asigna la Posicion de los Campos
            $pdf->SetXY(16, $separacion);
            // Imprimimos el Campo
            $pdf->Cell(20,7,'#',1,1,'C',t);
            // Asigna la Posicion de los Campos
            $pdf->SetXY(36, $separacion);
            // Imprimimos el Campo
            $pdf->Cell(80.5,7,utf8_decode('Concepto'),1,1,'C',t);
            $pdf->SetXY(116.5, $separacion);
            // Imprimimos el Campo
            $pdf->Cell(40,7,utf8_decode('Año'),1,1,'C',t);
            // Asigna la Posicion de los Campos
            $pdf->SetXY(156.5, $separacion);

            $pdf->Cell(42,7,'Monto',1,1,'C',t);
            // Asigna la Posicion de los Campos
            $pdf->SetXY(105, $separacion);
            // Imprimimos el Campo

            // Aumentamos la Variable de Separacion
            $separacion=$separacion+7;
            ///////////////////////////////////////////////
            
            // Asigna la Posicion de los Campos
            $pdf->SetXY(16, $separacionCopia);
            // Imprimimos el Campo
            $pdf->Cell(20,7,'#',1,1,'C',t);
            // Asigna la Posicion de los Campos
            $pdf->SetXY(36, $separacionCopia);
            // Imprimimos el Campo
            $pdf->Cell(80.5,7,utf8_decode('Concepto'),1,1,'C',t);
            $pdf->SetXY(116.5, $separacionCopia);
            // Imprimimos el Campo
            $pdf->Cell(40,7,utf8_decode('Año'),1,1,'C',t);
            // Asigna la Posicion de los Campos
            $pdf->SetXY(156.5, $separacionCopia);

            $pdf->Cell(42,7,'Monto',1,1,'C',t);
            // Asigna la Posicion de los Campos
            $pdf->SetXY(105, $separacionCopia);
            // Imprimimos el Campo

            // Aumentamos la Variable de Separacion
            $separacionCopia=$separacionCopia+7;
            // Aumentamos la Variable de Contador
            
            
            
            $contador++;
        }*/
        
        $pdf->SetFont('Arial','B',10);
        
        // Asigna la Posicion de los Campos
        $pdf->SetXY(9, $separacion);
        // Imprimimos el Campo
        $pdf->Cell(20,6, $value->cantidad,0,1,'C');
        // Asigna la Posicion de los Campos
        $pdf->SetXY(39, $separacion);
        // Imprimimos el Campo
        $pdf->Cell(100,5,utf8_decode($value->nombre),0,1,'L');
        $pdf->SetXY(145, $separacion);
        
        $valorProducto="";
        if($value->cantidad >= $value->cantidad_m) {
            $valorProducto = $value->precio_m;
        } else {
            $valorProducto = $value->precio_u;
        }
        
        // Imprimimos el Campo
        $pdf->Cell(25,5,utf8_decode("$".$valorProducto." p/u"),0,1,'R');
        // Asigna la Posicion de los Campos
        $pdf->SetXY(182, $separacion);

        $pdf->Cell(19,5,utf8_decode("$".$value->total),0,1,'R');

        // Aumentamos la Variable de Separacion
        $separacion=$separacion+6.2;
        
        
        ///////////////////////////////////////////////////////////
        
        // Asigna la Posicion de los Campos
        $pdf->SetXY(9, $separacionCopia);
        // Imprimimos el Campo
        $pdf->Cell(20,6, $value->cantidad,0,1,'C');
        // Asigna la Posicion de los Campos
        $pdf->SetXY(39, $separacionCopia);
        // Imprimimos el Campo
        $pdf->Cell(100,5,utf8_decode($value->nombre),0,1,'L');
        $pdf->SetXY(145, $separacionCopia);
        // Imprimimos el Campo
        $pdf->Cell(25,5,utf8_decode("$".$valorProducto." p/u"),0,1,'R');
        // Asigna la Posicion de los Campos
        $pdf->SetXY(182, $separacionCopia);

        $pdf->Cell(19,5,utf8_decode("$".$value->total),0,1,'R');

        // Aumentamos la Variable de Separacion
        $separacionCopia=$separacionCopia+6.2;

        // Aumentamos la Variable de Numero de Registros
        $noReg++;

        // Aumentamos la Variable de Contador
        $contador++;
    }
    
    // Asigna la Posicion de los Campos
    $pdf->SetXY(9, $separacion);
    // Imprimimos el Campo
    $pdf->Cell(20,6, "",0,1,'C');
    // Asigna la Posicion de los Campos
    $pdf->SetXY(39, $separacion);
    // Imprimimos el Campo
    $pdf->Cell(100,5,utf8_decode("Cargo por prioridad: ".$resPedido[prioridad]),0,1,'L');
    // Imprimimos el Campo
    $pdf->Cell(25,5,utf8_decode(""),0,1,'R');
    // Asigna la Posicion de los Campos
    $pdf->SetXY(182, $separacion);
    $pdf->Cell(19,5,utf8_decode("$".$resPedido[monto]),0,1,'R');
    
    // Asigna la Posicion de los Campos
    $pdf->SetXY(9, $separacionCopia);
    // Imprimimos el Campo
    $pdf->Cell(20,6, "",0,1,'C');
    // Asigna la Posicion de los Campos
    $pdf->SetXY(39, $separacionCopia);
    // Imprimimos el Campo
    $pdf->Cell(100,5,utf8_decode("Cargo por prioridad: ".$resPedido[prioridad]),0,1,'L');
    // Imprimimos el Campo
    $pdf->Cell(25,5,utf8_decode(""),0,1,'R');
    // Asigna la Posicion de los Campos
    $pdf->SetXY(182, $separacionCopia);
    $pdf->Cell(19,5,utf8_decode("$".$resPedido[monto]),0,1,'R');
    
    $pdf->Output();
?>