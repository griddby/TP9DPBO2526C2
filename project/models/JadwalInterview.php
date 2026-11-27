<?php
class JadwalInterview {
    // Atribut untuk menyimpan data jadwal interview.
    private ?int $id_interview;        // Primary Key jadwal interview.
    private int $id;                   // Foreign Key yang menghubungkan jadwal dengan kandidat.
    private string $nama_kandidat;     // Nama kandidat yang mengikuti interview.
    private string $nama_interviewer;  // Nama pewawancara.
    private string $jenis_interview;   // Jenis interview.
    private string $tanggal;           // Tanggal dan waktu pelaksanaan interview.
    private string $status_interview;  // Status pelaksanaan interview.

    // Constructor untuk menginisialisasi seluruh atribut objek JadwalInterview.
    public function __construct(
        ?int $id_interview,
        int $id,
        string $nama_kandidat,
        string $nama_interviewer,
        string $jenis_interview,
        string $tanggal,
        string $status_interview
    ) {
        $this->id_interview = $id_interview;
        $this->id = $id;
        $this->nama_kandidat = $nama_kandidat;
        $this->nama_interviewer = $nama_interviewer;
        $this->jenis_interview = $jenis_interview;
        $this->tanggal = $tanggal;
        $this->status_interview = $status_interview;
    }

    // Getter untuk mengambil nilai setiap atribut.
    public function getIdInterview(): ?int {
        return $this->id_interview;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getNamaKandidat(): string {
        return $this->nama_kandidat;
    }

    public function getNamaInterviewer(): string {
        return $this->nama_interviewer;
    }

    public function getJenisInterview(): string {
        return $this->jenis_interview;
    }

    public function getTanggal(): string {
        return $this->tanggal;
    }

    public function getStatusInterview(): string {
        return $this->status_interview;
    }

    // Setter untuk mengubah atribut yang dapat diperbarui.
    public function setNamaInterviewer(string $nama_interviewer): void {
        $this->nama_interviewer = $nama_interviewer;
    }

    public function setJenisInterview(string $jenis_interview): void {
        $this->jenis_interview = $jenis_interview;
    }

    public function setTanggal(string $tanggal): void {
        $this->tanggal = $tanggal;
    }

    public function setStatusInterview(string $status_interview): void {
        $this->status_interview = $status_interview;
    }
}
?>