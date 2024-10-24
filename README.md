# TesteBoostech

Este é o projeto desenvolvido para o teste técnico da empresa Boostech. O desafio consiste na criação de um sistema completo para o sorteio de amigo secreto.

## Desenvolvido por:

- [@AndreMeneses0103](https://github.com/AndreMeneses0103)

## 🔗 Links

[![linkedin](https://img.shields.io/badge/linkedin-0A66C2?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/andre-meneses-dev/)

[![github](https://img.shields.io/badge/github-181717?style=for-the-badge&logo=github&logoColor=white)](https://github.com/AndreMeneses0103)

  
## Requisitos

- PHP 8
- Composer
- Laravel 11
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

## Funcionalidades extras
- **Sistema de Login**: Desenvolvi um sistema de login com usuários e administradores. Somente o administrador tem acesso ao gerenciamento de usuários e pode realizar o sorteio. Os usuários comuns podem fazer login e ver somente quem sortearam.


## Funcionamento do Sistema
### Pagina de Login
Nesta página, os usuários podem inserir suas credenciais para acessar o sistema, separando administrador dos usuários.
![image](https://github.com/user-attachments/assets/7d1eea10-e833-47ec-9141-0e538b822109)


### Página Home
A página inicial exibe os usuários cadastrados no sistema, com opções de cadastro, edição, remoção ou busca.
![image](https://github.com/user-attachments/assets/16edef56-34f3-4e78-b26b-885173efc0fd)


### Página Cadastro/Edição
A pagina de cadastro/edição permite o administrador cadastrar ou editar usuarios, dependendo da opção selecionada na página home.
![image](https://github.com/user-attachments/assets/112135be-2c3f-438e-bfa4-3aa2ae816ec5)



### Página do Sorteio
A página de sorteio é onde o administrador pode realizar o sorteio dos amigos secretos, e os usuários podem visualizar quem foi sorteado.
![image](https://github.com/user-attachments/assets/8d30a7cb-2875-485e-96a8-7618bd66b652)


## Considerações Finais

Este projeto foi desenvolvido como parte do teste prático da empresa Boostech. Sinta-se à vontade para explorar este projeto. Se tiver alguma dúvida ou problema, não hesite em entrar em contato. Desde já, agradeço pela oportunidade!
