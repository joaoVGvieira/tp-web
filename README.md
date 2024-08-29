# Biblioteca MyLibrary 📚
Projeto de gerenciamento de biblioteca.

## Como rodar? 
### Requisitos 
Primeiramente é necessário possuir os requisitos listados abaixo:
- PHP
- Composer
- Laravel
- npm
- MySQL

### Passo a passo


**1. .env.example, entao é so renomear este arquivo para .env:**

**2. É necessário instalar e atualizar as dependências do projeto e gerar a key:**
```
composer install
composer update
php artisan key:generate
```

**3. Agora mudar seguintes variáveis correspondentes ao Banco de Dados:**
<br>Antes:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Depois: 
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=projeto-biblioteca
DB_USERNAME=[seu usuario admin]
DB_PASSWORD=[sua senha admin]
```

**4. Com as dependências corretamente instaladas e o arquivo de variáveis configuradas, é hora de "buildar" o Jetstream + Livewire para realizar a autenticação do projeto com npm:**
```
npm install
npm run build
php artisan migrate
```
**5. Com tudo corretamente instalado, é hora de popularmos o Banco de Dados com alguns usuários e livros.**
```
```

**6. Agora so rodar**
```
php artisan serve
```

### Explicando a aplicação 
#### Banco de Dados
O Banco de Dados da biblioteca possui 3 tabelas:
- Usuários (users)
- Livros (books)
- Reservas (reservations)

### Livros
Os livros são ser cadastrados com nome, gênero, autor, número de registro, capa e sinopse.

### Usuários
Os usuários se diferem entre usuários administradores e usuarios comuns. <br>
Os usuários comuns possuem a atribuição de realizar a reserva de livros. <br>
Os usuários administradores possuem a atribuição de realizar a reserva de livros e também podem adicionar livros na biblioteca. <br>
Abaixo se encontram as credenciais de cada usuário criado no Seeder.

```
Usuário comum
login: usuario1@teste
senha: 1234
```
```
Usuário administrador
login: admin@teste
senha: 1234
```

