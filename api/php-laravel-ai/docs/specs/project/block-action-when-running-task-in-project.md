# Feature: Bloqueio de ações enquanto atividade em execução

Bloquear ações de editar e excluir projeto enquanto possui alguma task com status igual a `running`.

## Regras

- O bloqueio deve ser aplicado somente no projeto da requisição.
- Aplicar regras nas rotas `projects.update` e `projects.destroy`.
- Quando efetuado o bloqueio retornar 403

## Resultado esperado

- Bloqueio antes da ação requisitada ser efetuada.
