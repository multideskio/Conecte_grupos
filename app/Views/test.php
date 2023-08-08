<!-- Inclua o jQuery e o Bootstrap no seu HTML -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">



<!-- Os cards Bootstrap para exibir os dados -->
<div class="container mt-4">
    <div class="form-group">
        <input type="text" class="form-control" id="searchInput" placeholder="Digite o nome do grupo">
    </div>

    <!-- Checkbox para selecionar todos -->
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="SelectAll" id="selectAll">
        <label class="form-check-label" for="selectAll">
            Selecionar Todos
        </label>
    </div>

    <div class="row d-flex align-items-stretch" id="groupList"></div>

    <!-- Botão para enviar os grupos selecionados por POST -->
    <button type="button" class="btn btn-primary mt-3" id="sendGroupsBtn">Enviar Grupos Selecionados</button>
</div>

<!-- O script AJAX para obter os dados e exibir nos cards -->
<script>
    $(document).ready(function() {
        // Array para armazenar todos os grupos retornados pela API
        var allGroups = [];

        $.ajax({
            url: 'http://localhost:8081/api/v1/groups/meupessoal', // URL da API com o termo de pesquisa 'watsapp_dinamus'
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                allGroups = data;
                renderGroups(allGroups); // Função para renderizar todos os grupos na página
            },
            error: function(xhr, status, error) {
                console.error('Erro ao obter os dados: ' + error);
            }
        });

        // Função para renderizar os grupos na página
        function renderGroups(groups) {
            var groupList = $('#groupList');
            groupList.empty();

            $.each(groups, function(index, group) {
                var card = `
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column">
                                <div class="form-check">
                                    <input class="form-check-input group-checkbox" type="checkbox" value="${group.owner}" id="checkGroup${group.owner}">
                                    <label class="form-check-label" for="checkGroup${group.owner}">
                                        Selecionar para enviar mensagem
                                    </label>
                                </div>
                                <br>
                                <h5 class="card-title">${group.subject}</h5>
                                <p class="card-text">${group.desc || ''}</p>
                                <p class="card-text">Owner: ${group.owner}</p>
                                <p class="card-text">Subject Time: ${group.subjectTime}</p>
                                <p class="card-text">Creation: ${group.creation}</p>
                            </div>
                        </div>
                    </div>
                `;

                groupList.append(card);
            });
        }

        // Função para realizar a pesquisa nos dados já retornados
        function searchGroups(searchTerm) {
            var filteredGroups = allGroups.filter(function(group) {
                return group.subject.toLowerCase().includes(searchTerm.toLowerCase());
            });
            renderGroups(filteredGroups);
        }

        // Evento de digitação no campo de busca
        $('#searchInput').on('input', function() {
            var searchTerm = $(this).val();
            searchGroups(searchTerm);
        });

        // Evento de seleção dos checkboxes dos Owners
        $(document).on('change', '.group-checkbox', function() {
            var selectedOwners = [];
            $('.group-checkbox:checked').each(function() {
                if ($(this).val() !== 'SelectAll') {
                    selectedOwners.push($(this).val());
                }
            });

            if (selectedOwners.length > 0) {
                var selectedGroups = allGroups.filter(function(group) {
                    return selectedOwners.includes(group.owner);
                });
                renderGroups(selectedGroups);
            } else {
                renderGroups(allGroups);
            }
        });

        // Evento do botão para enviar os grupos selecionados por POST
        $('#sendGroupsBtn').on('click', function() {
            var selectedOwners = [];
            $('.group-checkbox:checked').each(function() {
                if ($(this).val() !== 'SelectAll') {
                    selectedOwners.push($(this).val());
                }
            });

            if (selectedOwners.length > 0) {
                // Enviar os grupos selecionados por POST para outra página usando AJAX
                $.ajax({
                    url: 'caminho/para/outro/script.php', // Substitua pelo caminho do script PHP que receberá os grupos selecionados
                    method: 'POST',
                    data: {
                        selectedOwners: selectedOwners
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Trate a resposta do servidor aqui, se necessário
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao enviar os grupos selecionados: ' + error);
                    }
                });
            } else {
                alert('Selecione pelo menos um grupo para enviar a mensagem.');
            }
        });
    });
</script>