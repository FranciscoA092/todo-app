# Feature: Parar execução de atividade

Endpoint para registrar parada de execução de uma atividade.

## Regras

- A Url do endpoint deve seguir o formato /projects/{project}/tasks/{id}/stop [POST]
- Caso o id passado nao exista retornar 404
- Utilizar sempre o ultimo registro de runner da atividade para atualizar a coluna `stop_at`
- Caso não seja encontrado ultimo registro de runner com `stop_at` igual a `null` deve retornar 400

## Saída esperada

```json
{
    "message": "Execução parada"
}
```

## Resultado esperado

- Atualização no registro de runner com timestamp na coluna stop_at
- Atualizar status da atividade para `pending`
