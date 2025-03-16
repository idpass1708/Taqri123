CREATE DATABASE kehadiran_taqri;
USE kehadiran_taqri;

CREATE TABLE peserta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    nomor_wa VARCHAR(20) NOT NULL UNIQUE,
    juz INT NOT NULL
);
