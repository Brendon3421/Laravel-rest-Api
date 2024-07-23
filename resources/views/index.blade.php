<!DOCTYPE html>
<html lang="PT-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-rBSK8Lq8Q9HE0tLbjeToYpiHzHWEhljE8RSBwbJ3IqDdjP1IM+uw5kYMkMjqdPr" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>NexusTalk</title>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
</head>

<body>
    <header>
        <nav class="section__container nav__container">
            <ul class="nav__link">
                <div class="nav__logo">Nexus <span>Talk</span><span class="beta">.beta</span></div>
                <li class="link"><a href="">home</a></li>
                <li class="link"><a href="#service">Oque fazemos</a></li>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    Login
                </button>
            </ul>
            <button class="btn">Suporte</button>
        </nav>
        <div class="header__container">
            <h1>Nexus<p>Talk</p>
            </h1>
            <div class="header__form">
                <form action="">
                    <h4>Fique por dentro das novidades</h4>
                    <input type="text" placeholder="Seu primeiro nome">
                    <input type="text" placeholder="Seu Ultimo nome">
                    <input type="text" placeholder="Email">
                    <input type="text" placeholder="Celular">
                    <div class="button btn form__btn">Enviar</div>
                </form>
            </div>
        </div>
    </header>

    <section class="section__container service__container" id="service">
        <div class="service__header">
            <div class="service__header_content">
                <h2 class="section__header">Serviços</h2>
                <p>
                    Chat Instantâneo: Além das videochamadas, a plataforma oferece uma funcionalidade de chat
                    instantâneo para comunicação rápida e eficiente. Compartilhe mensagens, arquivos e mídias de forma
                    conveniente.
                </p>
            </div>
        </div>
        <div class="service__grid">
            <div class="service__card">
                <span><i class="ri-video-chat-line"></i></span>
                <h4>Sistema de Video</h4>
                <p>
                    Videochamadas de Qualidade Superior: Desfrute de videochamadas cristalinas e nítidas,
                    independentemente da distância geográfica.
                    O NexusTalk utiliza tecnologia avançada para garantir uma experiência visual imersiva.
                </p>
                <a href="#">Saiba mais</a>
            </div>
            <div class="service__card">
                <span><i class="ri-chat-1-line"></i></span>
                <h4> Chat Instantâneo</h4>
                <p>
                    Além das videochamadas, a plataforma oferece uma funcionalidade de chat instantâneo para comunicação
                    rápida e
                    eficiente. Compartilhe mensagens, arquivos e mídias de forma conveniente.
                </p>
                <a href="#">Saiba mais</a>
            </div>
            <div class="service__card">
                <span><i class="ri-hospital-line"></i></span>
                <h4>Perfil Personalizado</h4>
                <p>
                    Personalização de Perfil: Crie seu perfil personalizado,
                    adicione foto e status, tornando suas interações mais pessoais e significativas.
                </p>
                <a href="#">Saiba mais</a>
            </div>
        </div>
    </section>

    <!-- Modal Login -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        @include('forms.login')
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#ModalRegistro">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Registro -->
    <div class="modal fade" id="ModalRegistro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="ModalRegistroLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalRegistroLabel">Registro</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        @include('forms.registrarUser')
                    </div>
                </div>
                
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>

<script>
    function alertinua() {
        alert("chamou o botao");
    }
</script>
