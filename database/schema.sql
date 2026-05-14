-- ============================================================
--  ESTUDAI - Schema principal
--  MySQL 8+ | utf8mb4_unicode_ci
--
--  Preserva usuarios, materias, conquistas e usuario_conquistas.
--  Reseta o dominio avaliativo: respostas, simulados, questoes,
--  alternativas, arquivos de questoes e provas.
-- ============================================================

CREATE TABLE IF NOT EXISTS usuarios (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL,
    avatar_cor VARCHAR(7) NOT NULL DEFAULT '#00e5a0',
    xp INT UNSIGNED NOT NULL DEFAULT 0,
    nivel TINYINT UNSIGNED NOT NULL DEFAULT 1,
    streak TINYINT UNSIGNED NOT NULL DEFAULT 0,
    ultimo_login DATE,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS materias (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL UNIQUE,
    cor VARCHAR(7) NOT NULL,
    icone VARCHAR(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO materias (id, nome, cor, icone) VALUES
    (1, 'Matemática', '#00e5a0', 'MAT'),
    (2, 'Português', '#00b8ff', 'POR'),
    (3, 'Física', '#7c5cff', 'FIS'),
    (4, 'Química', '#4ab89a', 'QUI'),
    (5, 'Biologia', '#5cb85c', 'BIO'),
    (6, 'História', '#c9842a', 'HIS'),
    (7, 'Geografia', '#2aa0c9', 'GEO'),
    (8, 'Inglês', '#d94a90', 'ING'),
    (9, 'Filosofia', '#8b6914', 'FIL'),
    (10, 'Sociologia', '#6b7a8d', 'SOC')
ON DUPLICATE KEY UPDATE
    nome = VALUES(nome),
    cor = VALUES(cor),
    icone = VALUES(icone);

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS respostas;
DROP TABLE IF EXISTS simulados;
DROP TABLE IF EXISTS questao_arquivos;
DROP TABLE IF EXISTS alternativas;
DROP TABLE IF EXISTS questoes;
DROP TABLE IF EXISTS provas;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE provas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    vestibular VARCHAR(40) NOT NULL,
    ano SMALLINT UNSIGNED NOT NULL,
    edicao VARCHAR(80) NULL,
    origem VARCHAR(40) NOT NULL DEFAULT 'manual',
    external_id VARCHAR(120) NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_provas_origem_external (origem, external_id),
    KEY idx_provas_vestibular_ano (vestibular, ano)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE questoes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    prova_id INT UNSIGNED NOT NULL,
    materia_id TINYINT UNSIGNED NOT NULL,
    numero SMALLINT UNSIGNED NULL,
    indice VARCHAR(40) NULL,
    disciplina_original VARCHAR(80) NULL,
    idioma VARCHAR(30) NULL,
    dificuldade ENUM('facil', 'medio', 'dificil') NOT NULL DEFAULT 'medio',
    enunciado MEDIUMTEXT NOT NULL,
    contexto MEDIUMTEXT NULL,
    alternativas_intro TEXT NULL,
    gabarito CHAR(1) NOT NULL,
    explicacao TEXT NULL,
    origem VARCHAR(40) NOT NULL DEFAULT 'manual',
    external_id VARCHAR(160) NULL,
    ativa TINYINT(1) NOT NULL DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_questoes_origem_external (origem, external_id),
    KEY idx_questoes_filtros (materia_id, dificuldade, ativa),
    KEY idx_questoes_prova (prova_id, numero),
    CONSTRAINT fk_questoes_prova FOREIGN KEY (prova_id) REFERENCES provas(id) ON DELETE CASCADE,
    CONSTRAINT fk_questoes_materia FOREIGN KEY (materia_id) REFERENCES materias(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE alternativas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    questao_id INT UNSIGNED NOT NULL,
    letra CHAR(1) NOT NULL,
    texto MEDIUMTEXT NOT NULL,
    arquivo_url TEXT NULL,
    correta TINYINT(1) NOT NULL DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_alternativas_questao_letra (questao_id, letra),
    KEY idx_alternativas_correta (questao_id, correta),
    CONSTRAINT fk_alternativas_questao FOREIGN KEY (questao_id) REFERENCES questoes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE questao_arquivos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    questao_id INT UNSIGNED NOT NULL,
    arquivo_url TEXT NOT NULL,
    tipo VARCHAR(40) NULL,
    ordem TINYINT UNSIGNED NOT NULL DEFAULT 1,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_questao_arquivos_questao FOREIGN KEY (questao_id) REFERENCES questoes(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE simulados (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT UNSIGNED NOT NULL,
    iniciado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    finalizado_em TIMESTAMP NULL,
    tempo_gasto SMALLINT UNSIGNED COMMENT 'segundos',
    acertos TINYINT UNSIGNED DEFAULT 0,
    total TINYINT UNSIGNED DEFAULT 0,
    xp_ganho SMALLINT UNSIGNED DEFAULT 0,
    KEY idx_simulados_usuario_finalizado (usuario_id, finalizado_em),
    CONSTRAINT fk_simulados_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE respostas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    simulado_id INT UNSIGNED NOT NULL,
    questao_id INT UNSIGNED NOT NULL,
    resposta CHAR(1),
    correta TINYINT(1) NOT NULL DEFAULT 0,
    UNIQUE KEY uniq_simulado_questao (simulado_id, questao_id),
    KEY idx_respostas_questao (questao_id),
    CONSTRAINT fk_respostas_simulado FOREIGN KEY (simulado_id) REFERENCES simulados(id) ON DELETE CASCADE,
    CONSTRAINT fk_respostas_questao FOREIGN KEY (questao_id) REFERENCES questoes(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS conquistas (
    id TINYINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    chave VARCHAR(40) NOT NULL UNIQUE,
    nome VARCHAR(80) NOT NULL,
    descricao VARCHAR(200),
    icone VARCHAR(8),
    xp_bonus SMALLINT UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS usuario_conquistas (
    usuario_id INT UNSIGNED NOT NULL,
    conquista_id TINYINT UNSIGNED NOT NULL,
    desbloqueado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, conquista_id),
    CONSTRAINT fk_usuario_conquistas_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    CONSTRAINT fk_usuario_conquistas_conquista FOREIGN KEY (conquista_id) REFERENCES conquistas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO conquistas (id, chave, nome, descricao, icone, xp_bonus) VALUES
    (1, 'primeiro_simulado', 'Primeira Prova', 'Completou seu primeiro simulado', 'ALVO', 50),
    (2, 'streak_3', 'Trinômio do Esforço', '3 dias consecutivos de estudo', 'FOGO', 80),
    (3, 'streak_7', 'Semana Perfeita', '7 dias consecutivos de estudo', 'RAIO', 200),
    (4, 'acerto_perfeito', 'Nota 10!', 'Acertou 100% de um simulado', 'TROF', 150),
    (5, 'maratona', 'Maratonista', 'Completou 10 simulados', 'MEDA', 300),
    (6, 'mestre_matematica', 'Mestre dos Números', 'Acertou 90% ou mais em Matemática em 5 simulados', 'MAT', 250),
    (7, 'mestre_portugues', 'Senhor das Palavras', 'Acertou 90% ou mais em Português em 5 simulados', 'POR', 250),
    (8, 'velocista', 'Velocista', 'Terminou um simulado em menos de 5 minutos', 'TEMP', 100),
    (9, 'dedicado', 'Dedicado', 'Acumulou 1000 XP', 'XP', 200),
    (10, 'explorador', 'Explorador', 'Respondeu questões de 5 matérias diferentes', 'MAPA', 120)
ON DUPLICATE KEY UPDATE
    nome = VALUES(nome),
    descricao = VALUES(descricao),
    icone = VALUES(icone),
    xp_bonus = VALUES(xp_bonus);
