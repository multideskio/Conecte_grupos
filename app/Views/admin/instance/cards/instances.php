<div class="row mb-3 pb-1">
    <div class="col-12">
        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
            <div class="flex-grow-1">
                <h4 class="fs-16 mb-1"><span id="saudacao"></span>, <?= primaryName(session('user')['name']) ?>!</h4>
                <p class="text-muted mb-0">Gerencie sua instâncias de forma prática e rápida. Você também pode atualizar seu perfil através do nosso Painel.</p>
            </div>
            <div class="mt-3 mt-lg-0">
                <!--end col-->
                <div class="col-auto">
                    <button type="button" class="btn btn-soft-success" id="syncButton"><i class="ri-restart-line align-middle me-1"></i> Sincronizar instâncias</button>
                </div>
                <!--end col-->
            </div>
        </div><!-- end card header -->
    </div>
    <!--end col-->
</div>
<!--end row-->
<div class="row mb-3 pb-1">
    <div class="col-12">
        <!-- Primary Alert -->
        <div class="alert alert-primary alert-dismissible bg-primary text-white alert-label-icon fade show" role="alert">
            <i class="ri-user-smile-line label-icon"></i><strong>Dica</strong> - Se a sua instância aparece como desconectada mesma estando conectada, faça uma sincronização.
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>

<div class="noresult" style="display: none;" id="syncMessage">
    <div class="text-center">
        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
        <h5 class="mt-2" id="syncMessageText">Buscando instâncias</h5>
        <p class="text-muted mb-0"></p>
    </div>
</div>

<div class="row" id="cards-container" style="display: none;">
    <!-- Cards serão adicionados aqui dinamicamente -->
</div>



