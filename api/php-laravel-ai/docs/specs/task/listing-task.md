# Feature: Editar atividade

Endpoint para listagem de atividades do projeto.

## Regras

- A Url do endpoint deve seguir o formato /projects/{project}/tasks [GET]
- Os dados devem ser paginado com 10 items por página fixa.

## Saída esperada

Saída esperada abaixo representa apenas os items do data na paginação.

```json
{
    "id": 1,
    "title": "title task",
    "description": null,
    "status": "pending",
    "created_at": "2026-05-22 12:00:00",
    "project_id": 1
}
```
