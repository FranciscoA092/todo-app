# Feature: Iniciar execução da atividade

Endpoint para sinalizar inicio da execução de uma atividade. Ao da start na atividade e gerado um registro na entidade `Runner` informando o timestamp atual na coluna `start_at`.

Entidade Runner:

- start_at timestamp
- stop_at timestamp|null
- task_id

## Regras

- A Url do endpoint deve seguir o formato /projects/{project}/tasks/{id}/start [POST]
- Caso a atividade esteja com status de `running` deve retornar 403
- Caso o id passado nao exista retornar 404
- Caso atividade possua algum registro em runner que esteja com a coluna stop_at null retorna 403, isto representa que possui uma execução em aberto.

## Resultado esperado

- Registro de runner com timestamp de inicio na coluna start_at
- Status da atividade atualizado para running
