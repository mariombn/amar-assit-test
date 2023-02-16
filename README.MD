# 

## Requisitos para o ambiente de Desenvolvimento

- docker e docker-compose
- node e npm

## Instalação

Clone o repositório em um diretório
```bash
git clone git@github.com:mariombn/amar-assit-test.git amarassist
```
Acesse o diretório do node (front) do projeto e instale as dependências
```bash
cd amarassist/node
npm install
```
Agora, volte um diretório e rode o comando abaixo para iniciar os conteiners do docker
```bash
cd ..
docker-compose up
```
Uma vez que as imagens estejam rodando, vamos agora acessar a imagem do backend para instalar as dependências com o comando abaixo
```bash
docker exec -it amarassist_back bash
```
E uma vez dentro do conteiner, vamos instalar as dependências
```bash
composer install
```

E por fim, vamos rodar os comandos do artisan abaixo para criar as tabelas e a massa de testes inicial, alem das configurações do client do passport

```bash
cp .env.example .env
php artisan migrate
php artisan db:seed
php artisan passport:client
php artisan passport:install
php artisan key:generate
```

Também existem dois comandos que precisam ser todados para os devidos testes:

O comando abaixo vai gerar faturas para cada contrato de acordo com o dia. Pode ser necessário alterar o campo ciclo de alguma linha da tabela contracts para o dia atual caso não exista nenhum. A ideia é que esse comando rode uma vez por dia a partir de uma cron.
```bash
php artisan cron:generete-charges
```

O próximo comando também deve ser rodado diariamente. Ele é responsavel por calcular os Juros de todas as faturas que estão atrasadas.
```bash
php artisan cron:apply-fine-value
```

