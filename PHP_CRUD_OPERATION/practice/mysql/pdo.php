<?php

$db = new PDO("mysql:dbname=latihan;host=localhost","root","");

// var_dump($db);
var_dump($db->query("insert into kelas values('','SMK','TKR')"));

// $tampil=$db->query("select * from kelas");
// $tampil_data=$tampil->fetch(PDO::FETCH_OBJ);
$tampil_data=$tampil->fetchAll(PDO::FETCH_OBJ);

var_dump($tampil_data);