<?= $this->section('js') ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        // Função para criar um card com os dados
        function createCard(data) {
            var statusBadge = '';
            if (data.status === 'open') {
                statusBadge = '<span class="badge bg-success">Aberta</span>';
            } else if (data.status === 'connecting') {
                statusBadge = '<span class="badge bg-warning">Conectando</span>';
            } else if (data.status === 'close') {
                statusBadge = '<span class="badge bg-danger">Fechada</span>';
            }

            // Verifica se o URL da imagem é nulo
            var imageUrl = data.profile_picture_url ? data.profile_picture_url : 'https://placehold.co/100x100';

            var card = `
        <div class="col-xl-4 col-md-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">${data.name}</h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted">Opções <i class="mdi mdi-dots-vertical align-middle fs-16 ms-0"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" style="">
                                <a class="dropdown-item" href="#">Editar perfil</a>
                                <a class="dropdown-item" href="${baseUrl}dashboard/schedule/${data.name}">Agendar mensagem</a>
                                <a class="dropdown-item" href="${baseUrl}dashboard/send/${data.name}">Enviar mensagem</a>
                                <a class="dropdown-item sincronizaGrupos" href="javascript:void(0);" data-instance="${data.name}">Sincronizar grupos</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mx-auto avatar-md mb-3">
                        <img src="${imageUrl}" alt="" class="img-fluid rounded-circle ${data.name}">
                    </div>
                    <h5 class="card-title mb-1">${data.profile_name}</h5>
                    <p class="text-muted mb-1">${data.profile_status}</p>
                    <p class="text-muted mb-1">${data.phone}</p>
                    <p class="text-muted mb-1" data-bs-toggle="tooltip" title="Sua chave API">${data.api_key}</p>
                    <p class="text-muted mb-1" data-bs-toggle="tooltip" title="URL DA API">${data.server_url}</p>
                    <p class="text-muted mb-1" data-bs-toggle="tooltip" title="Status da instância">${statusBadge}</p>
                    <ul class="list-inline" style="font-size: 24px;">
                        <li class="list-inline-item">
                            <a href="javascript:void(0);" class="lh-3 align-middle link-success conectar-link" data-instance="${data.name}" data-apikey="${data.api_key}">
                                <i class="ri-camera-fill"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript:void(0);" class="lh-1 align-middle link-primary restart-link" data-instance="${data.name}" data-apikey="${data.api_key}">
                                <i class="ri-loader-fill"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript:void(0);" class="lh-1 align-middle link-danger desconect-link" data-instance="${data.name}" data-apikey="${data.api_key}">
                                <i class="ri-login-box-line"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        `;
            return card;
        }

        function instancias() {
            $('#cards-container').hide()
            $('#syncButton').prop('disabled', true); // Desabilita o botão
            $('#syncMessage').show(); // Mostra a mensagem de sincronização
            // Buscar os dados da API
            $.getJSON(baseUrl + "/api/v1/instances", function(data) {
                var cardsContainer = $('#cards-container');
                cardsContainer.empty(); // Limpar o conteúdo anterior dos cards
                data.forEach(function(item) {
                    var card = createCard(item);
                    cardsContainer.append(card);
                });

                $('#syncButton').prop('disabled', false); // Habilita o botão novamente
                $('#syncMessage').hide(); // Esconde a mensagem após um curto período de tempo
                $('#cards-container').show()
            });

        }


        // Função para sincronizar e atualizar os cards
        function sincronize() {
            $('#cards-container').hide()
            $('#syncMessageText').text('Sincronização inciada.');
            $('#syncButton').prop('disabled', true); // Desabilita o botão
            $('#syncMessage').show(); // Mostra a mensagem de sincronização
            $.get(baseUrl + "api/v1/instances/sincronize", function() {
                instancias();
            }).always(function() {
                $('#syncMessageText').text('Sincronização concluída.'); // Altera a mensagem quando a sincronização termina
                $('#syncButton').prop('disabled', false); // Habilita o botão novamente
                setTimeout(function() {
                    $('#syncMessage').hide(); // Esconde a mensagem após um curto período de tempo
                }, 3000); // Tempo em milissegundos (aqui definido para 3 segundos)
            });
        }





        // Função genérica para executar ações
        function performAction(actionType, instance, apikey) {
            $('#syncButton').prop('disabled', true);
            $.ajax({
                type: "POST",
                url: baseUrl + `api/v1/instances/${actionType}`,
                data: {
                    instance: instance,
                    apikey: apikey
                },
                success: function(response) {
                    console.log(`${actionType} com sucesso...`);
                    if (actionType == 'conectar') {
                        $("#modalQrCode").modal('show');
                        $('#imageQrCode').attr('src', response.base64);
                        if (response.pairingCode) {
                            $('#textConnect').html(response.pairingCode)
                        }
                        updateCountdown();
                    }
                    instancias();
                },
                error: function(xhr, status, error) {
                    console.error(`Erro durante ${actionType}:`, error);
                    $('#syncMessageText').text(`Erro durante ${actionType}: ${error}`);
                    // Mostrar mensagem de erro para o usuário
                }
            });
        }



        // Usando a função genérica para diferentes ações
        $(document).on('click', '.desconect-link', function() {
            var instance = $(this).data('instance');
            var apikey = $(this).data('apikey');
            $('#cards-container').hide()
            $('#syncMessage').show()
            $('#syncMessageText').text(`Desconectando instância  ${instance}.`);
            performAction('disconnect', instance, apikey);
        });

        $(document).on('click', '.restart-link', function() {
            var instance = $(this).data('instance');
            var apikey = $(this).data('apikey');
            $('#cards-container').hide()
            $('#syncMessage').show()
            $('#syncMessageText').text(`Sincronizando  ${instance}.`);
            performAction('restart', instance, apikey);
        });

        $(document).on('click', '.conectar-link', function() {
            var instance = $(this).data('instance');
            var apikey = $(this).data('apikey');
            $('#cards-container').hide()
            $('#syncMessage').show()
            $('#syncMessageText').text(`Gerando QR Code para a instância ${instance}.`);
            performAction('conectar', instance, apikey);
        });

        var seconds = 30;

        // Função para atualizar o contador regressivo
        function updateCountdown() {
            console.log('Iniciou contagem...')
            if (seconds > 0) {
                $("#countdown").text(seconds);
                seconds--;
                setTimeout(updateCountdown, 1000); // Chama a função novamente após 1 segundo
            } else {
                sincronize();
                // Atualiza a página após 30 segundos
                setTimeout(function() {
                    window.location.reload(); // Esconde a mensagem após um curto período de tempo
                }, 3000); // Tempo em milissegundos (aqui definido para 3 segundos)

            }
        }

        $('#syncButton').click(sincronize);
        instancias();










        function sincronizeGroups(instance) {
            Toastify({
                text: "Sincronizando grupos",
                duration: 3000,
                style: {
                    background: "linear-gradient(to right, #0011ff, #1d5d8f)",
                },
            }).showToast();

            $.ajax({
                type: "PUT",
                url: `${baseUrl}api/v1/groups/sincronize/${instance}`,
                dataType: "json",
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    Toastify({
                        text: "Os grupos foram sincronizados com sucesso",
                        duration: 5000,
                        style: {
                            background: "linear-gradient(to right, #569701, #2e8f1d)",
                        },
                    }).showToast();

                    console.log(response);

                },
                error: function(xhr, status, error) {
                    Toastify({
                        text: `Houve um problema ao sincronizar, verifique a data!`,
                        duration: 7000,
                        style: {
                            background: "linear-gradient(to right, #ff3838, #ff3e3e)",
                        },
                    }).showToast();

                    console.log(error)
                }
            });
        }

        //SINCRONIZA GRUPOS
        $(document).on('click', '.sincronizaGrupos', function() {
            var instance = $(this).data('instance');
            sincronizeGroups(instance);
        });
    });
</script>
<?= $this->endSection() ?>