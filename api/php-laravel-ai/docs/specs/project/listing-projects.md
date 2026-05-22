# Feature: Listagem de projetos

Implementar endpoint para listagem de projetos cadastrados.

## Regras

- O Resultado do endpoint deve ser paginado, com um tamanho fixo de 10 items por página.

## Saída esperada

Exemplo de items do data da paginação:

```json
{
    "id": 1,
    "title": "title of project",
    "description": "text description of project",
    "created_at": "2026-05-22 10:00:00"
}
```

## Rsultado esperado

- Endpoint com dados paginado
