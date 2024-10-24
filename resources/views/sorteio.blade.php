<!doctype html>
<html lang="en">

<head>
    <title>Sorteio de Amigo Secreto</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Resultado do Sorteio de Amigo Secreto</h2>

        <div class="d-flex justify-content-center">
            <table class="table table-striped" style="width: 50%;">
                <thead>
                    <tr>
                        <th scope="col">Pessoa</th>
                        <th scope="col">Sorteado</th>
                    </tr>
                </thead>
                <tbody id="sorteio-results">
                    <!-- Os resultados do sorteio serão inseridos aqui -->
                </tbody>
            </table>
        </div>

        <div class="text-center mb-4">
            <div class="d-inline">
                <a href="/home" class="btn btn-primary" id="btn_voltar">Voltar</a>
            </div>
            <div class="d-inline">
                <button class="btn btn-success" onclick="novoSorteio()">Novo Sorteio</button>
            </div>
        </div>
    </div>

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
                    document.getElementById('btn_voltar').href = "/";
                    fetchOneSorteioResults(user.id);
                } else {
                    fetchSorteioResults();
                }
            }
        }
        async function fetchSorteioResults() {
            try {
                const response = await fetch('pessoas/resultado');
                if (!response.ok) {
                    throw new Error('Erro ao buscar os resultados do sorteio.');
                }

                const resultados = await response.json();

                const tableBody = document.getElementById('sorteio-results');
                tableBody.innerHTML = '';

                resultados.forEach(result => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${result.pessoa}</td>
                        <td>${result.quem_sorteou}</td>
                    `;
                    tableBody.appendChild(row);
                });
            } catch (error) {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao carregar os resultados do sorteio.');
            }
        }
        async function fetchOneSorteioResults(id) {
            try {
                const response = await fetch(`pessoas/resultado/${id}`);
                if (!response.ok) {
                    throw new Error('Erro ao buscar os resultados do sorteio.');
                }

                const resultado = await response.json();

                const tableBody = document.getElementById('sorteio-results');
                tableBody.innerHTML = '';

                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${resultado.pessoa}</td>
            <td>${resultado.quem_sorteou}</td>
        `;
                tableBody.appendChild(row);

            } catch (error) {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao carregar os resultados do sorteio.');
            }
        }


        document.addEventListener('DOMContentLoaded', isLogged);

        async function novoSorteio() {
            try {
                const response = await fetch('/pessoas/sorteio', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    }
                });

                if (response.ok) {
                    fetchSorteioResults();
                } else {
                    alert('Erro ao realizar o sorteio.');
                }
            } catch (error) {
                console.error('Erro:', error);
                alert('Ocorreu um erro ao tentar realizar o sorteio.');
            }
        }
    </script>
</body>

</html>
