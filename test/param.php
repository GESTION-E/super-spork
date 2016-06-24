<?php

require '../util/loadClass.php';

Usuario::initDaemon("admE1");
//----------------------------------------
$p = new Param();
$p->setFecha_enviada('2016-05-05');

$a = array();
$n = new Nivel();
$n->setCantidad(1);
$n->setHasta(10000);
$a[]=$n;
$n = new Nivel();
$n->setCantidad(2);
$n->setHasta(20000);
$a[]=$n;
$n = new Nivel();
$n->setCantidad(3);
$n->setHasta(30000);
$a[]=$n;
$n = new Nivel();
$n->setCantidad(4);
$n->setHasta(99999999999999.99);
$a[]=$n;

echo $n->setAll($a);
//----------------------------------------

$a = array();
$n = new Rechazo();
$n->setNumero(11);
$n->setDescripcion('Excede el límite de endosos');
$n->setDepositaria(1);
$n->setGirada(0);
$a[]=$n;
$n = new Rechazo();
$n->setNumero(16);
$n->setDescripcion('El documento no es cheque');
$n->setDepositaria(1);
$n->setGirada(0);
$a[]=$n;
$n = new Rechazo();
$n->setNumero(33);
$n->setDescripcion('Cheque librado en fórmulas de cuadernos no entregadas por el Banco');
$n->setDepositaria(1);
$n->setGirada(0);
$a[]=$n;
$n = new Rechazo();
$n->setNumero(36);
$n->setDescripcion('Adulteración de cheque');
$n->setDepositaria(1);
$n->setGirada(0);
$a[]=$n;
$n = new Rechazo();
$n->setNumero(37);
$n->setDescripcion('Plazo de validez legal vencido');
$n->setDepositaria(1);
$n->setGirada(0);
$a[]=$n;
$n = new Rechazo();
$n->setNumero(38);
$n->setDescripcion('No coincide firma librador y salvado al dorso');
$n->setDepositaria(1);
$n->setGirada(0);
$a[]=$n;
$n = new Rechazo();
$n->setNumero(46);
$n->setDescripcion('Diseño no compensable / pagadero por caja');
$n->setDepositaria(1);
$n->setGirada(0);
$a[]=$n;
$n = new Rechazo();
$n->setNumero(47);
$n->setDescripcion('No corresponde segunda presentación');
$n->setDepositaria(1);
$n->setGirada(0);
$a[]=$n;
$n = new Rechazo();
$n->setNumero(83);
$n->setDescripcion('Irregularidad en la cadena de endosos');
$n->setDepositaria(1);
$n->setGirada(0);
$a[]=$n;
$n = new Rechazo();
$n->setNumero(96);
$n->setDescripcion('Errores Entidad depositaria');
$n->setDepositaria(1);
$n->setGirada(0);
$a[]=$n;

echo $n->setAll($a);