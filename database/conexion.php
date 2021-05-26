<?php


function conectarBD()
{
    //$conexionBD = pg_pconnect("host='localhost' dbname=db_simun port=5432 user=postgres password=B4rranc0-%2021-%") or die("Error de conexion");
    //$conexionBD = pg_pconnect("host='localhost' dbname=db_simun20210413 port=5432 user=postgres password=76369890") or die("Error de conexion");
    $conexionBD = pg_pconnect("host='192.168.2.44' dbname=db_simun port=5432 user=postgres password=B4rranc0-%2021-%") or die("Error de conexion");
    return $conexionBD;
}

