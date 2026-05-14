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
    (1, 'Matemática', '#00e5a0', '📐'),
    (2, 'Português', '#00b8ff', '📖'),
    (3, 'Física', '#7c5cff', '⚡'),
    (4, 'Química', '#4ab89a', '🧪'),
    (5, 'Biologia', '#5cb85c', 'B'),
    (6, 'História', '#c9842a', '🏛️'),
    (7, 'Geografia', '#2aa0c9', 'G'),
    (8, 'Inglês', '#d94a90', '🗣️'),
    (9, 'Filosofia', '#8b6914', '💡'),
    (10, 'Sociologia', '#6b7a8d', '🤝');

UPDATE materias SET
    nome = CASE id
        WHEN 1 THEN 'Matemática'
        WHEN 2 THEN 'Português'
        WHEN 3 THEN 'Física'
        WHEN 4 THEN 'Química'
        WHEN 5 THEN 'Biologia'
        WHEN 6 THEN 'História'
        WHEN 7 THEN 'Geografia'
        WHEN 8 THEN 'Inglês'
        WHEN 9 THEN 'Filosofia'
        WHEN 10 THEN 'Sociologia'
        ELSE nome
    END,
    icone = CASE id
        WHEN 1 THEN '📐'
        WHEN 2 THEN '📖'
        WHEN 3 THEN '⚡'
        WHEN 4 THEN '🧪'
        WHEN 5 THEN '🌿'
        WHEN 6 THEN '🏛️'
        WHEN 7 THEN '🌎'
        WHEN 8 THEN '🗣️'
        WHEN 9 THEN '💡'
        WHEN 10 THEN '🤝'
        ELSE icone
    END
WHERE id BETWEEN 1 AND 10;

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
    (1, 'primeiro_simulado', 'Primeira Prova', 'Completou seu primeiro simulado', '🎯', 50),
    (2, 'streak_3', 'Trinômio do Esforço', '3 dias consecutivos de estudo', '🔥', 80),
    (3, 'streak_7', 'Semana Perfeita', '7 dias consecutivos de estudo', '⚡', 200),
    (4, 'acerto_perfeito', 'Nota 10!', 'Acertou 100% de um simulado', '🏆', 150),
    (5, 'maratona', 'Maratonista', 'Completou 10 simulados', '🏅', 300),
    (6, 'mestre_matematica', 'Mestre dos Números', 'Acertou 90%+ em Matemática', '📐', 250),
    (7, 'mestre_portugues', 'Senhor das Palavras', 'Acertou 90%+ em Português', '📖', 250),
    (8, 'velocista', 'Velocista', 'Terminou um simulado em menos de 5 minutos', '⏱️', 100),
    (9, 'dedicado', 'Dedicado', 'Acumulou 1000 XP', '💎', 200),
    (10, 'explorador', 'Explorador', 'Respondeu questões de 5 matérias diferentes', '🌐', 120);

UPDATE conquistas SET
    nome = CASE chave
        WHEN 'primeiro_simulado' THEN 'Primeira Prova'
        WHEN 'streak_3' THEN 'Trinômio do Esforço'
        WHEN 'streak_7' THEN 'Semana Perfeita'
        WHEN 'acerto_perfeito' THEN 'Nota 10!'
        WHEN 'maratona' THEN 'Maratonista'
        WHEN 'mestre_matematica' THEN 'Mestre dos Números'
        WHEN 'mestre_portugues' THEN 'Senhor das Palavras'
        WHEN 'velocista' THEN 'Velocista'
        WHEN 'dedicado' THEN 'Dedicado'
        WHEN 'explorador' THEN 'Explorador'
        ELSE nome
    END,
    descricao = CASE chave
        WHEN 'primeiro_simulado' THEN 'Completou seu primeiro simulado'
        WHEN 'streak_3' THEN '3 dias consecutivos de estudo'
        WHEN 'streak_7' THEN '7 dias consecutivos de estudo'
        WHEN 'acerto_perfeito' THEN 'Acertou 100% de um simulado'
        WHEN 'maratona' THEN 'Completou 10 simulados'
        WHEN 'mestre_matematica' THEN 'Acertou 90%+ em Matemática'
        WHEN 'mestre_portugues' THEN 'Acertou 90%+ em Português'
        WHEN 'velocista' THEN 'Terminou um simulado em menos de 5 minutos'
        WHEN 'dedicado' THEN 'Acumulou 1000 XP'
        WHEN 'explorador' THEN 'Respondeu questões de 5 matérias diferentes'
        ELSE descricao
    END,
    icone = CASE chave
        WHEN 'primeiro_simulado' THEN '🎯'
        WHEN 'streak_3' THEN '🔥'
        WHEN 'streak_7' THEN '⚡'
        WHEN 'acerto_perfeito' THEN '🏆'
        WHEN 'maratona' THEN '🏅'
        WHEN 'mestre_matematica' THEN '📐'
        WHEN 'mestre_portugues' THEN '📖'
        WHEN 'velocista' THEN '⏱️'
        WHEN 'dedicado' THEN '💎'
        WHEN 'explorador' THEN '🌐'
        ELSE icone
    END
