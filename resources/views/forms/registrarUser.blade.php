<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-step Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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

        <form id="multi-step-form">
            @csrf
            <!-- Step 1 -->
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
                    <div class="form-floating">
                        <select class="form-select" id="floatingSelect" name="genero_id"
                            aria-label="Floating label select example">
                            @foreach ($generos as $g)
                                <option value="{{ $g->id }}">{{ $g->name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Genero*</label>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
            </div>

            <!-- Step 2 -->
            <div class="step">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nome">Nome do Endereço *</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                        <span class="text-danger" id="nome-error"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="cep">CEP*</label>
                        <input type="text" class="form-control" id="cep" name="cep" required>
                        <span class="text-danger" id="cep-error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rua">Rua*</label>
                    <input type="text" class="form-control" id="rua" name="rua" required>
                    <span class="text-danger" id="rua-error"></span>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="complemento">Complemento*</label>
                        <input type="text" class="form-control" id="complemento" name="complemento">
                        <span class="text-danger" id="complemento-error"></span>
                    </div>
                    <div class="col-md-6">
                        <label for="numero">Número*</label>
                        <input type="text" class="form-control" id="numero" name="numero" required>
                        <span class="text-danger" id="numero-error"></span>
                        <br></br>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-secondary" onclick="prevStep()">Previous</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>

            </div>
    </div>
    </form>
    </div>

    <script>
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
            document.getElementById('nome-error').textContent = '';
            document.getElementById('cep-error').textContent = '';
            document.getElementById('rua-error').textContent = '';
            document.getElementById('complemento-error').textContent = '';
            document.getElementById('numero-error').textContent = '';
            document.getElementById('alert-container').innerHTML = '';

            // Gather form data
            const formData = new FormData(this);

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
