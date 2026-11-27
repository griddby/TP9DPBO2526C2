-- Database: mvp_kandidat_db
CREATE DATABASE IF NOT EXISTS `mvp_kandidat_db`;
USE `mvp_kandidat_db`;

CREATE TABLE IF NOT EXISTS `kandidat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `posisi` varchar(100) NOT NULL,
  `domisili` varchar(100) NOT NULL,
  `skorTes` int(11) NOT NULL DEFAULT 0,
  `pengalamanTahun` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `jadwal_interview`(
  `id_interview` INT AUTO_INCREMENT PRIMARY KEY,
  `id` INT NOT NULL,
  `nama_interviewer` VARCHAR(100) NOT NULL,
  `jenis_interview` ENUM('HR Interview', 'User Interview','Technical Interview') NOT NULL,
  `tanggal` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status_interview` ENUM('Dijadwalkan', 'Selesai', 'Dibatalkan') NOT NULL DEFAULT 'Dijadwalkan',
  FOREIGN KEY(id) REFERENCES kandidat(id)
);

INSERT INTO `kandidat` (`id`, `nama`, `posisi`, `domisili`, `skorTes`, `pengalamanTahun`) VALUES
(1, 'Raka Pratama', 'Backend Developer', 'Bandung', 92, 3),
(2, 'Sinta Maharani', 'UI/UX Designer', 'Jakarta', 88, 2),
(3, 'Dimas Nugroho', 'Data Analyst', 'Yogyakarta', 85, 1),
(4, 'Nadia Kusuma', 'Frontend Developer', 'Surabaya', 90, 2),
(5, 'Bagas Setiawan', 'QA Engineer', 'Bandung', 81, 1);

INSERT INTO `jadwal_interview` (`id`, `nama_interviewer`, `jenis_interview`, `tanggal`, `status_interview`) VALUES
(1, 'Andi Saputra', 'HR Interview', '2026-12-01 09:00:00', 'Dijadwalkan'),
(2, 'Dewi Anggraini', 'HR Interview', '2026-12-01 10:00:00', 'Dijadwalkan'),
(3, 'Budi Santoso', 'Technical Interview', '2026-12-02 13:00:00', 'Dijadwalkan'),
(4, 'Rina Amelia', 'User Interview', '2026-12-03 09:30:00', 'Dijadwalkan'),
(5, 'Andi Saputra', 'Technical Interview', '2026-12-04 14:00:00', 'Dijadwalkan');