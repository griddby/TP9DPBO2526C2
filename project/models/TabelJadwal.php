<?php
require_once __DIR__ . '/DB.php';
require_once __DIR__ . '/KontrakJadwal.php';
require_once __DIR__ . '/JadwalInterview.php';

class TabelJadwal extends DB implements KontrakJadwal {
    // Constructor untuk menginisialisasi koneksi database.
    public function __construct(
        string $host = "localhost",
        string $db_name = "mvp_kandidat_db",
        string $username = "root",
        string $password = ""
    ) {
        parent::__construct($host, $db_name, $username, $password);
    }

    // Mengubah satu baris hasil query menjadi objek JadwalInterview.
    private function mapRowToJadwal(array $row): JadwalInterview {
        return new JadwalInterview(
            (int)$row['id_interview'],
            (int)$row['id'],
            $row['nama_kandidat'],
            $row['nama_interviewer'],
            $row['jenis_interview'],
            $row['tanggal'],
            $row['status_interview']
        );
    }

    // Mengambil seluruh data jadwal interview beserta nama kandidat.
    public function getAllJadwal(): array {
        $query = "SELECT jadwal_interview.*, kandidat.nama AS nama_kandidat
                FROM jadwal_interview
                INNER JOIN kandidat ON jadwal_interview.id = kandidat.id
                ORDER BY jadwal_interview.tanggal DESC, jadwal_interview.id_interview ASC";

        $this->executeQuery($query);
        $rows = $this->getAllResult();
        // Mengubah setiap baris hasil query menjadi objek JadwalInterview.
        $list = [];
        foreach ($rows as $row) {
            $list[] = $this->mapRowToJadwal($row);
        }
        return $list;
    }

    // Mengambil satu data jadwal interview berdasarkan ID jadwal.
    public function getJadwalById(int $id_interview): ?JadwalInterview {
        $query = "SELECT jadwal_interview.*, kandidat.nama AS nama_kandidat
                FROM jadwal_interview
                INNER JOIN kandidat ON jadwal_interview.id = kandidat.id
                WHERE jadwal_interview.id_interview = :id_interview
                LIMIT 1";

        $this->executeQuery($query, [':id_interview' => $id_interview]);
        $rows = $this->getAllResult();
        // Mengembalikan null jika data jadwal tidak ditemukan.
        if (empty($rows)) {
            return null;
        }
        // Mengubah hasil query menjadi objek JadwalInterview.
        return $this->mapRowToJadwal($rows[0]);
    }

    // Menambahkan data jadwal interview baru ke database.
    public function addJadwal(int $id, string $nama_interviewer, string $jenis_interview, string $tanggal, string $status_interview): void {
        $query = "INSERT INTO jadwal_interview(id, nama_interviewer, jenis_interview, tanggal, status_interview) VALUES(:id, :nama_interviewer, :jenis_interview, :tanggal, :status_interview)";
        $this->executeQuery($query, [':id' => $id, ':nama_interviewer' => $nama_interviewer, ':jenis_interview' => $jenis_interview, ':tanggal' => $tanggal, ':status_interview' => $status_interview]);
    }

    // Memperbarui data jadwal interview berdasarkan ID jadwal.
    public function updateJadwal(int $id_interview, int $id, string $nama_interviewer, string $jenis_interview, string $tanggal, string $status_interview): void {
        $query = "UPDATE jadwal_interview SET id = :id, nama_interviewer = :nama_interviewer, jenis_interview = :jenis_interview, tanggal = :tanggal, status_interview = :status_interview WHERE id_interview = :id_interview";
        $this->executeQuery($query, [':id_interview' => $id_interview, ':id' => $id, ':nama_interviewer' => $nama_interviewer, ':jenis_interview' => $jenis_interview, ':tanggal' => $tanggal, ':status_interview' => $status_interview]);
    }

    // Menghapus data jadwal interview berdasarkan ID jadwal.
    public function deleteJadwal(int $id_interview): void {
        $query = "DELETE FROM jadwal_interview WHERE id_interview = :id_interview";
        $this->executeQuery($query, [':id_interview' => $id_interview]);
    }
}
?>