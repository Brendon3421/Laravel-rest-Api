<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuário</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <!-- Formulário de Registro (registrarUser.blade.php) -->
    <div class="container mt-5">
        <div id="alert-container"></div>
        <form id="user-form">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
                <span class="text-danger" id="name-error"></span>
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <span class="text-danger" id="email-error"></span>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <span class="text-danger" id="password-error"></span>
            </div>
            <div class="form-group">
                <div class="form-floating">
                    <select class="form-select" id="floatingSelect" name="genero_id" aria-label="Floating label select example">
                        @foreach ($generos as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                    <label for="floatingSelect">Genero</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        document.getElementById('user-form').addEventListener('submit', async function(event) {
            event.preventDefault();

            // Limpar mensagens de erro anteriores
            document.getElementById('name-error').textContent = '';
            document.getElementById('email-error').textContent = '';
            document.getElementById('password-error').textContent = '';
            document.getElementById('alert-container').innerHTML = '';

            // Obter dados do formulário
            const formData = new FormData(this);

            try {
                // Enviar dados para o servidor usando fetch
                const response = await fetch("{{ route('register.post.api') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                // Processar resposta do servidor
                const data = await response.json();

                if (response.ok) {
                    // Sucesso - Exibir mensagem de sucesso e redirecionar
                    const alertContainer = document.getElementById('alert-container');
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success';
                    successAlert.textContent = data.message || 'Usuário cadastrado com sucesso!';
                    alertContainer.appendChild(successAlert);

                    // Redirecionar após alguns segundos
                    setTimeout(() => {
                        window.location.href = '/home.dashboard'; // Substitua pelo caminho desejado
                    }, 2000);
                } else {
                    // Erros - Mostrar mensagens de erro no modal de registro
                    if (data.errors) {
                        for (const key in data.errors) {
                            if (data.errors.hasOwnProperty(key)) {
                                document.getElementById(`${key}-error`).textContent = data.errors[key][0];
                            }
                        }
                    } else {
                        const alertContainer = document.getElementById('alert-container');
                        const errorAlert = document.createElement('div');
                        errorAlert.className = 'alert alert-danger';
                        errorAlert.textContent = data.message || 'Erro ao cadastrar usuário';
                        alertContainer.appendChild(errorAlert);
                    }
                }
            } catch (error) {
                console.error('Erro:', error);
                const alertContainer = document.getElementById('alert-container');
                const errorAlert = document.createElement('div');
                errorAlert.className = 'alert alert-danger';
                errorAlert.textContent = 'Ocorreu um erro ao tentar cadastrar o usuário';
                alertContainer.appendChild(errorAlert);
            }
        });
    </script>
</body>

</html>