WHERE chave IN (
    'primeiro_simulado',
    'streak_3',
    'streak_7',
    'acerto_perfeito',
    'maratona',
    'mestre_matematica',
    'mestre_portugues',
    'velocista',
    'dedicado',
    'explorador'
);

INSERT IGNORE INTO questoes (id, materia_id, dificuldade, ano, vestibular, enunciado, alternativa_a, alternativa_b, alternativa_c, alternativa_d, alternativa_e, gabarito, explicacao) VALUES
    (1, 1, 'medio', 2023, 'ENEM', 'Uma empresa produziu 2400 peças. A produção caiu 15% e depois subiu 20%. Qual foi a produção final?', '2400', '2448', '2520', '2352', '2550', 'b', '2400 x 0,85 = 2040; 2040 x 1,20 = 2448.'),
    (2, 1, 'facil', 2022, 'FUVEST', 'Se log2(x)=3 e log2(y)=5, qual é log2(xy)?', '8', '15', '2', '16', '10', 'a', 'Produto vira soma dos logaritmos: 3 + 5 = 8.'),
    (3, 1, 'dificil', 2022, 'UNICAMP', 'Uma PG tem primeiro termo 2 e razão 3. Qual é a soma dos 5 primeiros termos?', '121', '242', '62', '120', '243', 'b', 'S5 = 2 x (3^5 - 1) / (3 - 1) = 242.'),
    (4, 2, 'medio', 2023, 'ENEM', 'Em "O menino correu rapidamente", a palavra rapidamente é:', 'Advérbio de modo', 'Adjetivo', 'Substantivo', 'Advérbio de tempo', 'Conjunção', 'a', 'Rapidamente modifica o verbo e indica modo.'),
    (5, 2, 'facil', 2022, 'FUVEST', 'Assinale a concordância correta.', 'Fazem dez anos que ele partiu.', 'Faz dez anos que ele partiu.', 'Fazem dez anos que eles partiram.', 'Faz dez anos que eles partiu.', 'Fazem ano que ele partiu.', 'b', 'Fazer indicando tempo decorrido é impessoal e fica no singular.'),
    (6, 2, 'dificil', 2022, 'UNICAMP', 'A figura de linguagem em "A vida é uma peça de teatro" é:', 'Metáfora', 'Metonímia', 'Sinestesia', 'Hipérbole', 'Antítese', 'a', 'Há comparação implícita entre vida e teatro.'),
    (7, 3, 'medio', 2023, 'ENEM', 'Um objeto parte do repouso e cai por 4 s. Com g=10 m/s2, qual é a velocidade final?', '20 m/s', '40 m/s', '80 m/s', '10 m/s', '160 m/s', 'b', 'v = g x t = 10 x 4 = 40 m/s.'),
    (8, 3, 'facil', 2022, 'FUVEST', 'A unidade SI de força é:', 'Newton', 'Joule', 'Pascal', 'Watt', 'Tesla', 'a', 'Newton é a unidade de força.'),
    (9, 3, 'dificil', 2022, 'UNICAMP', 'Resistores de 6 ohms e 3 ohms em paralelo têm resistência equivalente:', '2 ohms', '9 ohms', '4,5 ohms', '1 ohm', '18 ohms', 'a', '1/Req = 1/6 + 1/3 = 3/6, então Req = 2.'),
    (10, 4, 'medio', 2023, 'ENEM', 'Qual é a fórmula molecular da glicose?', 'C6H12O6', 'C12H22O11', 'CH4O', 'C2H5OH', 'C3H8O3', 'a', 'A glicose é um monossacarídeo de fórmula C6H12O6.'),
    (11, 4, 'facil', 2022, 'FUVEST', 'Qual é o número atômico do oxigênio?', '8', '16', '6', '7', '12', 'a', 'Oxigênio tem 8 prótons.'),
    (12, 5, 'medio', 2023, 'ENEM', 'Qual organela é responsável pela síntese de proteínas?', 'Ribossomo', 'Mitocôndria', 'Núcleo', 'Lisossomo', 'Cloroplasto', 'a', 'Ribossomos realizam a tradução de proteínas.'),
    (13, 5, 'facil', 2022, 'FUVEST', 'Processo em que plantas produzem glicose usando luz solar:', 'Fotossíntese', 'Respiração', 'Fermentação', 'Glicólise', 'Osmose', 'a', 'Fotossíntese usa luz, CO2 e água para gerar glicose.'),
    (14, 6, 'medio', 2023, 'ENEM', 'A Revolução Francesa foi ligada principalmente a:', 'Crise fiscal, desigualdade e iluminismo', 'Guerra Fria', 'Invasão da Polônia', 'Apartheid', 'Plano Marshall', 'a', 'Crise do Antigo Regime e ideias iluministas impulsionaram 1789.'),
    (15, 7, 'medio', 2023, 'ENEM', 'O fenômeno El Niño caracteriza-se por:', 'Aquecimento do Pacífico Equatorial', 'Resfriamento do Atlântico', 'Aumento do gelo ártico', 'Vulcanismo', 'Tsunamis constantes', 'a', 'El Niño é aquecimento anormal das águas do Pacífico Equatorial.'),
    (16, 8, 'facil', 2023, 'ENEM', 'Choose the correct form: She ___ to school every day.', 'goes', 'go', 'going', 'gone', 'is go', 'a', 'Third-person singular in simple present uses -s.'),
    (17, 9, 'medio', 2023, 'ENEM', '"Penso, logo existo" é uma máxima de:', 'René Descartes', 'Kant', 'Locke', 'Aristóteles', 'Hume', 'a', 'O cogito é ponto central da filosofia cartesiana.'),
    (18, 10, 'medio', 2023, 'ENEM', 'Fato social em Durkheim refere-se a:', 'Maneiras externas e coercitivas de agir, pensar e sentir', 'Ações individuais', 'Eventos documentados', 'Leis naturais', 'Opinião pessoal', 'a', 'Fatos sociais são externos ao indivíduo e exercem coerção.');

