# Feature: Cadastro de projetos

Implementar endpoint para cadastro de projetos.

## Regras

- Title obrigatório e deve ser único.
- Description texto obrigatório.

## Entrada

```json
{
    "title": "string|max:255|required",
    "description": "text|required"
}
```

## Saida esperada

```json
{
    "id": 1,
    "title": "title of project",
    "description": "text description of project",
    "created_at": "2026-05-22 10:00:00"
}
```

## Resultado esperado

- Registro do cadastro no banco de dados
