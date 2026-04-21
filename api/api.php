<?php
session_start();
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

header('Content-Type: application/json');

$API_KEY = 'b6028c4ff88af791a4f0a24fa44457a5';
$action  = $_GET['action'] ?? '';

// Fetch semua data dari BPS (satu endpoint untuk semua)
$url = "https://webapi.bps.go.id/v1/api/domain/type/all/prov/00000/key/b6028c4ff88af791a4f0a24fa44457a5/";
$response = file_get_contents($url);
$decoded  = json_decode($response, true);

// Data ada di index [1] (array kedua dalam "data")
$allData = $decoded['data'][1] ?? [];

if ($action === 'provinsi') {
    // Filter hanya yang domain_id berakhiran "00" dan bukan "0000" (Pusat)
    $provinsi = array_values(array_filter($allData, function($item) {
        return substr($item['domain_id'], -2) === '00' && $item['domain_id'] !== '0000';
    }));
    echo json_encode(['status' => 'OK', 'data' => $provinsi]);
    exit;
}

if ($action === 'kabkota') {
    $kode_prov = $_GET['kode'] ?? '';
    if (empty($kode_prov)) {
        echo json_encode(['error' => 'Kode provinsi diperlukan']);
        exit;
    }

    // Ambil 2 digit pertama kode provinsi (misal "3500" → "35")
    $prefix = substr($kode_prov, 0, 2);

    // Filter: 2 digit pertama sama, tapi bukan provinsinya sendiri (bukan berakhiran "00")
    $kabkota = array_values(array_filter($allData, function($item) use ($prefix) {
        return substr($item['domain_id'], 0, 2) === $prefix
            && substr($item['domain_id'], -2) !== '00';
    }));

    echo json_encode(['status' => 'OK', 'data' => $kabkota]);
    exit;
}

echo json_encode(['error' => 'Action tidak dikenali']);