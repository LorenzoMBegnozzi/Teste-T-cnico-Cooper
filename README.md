# Cadastro de Clientes em PHP

Sistema simples de gerenciamento de clientes em **PHP**, seguindo a arquitetura **MVC**, com validação de formulários e controle de duplicidade de emails

## Funcionalidades

- ✅ Listar clientes
- ✅ Criar novo cliente
- ✅ Editar cliente existente
- ✅ Excluir cliente
- ✅ Validação básica de campos:
  - Nome obrigatório (mínimo 3 caracteres)
  - Email obrigatório e válido
  - Telefone opcional (somente números e símbolos válidos)
  - Checagem de email duplicado
  - Checagem de CPF duplicado
 
## Como Rodar:
1. Inicie os containers: 
  docker-compose up -d

2. Acesse no navegador
   http://localhost:8080/clients