UPDATE questoes SET enunciado = 'Uma empresa produziu 2400 peças. A produção caiu 15% e depois subiu 20%. Qual foi a produção final?', explicacao = '2400 x 0,85 = 2040; 2040 x 1,20 = 2448.' WHERE id = 1;
UPDATE questoes SET enunciado = 'Se log2(x)=3 e log2(y)=5, qual é log2(xy)?' WHERE id = 2;
UPDATE questoes SET enunciado = 'Uma PG tem primeiro termo 2 e razão 3. Qual é a soma dos 5 primeiros termos?' WHERE id = 3;
UPDATE questoes SET enunciado = 'Em "O menino correu rapidamente", a palavra rapidamente é:', alternativa_a = 'Advérbio de modo', alternativa_d = 'Advérbio de tempo', alternativa_e = 'Conjunção' WHERE id = 4;
UPDATE questoes SET enunciado = 'Assinale a concordância correta.', explicacao = 'Fazer indicando tempo decorrido é impessoal e fica no singular.' WHERE id = 5;
UPDATE questoes SET enunciado = 'A figura de linguagem em "A vida é uma peça de teatro" é:', alternativa_a = 'Metáfora', alternativa_b = 'Metonímia', alternativa_d = 'Hipérbole', alternativa_e = 'Antítese', explicacao = 'Há comparação implícita entre vida e teatro.' WHERE id = 6;
UPDATE questoes SET enunciado = 'Um objeto parte do repouso e cai por 4 s. Com g=10 m/s2, qual é a velocidade final?' WHERE id = 7;
UPDATE questoes SET enunciado = 'A unidade SI de força é:', explicacao = 'Newton é a unidade de força.' WHERE id = 8;
UPDATE questoes SET enunciado = 'Resistores de 6 ohms e 3 ohms em paralelo têm resistência equivalente:', explicacao = '1/Req = 1/6 + 1/3 = 3/6, então Req = 2.' WHERE id = 9;
UPDATE questoes SET enunciado = 'Qual é a fórmula molecular da glicose?', explicacao = 'A glicose é um monossacarídeo de fórmula C6H12O6.' WHERE id = 10;
UPDATE questoes SET enunciado = 'Qual é o número atômico do oxigênio?', explicacao = 'Oxigênio tem 8 prótons.' WHERE id = 11;
UPDATE questoes SET enunciado = 'Qual organela é responsável pela síntese de proteínas?', alternativa_b = 'Mitocôndria', alternativa_c = 'Núcleo', explicacao = 'Ribossomos realizam a tradução de proteínas.' WHERE id = 12;
UPDATE questoes SET alternativa_a = 'Fotossíntese', alternativa_b = 'Respiração', alternativa_c = 'Fermentação', alternativa_d = 'Glicólise', explicacao = 'Fotossíntese usa luz, CO2 e água para gerar glicose.' WHERE id = 13;
UPDATE questoes SET enunciado = 'A Revolução Francesa foi ligada principalmente a:', alternativa_c = 'Invasão da Polônia' WHERE id = 14;
UPDATE questoes SET enunciado = 'O fenômeno El Niño caracteriza-se por:', alternativa_a = 'Aquecimento do Pacífico Equatorial', alternativa_b = 'Resfriamento do Atlântico', alternativa_c = 'Aumento do gelo ártico', explicacao = 'El Niño é aquecimento anormal das águas do Pacífico Equatorial.' WHERE id = 15;
UPDATE questoes SET enunciado = '"Penso, logo existo" é uma máxima de:', alternativa_a = 'René Descartes', alternativa_d = 'Aristóteles', explicacao = 'O cogito é ponto central da filosofia cartesiana.' WHERE id = 17;
UPDATE questoes SET alternativa_b = 'Ações individuais', alternativa_e = 'Opinião pessoal', explicacao = 'Fatos sociais são externos ao indivíduo e exercem coerção.' WHERE id = 18;
