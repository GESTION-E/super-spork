<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ($resultado = Utils::Upload(Utils::getUrlParam('tipo'), Utils::getUrlParam('dir'))) {
    Utils::gobackok($resultado);
} else {
    Utils::gobackok('Archivo ' . $_FILES["file"]["name"] . ' subido correctamente');
}
