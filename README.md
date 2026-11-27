# Tugas Praktikum 9 DPBO

## Janji

Saya Ingrid Gabryella Nainggolan dengan NIM 2506442 mengerjakan TP 9 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin

## Deskripsi Program

Recruitment System merupakan aplikasi berbasis web sederhana yang dikembangkan menggunakan PHP Native dengan konsep Object-Oriented Programming (OOP) dan arsitektur Model–View–Presenter (MVP).

Aplikasi ini digunakan untuk mengelola data kandidat dan jadwal interview dalam proses rekrutmen. Pengelolaan data menerapkan fitur CRUD (*Create, Read, Update, Delete*) yang terhubung dengan database MySQL.

---

# 1. Desain Program

## 1.1 Fitur Aplikasi

Aplikasi memiliki dua fitur utama:

- **Data Kandidat:** Mengelola informasi kandidat yang meliputi nama, posisi, domisili, skor tes, dan pengalaman kerja.
- **Jadwal Interview:** Mengelola jadwal wawancara kandidat yang meliputi nama kandidat, nama interviewer, jenis interview, tanggal interview, dan status interview.

Kedua fitur memiliki operasi CRUD untuk menambahkan, menampilkan, mengubah, dan menghapus data.

## 1.2 Arsitektur MVP

Aplikasi menerapkan arsitektur Model–View–Presenter (MVP) yang membagi tanggung jawab program menjadi tiga komponen:

| Komponen | Fungsi |
|---|---|
| Model | Mengelola data dan menjalankan query database. |
| View | Menampilkan antarmuka dan data yang diterima dari Presenter. |
| Presenter | Menghubungkan Model dengan View serta mengolah data sebelum ditampilkan. |

Komunikasi antar komponen menggunakan contract atau interface. Aplikasi juga menerapkan prinsip **Strict Passive View**, yaitu View tidak berhubungan langsung dengan Model maupun entity class. Seluruh pengolahan data dilakukan oleh Presenter sebelum diteruskan ke View.

File `index.php` berfungsi sebagai pengatur alur aplikasi untuk menangani request POST dan menentukan halaman yang akan ditampilkan.

## 1.3 Desain Database

Database yang digunakan bernama `mvp_kandidat_db` dan memiliki dua tabel:

### A. kandidat

| Atribut | Tipe Data | Keterangan |
|---|---|---|
| id | INT | Primary Key |
| nama | VARCHAR(100) | Nama kandidat |
| posisi | VARCHAR(100) | Posisi yang dilamar |
| domisili | VARCHAR(100) | Domisili kandidat |
| skorTes | INT | Nilai hasil tes |
| pengalamanTahun | INT | Pengalaman kerja dalam tahun |

### B. jadwal_interview

| Atribut | Tipe Data | Keterangan |
|---|---|---|
| id_interview | INT | Primary Key |
| id | INT | Foreign Key |
| nama_interviewer | VARCHAR(100) | Nama pewawancara |
| jenis_interview | ENUM | Jenis interview |
| tanggal | DATETIME | Tanggal dan waktu interview |
| status_interview | ENUM | Status interview |

Tabel `jadwal_interview` memiliki relasi dengan tabel `kandidat` melalui atribut `id` sebagai Foreign Key yang mengacu pada Primary Key `id` di tabel kandidat. Dengan demikian, setiap jadwal interview terhubung dengan kandidat yang terdaftar.

## 1.4 Struktur Folder

### Struktur Project

