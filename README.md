# 📡 Sistema de Cadastro de Antenas - Spassu

Sistema web para gerenciamento de antenas de transmissão, desenvolvido em PHP com Laravel.

## 🚀 Tecnologias Utilizadas

- **PHP** 8.2+
- **Laravel** 11.x
- **Tailwind CSS** 3.x
- **SQLite** (desenvolvimento) / **MySQL** (produção)
- **Alpine.js** para interatividade
- **Leaflet.js** para mapas

## 📋 Requisitos do Sistema

- PHP >= 8.2
- Composer
- Node.js >= 18.x
- NPM ou Yarn
- Extensões PHP: `pdo`, `mbstring`, `xml`, `gd`, `sqlite3` ou `mysql`

## 🔧 Instalação

### 1. Clone o repositório

```bash
git clone <url-do-repositorio>
cd spassu-cadastro-antenas
```

### 2. Instale as dependências

```bash
# Dependências PHP
composer install

# Dependências JavaScript
npm install
```

### 3. Configure o ambiente

```bash
# Copie o arquivo de ambiente
cp .env.example .env

# Gere a chave da aplicação
php artisan key:generate
```

### 4. Configure o banco de dados

Edite o arquivo `.env` e configure sua conexão de banco:

```env
DB_CONNECTION=sqlite
# OU para MySQL:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=antenas
# DB_USERNAME=root
# DB_PASSWORD=
```

### 5. Execute as migrations

```bash
php artisan migrate
```

### 6. Crie o link simbólico para storage

```bash
php artisan storage:link
```

### 7. Compile os assets

```bash
# Desenvolvimento
npm run dev

# Produção
npm run build
```

### 8. Inicie o servidor

```bash
php artisan serve
```

Acesse: `http://localhost:8000`

## 📊 Carga de Dados (100 mil registros)

Para demonstração da performance com grande volume de dados:

```bash
# Carrega 100.000 antenas
php artisan antenas:load

# Ou especifique a quantidade
php artisan antenas:load 50000
```

⏱️ **Tempo estimado:** ~30-60 segundos (dependendo do hardware)

## 🧪 Testes

```bash
# Rodar todos os testes
php artisan test

# Testes com coverage
php artisan test --coverage

# Testes específicos
php artisan test --filter=IbgeServiceTest
```

## 🏗️ Arquitetura do Projeto

```
app/
├── Http/
│   └── Controllers/
│       └── AntenaController.php      # Controller principal
├── Models/
│   └── Antena.php                    # Model com validações
├── Repositories/
│   ├── AntenaRepository.php          # Implementação do repositório
│   └── Contracts/
│       └── AntenaRepositoryInterface.php  # Interface
├── Services/
│   └── IbgeService.php               # Consumo da API do IBGE
└── Console/
    └── Commands/
        └── LoadMassiveAntennas.php   # Comando de carga massiva
```

### Padrões Adotados

- **Repository Pattern**: Separação da lógica de acesso a dados
- **Service Layer**: Lógica de negócio isolada
- **Dependency Injection**: Controllers recebem dependências via construtor
- **PSR-12**: Padrão de código seguido
- **SOLID**: Princípios aplicados na arquitetura

## 📱 Funcionalidades

### ✔️ Públicas (sem autenticação)
- Listagem de antenas com paginação
- Visualização individual de antena
- Mapa com localização (latitude/longitude)
- Ranking top 5 UFs com mais antenas

### 🔒 Protegidas (requer login)
- Cadastro de nova antena
- Edição de antena existente
- Exclusão de antena (com confirmação)
- Upload de foto (PNG/JPG, max 2MB)
- Dashboard do usuário

### 🔐 Autenticação
- Registro de novo usuário
- Login / Logout
- Recuperação de senha

## 🗃️ Estrutura do Banco

### Tabela: `antenas`

| Campo | Tipo | Obrigatório | Validações |
|-------|------|-------------|------------|
| id | integer | ✅ | Auto-increment |
| descricao | varchar(100) | ✅ | Min: 10, Max: 100, Único |
| latitude | decimal(10,7) | ✅ | Entre -90 e 90 |
| longitude | decimal(10,7) | ✅ | Entre -180 e 180 |
| uf | char(2) | ✅ | 2 caracteres |
| altura | decimal(5,2) | ✅ | Maior que 0 |
| data_implantacao | date | ❌ | Formato: Y-m-d |
| foto | varchar(255) | ❌ | PNG ou JPG |
| created_at | timestamp | ✅ | - |
| updated_at | timestamp | ✅ | - |
| deleted_at | timestamp | ❌ | Soft delete |

### Índices
- Primary Key: `id`
- Unique: `descricao`
- Index: `uf` (performance no ranking)

## 🔌 Integração com API Externa

### IBGE - Localidades

O sistema consome a API do IBGE para popular o combo de UFs:

**Endpoint:** `https://servicodados.ibge.gov.br/api/v1/localidades/estados`

**Características:**
- Cache de 24 horas para performance
- Fallback para lista estática em caso de falha
- Timeout de 10 segundos
- 3 tentativas de retry

## 🎨 Interface

- **Framework CSS**: Tailwind CSS
- **Componentes**: Alpine.js
- **Design**: Responsivo (mobile-first)
- **Acessibilidade**: Semântica HTML5, labels adequados
- **UX**: Mensagens de feedback, loading states

## 🔒 Segurança

- ✅ Validação server-side de todos os inputs
- ✅ Proteção CSRF em formulários
- ✅ Sanitização de uploads
- ✅ Prepared statements (Eloquent ORM)
- ✅ Hash bcrypt para senhas
- ✅ Middleware de autenticação

## ⚡ Performance

- **Paginação**: 50 registros por página
- **Cache**: API IBGE (24h)
- **Eager Loading**: Previne N+1 queries
- **Batch Insert**: 1000 registros por transação
- **Índices**: UF para queries de ranking

## 📖 Decisões Técnicas

### Por que Repository Pattern?
Facilita testes, manutenção e possível troca de ORM no futuro.

### Por que cache na API IBGE?
Estados brasileiros raramente mudam. Cache reduz latência e dependência externa.

### Por que SQLite para desenvolvimento?
Zero configuração, perfeito para desenvolvimento local.
Mesmo assim foi utilizado: Mysql com um banco local

### Por que não UUID?
Para 100k registros, auto-increment é mais performático. UUID seria ideal para sistema distribuído.

## 👤 Credenciais de Teste

Após rodar as migrations, crie um usuário:

```bash
php artisan tinker
>>> User::create(['name' => 'Teste', 'email' => 'teste@teste.com', 'password' => bcrypt('12345678')])
```

**Login:**
- Email: `teste@spassu.com`
- Senha: `senha123`

## 🐛 Troubleshooting

### Erro de permissão no storage

```bash
chmod -R 775 storage bootstrap/cache
```

### Link simbólico não funciona

```bash
php artisan storage:link
```

### NPM não compila assets

```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```

## 📝 TODO / Melhorias Futuras

- [ ] Testes de integração completos
- [ ] PHPStan level 8
- [ ] Docker / Laravel Sail
- [ ] CI/CD com GitLab CI
- [ ] Export CSV/Excel
- [ ] Filtros avançados
- [ ] API REST documentada
- [ ] Dashboard com gráficos

## 📄 Licença

Este projeto foi desenvolvido como avaliação técnica para a Spassu.

## 👨‍💻 Desenvolvedor

**Marcio Holanda de Andrade**
- Email: marcio.hol@hotmail.com
- LinkedIn: [seu-linkedin]
- GitHub: [seu-github]

---

**Desenvolvido com ❤️ usando Laravel**
