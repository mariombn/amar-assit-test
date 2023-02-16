FROM node:18

WORKDIR /app

COPY package*.json ./

RUN npm install -g @vue/cli
RUN npm install @vue/cli-service
RUN npm install

COPY . .

EXPOSE 3000

CMD ["npm", "run", "serve"]