# Feature: Excluir projeto

Endpoint para excluir projeto.

## Regras

- Receber o ID do projeto pela url
- Caso o projeto não seja encontrado retornar 404

## Saída esperada

```json
{
    "message": "Projeto excluido com sucesso"
}
```

## Resultado esperado

- Exclusão de registro do projeto no banco de dados.
