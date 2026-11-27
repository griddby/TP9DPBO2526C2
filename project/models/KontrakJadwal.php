<?php
interface KontrakJadwal {
    /**
     * Mengambil seluruh data kandidat sebagai array objek Kandidat.
     * @return JadwalInterview[]
     */

    // Mengambil seluruh data jadwal interview.
    public function getAllJadwal(): array;

    // Mengambil data jadwal interview berdasarkan ID jadwal.
    public function getJadwalById(int $id_interview): ?JadwalInterview;

    // Menambahkan data jadwal interview baru.
    public function addJadwal(int $id, string $nama_interviewer, string $jenis_interview, string $tanggal, string $status_interview): void;

    // Memperbarui data jadwal interview berdasarkan ID jadwal.
    public function updateJadwal(int $id_interview, int $id, string $nama_interviewer, string $jenis_interview, string $tanggal, string $status_interview): void;

    // Menghapus data jadwal interview berdasarkan ID jadwal.
    public function deleteJadwal(int $id_interview): void;
}
?>