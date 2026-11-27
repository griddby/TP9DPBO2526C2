<?php
require_once __DIR__ . '/KontrakPresenter.php';
require_once __DIR__ . '/../models/KontrakModel.php';
require_once __DIR__ . '/../views/KontrakView.php';

class PresenterKandidat implements KontrakPresenter {
    // Menyimpan objek Model dan View.
    private KontrakModel $model;
    private KontrakView $view;

    // Constructor untuk menerima objek Model dan View melalui dependency injection.
    public function __construct(KontrakModel $model, KontrakView $view) {
        $this->model = $model;
        $this->view = $view;
    }

    // Membuat satu baris HTML untuk menampilkan data kandidat pada tabel.
    private function buildRowHtml(int $no, Kandidat $kandidat): string {
        $id = (int)$kandidat->getId();
        $nama = htmlspecialchars($kandidat->getNama());
        $posisi = htmlspecialchars($kandidat->getPosisi());
        $domisili = htmlspecialchars($kandidat->getDomisili());
        $skorTes = number_format($kandidat->getSkorTes()) . ' / 100';
        $pengalaman = number_format($kandidat->getPengalamanTahun()) . ' Tahun';

        // Mengembalikan HTML berisi informasi kandidat beserta tombol Edit dan Hapus.
        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$nama}</strong></td>
            <td>{$posisi}</td>
            <td>{$domisili}</td>
            <td>{$skorTes}</td>
            <td>{$pengalaman}</td>
            <td class='col-actions'>
                <a href='index.php?screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
                <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus kandidat ini?')\">
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    // Mengambil seluruh data kandidat dan menampilkannya dalam bentuk tabel.
    public function tampilkanKandidat(): string {
        // Mengambil seluruh data kandidat dari Model.
        $listKandidat = $this->model->getAllKandidat();

        // Menghitung jumlah seluruh kandidat.
        $totalKandidat = count($listKandidat);
        $rowsHtml = '';

        // Memeriksa apakah data kandidat tersedia.
        if (empty($listKandidat)) {
            $rowsHtml = '<tr><td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data kandidat.</td></tr>';
        } else {
            // Membuat baris HTML untuk setiap kandidat.
            $no = 1;
            foreach ($listKandidat as $kandidat) {
                $rowsHtml .= $this->buildRowHtml($no, $kandidat);
                $no++;
            }
        }
        // Mengirimkan HTML tabel dan jumlah kandidat ke View.
        return $this->view->renderDaftar($rowsHtml, $totalKandidat);
    }

    // Menampilkan form untuk menambahkan atau mengubah data kandidat.
    public function tampilkanFormKandidat(?int $id = null): string {
        // Memeriksa apakah form digunakan untuk mengubah data kandidat.
        if ($id !== null) {
            // Mengambil data kandidat berdasarkan ID.
            $kandidat = $this->model->getKandidatById($id);
            // Mengarahkan pengguna ke halaman utama jika kandidat tidak ditemukan.
            if ($kandidat === null) {
                header("Location: index.php");
                exit();
            }

            // Menyusun data kandidat untuk dikirimkan ke View.
            $formData = [
                'id' => $kandidat->getId(),
                'nama' => $kandidat->getNama(),
                'posisi' => $kandidat->getPosisi(),
                'domisili' => $kandidat->getDomisili(),
                'skorTes' => $kandidat->getSkorTes(),
                'pengalamanTahun' => $kandidat->getPengalamanTahun(),
            ];

            // Menampilkan form ubah data kandidat.
            return $this->view->renderForm("Ubah Data Kandidat", "ubah", $formData);
        }
        // Menampilkan form tambah kandidat dengan data kosong.
        return $this->view->renderForm("Tambah Kandidat Baru", "tambah", []);
    }

    // Menambahkan data kandidat baru melalui Model.
    public function tambahKandidat(string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $this->model->addKandidat($nama, $posisi, $domisili, $skorTes, $pengalamanTahun);
        // Mengarahkan kembali pengguna ke halaman utama setelah data ditambahkan.
        header("Location: index.php");
        exit();
    }

    // Memperbarui data kandidat berdasarkan ID melalui Model.
    public function ubahKandidat(int $id, string $nama, string $posisi, string $domisili, int $skorTes, int $pengalamanTahun): void {
        $this->model->updateKandidat($id, $nama, $posisi, $domisili, $skorTes, $pengalamanTahun);
        // Mengarahkan kembali pengguna ke halaman utama setelah data diperbarui.
        header("Location: index.php");
        exit();
    }

    // Menghapus data kandidat berdasarkan ID melalui Model.
    public function hapusKandidat(int $id): void {
        $this->model->deleteKandidat($id);
        // Mengarahkan kembali pengguna ke halaman utama setelah data dihapus.
        header("Location: index.php");
        exit();
    }
}
?>