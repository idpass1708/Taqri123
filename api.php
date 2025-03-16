<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = "localhost";
$user = "root";  // Ganti dengan username database Anda
$pass = "";  // Ganti dengan password database Anda
$db = "kehadiran_taqri";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Gagal terhubung ke database"]));
}

// Mendapatkan juz yang tersedia
function getAvailableJuz($conn) {
    $query = "SELECT juz FROM peserta ORDER BY juz ASC";
    $result = $conn->query($query);

    $usedJuz = [];
    while ($row = $result->fetch_assoc()) {
        $usedJuz[] = $row['juz'];
    }

    for ($i = 1; $i <= 30; $i++) {
        if (!in_array($i, $usedJuz)) return $i;
    }

    return ($usedJuz) ? min($usedJuz) : 1; // Jika sudah penuh, ulang dari 1
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $nomor_wa = $_POST['nomor_wa'];
    $juz = getAvailableJuz($conn);

    $query = "INSERT INTO peserta (nama, nomor_wa, juz) VALUES ('$nama', '$nomor_wa', '$juz') 
              ON DUPLICATE KEY UPDATE juz = '$juz'";

    if ($conn->query($query) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Kehadiran disimpan", "juz" => $juz]);
    } else {
        echo json_encode(["status" => "error", "message" => "Gagal menyimpan data"]);
    }
}
?>



<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$pass = "";
$db = "kehadiran_taqri";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Gagal terhubung ke database"]));
}

$query = "SELECT * FROM peserta ORDER BY id DESC";
$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
?>



<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$host = "localhost";
$user = "root";
$pass = "";
$db = "kehadiran_taqri";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Gagal terhubung ke database"]));
}

$password = $_POST['password'];

if ($password === "taqri123") {
    $query = "DELETE FROM peserta";
    $conn->query($query);
    echo json_encode(["status" => "success", "message" => "Data berhasil direset"]);
} else {
    echo json_encode(["status" => "error", "message" => "Password salah"]);
}
?>
