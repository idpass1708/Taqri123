<?php
$dataFile = 'data.json';

// Ambil data JSON yang dikirim dari JavaScript
$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData, true);

// Reset List
if (isset($_GET['reset']) && $_GET['reset'] == 'true') {
    file_put_contents($dataFile, json_encode([]));
    echo json_encode(["message" => "List berhasil direset!"]);
    exit;
}

// Cek apakah nama & juz sudah diisi
if (!isset($data["nama"]) || !isset($data["juz"])) {
    echo json_encode(["message" => "Nama dan Juz harus diisi!"]);
    exit;
}

$nama = $data["nama"];
$juz = $data["juz"];

// Ambil data kehadiran yang sudah ada
$kehadiranList = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : [];

// Cek apakah Juz sudah ada sebelumnya
$juzTerpakai = array_column($kehadiranList, "juz");

if (in_array($juz, $juzTerpakai) && count($kehadiranList) < 30) {
    echo json_encode(["message" => "Juz ini sudah dipilih! Pilih juz lain."]);
    exit;
}

// Simpan data ke JSON
$kehadiranList[] = ["nama" => $nama, "juz" => $juz];
file_put_contents($dataFile, json_encode($kehadiranList));

// Kirim ke WhatsApp
$message = "Konfirmasi Kehadiran:\nNama: $nama\nJuz: $juz";
$whatsappUrl = "https://wa.me/6289656433788?text=" . urlencode($message);
echo json_encode(["message" => "Berhasil hadir!", "whatsapp" => $whatsappUrl]);
?>
