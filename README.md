# TesteBoostech

Este é o projeto desenvolvido para o teste técnico da empresa Boostech. O desafio consiste na criação de um sistema completo para o sorteio de amigo secreto.

## Desenvolvido por:

- [@AndreMeneses0103](https://github.com/AndreMeneses0103)

## 🔗 Links

[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/andre-meneses-dev/)

[![github](https://img.shields.io/badge/github-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/AndreMeneses0103)

  
## Requisitos

- PHP
- Composer
- Laravel
- MySql


## Banco de Dados

Para utilizar o projeto, é necessário ter o banco de dados MySql instalado em sua máquina. Nele, você deve apenas executar esse código:
```bash
    create database amigo_secreto
```
Não é necessário criar tabelas, pois o Laravel realizará a criação.

## Comandos para Recriar o Projeto

Para recriar este projeto em seu ambiente local, siga as instruções abaixo:

1. **Clone o Repositório:**
```bash
  git clone https://github.com/AndreMeneses0103/TesteBoostech.git
```

2. **Acesse o Diretório do Projeto:**

```bash
  cd amigo_secreto
```

3. **Instale as Dependências com Composer**
```bash
    composer install
```

4. **Abra o arquivo .env e altere as configurações do banco de dados de acordo com o seu MySQL:**
```bash
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=amigo_secreto
  DB_USERNAME=seu_usuario
  DB_PASSWORD=sua_senha
```

5. **Execute os Migrations e Seeders juntos (aqui as tabelas serão criadas no banco):**
```bash
      php artisan migrate --seed
```

6. **Inicie o projeto**
```bash
     php artisan serve
```

7. **Acesse a página de Login no seu navegador para usar o sistema**
 ```bash
     http://localhost:8000/
```

## Considerações Finais

Este projeto foi desenvolvido como parte do teste prático da empresa Boostech. Sinta-se à vontade para explorar este projeto. Se tiver alguma dúvida ou problema, não hesite em entrar em contato. Desde já, agradeço pela oportunidade!
