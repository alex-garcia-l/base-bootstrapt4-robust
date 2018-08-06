<?php
    include('../controladores/FPDF/fpdf.php');
    include("../controladores/controlador_bd.php");
    
    
    
    // Obtenemos la Fecha y Hora Actual
    $fechaActual = date("d/m/Y");
    $horaActual = date("H:i:s");
    
    $objDB = new DB;
    
    // Extendemos la Clase FPDF
    class PDF extends FPDF {
        
        // Encabezado
        public function header() {
            
            $objDB = new DB;
            //Logo
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(260, 6, 'Siempre Bella', 0, 0, 'C');

            $this->Ln(3);
            $this->Cell(1);
            $this->Cell(260, 10,'Frontera Comalapa, Chiapas', 0, 0, 'C');
            $this->Ln(5);
            $this->Cell(1);
            $this->Cell(260, 10,'Calle Central Oriente S/N', 0, 0, 'C');
            
            $this->Ln(10);
            $this->Cell(1);
            $this->Cell(260, 10,'REPORTE GENERAl DE COMPRAS POR PRODUCTOS', 0, 0, 'C');
            
            $fechaI = new DateTime($_GET[fechaInicial]);
            $fechaF = new DateTime($_GET[fechaFinal]);
            
            $fechaActual = date("d/m/Y");
            $this->Ln(15);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(-5);
            $this->Cell(5, 10, utf8_decode("Reporte del periodo ".$fechaI->format("d/m/Y")." al ".$fechaF->format("d/m/Y")), 0, 0, 'L');
            
            $this->Ln(0);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(205);
            $this->Cell(60, 10, utf8_decode('Fecha de impresión: ').$fechaActual, 0, 0, 'R');
            
            session_start();
            $con = $objDB->un_registro("SELECT CONCAT(nombres, ' ', apellidos) as nombre FROM personal WHERE id=".$_SESSION["idPersonal"]);
            $this->Ln(5);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(185);
            $this->Cell(80, 10,'Empleado: '.utf8_decode($con["nombre"]), 0, 0, 'R');
            
    }
        
    public function  Footer() {
            //Posicion: a 1,5 cm del final
        	$this->SetY(-15);
        	//Arial italic 8
        	$this->SetFont('Arial','I',8);
        	//Numero de pagina
        	$this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}.',0,0,'C');
        }
    }

    // Creamos el Objeto
    $pdf=new PDF(L,mm,letter); //$pdf=new PDF(P,mm,letter);
    // Agregamos los Alias
    $pdf->AliasNbPages();
    // Agregamos la Pagina NUeva
    $pdf->AddPage();
    
    // Asignamos el Color de Relleno para las Celdas
    $pdf->SetFillColor(200,200,200);

    // Para el Control de Impresion
    // Inicia la Variable de Separacion
    $separacion=60;
    
    // Inicia la Variable de No. Registros
    $limite=185;
    // Inicia la Variable de Contador
    $contador=0;
    // Inicia Variable de NO. Registros
    $noReg=1;

    $noTotalRegistro=1;
    $fechaInicial = $_GET[fechaInicial];
    $fechaFinal = $_GET[fechaFinal];
    $SQL = "SELECT com.id, usu.nom_usuario, pro.nombre, det.cantidad, det.costo_c, det.total, com.fecha FROM compras com, detalle_compras det, usuarios usu, productos pro WHERE pro.id=det.productos_id AND usu.id=com.usuarios_id AND com.id=det.compras_id AND com.estatus_id=6 AND (fecha >= '".$fechaInicial."' AND fecha <= '".$fechaFinal."')";
    
    // Obtenemos los Mensajes Enviados por Rango de Fechas
    $res = $objDB->fetch_object($SQL);
    
    // Vaciado de Datos
    // Ciclo FOR
    
    foreach ($res as $key => $value) {
    //for($i=0 ; $i<100 ; $i++) {
        // Evaluamos la Cantidad de Registros Impresos
        if ($separacion >= $limite) {
            // Agrega una Pagina Nueva
            $pdf->AddPage();
            // Reinicia la Variable de Contador
            $contador=0;
            // Reinicia la Variable de Separacion
            $separacion=60;
        }
        
        // Evaluamos Contador Para Encabezados
        if ($contador==0){

            // Agregamos los Encabezados
            // Define la Fuente a Usar
            $pdf->SetFont('Arial','B',10);
            
            // Asigna la Posicion de los Campos
            $pdf->SetXY(6, $separacion);
            // Imprimimos el Campo
            $pdf->Cell(20,7,'Folio Com.',1,1,'C',t);
            // Asigna la Posicion de los Campos
            $pdf->SetXY(26, $separacion);
            // Imprimimos el Campo
            $pdf->Cell(45,7,utf8_decode('Usuario'),1,1,'C',t);
            // Asigna la Posicion de los Campos
            // Asigna la Posicion de los Campos
            $pdf->SetXY(71, $separacion);
            // Imprimimos el Campo
            $pdf->Cell(88,7,'Producto',1,1,'C',t);
            $pdf->SetXY(159, $separacion);
            // Imprimimos el Campo
            $pdf->Cell(30,7,'Fecha Comp.',1,1,'C',t);
            $pdf->SetXY(189, $separacion);
            // Imprimimos el Campo
            $pdf->Cell(25,7,'Cant.',1,1,'C',t);
            $pdf->SetXY(214, $separacion);
            // Imprimimos el Campo
            $pdf->Cell(30,7,'P/Comp.',1,1,'C',t);
            
            $pdf->SetXY(244, $separacion);
            // Imprimimos el Campo
            $pdf->Cell(30,7,'Subtotal',1,1,'C',t);

            // Aumentamos la Variable de Separacion
            $separacion=$separacion+7;
            // Aumentamos la Variable de Contador
            $contador++;
            $pdf->SetFont('Arial','',9);
        }
        
        $caracteresFolio = strlen($value->id);
        $folio = "";
        for($i=0 ; $i<(8-$caracteresFolio) ; $i++) {
          $folio .= "0";
        }
        $folio .= $value->id;

        // Asigna la Posicion de los Campos
        $pdf->SetXY(6, $separacion);
        // Imprimimos el Campo
        $pdf->Cell(20,5,utf8_decode($folio),1,1,'C');
        // Asigna la Posicion de los Campos
        $pdf->SetXY(26, $separacion);
        // Imprimimos el Campo
        $pdf->Cell(45,5,utf8_decode($value->nom_usuario),1,1,'L');
        // Asigna la Posicion de los Campos
        $pdf->SetXY(71, $separacion);
        $pdf->Cell(88,5,utf8_decode($value->nombre),1,1,'L');
        // Asigna la Posicion de los Campos
        $pdf->SetXY(159, $separacion);
        
        $fecha = new DateTime($value->fecha);
        
        
        // Imprimimos el Campo
        $pdf->Cell(30,5,utf8_decode($fecha->format('d/m/Y')),1,1,'C');
        $pdf->SetXY(189, $separacion);
        // Imprimimos el Campo
        $pdf->Cell(25,5,utf8_decode($value->cantidad),1,1,'C');
        $pdf->SetXY(214, $separacion);
        // Imprimimos el Campo
        $pdf->Cell(30,5,utf8_decode("$".$value->costo_c." "),1,1,'R');
        $pdf->SetXY(244, $separacion);
        // Imprimimos el Campo
        $pdf->Cell(30,5,utf8_decode("$".$value->total." "),1,1,'R');

        // Aumentamos la Variable de Separacion
        $separacion=$separacion+5;

        // Aumentamos la Variable de Numero de Registros
        $noReg++;

        // Aumentamos la Variable de Contador
        $contador++;
        $noTotalRegistro++;
        
        $totalT += $value->total;
    }
    
    if($noReg > 1) {
        $pdf->SetFont('Arial','B',10);
        $pdf->SetXY(214, $separacion);
        // Imprimimos el Campo
        $pdf->Cell(30,5,utf8_decode("Total"),1,1,'C', t);
        $pdf->SetXY(244, $separacion);
        // Imprimimos el Campo
        $pdf->Cell(30,5,utf8_decode("$".$totalT." "),1,1,'R');
    }
    $pdf->Output();
?>