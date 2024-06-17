<?php
function koneksiDB() {
    $host = "localhost";
    $username= "root";
    $password= "";
    $db= "db_testing";

    $conn = mysqli_connect($host, $username, $password);
    if (!$conn) {
        die ("Koneksi Gagal : ". mysqli_connect_error());
    } else {
        return $conn;
    }
}
koneksiDB();