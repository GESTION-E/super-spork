<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CertificadoDao
 *
 * @author Daniel
 */
class FormCertificado extends FPDF {

// Cabecera de página
    function Header() {
        // Arial bold 15
        $this->SetFont('Times', 'B', 15);
        // Movernos a la derecha
        $this->Cell(90);
        // Título
        $this->Cell(50, 10, utf8_decode('CERTIFICADO DE RETENCIÓN'), 0, 0, 'C');
        // Salto de línea
        $this->Ln(15);
    }

// Pie de página
    function Footer() {
        // Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }

    function generar(Certificado $certificado, $file = null) {
        // Logo
        
        $cert_numero = str_pad($certificado->getNumero(), 14, "0", STR_PAD_LEFT);
        $doc_numero = str_pad($certificado->getComprobante(), 12, "0", STR_PAD_LEFT);

        $desc_impuesto = $certificado->getAllImpuestos();
        $desc_regimen  = $certificado->getAllRegimenes();

        $this->AliasNbPages();
        $this->AddPage();
        if (($certificado->getEmisor_logo()!=="")&&(file_exists('img/logo/' . $certificado->getEmisor_logo()))) {
            $this->Image('img/logo/' . $certificado->getEmisor_logo(), 25, 8, 33, 33);
        } 
        $this->SetFont('Times', 'B', 12);
        $this->Cell(80);
        $this->Cell(40, 10, utf8_decode('Certificado Nro: '), 0, 0, 'L');
        $this->Cell(10);
        $cert_numero_a = substr($cert_numero, -14, 4);
        $cert_numero_b = substr($cert_numero, -10, 4);
        $cert_numero_c = substr($cert_numero, -6);
        $this->Cell(20, 10, utf8_decode($cert_numero_a . '-' . $cert_numero_b . '-' . $cert_numero_c), 0, 0, 'R');


        $this->Ln(10);
        $this->Cell(80);
        $this->Cell(40, 10, utf8_decode('Fecha: '), 0, 0, 'L');
        $this->Cell(10);
        $this->Cell(20, 10, Utils::formatDate($certificado->getFecha()), 0, 0, 'R');

        $this->Ln(20);
        $this->SetFont('Times', 'B', 15);
        $this->Cell(5);
        $this->Cell(40, 10, utf8_decode('A - Datos del Agente de Retención'), 0, 0, 'L');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(70, 10, utf8_decode('Apellido y Nombre o Denominación: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $this->Cell(40, 10, utf8_decode($certificado->getEmisor_nombre()), 0, 0, 'L');

        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(70, 10, utf8_decode('C.U.I.T. Nro.: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $this->Cell(40, 10, utf8_decode((string) substr($certificado->getEmisor(), 0, 2)) . '-' . utf8_decode((string) substr($certificado->getEmisor(), 2, 8)) . '-' . utf8_decode((string) substr($certificado->getEmisor(), 10, 1)), 0, 0, 'L');

        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(20, 10, utf8_decode('Domicilio: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $this->Cell(40, 10, utf8_decode($certificado->getEmisor_domicilio()), 0, 0, 'L');

        $this->Ln(15);
        $this->SetFont('Times', 'B', 15);
        $this->Cell(5);
        $this->Cell(40, 10, utf8_decode('B - Datos del Sujeto Retenido'), 0, 0, 'L');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(70, 10, utf8_decode('Apellido y Nombre o Denominación: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $this->Cell(40, 10, utf8_decode($certificado->getReceptor_nombre()), 0, 0, 'L');

        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(70, 10, utf8_decode('C.U.I.T. Nro.: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $this->Cell(40, 10, utf8_decode((string) substr($certificado->getReceptor(), 0, 2)) . '-' . utf8_decode((string) substr($certificado->getReceptor(), 2, 8)) . '-' . utf8_decode((string) substr($certificado->getReceptor(), 10, 1)), 0, 0, 'L');

        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(20, 10, utf8_decode('Domicilio: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $this->Cell(40, 10, utf8_decode($certificado->getReceptor_domicilio()), 0, 0, 'L');

        $this->Ln(15);
        $this->SetFont('Times', 'B', 15);
        $this->Cell(5);
        $this->Cell(40, 10, utf8_decode('C - Datos de la Retención Practicada'), 0, 0, 'L');

        $this->Ln(10);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(30, 10, utf8_decode('Impuesto: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $this->Cell(40, 10, utf8_decode($certificado->getImpuesto() . '-' . $desc_impuesto[(int)$certificado->getImpuesto()][1]), 0, 0, 'L');

        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(30, 10, utf8_decode('Régimen: '), 0, 0, 'L');
        $this->Ln(2.5);
        $this->Cell(46);
        $this->SetFont('Times', '', 12);
        $this->MultiCell(0, 5, utf8_decode($certificado->getRegimen() . '-' . $desc_regimen[(int)$certificado->getRegimen()][1]), 0, 'L');
     //   $this->Cell(40, 10, utf8_decode($certificado->getRegimen() . '-' . $desc_regimen[(int)$certificado->getRegimen()][1]), 0, 0, 'L');

        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(95, 10, utf8_decode('Comprobante que origina la retención: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $doc_numero_a = substr($doc_numero, -12, 4);
        $doc_numero_b = substr($doc_numero, -8);
        $this->Cell(50, 10, utf8_decode($doc_numero_a . '-' . $doc_numero_b), 0, 0, 'L');


        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(95, 10, utf8_decode('Monto del Comprobante que origina la Retención: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $this->Cell(50, 10, utf8_decode('$' . $certificado->getImporte_comprobante() / 100), 0, 0, 'L');

        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(95, 10, utf8_decode('Monto de la Retención: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $this->Cell(50, 10, utf8_decode('$' . $certificado->getImporte() / 100), 0, 0, 'L');


        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(95, 10, utf8_decode('Imposibilidad de la Retención: '), 0, 0, 'L');
        $this->Cell(1);
        $this->SetFont('Times', '', 12);
        $this->Cell(50, 10, utf8_decode('NO'), 0, 0, 'L');

        $this->Ln(35);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(95, 10, utf8_decode('Firma del agente de Retención: '), 0, 0, 'L');
        if (($certificado->getEmisor_firma()!=="")&&(file_exists('../files/firma/' . $certificado->getEmisor_firma()))) {
            $this->Image('../files/firma/' . $certificado->getEmisor_firma(), 100, 205, 66, 33);
        }

        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(95, 10, utf8_decode('Aclaración: '), 0, 0, 'L');

        $this->Ln(5);
        $this->SetFont('Times', 'B', 12);
        $this->Cell(15);
        $this->Cell(95, 10, utf8_decode('Cargo: '), 0, 0, 'L');

        $this->Ln(25);
        $this->SetFont('Times', '', 12);
        $this->Cell(15);
        $this->MultiCell(0, 5, utf8_decode('Declaro que los datos consignados en este Formulario son correctos y completos sin omitir ni falsear dato alguno que deba contener, siendo fiel expresión de la verdad.'), 1, 'C');

        if ($file == null) {
            $this->Output($cert_numero . '.pdf','D');
        } else {
            $this->Output($file, 'F');
        }
    }

}

