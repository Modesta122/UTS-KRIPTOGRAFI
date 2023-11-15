<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Fungsi untuk mengenkripsi kata sandi menggunakan Hill Cipher
    function hillEncrypt($password, $keyMatrix) {
        $password = strtoupper($password); // Ubah teks menjadi huruf besar
        $result = "";

        // Pastikan panjang kata sandi genap
        if (strlen($password) % 2 != 0) {
            $password .= 'X';
        }

        for ($i = 0; $i < strlen($password); $i += 2) {
            $char1 = ord($password[$i]) - ord('A');
            $char2 = ord($password[$i + 1]) - ord('A');

            $result .= chr((($keyMatrix[0][0] * $char1 + $keyMatrix[0][1] * $char2) % 26) + ord('A'));
            $result .= chr((($keyMatrix[1][0] * $char1 + $keyMatrix[1][1] * $char2) % 26) + ord('A'));
        }

        return $result;
    }

    // Menggunakan kunci matriks Hill Cipher (ganti dengan kunci yang sesuai)
    $keyMatrix = [[2, 1], [3, 4]];
    $encryptedPassword = hillEncrypt($password, $keyMatrix);

    // Simpan data pengguna ke database (gantilah dengan koneksi ke database yang sesungguhnya)
    $servername = "localhost";
    $username_db = "root";
    $password_db = "";
    $database = "login_hillcipher";

    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$encryptedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Registrasi berhasil. <a href='login.php'>Login</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
