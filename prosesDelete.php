<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM barang WHERE id_barang = $id";

    if ($koneksi->query($sql) === TRUE) {
        header("Location: menuStaff.php");
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
} else {
    echo "Parameter ID tidak valid.";
}

$koneksi->close();