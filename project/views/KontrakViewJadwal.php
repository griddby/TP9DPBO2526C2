<?php
interface KontrakViewJadwal {
    // Menampilkan daftar jadwal interview dalam bentuk tabel.
    public function renderDaftar(string $rowsHtml, int $totalJadwal): string;

    // Menampilkan form untuk menambahkan atau mengubah jadwal interview.
    public function renderForm(string $judul, string $action, array $formData = [], string $pilihanKandidat = ''): string;
}
?>