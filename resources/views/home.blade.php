<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container mt-5">
        <!-- Título e botão de cadastro -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Lista de Pessoas</h1>
            <a href="cadastro" class="btn btn-primary">Cadastrar Nova Pessoa</a>
        </div>

        <!-- Barra de pesquisa -->
        <div class="mb-4">
            <input type="text" id="searchInput" class="form-control" placeholder="Pesquisar por nome ou email">
        </div>

        <!-- Tabela -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody id="pessoa-table-body">
                <!-- Mais linhas podem ser adicionadas aqui -->
            </tbody>
        </table>

        <!-- Botão de Sorteio centralizado -->
        <div class="d-flex justify-content-center mt-4">
            <button id="sorteioButton" class="btn btn-success">Sorteio</button>
        </div>
    </div>

    <script>
        let pessoas = [];

        function isLogged() {
            const user = JSON.parse(sessionStorage.getItem('user'));
            if (!user) {
                alert("Faça o login primeiro!");
                window.location.href = '/';
            } else {
                if (user.cargo !== "admin") {
                    alert("Voce nao tem permissao para acessar essa pagina.");
                    window.location.href = "/sorteio"
                } else {
                    fetchPessoas();
                }
            }
        }

        async function fetchPessoas() {
            const response = await fetch('/pessoas/all');
            if (response) {
                pessoas = await response.json();
                const tableBody = document.getElementById('pessoa-table-body');

                tableBody.innerHTML = '';

                pessoas.forEach(pessoa => {
                    if (pessoa.cargo !== "admin") {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                    <td>${pessoa.id}</td>
                    <td>${pessoa.nome}</td>
                    <td>${pessoa.email}</td>
                    <td>
                        <a href="/cadastro/${pessoa.id}" class="btn btn-warning btn-sm me-3">Editar</a>
                        <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(${pessoa.id})">Deletar</a>
                    </td>
                `;
                        tableBody.appendChild(row);
                    }
                });
            }
        }

        async function checkSorteio() {
            const pessoasSemAdmin = pessoas.filter(pessoa => pessoa.cargo !== 'admin');

            const allHaveReferenceId = pessoasSemAdmin.every(pessoa => pessoa.referencia_pessoa_id !== null);

            if (allHaveReferenceId) {
                window.location.href = '/sorteio';
            } else {
                try {
                    const response = await fetch('/pessoas/sorteio', {
                        method: 'POST' // ou o método que você usa
                    });

                    if (response.ok) {
                        window.location.href = '/sorteio';
                    } else {
                        alert('Erro ao realizar o sorteio.');
                    }
                } catch (error) {
                    console.error('Erro:', error);
                    alert('Ocorreu um erro ao tentar realizar o sorteio.');
                }
            }
        }


        function filterTable() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const tableBody = document.getElementById('pessoa-table-body');

            tableBody.innerHTML = '';

            const filteredPessoas = pessoas.filter(pessoa =>
                pessoa.nome.toLowerCase().includes(searchInput) ||
                pessoa.email.toLowerCase().includes(searchInput)
            );

            filteredPessoas.forEach(pessoa => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${pessoa.id}</td>
                <td>${pessoa.nome}</td>
                <td>${pessoa.email}</td>
                <td>
                    <a href="#" class="btn btn-warning btn-sm me-3">Editar</a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete(${pessoa.id})">Deletar</a>
                </td>
            `;
                tableBody.appendChild(row);
            });
        }

        function confirmDelete(id) {
            if (confirm("Tem certeza que deseja deletar esta pessoa?")) {
                deletePessoa(id);
            }
        }

        async function deletePessoa(id) {
            const response = await fetch(`/pessoas/delete/${id}`, {
                method: 'DELETE',
            });

            if (response.ok) {
                fetchPessoas();
            } else {
                alert('Erro ao deletar a pessoa.');
            }
        }

        document.addEventListener('DOMContentLoaded', isLogged);

        document.getElementById('searchInput').addEventListener('input', filterTable);

        document.getElementById('sorteioButton').addEventListener('click', checkSorteio);
    </script>
</body>

</html>
