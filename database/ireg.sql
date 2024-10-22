CREATE DATABASE IF NOT EXISTS laporan_iregularitas;

USE laporan_iregularitas;

CREATE TABLE iregularitas (
    id_sistem INT AUTO_INCREMENT PRIMARY KEY,
    ZonaAsal VARCHAR(50),
    Nama_Kantor_Asal VARCHAR(100),
    Kantor_Asal VARCHAR(100),
    Tanggal_Berita_Acara DATE,
    ZonaTujuan VARCHAR(50),
    Nama_Kantor_Tujuan VARCHAR(100),
    Kantor_Tujuan VARCHAR(100),
    Deskripsi TEXT,
    DNLN ENUM('DN', 'LN'),
    Nomor_Kiriman VARCHAR(50),
    Uraian_Berita_Acara TEXT,
    Deskripsi_Iregularitas TEXT,
    Bulan_BA VARCHAR(20),
    Minggu_Ke INT
);
