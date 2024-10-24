<!doctype html>
<html lang="en">

<head>
    <title>Cadastro/Editar</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body class="bg-light">
    <main class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 20rem;">
            <div class="card-body">
                <h5 class="card-title text-center">Cadastro/Editar Usuário</h5>
                <form id="userForm">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" placeholder="Digite seu nome"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Digite seu email"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" minlength="8" placeholder="Digite sua senha">
                        <small id="passwordHelp" class="form-text text-muted">A senha é obrigatória apenas para novos
                            usuários.</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                </form>
            </div>
        </div>
    </main>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>

    <script>
        function isLogged() {
            const user = JSON.parse(sessionStorage.getItem('user'));
            if (!user) {
                alert("Faça o login primeiro!");
                window.location.href = '/';
            } else {
                if (user.cargo !== "admin") {
                    alert("Voce nao tem permissao para acessar essa pagina.");
                    window.location.href = "/"
                }
            }
        }
        async function fetchUserData(id) {
            const response = await fetch(`/pessoas/${id}`);
            if (response.ok) {
                const userData = await response.json();
                document.getElementById('name').value = userData.pessoa.nome || '';
                document.getElementById('email').value = userData.pessoa.email || '';
                document.getElementById('password').removeAttribute('required');
                document.getElementById('passwordHelp').textContent = "Deixe em branco para manter a senha atual.";
            } else {
                console.error('Usuário não encontrado');
            }
        }

        function getIdFromUrl() {
            const pathSegments = window.location.pathname.split('/');
            return pathSegments[2] || '';
        }

        const userId = getIdFromUrl();
        if (userId) {
            fetchUserData(userId);
        } else {
            document.getElementById('password').setAttribute('required', 'required');
        }

        document.getElementById('userForm').addEventListener('submit', async function(event) {
            event.preventDefault();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (userId) {
                const resp = await fetch(`/pessoas/update/${userId}`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        nome: name,
                        email: email,
                        senha: password
                    })
                });

                const data = await resp.json();

                if (data.errors && data.errors.email) {
                    alert("Email já cadastrado");
                }

                if(data && data.user){
                    alert("Usuario atualizado com sucesso!");
                    window.location.href = '/home';
                }
            } else {
                const resp = await fetch('/pessoas/new', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        nome: name,
                        email: email,
                        senha: password,
                        cargo: "user"
                    })
                });

                const data = await resp.json();

                if (data.errors && data.errors.email) {
                    alert("Email já cadastrado");
                }

                if(data && data.data){
                    alert("Usuario cadastrado com sucesso!");
                    window.location.href = '/home';
                }
            }

        });

        document.addEventListener('DOMContentLoaded', isLogged);
    </script>
</body>

</html>
