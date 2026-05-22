# Feature: Excluir atividade

Endpoint para realizar exclusão de atividade.

## Regras

- A Url do endpoint deve seguir o formato /projects/{project}/tasks/{id} [DELETE]
- Caso atividade esteja com status de `running` retornar 403 e não executar ação de atualizar.

## Saida esperada

```json
{
    "message": "Atividade excluida com sucesso"
}
```

## Resultado esperado

- Exclusão de registro da atividade no banco de dados.
