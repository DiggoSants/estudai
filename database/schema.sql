-- ============================================================
--  ESTUDAI — Schema + Seed
--  MySQL 8+ | utf8mb4_unicode_ci
-- ============================================================

CREATE DATABASE IF NOT EXISTS estudai
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE estudai;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    avatar_cor VARCHAR(7) NOT NULL DEFAULT '#6b4de6',
    xp INT UNSIGNED NOT NULL DEFAULT 0,
    nivel TINYINT UNSIGNED NOT NULL DEFAULT 1,
    streak TINYINT UNSIGNED NOT NULL DEFAULT 0,
    ultimo_login DATE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS materias (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL UNIQUE,
    cor VARCHAR(7) NOT NULL,
    icone VARCHAR(8) NOT NULL
) ENGINE=InnoDB;

INSERT IGNORE INTO materias (id, nome, cor, icone) VALUES
    (1, 'Matemática', '#e85d4a', '📐'),
    (2, 'Português', '#6b4de6', '📖'),
    (3, 'Física', '#4a90d9', '⚡'),
    (4, 'Química', '#4ab89a', '🧪'),
    (5, 'Biologia', '#5cb85c', '🌿'),
    (6, 'História', '#c9842a', '🏛️'),
    (7, 'Geografia', '#2aa0c9', '🌎'),
    (8, 'Inglês', '#d94a90', '🗣️'),
    (9, 'Filosofia', '#8b6914', '💡'),
    (10, 'Sociologia', '#6b7a8d', '🤝');

CREATE TABLE IF NOT EXISTS questoes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    materia_id TINYINT UNSIGNED NOT NULL,
    dificuldade ENUM('facil', 'medio', 'dificil') NOT NULL DEFAULT 'medio',
    ano YEAR,
    vestibular VARCHAR(60),
    enunciado TEXT NOT NULL,
    alternativa_a TEXT NOT NULL,
    alternativa_b TEXT NOT NULL,
    alternativa_c TEXT NOT NULL,
    alternativa_d TEXT NOT NULL,
    alternativa_e TEXT NOT NULL,
    gabarito CHAR(1) NOT NULL,
    explicacao TEXT,
    FOREIGN KEY (materia_id) REFERENCES materias(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS simulados (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    iniciado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    finalizado_em TIMESTAMP NULL,
    tempo_gasto SMALLINT UNSIGNED COMMENT 'segundos',
    acertos TINYINT UNSIGNED DEFAULT 0,
    total TINYINT UNSIGNED DEFAULT 0,
    xp_ganho SMALLINT UNSIGNED DEFAULT 0,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS respostas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    simulado_id INT UNSIGNED NOT NULL,
    questao_id INT UNSIGNED NOT NULL,
    resposta CHAR(1),
    correta TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (simulado_id) REFERENCES simulados(id),
    FOREIGN KEY (questao_id) REFERENCES questoes(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS conquistas (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(40) NOT NULL UNIQUE,
    nome VARCHAR(80) NOT NULL,
    descricao VARCHAR(200),
    icone VARCHAR(8),
    xp_bonus SMALLINT UNSIGNED DEFAULT 0
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS usuario_conquistas (
    usuario_id INT UNSIGNED NOT NULL,
    conquista_id TINYINT UNSIGNED NOT NULL,
    desbloqueado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, conquista_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (conquista_id) REFERENCES conquistas(id)
) ENGINE=InnoDB;

INSERT IGNORE INTO conquistas (chave, nome, descricao, icone, xp_bonus) VALUES
    ('primeiro_simulado', 'Primeira Prova', 'Completou seu primeiro simulado', '🎯', 50),
    ('streak_3', 'Trinômio do Esforço', '3 dias consecutivos de estudo', '🔥', 80),
    ('streak_7', 'Semana Perfeita', '7 dias consecutivos de estudo', '⚡', 200),
    ('acerto_perfeito', 'Nota 10!', 'Acertou 100% de um simulado', '🏆', 150),
    ('maratona', 'Maratonista', 'Completou 10 simulados', '🏅', 300),
    ('mestre_matematica', 'Mestre dos Números', 'Acertou 90%+ em Matemática (5 simulados)', '📐', 250),
    ('mestre_portugues', 'Senhor das Palavras', 'Acertou 90%+ em Português (5 simulados)', '📖', 250),
    ('velocista', 'Velocista', 'Terminou um simulado em menos de 5 minutos', '⏱️', 100),
    ('dedicado', 'Dedicado', 'Acumulou 1000 XP', '💎', 200),
    ('explorador', 'Explorador', 'Respondeu questões de 5 matérias diferentes', '🌐', 120);

-- As 100 questoes enviadas seguem este mesmo formato:
-- INSERT INTO questoes (materia_id,dificuldade,ano,vestibular,enunciado,alternativa_a,alternativa_b,alternativa_c,alternativa_d,alternativa_e,gabarito,explicacao) VALUES (...);
