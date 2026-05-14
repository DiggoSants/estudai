<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $statement = $this->db->prepare('SELECT * FROM usuarios WHERE email = :email LIMIT 1');
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        return $user ?: null;
    }

    public function emailExists(string $email): bool
    {
        $statement = $this->db->prepare('SELECT id FROM usuarios WHERE email = ? LIMIT 1');
        $statement->execute([$email]);

        return (bool) $statement->fetch();
    }

    public function create(string $nome, string $email, string $senhaHash, string $avatarCor): void
    {
        $statement = $this->db->prepare('
            INSERT INTO usuarios (nome, email, senha_hash, avatar_cor, ultimo_login)
            VALUES (?, ?, ?, ?, ?)
        ');
        $statement->execute([$nome, $email, $senhaHash, $avatarCor, date('Y-m-d')]);
    }

    public function updateLoginStreak(int $id, ?string $ultimoLogin, int $streak): int
    {
        $hoje = date('Y-m-d');
        $ontem = date('Y-m-d', strtotime('-1 day'));
        $newStreak = $ultimoLogin === $ontem ? $streak + 1 : ($ultimoLogin === $hoje ? $streak : 1);

        $statement = $this->db->prepare('UPDATE usuarios SET ultimo_login = ?, streak = ? WHERE id = ?');
        $statement->execute([$hoje, $newStreak, $id]);

        return $newStreak;
    }
}
