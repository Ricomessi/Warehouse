<?php
session_start();
include("koneksi.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai yang dikirim dari formulir
    $newusername = $_POST['newusername'];
    $email = $_POST['email'];

    // Update data pada tabel pengguna berdasarkan username yang sedang login
    $updateQuery = "UPDATE pengguna SET email = ?, username = ? WHERE username = ?";
    $stmt = $koneksi->prepare($updateQuery);
    $stmt->bind_param("sss", $email, $newusername, $_SESSION['username']);

    if ($stmt->execute()) {
        // Jika email dan username berhasil diupdate
        $_SESSION['username'] = $newusername;

        // Jika ada gambar profil yang diunggah
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['size'] > 0) {
            $profileImage = $_FILES['profile_picture']['name'];
            $profileTmp = $_FILES['profile_picture']['tmp_name'];
            $uploadDir = "uploads/";

            // Pindahkan gambar profil yang diunggah ke direktori uploads
            move_uploaded_file($profileTmp, $uploadDir . $profileImage);

            // Update nama gambar profil pada tabel pengguna
            $updateImageQuery = "UPDATE pengguna SET profile = ? WHERE username = ?";
            $stmt = $koneksi->prepare($updateImageQuery);
            $stmt->bind_param("ss", $profileImage, $_SESSION['username']);
            $stmt->execute();
        }

        // Redirect kembali ke halaman profil setelah berhasil mengupdate
        header("Location: menuAdmin.php");
        exit();
    } else {
        echo "Terjadi kesalahan saat memperbarui profile: " . $koneksi->error;
    }

    $stmt->close();
    $koneksi->close();
}
?>