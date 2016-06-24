<?php

        if (count($argv)<2) return;
        $para  = $argv[1];
        $desde = 'anemometros@trp.com.ar';
        $cc    = "";
        $co    = "";
        if (count($argv)>2) {
			$titulo = $argv[2];
		} else {
			$titulo = "Prueba";
		}
        $now= new DateTime();
        // Para enviar un correo HTML, debe establecerse la cabecera Content-type
        $mensaje  = "<html><head><title>" . $titulo .
                    "</title></head><body> " .
                    "<h2>" . $now->format('Y-m-d H:i:s') .
                    "</h2><br></body>";
        $cabeceras  = "MIME-Version: 1.0\r\nContent-type: text/html; charset=UTF-8\r\n";
//        $cabeceras .= "To: " . $para . "\r\n";
        $cabeceras .= "From: " . $desde . "\r\n";
        $cabeceras .= "Cc: " . $cc . "\r\n";
        $cabeceras .= "Bcc: " . $co . "\r\n";
        // Enviarlo
        echo (mail($para, $titulo, $mensaje, $cabeceras))? "Mail enviado OK\n":"ERROR!!!!!";
