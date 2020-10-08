<?php 

include 'connection.php';

$input=$db->exec("insert into siswa (nama,pekerjaan) values('".$_POST['nama']."','".$_POST['pekerjaan']."')");
if($input)
{
    header("Location:index.php");
}