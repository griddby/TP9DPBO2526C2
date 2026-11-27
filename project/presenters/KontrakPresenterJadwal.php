<?php
interface KontrakPresenterJadwal {
    // Menampilkan seluruh data jadwal interview.
    public function tampilkanJadwal(): string;

    // Menampilkan form untuk menambahkan atau mengubah jadwal interview.
    public function tampilkanFormJadwal(?int $id_interview = null): string;

    // Menambahkan data jadwal interview baru.
    public function tambahJadwal(int $id, string $nama_interviewer, string $jenis_interview, string $tanggal, string $status_interview): void;

    // Mengubah data jadwal interview berdasarkan ID jadwal.
    public function ubahJadwal(int $id_interview, int $id, string $nama_interviewer, string $jenis_interview, string $tanggal, string $status_interview): void;

    // Menghapus data jadwal interview berdasarkan ID jadwal.
    public function hapusJadwal(int $id_interview): void;
}
?>