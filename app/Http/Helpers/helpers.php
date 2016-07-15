<?php

    function getLimpiarNumero($cadena){
        $cadena = str_replace(' ', '', $cadena);
        $cadena = str_replace('-', '', $cadena);
        $cadena = str_replace('(', '', $cadena);
        $cadena = str_replace(')', '', $cadena);
        $cadena = str_replace('/', '', $cadena);
        $cadena = str_replace('N', '', $cadena);
        $cadena = str_replace(',', '', $cadena);
        $cadena = str_replace(';', '', $cadena);
        $cadena = str_replace('*', '', $cadena);
        $cadena = str_replace('#', '', $cadena);
        $cadena = str_replace('.', '', $cadena);
        $cadena = str_replace('â', '', $cadena);
        $cadena = str_replace('€', '', $cadena);
        $cadena = str_replace('ª', '', $cadena);
        $cadena = str_replace('¬', '', $cadena);
        $cadena = preg_replace("/[^0-9]/", "", $cadena);
        return $cadena;
    }