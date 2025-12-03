# ðŸŽ“ UniSin - Plataforma de GamificaÃ§Ã£o Educacional

## ðŸŒŸ VisÃ£o Geral do Projeto

O UniSin Ã© uma plataforma educacional inovadora que utiliza a **gamificaÃ§Ã£o** para tornar o aprendizado mais envolvente e eficaz. Desenvolvido com uma arquitetura **Full-Stack**, o projeto Ã© dividido em um **Backend** robusto em PHP (Laravel) e um **Frontend** dinÃ¢mico em React.js.

O objetivo principal Ã© transformar a experiÃªncia de estudo, aplicando elementos de jogos como pontos, rankings, conquistas e desafios (PvP - Player versus Player) para motivar alunos e fornecer ferramentas de gestÃ£o e acompanhamento para professores e administradores escolares.

## ðŸ› ï¸ Tecnologias Utilizadas

| Categoria | Tecnologia | DescriÃ§Ã£o |
| :--- | :--- | :--- |
| **Backend** | PHP (Laravel) | Framework robusto para a API e lÃ³gica de negÃ³cio. |
| **Frontend** | React.js | Biblioteca JavaScript para a construÃ§Ã£o da interface do usuÃ¡rio. |
| **EstilizaÃ§Ã£o** | CSS Modules | Para escopo de estilos e manutenÃ§Ã£o facilitada. |
| **Banco de Dados** | MySQL/PostgreSQL (a ser confirmado) | Armazenamento de dados de usuÃ¡rios, atividades, rankings e inventÃ¡rio. |
| **ContainerizaÃ§Ã£o** | Docker | Para garantir um ambiente de desenvolvimento e produÃ§Ã£o consistente. |

## ðŸš€ Estrutura do Projeto

O repositÃ³rio estÃ¡ organizado em duas principais pastas:

- `backend/`: ContÃ©m toda a lÃ³gica de servidor, API RESTful e conexÃ£o com o banco de dados.
- `frontend/`: ContÃ©m a aplicaÃ§Ã£o web construÃ­da em React, incluindo componentes, rotas e a interface do usuÃ¡rio.

## ðŸ–¼ï¸ Prints de Tela (Screenshots)

Aqui vocÃª pode visualizar a interface da plataforma em aÃ§Ã£o.

| Tela | DescriÃ§Ã£o |
| :--- | :--- |
| **Login** | Tela de acesso para alunos, professores e administradores. |
| **Dashboard do Aluno** | VisÃ£o geral do progresso, ranking e moedas. |
| **Trilha de Aprendizagem** | VisualizaÃ§Ã£o das atividades e mÃ³dulos gamificados. |
| **InventÃ¡rio e Loja** | Itens e customizaÃ§Ãµes disponÃ­veis para o aluno. |
| **Perfil** | Dados de progresso e conquistas. |

<!-- ESPAÃ‡O PARA PRINTS DE TELA -->
<p align="center">
  <img src="./imagens-readme/login.png" alt="Tela de Login" width="45%">
  <img src="./imagens-readme/dashboard.png" alt="Tela de Dashboard" width="45%">
</p>
<p align="center">
  <img src="./imagens-readme/trilha.png" alt="Trilha de Aprendizagem" width="45%">
</p>

<p align="center">
  <img src="./imagens-readme/inventario.png" alt="Tela de InventÃ¡rio" width="45%">
  <img src="./imagens-readme/loja.png" alt="Tela da Loja" width="45%">
</p>
<p align="center">
  <img src="./imagens-readme/perfil.png" alt="Tela de Perfil" width="45%">
</p>

## âš™ï¸ Como Configurar e Executar o Projeto

Para rodar o projeto localmente, siga os passos abaixo:

1. **PrÃ©-requisitos:** Certifique-se de ter o Docker e o Docker Compose instalados.
2. **Clonar o RepositÃ³rio:**
   ```bash
   git clone https://github.com/saulobbarbosa/unisin-repo.git
   cd unisin-repo
   ```
3. **ConfiguraÃ§Ã£o do Backend (Laravel):**
   - Crie o arquivo de variÃ¡veis de ambiente: `cp backend/.env.example backend/.env`
   - Configure as variÃ¡veis de banco de dados e outras chaves necessÃ¡rias no arquivo `.env`.
4. **Executar com Docker Compose:**
   ```bash
   docker-compose up -d --build
   ```
5. **InstalaÃ§Ã£o de DependÃªncias e MigraÃ§Ãµes (Backend):**
   - Acesse o container do backend: `docker exec -it unisin-repo_backend_1 bash` (o nome do container pode variar)
   - Instale as dependÃªncias: `composer install`
   - Execute as migraÃ§Ãµes do banco de dados: `php artisan migrate --seed`
6. **InstalaÃ§Ã£o de DependÃªncias (Frontend):**
   - Acesse a pasta do frontend: `cd frontend`
   - Instale as dependÃªncias: `npm install` ou `yarn install`
7. **Acessar a AplicaÃ§Ã£o:**
   - O Frontend estarÃ¡ disponÃ­vel em `http://localhost:3000` (ou a porta configurada no Dockerfile/React).
   - A API do Backend estarÃ¡ disponÃ­vel em `http://localhost:8000/api` (ou a porta configurada).

## ðŸ¤ ContribuiÃ§Ã£o

Sinta-se Ã  vontade para contribuir com o projeto. Por favor, siga as diretrizes de contribuiÃ§Ã£o (a ser criado) e o CÃ³digo de Conduta (a ser criado).

## ðŸ“ LicenÃ§a

Este projeto estÃ¡ licenciado sob a LicenÃ§a MIT. Veja o arquivo `LICENSE` para mais detalhes.

## ðŸ“ž Contato

Desenvolvido por [Seu Nome/Equipe] - [Seu Email/Link para Perfil].
