<!doctype html>
<html lang="en">
<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />
</head>

<body class="bg-light">
    <main class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card" style="width: 20rem;">
            <div class="card-body">
                <h5 class="card-title text-center">Login</h5>
                <form id="loginForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" id="email" placeholder="Digite seu nome ou email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha</label>
                        <input type="password" class="form-control" id="password" placeholder="Digite sua senha" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
            </div>
        </div>
    </main>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"
    ></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"
    ></script>

    <script>
        const form = document.getElementById('loginForm');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Regex simples para validar email
            if (!emailPattern.test(email)) {
                alert('Por favor, insira um email válido.');
                return;
            }
            try {
                const response = await fetch('http://localhost:8000/pessoas/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email: email,
                        senha: password,
                    }),
                });

                if (response.ok) {
                    const result = await response.json();
                    alert('Login realizado com sucesso!');
                    sessionStorage.setItem("user", JSON.stringify(result.user));
                    if(result.user.cargo === "admin"){
                        window.location.href = '/home';
                    }else{
                        window.location.href = "/sorteio";
                    }
                } else {
                    const errorData = await response.json();
                    alert(errorData.message || 'Erro ao realizar login');
                }
            } catch (error) {
                alert('Erro ao conectar com o servidor');
                console.error('Erro:', error);
            }
        });
    </script>
</body>
</html>
