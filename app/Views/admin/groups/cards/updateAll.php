<?= $this->section('cssLink') ?>
<!-- multi.js css -->
<link rel="stylesheet" type="text/css" href="/assets/libs/multi.js/multi.min.css" />
<!-- autocomplete css -->
<link rel="stylesheet" href="/assets/libs/@tarekraafat/autocomplete.js/css/autoComplete.css">
<?= $this->endSection() ?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0 flex-grow-1">
                    Configure seu envio.
                    <br>
                    instância <b class="text-info"><?= $rowInstance['profile_name'] ?></b> selecionada
                </h4>
            </div><!-- end card header -->
            <div class="card-body">
                <?= form_open('api/v1/groups/updateall') ?>
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="">Escolha os grupos</label>
                            <select multiple="multiple" name="groups[]" id="multiselect-optiongroup">
                                <optgroup label="Superadmin">
                                    <?php foreach ($rowGroup as $list) : ?>
                                        <?php if ($list['owner'] == $rowInstance['owner']) : ?>
                                            <option value="<?= $list['id_group'] ?>"><?= $list['subject'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </optgroup>

                                <!-- <optgroup label="Admin">
                                    
                                </optgroup> -->

                                <optgroup label="Participante">
                                    <?php foreach ($rowGroup as $list) : ?>
                                        <?php if ($list['owner'] != $rowInstance['owner']) : ?>
                                            <option value="<?= $list['id_group'] ?>"><?= $list['subject'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </optgroup>
                            </select>
                            <div class="mt-3 alert alert-info alert-dismissible bg-info text-white alert-label-icon fade show" role="alert">
                                <i class="ri-user-smile-line label-icon"></i><strong>Ei</strong> para selecionar os grupos, clique sobre eles. Os grupos para os quais as mensagens serão enviadas estão localizados à direita.
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image">Troque a imagem dos grupos</label>
                            <input type="url" class="form-control" name="image" id="image" placeholder="https://sua-imagem.png">
                        </div>
                        <div class="mb-3">
                            <label for="titulo">Título do grupo</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Nome para o grupo">
                            <small>Exemplo de como o nome ficaria: Meu Grupo [1]</small>
                        </div>
                        <div class="mb-3">
                            <label for="desc">Descrição do grupo</label>
                            <input type="text" class="form-control" name="desc" id="desc" placeholder="Uma descrição qualquer...">
                        </div>

                        <div class="mb-3">
                            <label for="trancar">Segurança</label>
                            <select class="form-select" name="trancar" id="trancar">
                                <option value="">Selecione uma opção</option>
                                <option value="open">Abrir grupos</option>
                                <option value="close">Fechar grupos</option>
                            </select>
                        </div>

                        <input type="hidden" name="apiurl" value="<?= $rowInstance['server_url'] ?>">
                        <input type="hidden" name="instance" value="<?= $rowInstance['name'] ?>">
                        <input type="hidden" name="apikey" value="<?= $rowInstance['api_key'] ?>">
                        <div class="text-end">
                            <button type="submit" class="btn btn-info" id="sendButton">ENVIAR</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->section('js') ?>
<!-- multi.js -->
<script src="/assets/libs/multi.js/multi.min.js"></script>
<script>
    var multiSelectOptGroup = document.getElementById("multiselect-optiongroup");
    if (multiSelectOptGroup) {
        multi(multiSelectOptGroup, {
            enable_search: true
        });
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        var allowedExtensions = ['jpg', 'png', 'mp4', 'pdf', 'xlsx', 'zip', 'mp3', 'jpeg'];
        $('#archive').on('input', function() {
            var url = $(this).val();
            var extension = url.split('.').pop().toLowerCase();
            if ($.inArray(extension, allowedExtensions) === -1) {
                $('#errorMessage').show();
                $('#errorMessageText').text('Extensão inválida para envio. As extensões permitidas são: <br><b>' + allowedExtensions.join(', ')) + '</b>';
                //$(this).val('');
                $('#sendButton').prop('disabled', true); // Desabilita o botão
            } else {
                $('#errorMessage').hide();
                $('errorMessageText').text('');
                $('#sendButton').prop('disabled', false); // Desabilita o botão
            }
        });
    });



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

                //console.log(response);

                setTimeout(function() {
                    window.location.reload(); // Esconde a mensagem após um curto período de tempo
                }, 3000); // Tempo em milissegundos (aqui definido para 3 segundos)

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
</script>
<?= $this->endSection() ?>