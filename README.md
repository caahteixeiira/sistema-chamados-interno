# Sistema de Chamados Interno

Um sistema web moderno para gestão de chamados/tickets internos da empresa, construído com **Laravel 11**, **Vue 3**, **Inertia.js** e **Tailwind CSS**.

## 📋 Índice

- [Características](#-características)
- [Justificativa Tecnológica](#-justificativa-tecnológica)
- [Requisitos do Sistema](#-requisitos-do-sistema)
- [Instalação](#-instalação)
- [Configuração](#-configuração)
- [Execução](#-execução)
- [Uso](#-uso)
- [Funcionalidades Implementadas](#-funcionalidades-implementadas)
- [Estrutura do Projeto](#-estrutura-do-projeto)

---

## ✨ Características

- ✅ **CRUD completo de chamados**: Criar, listar, visualizar e editar.
- ✅ **Sistema de prioridades**: Baixa, Média, Alta (gerenciado via Enums).
- ✅ **Rastreamento de status**: Aberto, Em andamento, Resolvido, Fechado.
- ✅ **Gestão de responsáveis**: Atribuição manual ou automática.
- ✅ **Distribuição inteligente**: Atribui automaticamente ao responsável com menos chamados ativos.
- ✅ **Filtros avançados**: Busca em tempo real por título, status, prioridade e responsável.
- ✅ **Paginação Eficiente**: Listagem com 10 itens por página mantendo o estado dos filtros na URL.
- ✅ **Interface responsiva**: Funciona perfeitamente em desktop e dispositivos mobile.
- ✅ **Design limpo**: Construído com Tailwind CSS e focado em componentização.

---

## 🏗️ Justificativa Tecnológica

### Por que Laravel 11?

- **Madurez e estabilidade**: Framework consagrado com ecossistema robusto para o ecossistema PHP moderno.
- **Produtividade**: Convenções nativas de injeção de dependência e containers de serviços aceleram o desenvolvimento.
- **ORM Eloquent**: Abstração limpa de banco de dados, perfeita para trabalhar de forma defensiva com chaves estrangeiras explicitadas.
- **Segurança Nativa**: Proteção embutida contra SQL Injection, CSRF e XSS, além de hashing seguro de senhas com a API nativa.

### Por que Vue 3 + Inertia.js?

- **Eliminação de Atrito (Zero Rest API)**: O Inertia.js atua como o elo de ligação entre o backend e o frontend, permitindo renderizar componentes Vue diretamente do Controller Laravel compartilhando propriedades globais, dispensando o overhead de gerenciar rotas de API, tokens JWT ou gerenciadores de estado complexos (como Pinia/Vuex).
- **Abordagem SPA**: Entrega uma experiência rica de Single Page Application para o usuário com o fluxo de desenvolvimento ágil de um sistema monolítico.
- **Componentes Concisos**: Uso do Vue 3 sob o paradigma de `<script setup>` da Composition API, maximizando a legibilidade, modularidade e reatividade do código.

### Por que Tailwind CSS?

- **Utility-First**: Agiliza a estilização de componentes diretamente nas classes HTML, eliminando arquivos CSS inflados e desorganizados.
- **Build Otimizada**: Integração com o compilador do Vite, garantindo que apenas as classes efetivamente utilizadas nas views do Vue sejam empacotadas para a produção.

### 📦 Dependências e Bibliotecas Externas Utilizadas

Conforme solicitado nos requisitos do desafio, abaixo estão listadas as principais dependências externas adicionadas ao projeto além da estrutura base do ecossistema Laravel/Vue:

| Biblioteca / Pacote | Escopo | Finalidade Principal |
| :--- | :--- | :--- |
| `@inertiajs/vue3` | Frontend / Backend | Protocolo de comunicação para criar a arquitetura SPA monolítica sem a necessidade de rotas de API REST tradicionais. |
| `lucide-vue-next` | Frontend (Vue 3) | Conjunto de ícones vetoriais modernos e leves utilizados para enriquecer a identidade visual dos status e prioridades na listagem de chamados. |
| `tightenco/ziggy` | Blade / JavaScript | Permite utilizar as rotas nomeadas do Laravel diretamente dentro dos arquivos Vue através do helper `route()`. |

### Decisões Arquiteturais

#### 1. **Actions Pattern (Domain-Driven Design)**
```
app/Actions/Tickets/
├── CreateTicketAction.php
├── UpdateTicketAction.php
└── AssignTicketAutomaticallyAction.php
```
- **Benefício**: Lógica de negócio isolada e testável
- **Reutilização**: Ações podem ser chamadas de múltiplos contextos
- **Manutenibilidade**: Código mais organizado e fácil de entender
- **Princípio da Responsabilidade Única (Single Responsibility)**: Toda a inteligência e as regras de negócio foram removidas do Controller e encapsuladas em classes com um único propósito. Os controladores permanecem limpos (Thin Controllers), atuando estritamente no fluxo de entrada e saída HTTP.
- **Desacoplamento**: Lógicas cruciais como o cálculo da distribuição automática e persistência ficam isoladas de requisições web, permitindo que sejam facilmente testadas ou reutilizadas no futuro por comandos CLI ou jobs.

#### 2. **Enums para Valores Fixos**
- **Type-Safety**: O uso de PHP Backed Enums (`TicketStatus` e `TicketPriority`) impede o armazenamento de valores corrompidos ou inválidos no banco de dados. Os Enums centralizam métodos de conveniência como `label()` para a interface visual.

#### 3. **Distribuição Automática Inteligente**
- **Otimização de Query**: O algoritmo de balanço de carga computa os chamados utilizando `withCount()` diretamente via banco de dados (SQLite), filtrando estritamente as tarefas sob carga operacional ativa (`OPEN` e `IN_PROGRESS`). Isso delega a carga computacional de agregação para o motor de banco de dados, evitando carregar coleções inteiras em memória no PHP.

---

## 🖥️ Pré-requisitos

Antes de executar o projeto, certifique-se de possuir instalado:

- PHP 8.2 ou superior (com extensão PDO SQLite ativa)
- Composer 2.x
- Node.js 18 ou superior
- npm 9 ou superior
- Git

Verifique as versões instaladas:

```bash
php -v
composer -V
node -v
npm -v
git --version
```

## Testes

O projeto possui testes automatizados cobrindo as regras principais do domínio de chamados:

- criação manual de chamados;
- criação com atribuição automática;
- distribuição para o responsável com menor quantidade de chamados em aberto;
- garantia de que chamados resolvidos ou fechados não entram no cálculo de distribuição.

---

## 📦 Instalação

### 1. Clonar o repositório
```bash
git clone <seu-repositorio>
cd SistemaDeChamadosInterno
```

### 2. **Instale as dependências PHP**
```bash
composer install
```

### 3. **Instale as dependências JavaScript**
```bash
npm install
```

### 4. **Configure o arquivo `.env`**
```bash
cp .env.example .env
php artisan key:generate
```
Nota: O projeto está pré-configurado para utilizar SQLite. Não há necessidade de configurar servidores ou senhas extras de banco de dados locais.

**Configurações importantes do `.env`:**
```env
APP_NAME="Sistema de Chamados Interno"
APP_ENV=local
APP_KEY=base64:Ff/V0QyvEzkAmTurULnX+npZ00PD8uhiQejDIXl2mwI=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
# CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"

```

### 5. **Execute as migrações e popular dados (Seeders)**
```bash
php artisan migrate
php artisan migrate --seed
```
Dica: Ao rodar o comando pela primeira vez, o Laravel 11 identificará que o arquivo database.sqlite não existe e perguntará se deseja criá-lo. Digite yes (ou sim) no terminal.

### 6. **Popule o banco com dados iniciais**
```bash
php artisan db:seed
```

Isso criará 3 responsáveis de exemplo:
- Ana Suporte (ana@empresa.com)
- Bruno TI (bruno@empresa.com)
- Carla Administrativo (carla@empresa.com)

---

## ⚙️ Configuração

### Criando novos responsáveis

Se precisar adicionar mais responsáveis, edite [database/seeders/ResponsibleSeeder.php](database/seeders/ResponsibleSeeder.php):

```php
Responsible::create([
    'name' => 'Novo Responsável',
    'email' => 'novo@empresa.com',
]);
```

Depois execute:
```bash
php artisan db:seed --class=ResponsibleSeeder
```

### Alterando valores padrão de Status e Prioridade

Edite os enums em `app/Enums/`:
- [TicketStatus.php](app/Enums/TicketStatus.php)
- [TicketPriority.php](app/Enums/TicketPriority.php)

🔑 Credenciais de Acesso (Importante)
O comando de seeders cria automaticamente uma conta de usuário de testes e os 3 técnicos responsáveis exigidos pelo desafio:

E-mail de Login: test@example.com

Senha padrão: password

Técnicos Criados no Banco:

Ana Suporte (ana@empresa.com)

Bruno TI (bruno@empresa.com)

Carla Administrativo (carla@empresa.com)

---

## ▶️ Execução

### Em desenvolvimento

**Terminal 1 - Backend Laravel:**
```bash
php artisan serve
```
A aplicação estará disponível em `http://localhost:8000`

**Terminal 2 - Frontend com Hot Reload:**
```bash
npm run dev
```
### Executando Testes Automatizados 🧪
**Caso queira validar os fluxos e as regras de negócio das Actions e Controllers, execute:**

```bash
php artisan test
```

### Em produção

**Build dos assets:**
```bash
npm run build
```

**Start do servidor:**
```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## 🎯 Uso

### Acessando a aplicação

1. Abra `http://localhost:8000` no navegador
2. A primeira tela será a listagem de chamados
3. Clique em **"Novo Chamado"** para criar um

### Criando um chamado

1. Preencha os campos obrigatórios:
   - **Título**: Breve descrição do problema
   - **Descrição**: Detalhes completos
   - **Prioridade**: Baixa, Média ou Alta

2. Escolha o responsável:
   - **Manual**: Selecione um responsável na lista
   - **Automático**: Marque "Atribuir automaticamente" (será atribuído ao com menos chamados em aberto)

3. Clique em **"Criar Chamado"**

### Listando chamados

Na página principal, você pode:
- **Buscar**: Por título do chamado
- **Filtrar por Status**: Aberto, Em andamento, Resolvido, Fechado
- **Filtrar por Prioridade**: Baixa, Média, Alta
- **Filtrar por Responsável**: Selecione um responsável específico

Os chamados são ordenados por data de abertura (mais recentes primeiro).

### Visualizando um chamado

Clique em **"Ver"** na tabela para ver todos os detalhes:
- Título, Descrição
- Status e Prioridade
- Responsável atribuído
- Data de abertura
- Datas de criação/atualização

### Editando um chamado

1. Clique em **"Editar"** na tabela ou na página de visualização
2. Altere os dados necessários (todos os campos)
3. Você pode reatribuir ou usar a distribuição automática
4. Clique em **"Atualizar Chamado"**

---

## 🔧 Funcionalidades Implementadas

### ✅ 1. Documentação (1.0)
- [x] README com instruções de instalação e execução
- [x] Justificativas de escolhas tecnológicas e arquiteturais

### ✅ 2. Cadastro de Chamados (2.0)
- [x] Cadastro de chamados (2.1)
- [x] Edição de chamados (2.1)
- [x] Listagem de chamados (2.1)
- [x] Visualização de chamados (2.1)
- [x] Campos obrigatórios (2.2):
  - [x] Título
  - [x] Descrição
  - [x] Prioridade (Baixa, Média, Alta)
  - [x] Status (Aberto, Em andamento, Resolvido, Fechado)
  - [x] Responsável pelo atendimento
  - [x] Data e hora de abertura
- [x] Campos adicionais (2.3):
  - [x] Timestamps (created_at, updated_at)

### ✅ 3. Responsáveis pelo Atendimento (3.0)
- [x] Manutenção de conjunto de responsáveis (3.1)
- [x] 3+ responsáveis disponíveis (3.4) - Ana, Bruno, Carla
- [x] Seleção de responsáveis ao criar/editar (3.3)
- [x] Sem interface de CRUD para responsáveis (3.2) - como solicitado

### ✅ 4. Distribuição Automática (4.0)
- [x] Opção de atribuição automática (4.1)
- [x] Atribui ao responsável com menos chamados em aberto (4.1)
- [x] Seleção manual também disponível (4.2)
- [x] "Em aberto" = OPEN ou IN_PROGRESS (4.3)

### ✅ 5. Listagem e Acompanhamento (5.0)
- [x] Tela de listagem de chamados (5.1)
- [x] Filtros por status (5.2)
- [x] Filtros por prioridade (5.2)
- [x] Filtros por responsável (5.2)
- [x] Busca por título (5.2)
- [x] Ordenação por data (mais recentes primeiro) (5.2)
- [x] Paginação (10 por página) (5.2)

### ✅ 6. Funcionamento da Aplicação (6.0)
- [x] Executável localmente (6.1)
- [x] Documentação de setup (6.2)
- [x] Dependências documentadas (6.2)
- [x] Decisões justificadas (6.2)

---

## 🧪 Estrutura do Projeto

```
app/
├── Actions/Tickets/           # Lógica de negócio
│   ├── CreateTicketAction.php
│   ├── UpdateTicketAction.php
│   └── AssignTicketAutomaticallyAction.php
├── Enums/                      # Valores fixos type-safe
│   ├── TicketStatus.php
│   └── TicketPriority.php
├── Http/
│   ├── Controllers/TicketController.php
│   ├── Requests/               # Validação
│   │   ├── StoreTicketRequest.php
│   │   └── UpdateTicketRequest.php
│   └── Middleware/
├── Models/                     # Eloquent Models
│   ├── Ticket.php
│   ├── Responsible.php
│   └── User.php
└── Providers/

database/
├── migrations/                 # Schema do banco
├── seeders/                    # Dados iniciais
│   ├── DatabaseSeeder.php
│   └── ResponsibleSeeder.php
└── factories/

resources/
├── js/
│   ├── Pages/Tickets/         # Páginas Vue
│   │   ├── Index.vue          # Listagem
│   │   ├── Create.vue         # Criar
│   │   ├── Edit.vue           # Editar
│   │   └── Show.vue           # Visualizar
│   ├── Components/Tickets/    # Componentes reutilizáveis
│   │   ├── TicketForm.vue
│   │   ├── TicketStatusBadge.vue
│   │   └── TicketPriorityBadge.vue
│   ├── Layouts/               # Layouts
│   │   └── AuthenticatedLayout.vue
│   └── app.js                 # Entry point

routes/
├── web.php                    # Rotas web
└── auth.php                   # Rotas de autenticação

config/                        # Configurações Laravel
```

---

## 🚀 Próximos Passos Possíveis

- [ ] Adicionar testes automatizados (PHPUnit + Vitest)
- [ ] Sistema de notificações em tempo real (Laravel Reverb / WebSockets).
- [ ] Implementar soft deletes para chamados
- [ ] Adicionar comentários/notas em chamados
- [ ] Histórico de mudanças (activity log)
- [ ] Notificações por email
- [ ] Relatórios de produtividade
- [ ] Dark mode na UI
- [ ] Exportar chamados para PDF/Excel

---

## 📞 Suporte

Para dúvidas ou problemas:

1. Verifique se todas as dependências estão instaladas
2. Confirme que o `.env` está configurado corretamente
3. Execute `php artisan migrate:fresh --seed` para resetar o banco
4. Verifique os logs em `storage/logs/`

---


