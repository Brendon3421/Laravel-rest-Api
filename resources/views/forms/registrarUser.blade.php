<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-step Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-M7a/7i8F+IgeMTS2xHjQzU/q9N6FbOm69ckkF9eZ5JPR2Wq2TXMVAMNXjYJfI3u8" crossorigin="anonymous">

    <style>
        .step {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div id="alert-container"></div>
        <!-- Progress bar -->
        <div class="row">
            <h2>Progresso</h2>
        </div>
        <div class="progress mb-4">
            <div id="progress-bar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                aria-valuemin="0" aria-valuemax="100"></div>
        </div>

        <form id="multi-step-form" enctype="multipart/form-data">
            @csrf
            <!-- Step 1: User Information -->
            <div class="step">
                <div class="form-group">
                    <label for="name">Nome Completo*</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                    <span class="text-danger" id="name-error"></span>
                </div>
                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <span class="text-danger" id="email-error"></span>
                </div>
                <div class="form-group">
                    <label for="password">Senha*</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <span class="text-danger" id="password-error"></span>
                </div>
                <div class="form-group">
                    <label for="genero">Gênero*</label>
                    <select class="form-control" id="genero" name="genero_id" required>
                        @foreach ($generos as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="genero-error"></span>
                </div>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 2: Address Information -->
            <div class="step">
                <div class="form-group">
                    <label for="nome_endereco">Nome do Endereço *</label>
                    <input type="text" class="form-control" id="nome_endereco" name="name" required>
                    <span class="text-danger" id="nome_endereco-error"></span>
                </div>
                <div class="form-group">
                    <label for="cep">CEP*</label>
                    <input type="text" class="form-control" id="cep" name="cep" required>
                    <span class="text-danger" id="cep-error"></span>
                </div>
                <div class="form-group">
                    <label for="rua">Rua*</label>
                    <input type="text" class="form-control" id="rua" name="rua" required>
                    <span class="text-danger" id="rua-error"></span>
                </div>
                <div class="form-group">
                    <label for="complemento">Complemento</label>
                    <input type="text" class="form-control" id="complemento" name="complemento">
                    <span class="text-danger" id="complemento-error"></span>
                </div>
                <div class="form-group">
                    <label for="numero">Número*</label>
                    <input type="text" class="form-control" id="numero" name="numero" required>
                    <span class="text-danger" id="numero-error"></span>
                </div>
                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 3: Contact Information -->
            <div class="step">
                <div class="form-group">
                    <label for="contact_name">Nome*</label>
                    <input type="text" class="form-control" id="contact_name" name="nome" required>
                    <span class="text-danger" id="contact_name-error"></span>
                </div>
                <div class="form-group">
                    <label for="contact_email">Email*</label>
                    <input type="email" class="form-control" id="contact_email" name="email" required>
                    <span class="text-danger" id="contact_email-error"></span>
                </div>
                <div class="form-group">
                    <label for="celular">Celular*</label>
                    <input type="text" class="form-control" id="celular" name="celular" required>
                    <span class="text-danger" id="celular-error"></span>
                </div>
                <div class="form-group">
                    <label for="telefone_fixo">Telefone Fixo*</label>
                    <input type="text" class="form-control" id="telefone_fixo" name="telefone_fixo" required>
                    <span class="text-danger" id="telefone_fixo-error"></span>
                </div>
                <div class="form-group">
                    <label for="imagem">Imagem (jpg, png, gif, svg)</label>
                    <input type="file" class="form-control" id="imagem" name="imagem"
                        accept=".jpg,.jpeg,.png,.gif,.svg">
                    <span class="text-danger" id="imagem-error"></span>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea class="form-control" id="descricao" name="descricao"></textarea>
                    <span class="text-danger" id="descricao-error"></span>
                </div>
                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 4: Contact Information -->
            <div class="step">
                <div class="form-group">
                    <label for="role">Regra de Usuário</label>
                    <select class="form-control" id="role" name="role_id">
                        @foreach ($role as $r)
                            <option value="{{ $r->id }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="role-error"></span>
                </div>
                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <div class="step">
                <div id="company-form" class="step" style="display: none;">
                    <h4>Cadastro de Empresa</h4>
                    <div class="form-group">
                        <label for="company_name">Nome da Empresa*</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" required>
                        <span class="text-danger" id="company_name-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="company_cnpj">CNPJ*</label>
                        <input type="text" class="form-control" id="company_cnpj" name="company_cnpj" required>
                        <span class="text-danger" id="company_cnpj-error"></span>
                    </div>
                    <!-- Outros campos de cadastro de empresa -->
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
            </div>

        </form>
    </div>

    <script>
        document.getElementById('role').addEventListener('change', function() {
            const selectedRole = this.value;
            const companyForm = document.getElementById('company-form');

            // Supondo que o ID do super-admin seja "1"
            if (selectedRole === '1') {
                companyForm.style.display = 'block';
            } else {
                companyForm.style.display = 'none';
            }
        });

        let currentStep = 0;
        showStep(currentStep);

        function showStep(step) {
            const steps = document.getElementsByClassName('step');
            steps[step].style.display = 'block';
            updateProgressBar(step);
        }

        function nextStep() {
            const steps = document.getElementsByClassName('step');
            steps[currentStep].style.display = 'none';
            currentStep++;
            if (currentStep >= steps.length) {
                currentStep = steps.length - 1;
            }
            showStep(currentStep);
        }

        function prevStep() {
            const steps = document.getElementsByClassName('step');
            steps[currentStep].style.display = 'none';
            currentStep--;
            if (currentStep < 0) {
                currentStep = 0;
            }
            showStep(currentStep);
        }

        function updateProgressBar(step) {
            const steps = document.getElementsByClassName('step');
            const progress = ((step + 1) / steps.length) * 100;
            const progressBar = document.getElementById('progress-bar');
            progressBar.style.width = `${progress}%`;
            progressBar.setAttribute('aria-valuenow', progress);
        }

        document.getElementById('multi-step-form').addEventListener('submit', async function(event) {
            event.preventDefault();

            // Clear previous error messages
            document.getElementById('name-error').textContent = '';
            document.getElementById('email-error').textContent = '';
            document.getElementById('password-error').textContent = '';
            document.getElementById('genero-error').textContent = '';
            document.getElementById('nome_endereco-error').textContent = '';
            document.getElementById('cep-error').textContent = '';
            document.getElementById('rua-error').textContent = '';
            document.getElementById('complemento-error').textContent = '';
            document.getElementById('numero-error').textContent = '';
            document.getElementById('contact_name-error').textContent = '';
            document.getElementById('contact_email-error').textContent = '';
            document.getElementById('celular-error').textContent = '';
            document.getElementById('telefone_fixo-error').textContent = '';
            document.getElementById('imagem-error').textContent = '';
            document.getElementById('descricao-error').textContent = '';
            document.getElementById('alert-container').innerHTML = '';

            // Gather form data
            const formData = new FormData(this);

            // Log FormData content
            for (const [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            try {
                // Send data to the server using fetch
                const response = await fetch("{{ route('register.post.api') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                // Process server response
                const data = await response.json();

                if (response.ok) {
                    // Success - Show success message and redirect
                    const alertContainer = document.getElementById('alert-container');
                    const successAlert = document.createElement('div');
                    successAlert.className = 'alert alert-success';
                    successAlert.textContent = data.message || 'Usuário cadastrado com sucesso!';
                    alertContainer.appendChild(successAlert);
                    // Redirect after a few seconds
                    setTimeout(() => {
                        window.location.href = '/dashboard'; // Replace with the desired path
                    }, 2000);
                } else {
                    // Errors - Show error messages
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
