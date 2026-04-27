<?php
/**
 * api_wisman.php
 * API untuk statistik_wisatawan.php
 * Sumber: BPS Web API
 */

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-cache, no-store, must-revalidate');

/* =====================================
   KONFIGURASI BPS
===================================== */
define('BPS_API_KEY', 'b6028c4ff88af791a4f0a24fa44457a5');
define('BPS_BASE_URL', 'https://webapi.bps.go.id/v1/api/list');

define('BPS_VAR',    '1470');
define('BPS_DOMAIN', '0000');
define('BPS_TAHUN',  '126');

/* bulan yang ingin ditampilkan */
define('BULAN_AKTIF', [1,2]); // Jan, Feb

/* id total yang tidak dimasukkan top negara */
$TOTAL_IDS = [12,36,53,112,160,183,244,245];


/* =====================================
   FUNCTION
===================================== */
function kirimError($msg, $code = 500){
    http_response_code($code);

    echo json_encode([
        "status"  => "error",
        "message" => $msg
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

/* format key BPS */
function buatKey($vervarId, $bulan){
    return $vervarId . '14700126' . $bulan;
}


/* =====================================
   REQUEST KE BPS
===================================== */
$url = sprintf(
    '%s/model/data/lang/ind/domain/%s/var/%s/th/%s/key/%s',
    BPS_BASE_URL,
    BPS_DOMAIN,
    BPS_VAR,
    BPS_TAHUN,
    BPS_API_KEY
);

$ctx = stream_context_create([
    'http' => [
        'method'  => 'GET',
        'timeout' => 20,
        'header'  => "User-Agent: StatistikWisman\r\n"
    ],
    'ssl' => [
        'verify_peer'      => false,
        'verify_peer_name' => false
    ]
]);

$raw = @file_get_contents($url, false, $ctx);

if($raw === false){
    kirimError("Gagal mengambil data dari BPS");
}

$json = json_decode($raw, true);

if(!$json){
    kirimError("Response JSON tidak valid");
}

if(($json['status'] ?? '') != 'OK'){
    kirimError("Status BPS bukan OK");
}

if(empty($json['datacontent'])){
    kirimError("Datacontent kosong");
}


/* =====================================
   MAPPING DATA
===================================== */
$dc = $json['datacontent'];

/* map kebangsaan */
$mapNegara = [];
foreach($json['vervar'] as $v){
    $mapNegara[(int)$v['val']] = strip_tags($v['label']);
}

/* map bulan */
$mapBulan = [];
foreach($json['turtahun'] as $b){
    $mapBulan[(int)$b['val']] = $b['label'];
}

$tahun = $json['tahun'][0]['label'] ?? date('Y');


/* =====================================
   DATA PER BULAN
===================================== */
$bulanLabels = [];
$bulanValues = [];

foreach(BULAN_AKTIF as $bln){

    $key = buatKey(245, $bln); // grand total

    $bulanLabels[] = $mapBulan[$bln] ?? "Bulan $bln";
    $bulanValues[] = isset($dc[$key]) ? (int)$dc[$key] : 0;
}


/* =====================================
   TOP 10 NEGARA
===================================== */
$negaraTotal = [];

foreach($mapNegara as $id => $nama){

    if(in_array($id, $TOTAL_IDS)) continue;

    $total = 0;

    foreach(BULAN_AKTIF as $bln){

        $key = buatKey($id, $bln);

        if(isset($dc[$key])){
            $total += (int)$dc[$key];
        }
    }

    if($total > 0){
        $negaraTotal[$nama] = $total;
    }
}

arsort($negaraTotal);

$top10 = array_slice($negaraTotal, 0, 10, true);


/* =====================================
   RINGKASAN
===================================== */
$grandTotal = array_sum($bulanValues);

$nilaiTertinggi = max($bulanValues);

$indexTinggi = array_search($nilaiTertinggi, $bulanValues);

$bulanTertinggi = $bulanLabels[$indexTinggi] ?? '-';

$rata = count($bulanValues) > 0
    ? round($grandTotal / count($bulanValues))
    : 0;


/* =====================================
   OUTPUT JSON
===================================== */
echo json_encode([

    "status" => "success",

    "tahun" => $tahun,

    "bulan_ditampilkan" => array_map(function($b) use($mapBulan){
        return $mapBulan[$b] ?? "Bulan $b";
    }, BULAN_AKTIF),

    "per_bulan" => [
        "labels" => $bulanLabels,
        "values" => $bulanValues
    ],

    "per_kebangsaan" => [
        "labels" => array_keys($top10),
        "values" => array_values($top10)
    ],

    "ringkasan" => [
        "grand_total"      => $grandTotal,
        "nilai_tertinggi"  => $nilaiTertinggi,
        "bulan_tertinggi"  => $bulanTertinggi,
        "rata_rata_bulan"  => $rata
    ],

    "meta" => [
        "sumber"       => "Badan Pusat Statistik (BPS)",
        "variabel"     => "Wisatawan Mancanegara per Bulan Menurut Kebangsaan",
        "diambil_pada" => date('Y-m-d H:i:s')
    ]

], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);