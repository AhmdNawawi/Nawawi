<?php

$host= "localhost";
$username= "root";
$password= "";
$database= "db_bansos";

$mysqli = mysqli_connect($host, $username, $password, $database);

if (!$mysqli) {
	// tampilkan pesan gagal koneksi
	die('Koneksi Database Gagal : ' . mysqli_connect_error());
}