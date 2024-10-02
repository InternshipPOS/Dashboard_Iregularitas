-- Membuat database dengan nama iregularitas
CREATE DATABASE IF NOT EXISTS iregularitas;

-- Menggunakan database iregularitas
USE iregularitas;

-- Membuat tabel regional1 dengan kolom dan tipe data yang sesuai
CREATE TABLE IF NOT EXISTS regional1 (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_sistem VARCHAR(255) NOT NULL,
    reg_asal_p6 VARCHAR(255) NOT NULL,
    kantor_asal_p6 VARCHAR(255) NOT NULL,
    nopend_asal_p6 VARCHAR(255) NOT NULL,
    tanggal_berita_acara DATETIME NOT NULL,   -- Format 'yyyy/mm/dd hh:mm:ss'
    bulan VARCHAR(50),                        -- Menyimpan nama bulan
    week VARCHAR(5),                          -- Format seperti 'W01'
    tahun YEAR,                               -- Tahun
    reg_tujuan_p6 VARCHAR(255) NOT NULL,
    kantor_tujuan_p6 VARCHAR(255) NOT NULL,
    nopend_tujuan_p6 VARCHAR(255) NOT NULL,
    deskripsi TEXT,                           -- Deskripsi panjang
    dnln VARCHAR(50),                         -- Bisa disesuaikan jika berupa enum atau angka
    nomor_kiriman VARCHAR(255),               -- Format nomor atau teks
    uraian_berita_acara TEXT,                 -- Kolom tambahan untuk uraian berita acara
    deskripsi_iregularitas TEXT,              -- Kolom tambahan untuk deskripsi iregularitas
    rincian_root_cause TEXT,                  -- Kolom tambahan untuk rincian root cause
    referensi_root_cause VARCHAR(255),        -- Kolom tambahan untuk referensi root cause
    tindakan_pencegahan TEXT,                 -- Kolom tambahan untuk tindakan pencegahan
    corrective_action VARCHAR(255),           -- Kolom tambahan untuk corrective action
    locus VARCHAR(255),                       -- Kolom tambahan untuk locus
    nama_nik_pegawai VARCHAR(255),            -- Kolom tambahan untuk nama NIK pegawai
    nomor_evidence VARCHAR(255),              -- Kolom tambahan untuk nomor evidence
    validasi_regional VARCHAR(50),            -- Kolom tambahan untuk validasi regional
    validasi_pusat VARCHAR(50)                -- Kolom tambahan untuk validasi pusat
);

-- Contoh memasukkan data ke dalam tabel regional1
INSERT INTO regional1 
    (id_sistem, reg_asal_p6, kantor_asal_p6, nopend_asal_p6, tanggal_berita_acara, bulan, week, tahun, reg_tujuan_p6, kantor_tujuan_p6, nopend_tujuan_p6, deskripsi, dnln, nomor_kiriman, uraian_berita_acara, deskripsi_iregularitas, rincian_root_cause, referensi_root_cause, tindakan_pencegahan, corrective_action, locus, nama_nik_pegawai, nomor_evidence, validasi_regional, validasi_pusat)
VALUES 
    ('ID001', 'Reg Asal 1', 'Kantor Asal 1', 'NoPend Asal 1', STR_TO_DATE('05-01-2023 15:04:40', '%d-%m-%Y %H:%i:%s'), 'Januari', 'W01', 2023, 'Reg Tujuan 1', 'Kantor Tujuan 1', 'NoPend Tujuan 1', 'Deskripsi Contoh', 'DNLN1', 'No Kiriman 1', 'Uraian Berita Acara 1', 'Deskripsi Iregularitas 1', 'Rincian Root Cause 1', 'Referensi Root Cause 1', 'Tindakan Pencegahan 1', 'Corrective Action 1', 'Locus 1', 'Nama NIK Pegawai 1', 'Nomor Evidence 1', 'Validasi Regional 1', 'Validasi Pusat 1'),
    ('ID002', 'Reg Asal 2', 'Kantor Asal 2', 'NoPend Asal 2', STR_TO_DATE('06-02-2023 10:30:45', '%d-%m-%Y %H:%i:%s'), 'Februari', 'W02', 2023, 'Reg Tujuan 2', 'Kantor Tujuan 2', 'NoPend Tujuan 2', 'Deskripsi Contoh 2', 'DNLN2', 'No Kiriman 2', 'Uraian Berita Acara 2', 'Deskripsi Iregularitas 2', 'Rincian Root Cause 2', 'Referensi Root Cause 2', 'Tindakan Pencegahan 2', 'Corrective Action 2', 'Locus 2', 'Nama NIK Pegawai 2', 'Nomor Evidence 2', 'Validasi Regional 2', 'Validasi Pusat 2');

-- Contoh mengambil data dari tabel regional1
SELECT 
    id_sistem,
    reg_asal_p6,
    kantor_asal_p6,
    nopend_asal_p6,
    DATE_FORMAT(tanggal_berita_acara, '%d-%m-%Y %H:%i:%s') AS tanggal_berita_acara,  -- Format output tanggal dengan detik
    bulan,
    week,
    tahun,
    reg_tujuan_p6,
    kantor_tujuan_p6,
    nopend_tujuan_p6,
    deskripsi,
    dnln,
    nomor_kiriman,
    uraian_berita_acara,
    deskripsi_iregularitas,
    rincian_root_cause,
    referensi_root_cause,
    tindakan_pencegahan,
    corrective_action,
    locus,
    nama_nik_pegawai,
    nomor_evidence,
    validasi_regional,
    validasi_pusat
FROM 
    regional1;

