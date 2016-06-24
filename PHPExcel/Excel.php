<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Excel
 *
 * @author Daniel
 */
final class Excel {
 public static function generoDescargoDoc(Documento $search) {
        
    require_once '../PHPExcel/PHPExcel.php';

    /** PHPExcel_IOFactory */
    require_once '../PHPExcel/PHPExcel/IOFactory.php';

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load('../PHPExcel/templates/documentos.xls');

    if ($search->getEmisor() == Usuario::getCuit()) {
        $funcion = 'cobrar';
        $titulo = 'Documentos a Cobrar';
        $columna = 'Deudor';
    } else {
        $funcion = 'pagar';
        $titulo = 'Documentos a Pagar';
        $columna = 'Acreedor';
    }
    
    $objPHPExcel->getActiveSheet()->setCellValue('L1', PHPExcel_Shared_Date::PHPToExcel(time()));
    $objPHPExcel->getActiveSheet()->setCellValue('A1', Usuario::getNombreEmpresa());
    $objPHPExcel->getActiveSheet()->setCellValue('E1', $titulo);
    $objPHPExcel->getActiveSheet()->setCellValue('D2', $columna);

    $row = $baseRow = 3;
    $dao = new DocumentoDao();
    $ed = new EmpresaDao();
    $od = new OpDao();
    
    $documentos = $dao->find($search);
    
    foreach($documentos as $doc) {
        $cuit = ($funcion=='cobrar')? $doc->getReceptor() : $doc->getEmisor();
        
        if (!(($opid = $doc->getOp())==0)) {
            $op  = $od->findById($opid);
            $opn = $op->getNumero();
        } else {
            $opn = '';
        }

	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $doc->getTipo())
	                              ->setCellValue('B'.$row, (string) $doc->getNumero())
	                              ->setCellValue('C'.$row, $cuit)
	                              ->setCellValue('D'.$row, $ed->findById($cuit)->getNombre())
	                              ->setCellValue('E'.$row, $doc->getImporte()/100)
                                      ->setCellValue('F'.$row, $doc->getMoneda())
                                      ->setCellValue('G'.$row, Utils::formatDate($doc->getFecha()))
                                      ->setCellValue('H'.$row, Utils::formatDate($doc->getVence()))
                                      ->setCellValue('I'.$row, Utils::formatDate($doc->getTentativa()))
                                      ->setCellValue('J'.$row, $doc->getComentario())
                                      ->setCellValue('K'.$row, $doc->getEstado())
                                      ->setCellValue('L'.$row, (string) $opn);
        $row++;
        }
    
    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Documentos.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    
    }
    
    
    
    
    
    public static function generoDescargoOp(Op $search) {
        
    require_once '../PHPExcel/PHPExcel.php';

    /** PHPExcel_IOFactory */
    require_once '../PHPExcel/PHPExcel/IOFactory.php';

    
    if ($search->getReceptor() == Usuario::getCuit()) {
        $funcion = 'cobrar';
        $titulo = 'Órdenes de pago a Cobrar';
        $columna = 'Deudor';
    } else {
        $funcion = 'pagar';
        $titulo = 'Órdenes de pago emitidas';
        $columna = 'Acreedor';
    }
    
    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load('../PHPExcel/templates/ops.xls');

    $objPHPExcel->getActiveSheet()->setCellValue('O1', PHPExcel_Shared_Date::PHPToExcel(time()));
    $objPHPExcel->getActiveSheet()->setCellValue('A1', Usuario::getNombreEmpresa());
    $objPHPExcel->getActiveSheet()->setCellValue('E1', $titulo);
    $objPHPExcel->getActiveSheet()->setCellValue('C2', $columna);

    $row = $baseRow = 3;
    $ed = new EmpresaDao();
    $dao = new OpDao();
    $ops = $dao->find($search);
    
    foreach($ops as $op) {
        $cuit = ($funcion=='pagar')? $op->getReceptor() : $op->getEmisor();
        
        $documentos = '';
        $nd = 0;
        foreach ($op->getDocumentos() as $d) {
                $documentos .= $d->getNumero() . ' - ';
                $nd++;
        }
        if ($nd == 0) {$nd = 1;}
        
        $objPHPExcel->getActiveSheet()->getRowDimension($row)->setRowHeight(12.75 * $nd);
        
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, (string) $op->getNumero())
	                              ->setCellValue('B'.$row, $cuit)
	                              ->setCellValue('C'.$row, $ed->findById($cuit)->getNombre())
	                              ->setCellValue('D'.$row, $op->getImporte()/100)
                                      ->setCellValue('E'.$row, $op->getRetgan()/100)
                                      ->setCellValue('F'.$row, $op->getRetiva()/100)
                                      ->setCellValue('G'.$row, $op->getRetib()/100)
                                      ->setCellValue('H'.$row, $op->getRetotra()/100)
                                      ->setCellValue('I'.$row, $op->getMoneda())
                                      ->setCellValue('J'.$row, Utils::formatDate($op->getDisponibilidad()))
                                      ->setCellValue('K'.$row, Utils::formatDate($op->getDiferimiento()))
                                      ->setCellValue('L'.$row, $op->getTipo())
                                      ->setCellValue('M'.$row, $op->getLugar())
                                      ->setCellValue('N'.$row, $op->getEstado())
                                      ->setCellValue('O'.$row, (string) $documentos);
        $row++;
        }
    
    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="OPs.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    
    }
    
    public static function rankingOp(Op $search) {
        
    require_once '../PHPExcel/PHPExcel.php';

    /** PHPExcel_IOFactory */
    require_once '../PHPExcel/PHPExcel/IOFactory.php';

    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load('../PHPExcel/templates/ranking.xls');
    
    if ($search->getReceptor() == Usuario::getCuit()) {
        $titulo = 'Ranking de pagos de deudores';
        $columna = 'Deudor';
    } else {
        $titulo = 'Ranking de pagos a proveedores';
        $columna = 'Acreedor';
    }
    
    $diferimiento = $search->getDiferimiento();
    if ($diferimiento !== null) {
        if (is_array($diferimiento)) {
            $texto = Utils::formatDate($diferimiento[0]) . ' al ' . Utils::formatDate($diferimiento[1]);
        } else {
            $texto = Utils::formatDate($diferimiento);
        }
    } else {
        $texto = 'Todos los registros';
    }
    
    $objPHPExcel->getActiveSheet()->setCellValue('B1', $titulo);
    $objPHPExcel->getActiveSheet()->setCellValue('B2', $columna);
    $objPHPExcel->getActiveSheet()->setCellValue('D1', $texto);
    $objPHPExcel->getActiveSheet()->setCellValue('A1', Usuario::getNombreEmpresa());

    $row = $baseRow = 3;
    
    $dao = new OpDao();
    $renglones = $dao->ranking($search);
    
    foreach($renglones as $renglon) {
        $fila = array_values($renglon);
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $fila[0])
	                              ->setCellValue('B'.$row, $fila[1])
	                              ->setCellValue('C'.$row, $fila[2]/100)
	                              ->setCellValue('D'.$row, $fila[3]);
        $row++;
    }
    
    // Redirect output to a client’s web browser (Excel5)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Ranking.xls"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');

    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    
    }
    
    public static function xlstocsv($file) {
        set_time_limit(30);
        require_once '../PHPExcel/PHPExcel/IOFactory.php';
        
        $objReader = PHPExcel_IOFactory::createReader('Excel5');

        $objPHPExcel = $objReader->load($file);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV')->setDelimiter(';')
                                                                          ->setEnclosure('')
                                                                          ->setLineEnding("\r\n")
                                                                          ->setSheetIndex(0)
                                                                          ->save($file . '.csv');
        set_time_limit(30);
        return $file . '.csv';
    }
}
