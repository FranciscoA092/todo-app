# Feature: Cadastro de atividades

Endpoint para cadastro de atividades, onde uma atividade sempre pertencerá a um projeto seguindo o relacionamento de 1 (Projeto) para N (Atividade). Para a entidade `atividade` a mesma deve possuir um campo de status do tipo enum para suportar os valores `pending`, `running` e `completed`.

## Regras

- A Url do endpoint deve seguir o formato /projects/{project}/tasks [POST]
- Utilizar o ID do projeto vindo da url para criar o relacionamento entre à atividade e o projeto.
- O Campo `title` é obrigatório
- O Campo `description` é texto e opcional seu preenchimento
- Ao registrar atividade por padrão a coluna status deve ter ser valor como `pending`

## Entrada

```json
{
    "title": "string|max:255|required",
    "description": "text|nullable"
}
```

## Saída esperada

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

## Resultado esperado

- Registro da atividade no banco de dados
