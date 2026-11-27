<?php
// Memanggil file Model.
require_once __DIR__ . '/models/TabelKandidat.php';
require_once __DIR__ . '/models/TabelJadwal.php';

// Memanggil file View.
require_once __DIR__ . '/views/ViewKandidat.php';
require_once __DIR__ . '/views/ViewJadwal.php';

// Memanggil file Presenter.
require_once __DIR__ . '/presenters/PresenterKandidat.php';
require_once __DIR__ . '/presenters/PresenterJadwal.php';

// Membuat objek Model Kandidat dan Jadwal Interview.
$modelKandidat = new TabelKandidat('localhost', 'mvp_kandidat_db', 'root', '');
$modelJadwal = new TabelJadwal('localhost', 'mvp_kandidat_db', 'root', '');

// Membuat objek View Kandidat dan Jadwal Interview.
$viewKandidat = new ViewKandidat();
$viewJadwal = new ViewJadwal();

// Membuat objek Presenter Kandidat dan Jadwal Interview.
$presenterKandidat = new PresenterKandidat($modelKandidat, $viewKandidat);
$presenterJadwal = new PresenterJadwal($modelJadwal, $modelKandidat, $viewJadwal);

// Memeriksa apakah terdapat permintaan POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Menangani aksi data kandidat.
    if ($action === 'tambah') {
        $presenterKandidat->tambahKandidat(
            $_POST['nama'],
            $_POST['posisi'],
            $_POST['domisili'],
            (int)$_POST['skorTes'],
            (int)$_POST['pengalamanTahun']
        );

    } elseif ($action === 'ubah') {
        $presenterKandidat->ubahKandidat(
            (int)$_POST['id'],
            $_POST['nama'],
            $_POST['posisi'],
            $_POST['domisili'],
            (int)$_POST['skorTes'],
            (int)$_POST['pengalamanTahun']
        );

    } elseif ($action === 'hapus') {
        $presenterKandidat->hapusKandidat((int)$_POST['id']);

    // Menangani aksi jadwal interview.
    } elseif ($action === 'tambah_jadwal') {
        $presenterJadwal->tambahJadwal(
            (int)$_POST['id'],
            $_POST['nama_interviewer'],
            $_POST['jenis_interview'],
            str_replace('T', ' ', $_POST['tanggal']),
            $_POST['status_interview']
        );

    } elseif ($action === 'ubah_jadwal') {
        $presenterJadwal->ubahJadwal(
            (int)$_POST['id_interview'],
            (int)$_POST['id'],
            $_POST['nama_interviewer'],
            $_POST['jenis_interview'],
            str_replace('T', ' ', $_POST['tanggal']),
            $_POST['status_interview']
        );

    } elseif ($action === 'hapus_jadwal') {
        $presenterJadwal->hapusJadwal((int)$_POST['id_interview']);
    }

    // Mengarahkan kembali pengguna jika aksi tidak melakukan redirect.
    header("Location: index.php");
    exit();

} else {
    // Mengambil halaman yang ingin ditampilkan.
    $screen = $_GET['screen'] ?? 'list';

    // Menampilkan halaman data kandidat.
    if ($screen === 'add') {
        echo $presenterKandidat->tampilkanFormKandidat();

    } elseif ($screen === 'edit' && isset($_GET['id'])) {
        echo $presenterKandidat->tampilkanFormKandidat((int)$_GET['id']);

    } elseif ($screen === 'list') {
        echo $presenterKandidat->tampilkanKandidat();

    // Menampilkan halaman jadwal interview.
    } elseif ($screen === 'add_jadwal') {
        echo $presenterJadwal->tampilkanFormJadwal();

    } elseif ($screen === 'edit_jadwal' && isset($_GET['id'])) {
        echo $presenterJadwal->tampilkanFormJadwal((int)$_GET['id']);

    } elseif ($screen === 'list_jadwal') {
        echo $presenterJadwal->tampilkanJadwal();

    } else {
        echo $presenterKandidat->tampilkanKandidat();
    }
}
?>