<?php
require_once __DIR__ . '/KontrakPresenterJadwal.php';
require_once __DIR__ . '/../models/KontrakJadwal.php';
require_once __DIR__ . '/../models/KontrakModel.php';
require_once __DIR__ . '/../models/JadwalInterview.php';
require_once __DIR__ . '/../views/KontrakViewJadwal.php';

class PresenterJadwal implements KontrakPresenterJadwal {
    // Menyimpan objek Model Jadwal, Model Kandidat, dan View.
    private KontrakJadwal $model;
    private KontrakModel $modelKandidat;
    private KontrakViewJadwal $view;

    // Constructor untuk menerima Model dan View melalui dependency injection.
    public function __construct(KontrakJadwal $model, KontrakModel $modelKandidat, KontrakViewJadwal $view) {
        $this->model = $model;
        $this->modelKandidat = $modelKandidat;
        $this->view = $view;
    }

    // Membuat satu baris HTML untuk menampilkan data jadwal interview.
    private function buildRowHtml(int $no, JadwalInterview $jadwal): string {
        $id_interview = (int)$jadwal->getIdInterview();
        $nama_kandidat = htmlspecialchars($jadwal->getNamaKandidat());
        $nama_interviewer = htmlspecialchars($jadwal->getNamaInterviewer());
        $jenis_interview = htmlspecialchars($jadwal->getJenisInterview());
        $tanggal = htmlspecialchars($jadwal->getTanggal());
        $status_interview = htmlspecialchars($jadwal->getStatusInterview());

        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$nama_kandidat}</strong></td>
            <td>{$nama_interviewer}</td>
            <td>{$jenis_interview}</td>
            <td>{$tanggal}</td>
            <td>{$status_interview}</td>
            <td class='col-actions'>
                <a href='index.php?screen=edit_jadwal&id={$id_interview}' class='btn btn-edit'>Edit</a>

                <form method='post' action='index.php' style='display:inline;' onsubmit=\"return confirm('Hapus jadwal interview ini?')\">
                    <input type='hidden' name='action' value='hapus_jadwal'>
                    <input type='hidden' name='id_interview' value='{$id_interview}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    // Mengambil seluruh data jadwal dan menampilkannya dalam bentuk tabel.
    public function tampilkanJadwal(): string {
        $listJadwal = $this->model->getAllJadwal();
        $totalJadwal = count($listJadwal);
        $rowsHtml = '';

        // Memeriksa apakah terdapat data jadwal.
        if (empty($listJadwal)) {
            $rowsHtml = '<tr><td colspan="7" style="text-align:center;color:#6b7280;padding:24px;">Belum ada data jadwal.</td></tr>';
        } else {
            $no = 1;

            // Membuat baris HTML untuk setiap jadwal.
            foreach ($listJadwal as $jadwal) {
                $rowsHtml .= $this->buildRowHtml($no, $jadwal);
                $no++;
            }
        }
        return $this->view->renderDaftar($rowsHtml, $totalJadwal);
    }

    // Menampilkan form tambah atau ubah jadwal interview.
    public function tampilkanFormJadwal(?int $id_interview = null): string {
        // Mengambil seluruh data kandidat dari Model.
        $kandidatObjects = $this->modelKandidat->getAllKandidat();
        $pilihanKandidat = '<option value="">-- Pilih Kandidat --</option>';
        // Membuat pilihan kandidat untuk dropdown.
        foreach ($kandidatObjects as $kandidat) {
            $idKandidat = (int)$kandidat->getId();
            $namaKandidat = htmlspecialchars($kandidat->getNama());

            $pilihanKandidat .= "<option value='{$idKandidat}'>{$namaKandidat}</option>";
        }

        // Memeriksa apakah form digunakan untuk mengubah jadwal.
        if ($id_interview !== null) {
            // Mengambil data jadwal berdasarkan ID jadwal interview.
            $jadwal = $this->model->getJadwalById($id_interview);

            // Mengarahkan pengguna jika jadwal tidak ditemukan.
            if ($jadwal === null) {
                header("Location: index.php?screen=list_jadwal");
                exit();
            }

            // Menyusun data jadwal untuk dikirimkan ke View.
            $formData = [
                'id_interview' => $jadwal->getIdInterview(),
                'id' => $jadwal->getId(),
                'nama_interviewer' => $jadwal->getNamaInterviewer(),
                'jenis_interview' => $jadwal->getJenisInterview(),
                'tanggal' => str_replace(' ', 'T', substr($jadwal->getTanggal(), 0, 16)),
                'status_interview' => $jadwal->getStatusInterview()
            ];

            // Menandai kandidat yang sedang dipilih.
            $pilihanKandidat = str_replace(
                "value='{$jadwal->getId()}'",
                "value='{$jadwal->getId()}' selected",
                $pilihanKandidat
            );

            // Menampilkan form ubah jadwal interview.
            return $this->view->renderForm("Ubah Jadwal Interview", "ubah_jadwal", $formData, $pilihanKandidat);
        }
        // Menampilkan form tambah jadwal interview.
        return $this->view->renderForm("Tambah Jadwal Baru", "tambah_jadwal", [], $pilihanKandidat);
    }


    // Menambahkan jadwal interview baru melalui Model.
    public function tambahJadwal(int $id, string $nama_interviewer, string $jenis_interview, string $tanggal, string $status_interview): void {
        $this->model->addJadwal($id, $nama_interviewer, $jenis_interview, $tanggal, $status_interview);
        header("Location: index.php?screen=list_jadwal");
        exit();
    }

    // Memperbarui jadwal interview berdasarkan ID jadwal.
    public function ubahJadwal(int $id_interview, int $id, string $nama_interviewer, string $jenis_interview, string $tanggal, string $status_interview): void {
        $this->model->updateJadwal($id_interview, $id, $nama_interviewer, $jenis_interview, $tanggal, $status_interview);
        header("Location: index.php?screen=list_jadwal");
        exit();
    }

    // Menghapus jadwal interview berdasarkan ID jadwal.
    public function hapusJadwal(int $id_interview): void {
        $this->model->deleteJadwal($id_interview);
        header("Location: index.php?screen=list_jadwal");
        exit();
    }
}
?>