# Estudai

Projeto PHP + MySQL usando arquitetura MVC.

## Estrutura

```text
app/
  Controllers/   Controllers da aplicacao
  Core/          Classes base: Controller, Model, Router e Database
  Models/        Models e regras de acesso a dados
  Views/         Telas e layouts
config/          Configuracoes da aplicacao e banco
database/        Scripts SQL
public/          Entrada publica da aplicacao e assets
routes/          Definicao das rotas
```

## Como rodar no XAMPP

1. Coloque a pasta em `C:\xampp\htdocs\estudai`.
2. Crie o banco `estudai` no phpMyAdmin.
3. Importe `database/schema.sql`.
4. Ajuste as credenciais em `config/config.php`, se necessario.
5. Acesse `http://localhost/estudai`.
