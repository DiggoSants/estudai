-- ============================================================
--  ESTUDAI - Schema + Seed
--  MySQL 8+ | utf8mb4_unicode_ci
--  Execute no banco configurado em DATABASE_URL/MYSQL_URL.
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

INSERT IGNORE INTO materias (id, nome, cor, icone) VALUES
    (1, 'Matematica', '#00e5a0', 'M'),
    (2, 'Portugues', '#00b8ff', 'P'),
    (3, 'Fisica', '#7c5cff', 'F'),
    (4, 'Quimica', '#4ab89a', 'Q'),
    (5, 'Biologia', '#5cb85c', 'B'),
    (6, 'Historia', '#c9842a', 'H'),
    (7, 'Geografia', '#2aa0c9', 'G'),
    (8, 'Ingles', '#d94a90', 'I'),
    (9, 'Filosofia', '#8b6914', 'FI'),
    (10, 'Sociologia', '#6b7a8d', 'S');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS respostas (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    simulado_id INT UNSIGNED NOT NULL,
    questao_id INT UNSIGNED NOT NULL,
    resposta CHAR(1),
    correta TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (simulado_id) REFERENCES simulados(id),
    FOREIGN KEY (questao_id) REFERENCES questoes(id),
    UNIQUE KEY uniq_simulado_questao (simulado_id, questao_id)
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
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (conquista_id) REFERENCES conquistas(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT IGNORE INTO conquistas (id, chave, nome, descricao, icone, xp_bonus) VALUES
    (1, 'primeiro_simulado', 'Primeira Prova', 'Completou seu primeiro simulado', 'T', 50),
    (2, 'streak_3', 'Trinomio do Esforco', '3 dias consecutivos de estudo', 'F', 80),
    (3, 'streak_7', 'Semana Perfeita', '7 dias consecutivos de estudo', 'W', 200),
    (4, 'acerto_perfeito', 'Nota 10', 'Acertou 100% de um simulado', 'A+', 150),
    (5, 'maratona', 'Maratonista', 'Completou 10 simulados', '10', 300),
    (6, 'mestre_matematica', 'Mestre dos Numeros', 'Acertou 90%+ em Matematica', 'M', 250),
    (7, 'mestre_portugues', 'Senhor das Palavras', 'Acertou 90%+ em Portugues', 'P', 250),
    (8, 'velocista', 'Velocista', 'Terminou um simulado em menos de 5 minutos', 'V', 100),
    (9, 'dedicado', 'Dedicado', 'Acumulou 1000 XP', 'XP', 200),
    (10, 'explorador', 'Explorador', 'Respondeu questoes de 5 materias diferentes', 'E', 120);

INSERT IGNORE INTO questoes (id, materia_id, dificuldade, ano, vestibular, enunciado, alternativa_a, alternativa_b, alternativa_c, alternativa_d, alternativa_e, gabarito, explicacao) VALUES
    (1, 1, 'medio', 2023, 'ENEM', 'Uma empresa produziu 2400 pecas. A producao caiu 15% e depois subiu 20%. Qual foi a producao final?', '2400', '2448', '2520', '2352', '2550', 'b', '2400 x 0,85 = 2040; 2040 x 1,20 = 2448.'),
    (2, 1, 'facil', 2022, 'FUVEST', 'Se log2(x)=3 e log2(y)=5, qual e log2(xy)?', '8', '15', '2', '16', '10', 'a', 'Produto vira soma dos logaritmos: 3 + 5 = 8.'),
    (3, 1, 'dificil', 2022, 'UNICAMP', 'Uma PG tem primeiro termo 2 e razao 3. Qual a soma dos 5 primeiros termos?', '121', '242', '62', '120', '243', 'b', 'S5 = 2 x (3^5 - 1) / (3 - 1) = 242.'),
    (4, 2, 'medio', 2023, 'ENEM', 'Em "O menino correu rapidamente", a palavra rapidamente e:', 'Adverbio de modo', 'Adjetivo', 'Substantivo', 'Adverbio de tempo', 'Conjuncao', 'a', 'Rapidamente modifica o verbo e indica modo.'),
    (5, 2, 'facil', 2022, 'FUVEST', 'Assinale a concordancia correta.', 'Fazem dez anos que ele partiu.', 'Faz dez anos que ele partiu.', 'Fazem dez anos que eles partiram.', 'Faz dez anos que eles partiu.', 'Fazem ano que ele partiu.', 'b', 'Fazer indicando tempo decorrido e impessoal e fica no singular.'),
    (6, 2, 'dificil', 2022, 'UNICAMP', 'A figura de linguagem em "A vida e uma peca de teatro" e:', 'Metafora', 'Metonimia', 'Sinestesia', 'Hiperbole', 'Antitese', 'a', 'Ha comparacao implicita entre vida e teatro.'),
    (7, 3, 'medio', 2023, 'ENEM', 'Um objeto parte do repouso e cai por 4 s. Com g=10 m/s2, qual a velocidade final?', '20 m/s', '40 m/s', '80 m/s', '10 m/s', '160 m/s', 'b', 'v = g x t = 10 x 4 = 40 m/s.'),
    (8, 3, 'facil', 2022, 'FUVEST', 'A unidade SI de forca e:', 'Newton', 'Joule', 'Pascal', 'Watt', 'Tesla', 'a', 'Newton e a unidade de forca.'),
    (9, 3, 'dificil', 2022, 'UNICAMP', 'Resistores de 6 ohms e 3 ohms em paralelo tem resistencia equivalente:', '2 ohms', '9 ohms', '4,5 ohms', '1 ohm', '18 ohms', 'a', '1/Req = 1/6 + 1/3 = 3/6, entao Req = 2.'),
    (10, 4, 'medio', 2023, 'ENEM', 'Qual e a formula molecular da glicose?', 'C6H12O6', 'C12H22O11', 'CH4O', 'C2H5OH', 'C3H8O3', 'a', 'A glicose e um monossacarideo de formula C6H12O6.'),
    (11, 4, 'facil', 2022, 'FUVEST', 'Qual e o numero atomico do oxigenio?', '8', '16', '6', '7', '12', 'a', 'Oxigenio tem 8 protons.'),
    (12, 5, 'medio', 2023, 'ENEM', 'Qual organela e responsavel pela sintese de proteinas?', 'Ribossomo', 'Mitocondria', 'Nucleo', 'Lisossomo', 'Cloroplasto', 'a', 'Ribossomos realizam a traducao de proteinas.'),
    (13, 5, 'facil', 2022, 'FUVEST', 'Processo em que plantas produzem glicose usando luz solar:', 'Fotossintese', 'Respiracao', 'Fermentacao', 'Glicolise', 'Osmose', 'a', 'Fotossintese usa luz, CO2 e agua para gerar glicose.'),
    (14, 6, 'medio', 2023, 'ENEM', 'A Revolucao Francesa foi ligada principalmente a:', 'Crise fiscal, desigualdade e iluminismo', 'Guerra Fria', 'Invasao da Polonia', 'Apartheid', 'Plano Marshall', 'a', 'Crise do Antigo Regime e ideias iluministas impulsionaram 1789.'),
    (15, 7, 'medio', 2023, 'ENEM', 'O fenomeno El Nino caracteriza-se por:', 'Aquecimento do Pacifico Equatorial', 'Resfriamento do Atlantico', 'Aumento do gelo artico', 'Vulcanismo', 'Tsunamis constantes', 'a', 'El Nino e aquecimento anormal das aguas do Pacifico Equatorial.'),
    (16, 8, 'facil', 2023, 'ENEM', 'Choose the correct form: She ___ to school every day.', 'goes', 'go', 'going', 'gone', 'is go', 'a', 'Third-person singular in simple present uses -s.'),
    (17, 9, 'medio', 2023, 'ENEM', '"Penso, logo existo" e uma maxima de:', 'Rene Descartes', 'Kant', 'Locke', 'Aristoteles', 'Hume', 'a', 'O cogito e ponto central da filosofia cartesiana.'),
    (18, 10, 'medio', 2023, 'ENEM', 'Fato social em Durkheim refere-se a:', 'Maneiras externas e coercitivas de agir, pensar e sentir', 'Acoes individuais', 'Eventos documentados', 'Leis naturais', 'Opiniao pessoal', 'a', 'Fatos sociais sao externos ao individuo e exercem coercao.');
