-- ============================================================
-- SCRIPT DE CRIAÇÃO DO BANCO DE DADOS - CONSULTÓRIO ODONTOLÓGICO
-- BANCO DE DADOS: MySQL 8.0+
-- ============================================================

CREATE DATABASE IF NOT EXISTS consultorio_odontologico
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE consultorio_odontologico;

-- Desabilitar verificação de chaves estrangeiras temporariamente
SET FOREIGN_KEY_CHECKS = 0;

-- Drop de tabelas se já existirem
DROP TABLE IF EXISTS consulta_procedimentos;
DROP TABLE IF EXISTS pagamentos;
DROP TABLE IF EXISTS receitas_medicas;
DROP TABLE IF EXISTS consultas;
DROP TABLE IF EXISTS procedimentos;
DROP TABLE IF EXISTS prontuarios;
DROP TABLE IF EXISTS recepcionistas;
DROP TABLE IF EXISTS dentistas;
DROP TABLE IF EXISTS pacientes;
DROP TABLE IF EXISTS pessoas;

-- Reabilitar verificação de chaves estrangeiras
SET FOREIGN_KEY_CHECKS = 1;

-- ------------------------------------------------------------
-- 1. Tabela Base: pessoas (Tabela Pai)
-- ------------------------------------------------------------
CREATE TABLE pessoas (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cpf VARCHAR(11) NOT NULL UNIQUE,
    telefone VARCHAR(20),
    email VARCHAR(100),
    data_nascimento DATE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 2. Tabela: pacientes (Especialização de Pessoas)
-- ------------------------------------------------------------
CREATE TABLE pacientes (
    pessoa_id BIGINT PRIMARY KEY,
    convenio VARCHAR(100),
    historico_medico TEXT,
    CONSTRAINT fk_pacientes_pessoas FOREIGN KEY (pessoa_id)
        REFERENCES pessoas (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 3. Tabela: dentistas (Especialização de Pessoas)
-- ------------------------------------------------------------
CREATE TABLE dentistas (
    pessoa_id BIGINT PRIMARY KEY,
    cro VARCHAR(20) NOT NULL UNIQUE,
    especialidade VARCHAR(100),
    CONSTRAINT fk_dentistas_pessoas FOREIGN KEY (pessoa_id)
        REFERENCES pessoas (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 4. Tabela: recepcionistas (Especialização de Pessoas)
-- ------------------------------------------------------------
CREATE TABLE recepcionistas (
    pessoa_id BIGINT PRIMARY KEY,
    turno VARCHAR(50),
    CONSTRAINT fk_recepcionistas_pessoas FOREIGN KEY (pessoa_id)
        REFERENCES pessoas (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 5. Tabela: prontuarios
-- ------------------------------------------------------------
CREATE TABLE prontuarios (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    paciente_id BIGINT NOT NULL UNIQUE,
    odontograma TEXT,
    historico_evolucao TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_prontuarios_pacientes FOREIGN KEY (paciente_id)
        REFERENCES pacientes (pessoa_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 6. Tabela: procedimentos
-- ------------------------------------------------------------
CREATE TABLE procedimentos (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco_base DECIMAL(10, 2) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 7. Tabela: consultas
-- ------------------------------------------------------------
CREATE TABLE consultas (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    paciente_id BIGINT NOT NULL,
    dentista_id BIGINT NOT NULL,
    data_hora DATETIME NOT NULL,
    status ENUM('AGENDADA', 'REALIZADA', 'CANCELADA') NOT NULL DEFAULT 'AGENDADA',
    valor_total DECIMAL(10, 2) DEFAULT 0.00,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_consultas_pacientes FOREIGN KEY (paciente_id)
        REFERENCES pacientes (pessoa_id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_consultas_dentistas FOREIGN KEY (dentista_id)
        REFERENCES dentistas (pessoa_id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 8. Tabela de Junção: consulta_procedimentos (N:M)
-- ------------------------------------------------------------
CREATE TABLE consulta_procedimentos (
    consulta_id BIGINT NOT NULL,
    procedimento_id BIGINT NOT NULL,
    PRIMARY KEY (consulta_id, procedimento_id),
    CONSTRAINT fk_cp_consultas FOREIGN KEY (consulta_id)
        REFERENCES consultas (id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_cp_procedimentos FOREIGN KEY (procedimento_id)
        REFERENCES procedimentos (id) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 9. Tabela: receitas_medicas
-- ------------------------------------------------------------
CREATE TABLE receitas_medicas (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    consulta_id BIGINT NOT NULL,
    data DATE NOT NULL,
    descricao_medicamentos TEXT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_receitas_consultas FOREIGN KEY (consulta_id)
        REFERENCES consultas (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 10. Tabela: pagamentos
-- ------------------------------------------------------------
CREATE TABLE pagamentos (
    id BIGINT AUTO_INCREMENT PRIMARY KEY,
    consulta_id BIGINT NOT NULL UNIQUE,
    valor DECIMAL(10, 2) NOT NULL,
    forma_pagamento ENUM('PIX', 'CARTAO_CREDITO', 'CARTAO_DEBITO', 'DINHEIRO') NOT NULL,
    status ENUM('PENDENTE', 'PAGO', 'CANCELADO') NOT NULL DEFAULT 'PENDENTE',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_pagamentos_consultas FOREIGN KEY (consulta_id)
        REFERENCES consultas (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================
-- INSERÇÃO DE DADOS DE EXEMPLO (OPCIONAL)
-- ============================================================

-- Inserir Pessoas
INSERT INTO pessoas (nome, cpf, telefone, email, data_nascimento) VALUES
('Dr. Carlos Eduardo', '12345678901', '11988887777', 'carlos@consultorio.com', '1980-05-12'),
('Ana Paula Silva', '98765432100', '11977776666', 'ana.silva@gmail.com', '1995-10-25'),
('Mariana Costa', '45678912300', '11966665555', 'mariana@consultorio.com', '1990-03-15');

-- Inserir Dentista (ID 1)
INSERT INTO dentistas (pessoa_id, cro, especialidade) VALUES
(1, 'CRO-SP-12345', 'Ortodontia');

-- Inserir Paciente (ID 2)
INSERT INTO pacientes (pessoa_id, convenio, historico_medico) VALUES
(2, 'Amil Dental', 'Alergia a Penicilina');

-- Inserir Recepcionista (ID 3)
INSERT INTO recepcionistas (pessoa_id, turno) VALUES
(3, 'Manhã');

-- Inserir Prontuário para Paciente 2
INSERT INTO prontuarios (paciente_id, odontograma, historico_evolucao) VALUES
(2, 'Dente 18 hígido, Dente 21 restauração resina', 'Paciente relata sensibilidade no dente 21');

-- Inserir Procedimentos
INSERT INTO procedimentos (nome, descricao, preco_base) VALUES
('Limpeza (Profilaxia)', 'Remoção de placa bacteriana e tártaro', 150.00),
('Restauração em Resina', 'Restauração estética de dente cariado', 250.00),
('Tratamento de Canal', 'Endodontia para dente unirradicular', 600.00);

-- Inserir Consulta
INSERT INTO consultas (paciente_id, dentista_id, data_hora, status, valor_total) VALUES
(2, 1, '2026-04-10 14:00:00', 'AGENDADA', 250.00);

-- Vincular Procedimento à Consulta
INSERT INTO consulta_procedimentos (consulta_id, procedimento_id) VALUES
(1, 2);
