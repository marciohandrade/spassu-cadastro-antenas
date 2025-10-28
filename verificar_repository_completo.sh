#!/bin/bash

echo "🔍 Verificando estrutura e conteúdo do Repository Pattern..."

# Funções utilitárias
check_dir() {
  [ -d "$1" ] && echo "✅ Diretório existe: $1" || echo "❌ Diretório faltando: $1"
}

check_file() {
  [ -f "$1" ] && echo "✅ Arquivo existe: $1" || echo "❌ Arquivo faltando: $1"
}

check_content() {
  local file="$1"
  local pattern="$2"
  local label="$3"
  if grep -q "$pattern" "$file"; then
    echo "✅ $label encontrado em $file"
  else
    echo "❌ $label NÃO encontrado em $file"
  fi
}

# Verificações de estrutura
check_dir "app/Repositories"
check_dir "app/Repositories/Contracts"
check_file "app/Repositories/Contracts/AntenaRepositoryInterface.php"
check_file "app/Repositories/AntenaRepository.php"
check_file "app/Providers/RepositoryServiceProvider.php"
check_file "app/Http/Controllers/AntenaController.php"
check_file "app/Http/Controllers/Api/AntenaController.php"

# Verificações de conteúdo da interface
check_content "app/Repositories/Contracts/AntenaRepositoryInterface.php" "namespace App\\Repositories\\Contracts;" "Namespace da interface"
check_content "app/Repositories/Contracts/AntenaRepositoryInterface.php" "interface AntenaRepositoryInterface" "Definição da interface"
check_content "app/Repositories/Contracts/AntenaRepositoryInterface.php" "public function all()" "Método all()"
check_content "app/Repositories/Contracts/AntenaRepositoryInterface.php" "public function topRanking" "Método topRanking()"
check_content "app/Repositories/Contracts/AntenaRepositoryInterface.php" "public function create" "Método create()"

# Verificações de conteúdo da implementação
check_content "app/Repositories/AntenaRepository.php" "namespace App\\Repositories;" "Namespace da implementação"
check_content "app/Repositories/AntenaRepository.php" "implements AntenaRepositoryInterface" "Implementação da interface"
check_content "app/Repositories/AntenaRepository.php" "public function all()" "Método all()"
check_content "app/Repositories/AntenaRepository.php" "public function topRanking" "Método topRanking()"
check_content "app/Repositories/AntenaRepository.php" "public function create" "Método create()"

# Verificações do Service Provider
check_content "app/Providers/RepositoryServiceProvider.php" "namespace App\\Providers;" "Namespace do provider"
check_content "app/Providers/RepositoryServiceProvider.php" "bind(AntenaRepositoryInterface::class, AntenaRepository::class)" "Bind da interface"

# Verificação de registro no bootstrap (Laravel 11)
check_content "bootstrap/app.php" "App\\Providers\\RepositoryServiceProvider::class" "Registro do provider no bootstrap"

# Verificações nos controllers
check_content "app/Http/Controllers/AntenaController.php" "use App\\Repositories\\Contracts\\AntenaRepositoryInterface;" "Uso da interface no controller web"
check_content "app/Http/Controllers/Api/AntenaController.php" "use App\\Repositories\\Contracts\\AntenaRepositoryInterface;" "Uso da interface no controller API"

echo "✅ Verificação concluída."