```text
TP9DBPO2526/
│
├── mvp_kandidat_db.sql             # Perintah SQL untuk membuat database, tabel, dan data awal.
├── README.md                       # Dokumentasi project.
│
├── Dokumentasi/
│   └── Dokumentasi_TP9.mp4             # Dokumentasi proses CRUD aplikasi.
│
└── Project/
    │
    ├── index.php                   # Halaman utama sekaligus pengatur alur aplikasi.
    │
    ├── models/
    │   ├── DB.php                  # Mengatur koneksi dan eksekusi query database.
    │   ├── Kandidat.php            # Entity untuk menyimpan atribut data kandidat.
    │   ├── JadwalInterview.php     # Entity untuk menyimpan atribut jadwal interview.
    │   ├── KontrakModel.php        # Interface untuk operasi Model kandidat.
    │   ├── KontrakJadwal.php       # Interface untuk operasi Model jadwal interview.
    │   ├── TabelKandidat.php       # Mengelola CRUD tabel kandidat.
    │   └── TabelJadwal.php         # Mengelola CRUD tabel jadwal interview.
    │
    ├── presenters/
    │   ├── KontrakPresenter.php    # Interface Presenter kandidat.
    │   ├── PresenterKandidat.php   # Mengatur proses pengelolaan data kandidat.
    │   ├── KontrakPresenterJadwal.php # Interface Presenter jadwal interview.
    │   └── PresenterJadwal.php    # Mengatur proses pengelolaan jadwal interview.
    │
    ├── views/
    │   ├── KontrakView.php         # Interface View kandidat.
    │   ├── ViewKandidat.php        # Menampilkan halaman data kandidat.
    │   ├── KontrakViewJadwal.php   # Interface View jadwal interview.
    │   └── ViewJadwal.php          # Menampilkan halaman jadwal interview.
    │
    └── template/
        ├── skin.html               # Template daftar kandidat.
        ├── form.html               # Template form kandidat.
        ├── skin_jadwal.html        # Template daftar jadwal interview.
        └── form_jadwal.html        # Template form jadwal interview.
```
---

# 2. Alur Program

## 2.1 Alur MVP

Secara umum, proses aplikasi berjalan melalui tahapan berikut:

```text
          USER
            |
            v
         index.php
       (Router Utama)
            |
            v
         PRESENTER
          /     \
         v       v
      MODEL     VIEW
         |
         v
      DATABASE
         |
         v
       MODEL
         |
         v
      PRESENTER
         |
         v
        VIEW
         |
         v
   TAMPILAN APLIKASI
```

1. Pengguna mengakses aplikasi melalui browser.
2. `index.php` menentukan halaman atau aksi yang diminta.
3. Presenter menerima permintaan dan memanggil Model jika membutuhkan data.
4. Model berinteraksi dengan database untuk mengambil atau mengolah data.
5. Hasil pengolahan dikembalikan kepada Presenter.
6. Presenter mengirimkan data yang telah disiapkan kepada View.
7. View menampilkan hasilnya kepada pengguna.

## 2.2 Alur CRUD

| Operasi | Alur Proses |
|---|---|
| Create | Pengguna mengisi form, Presenter menerima data, kemudian Model menjalankan INSERT. |
| Read | Presenter meminta data kepada Model, kemudian View menampilkan data dalam tabel. |
| Update | Pengguna memilih Edit, Presenter mengambil data lama untuk mengisi form, kemudian Model menjalankan UPDATE. |
| Delete | Pengguna memilih Hapus, Presenter memanggil Model untuk menjalankan DELETE. |

Seluruh proses penambahan, perubahan, dan penghapusan data dilakukan melalui request POST.

## 2.3 Alur Khusus Jadwal Interview

Fitur jadwal interview memiliki hubungan dengan data kandidat.

1. Presenter mengambil data kandidat melalui Model kandidat.
2. Presenter menyiapkan pilihan kandidat untuk ditampilkan pada dropdown.
3. Pengguna memilih kandidat dan mengisi informasi jadwal interview.
4. Presenter menerima data yang dikirim melalui form.
5. Model menyimpan jadwal interview ke database.
6. Untuk menampilkan nama kandidat pada daftar jadwal, Model menggunakan JOIN antara tabel `jadwal_interview` dan `kandidat`.

Dengan demikian, pengguna dapat memilih nama kandidat secara langsung tanpa harus memasukkan ID kandidat secara manual.

---

# 3. Dokumentasi Program

Dokumentasi proses Create, Read, Update, dan Delete pada aplikasi Recruitment System.
