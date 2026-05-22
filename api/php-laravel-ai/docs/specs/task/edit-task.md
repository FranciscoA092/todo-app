# Feature: Editar atividades

Endpoint para editar informações da atividade.

## Regras

- A Url do endpoint deve seguir o formato /projects/{project}/tasks/{id} [PUT]
- O Campo `title` é obrigatório
- O Campo `description` é texto e opcional seu preenchimento
- O campo `status` deve aceitar apenas os valores `pending` e `completed`.
- Caso atividade esteja com status de `running` retornar 403 e não executar ação de atualizar.

## Entrada

```json
{
    "title": "string|max:255|required",
    "description": "text|nullable",
    "status": "in:pending,completed|required"
}
```

## Saída esperada

```json
{
    "message": "Atividade atualizada com sucesso"
}
```

## Resultado esperado

- Registro de atividade atualizado com as novas informações no banco de dados.
