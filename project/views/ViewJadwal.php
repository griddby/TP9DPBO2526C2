<?php
require_once __DIR__ . '/KontrakViewJadwal.php';

class ViewJadwal implements KontrakViewJadwal {
    // Menyimpan lokasi file template daftar dan form jadwal.
    private string $skinPath;
    private string $formPath;

    // Constructor untuk menentukan lokasi template.
    public function __construct(string $skinPath = '', string $formPath = '') {
        $this->skinPath = $skinPath ?: __DIR__ . '/../template/skin_jadwal.html';
        $this->formPath = $formPath ?: __DIR__ . '/../template/form_jadwal.html';
    }

    // Menampilkan daftar jadwal interview.
    public function renderDaftar(string $rowsHtml, int $totalJadwal): string {
        $template = file_get_contents($this->skinPath);

        if ($template === false) {
            throw new RuntimeException("Template daftar jadwal tidak ditemukan.");
        }

        // Mengganti placeholder pada template daftar jadwal.
        $tokens = [
            '{{TABLE_ROWS}}' => $rowsHtml,
            '{{TOTAL_DATA}}' => (string)$totalJadwal
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }

    // Menampilkan form tambah atau ubah jadwal interview.
    public function renderForm(string $title, string $action, array $formData = [], string $pilihanKandidat = ''): string {
        $template = file_get_contents($this->formPath);

        // Memastikan file template berhasil dibaca.
        if ($template === false) {
            throw new RuntimeException("Template form jadwal tidak ditemukan.");
        }

        // Mengambil data jenis dan status interview.
        $jenisInterview = $formData['jenis_interview'] ?? '';
        $statusInterview = $formData['status_interview'] ?? '';

        // Menyiapkan pasangan placeholder dan data form.
        $tokens = [
            '{{FORM_TITLE}}' => htmlspecialchars($title),
            '{{ACTION}}' => htmlspecialchars($action),
            '{{ID_INTERVIEW}}' => htmlspecialchars((string)($formData['id_interview'] ?? '')),
            '{{PILIHAN_KANDIDAT}}' => $pilihanKandidat,
            '{{NAMA_INTERVIEWER}}' => htmlspecialchars((string)($formData['nama_interviewer'] ?? '')),
            '{{TANGGAL}}' => htmlspecialchars((string)($formData['tanggal'] ?? '')),
            '{{HR_SELECTED}}' => ($jenisInterview === 'HR Interview') ? 'selected' : '',
            '{{USER_SELECTED}}' => ($jenisInterview === 'User Interview') ? 'selected' : '',
            '{{TECHNICAL_SELECTED}}' => ($jenisInterview === 'Technical Interview') ? 'selected' : '',
            '{{DIJADWALKAN_SELECTED}}' => ($statusInterview === 'Dijadwalkan') ? 'selected' : '',
            '{{SELESAI_SELECTED}}' => ($statusInterview === 'Selesai') ? 'selected' : '',
            '{{DIBATALKAN_SELECTED}}' => ($statusInterview === 'Dibatalkan') ? 'selected' : ''
        ];

        // Mengganti seluruh placeholder pada template form.
        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }
}
?>