DROP DATABASE IF EXISTS ELECTION;
CREATE DATABASE ELECTION;
CREATE USER IF NOT EXISTS 'ElectionAdmin'@'localhost' IDENTIFIED BY '12345';
GRANT ALL PRIVILEGES ON ELECTION.* TO 'ElectionAdmin'@'localhost';

USE ELECTION;

CREATE TABLE vereador ( numero INT PRIMARY KEY,
                        nome TEXT,
                        partido TEXT,
                        foto TEXT,
                        votos INT 
                        );

CREATE TABLE prefeito ( numero INT PRIMARY KEY,
                        nome TEXT,
                        partido TEXT,
                        foto TEXT,
                        votos INT,
                        vice TEXT,
                        fotoVice TEXT,
                        partidoVice TEXT 
                        );

INSERT INTO vereador VALUES (51222, 'Christianne Varão', 'PEN', "cv1.jpg", 0);
INSERT INTO vereador VALUES (55555, 'Homero do Zé Filho', 'PSL', "cv2.jpg", 0);
INSERT INTO vereador VALUES (43333, 'Dandor', 'PV', "cv3.jpg", 0);
INSERT INTO vereador VALUES (15123, 'Filho', 'MDB', "cv4.jpg", 0);
INSERT INTO vereador VALUES (27222, 'Joel Varão', 'PSDC', "cv5.jpg", 0);
INSERT INTO vereador VALUES (45000, 'Professor Clebson Almeida', 'PSDB', "cv6.jpg", 0);

INSERT INTO prefeito VALUES (12, 'Chiquinho do Adbon', 'PDT', 'cp3.jpg', 0, 'Arão', 'v3.jpg', 'PRP');
INSERT INTO prefeito VALUES (15, 'Malrinete Gralhada', 'MDB', 'cp2.jpg', 0, 'Biga', 'v2.jpg', 'MDB');
INSERT INTO prefeito VALUES (45, 'Dr. Francisco', 'PSC', 'cp1.jpg', 0, 'João Rodrigues', 'v1.jpg', 'PV');
INSERT INTO prefeito VALUES (54, 'Zé Lopes', 'PPL', 'cp4.jpg', 0, 'Francisca Ferreira Ramos', 'v4.jpg', 'PPL');
INSERT INTO prefeito VALUES (65, 'Lindomar Pescador', 'PC do B', 'cp5.jpg', 0, 'Malú', 'v5.jpg', 'PC do B');