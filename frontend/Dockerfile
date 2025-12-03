FROM node:20-alpine

# Definir diretório de trabalho
WORKDIR /app

# Copiar arquivos de dependências
COPY package*.json ./

# Instalar dependências
RUN npm install

# Copiar o restante do código
COPY . .

# Expor a porta 3000 (padrão do React)
EXPOSE 3000

# Comando para iniciar a aplicação
CMD ["npm", "start"]