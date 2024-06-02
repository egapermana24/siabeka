<?php
include '../database/koneksi.php';

$id_user = $_POST['id_user'];
$id_unit_kerja = $_POST['id_unit_kerja'];
$id_uraian_kegiatan = $_POST['id_uraian_kegiatan'];
$id_user2 = $_POST['id_user2'];
$id_unit_kerja2 = $_POST['id_unit_kerja2'];
$id_uraian_kegiatan2 = $_POST['id_uraian_kegiatan2'];

// Fungsi untuk mengecek apakah data sudah ada di tabel norma_waktu_komponen
function checkData($conn, $id_user, $id_unit_kerja, $id_uraian_kegiatan) {
    $checkQuery = "SELECT * FROM norma_waktu_komponen WHERE id_user = '$id_user' AND id_unit_kerja = '$id_unit_kerja' AND id_uraian_kegiatan = '$id_uraian_kegiatan'";
    $checkResult = mysqli_query($conn, $checkQuery);
    return mysqli_num_rows($checkResult) > 0;
}

// Looping untuk data pertama
for ($i = 0; $i < count($id_uraian_kegiatan); $i++) {
    $idUraian = mysqli_real_escape_string($conn, $id_uraian_kegiatan[$i]);

    if (checkData($conn, $id_user, $id_unit_kerja, $idUraian)) {
        echo '<script>document.location="../normawaktukomponen/";</script>';
    } else {
        $insertQuery = "INSERT INTO norma_waktu_komponen (id_user, id_unit_kerja, id_uraian_kegiatan) VALUES ('$id_user', '$id_unit_kerja', '$idUraian')";
        if (mysqli_query($conn, $insertQuery)) {
            echo '<script>document.location="../normawaktukomponen/";</script>';
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }
    }
}

// Looping untuk data kedua
for ($i = 0; $i < count($id_uraian_kegiatan2); $i++) {
    $idUraian2 = mysqli_real_escape_string($conn, $id_uraian_kegiatan2[$i]);

    if (checkData($conn, $id_user2, $id_unit_kerja2, $idUraian2)) {
        echo '<script>document.location="../normawaktukomponen/";</script>';
    } else {
        $insertQuery = "INSERT INTO norma_waktu_komponen (id_user, id_unit_kerja, id_uraian_kegiatan) VALUES ('$id_user2', '$id_unit_kerja2', '$idUraian2')";
        if (mysqli_query($conn, $insertQuery)) {
            echo '<script>document.location="../normawaktukomponen/";</script>';
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }
    }
}
?>
