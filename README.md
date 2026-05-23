# ToDo App

Este repositório/projeto foi criado para fins de aplicabilidade de estudos relacionado a linguagens ou frameworks web.

![Tela de projetos](/designer/Projects.png)

![Tela de atividades](/designer/Project.png)

#### Paleta de cores

```json
{
  "primary": "#0CBE36",
  "background": "#15181F",
  "foreground": "#1A1E27",
  "text": "#575D69",
  "title": "#FFFFFF"
}
```

### Objetivo

Implementar pequeno sistema web de lista de tarefas sempre utilizando arquitetura API Rest entre frontend e backend para que seja possivel abranger vários tópicos durante o estudo, segue lista de stacks que deverão está implementados aqui:

**Frontend**:

🚧 VueJS

[ ] NuxtJS

[ ] ReactJS

[ ] Next.js

**Backend**:

✅ PHP Laravel

[ ] NestJs

[ ] Python

[ ] Java

[ ] Node.js

---

### Funcionalidades

- Projetos
  - Cadastro
  - Edição
  - Exclusão
- Atividades
  - Cadastro
  - Edição
  - Exclusão
  - Play na execução
  - Pause da execução
  - Marcar como concluído

#### Regras de negócio

1. Caso alguma atividade esteja com status de **Play (Em Execução)**, não deve ser permitido que outra atividade seja executada.

2. Ações de Editar ou Excluir não devem ser permitidos caso alguma atividade esteja em execução do projeto.

3. Aplicar a regra **2** para atividades, ações apenas em atividades sem execução atual.

4. Nas listagens na qual seu respectivo endpoint tenha resposta paginada deve ser utilizado o `infinite scroll` para carregamento de resultados.

### Informações técnicas API

#### Endpoints

**/projects** - [GET] Listagem de projetos (`paginado`)

**/projects** - [POST] Cadastro de projeto

**/projects/{id}** - [PUT] Edição de projeto

**/projects/{id}** - [DELETE] Exclusão de projeto

**/projects/{id}/tasks** - [GET] Listagem de atividades do projeto (`paginado`)

**/projects/{id}/tasks** - [POST] Cadastro de atividade no projeto

**/projects/{id}/tasks/{taskId}** - [PUT] Editar atividade

**/projects/{id}/tasks/{taskId}** - [DELETE] Exclui atividade

**/projects/{id}/tasks/{taskId}/start** - [POST] Inicia execução de atividade

**/projects/{id}/tasks/{taskId}/stop** - [POST] Pausa execução de atividade

#### Entidades e atributos

**Project**

```json
{
  "title": "string|max:255|required",
  "description": "text|required",
  "created_at": "dateTime|auto"
}
```

**Task**

> Relacionamento Project (1) > Task (N)

```json
{
    "title": "string|max:255|required",
    "description": "text|nullable",
    "status": "in:pending,running,completed",
    "created_at": "dateTime|auto",
    "project_id": Project
}
```

**Runner**

> Relacionamento Task (1) > Runner (N)

```json
{
    "start_at": "timestamp",
    "stop_at": "timestamp",
    "task_id": Task
}
```
