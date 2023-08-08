<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body>
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

        <div class="row d-flex align-items-stretch" id="groupList">
     
        <?php foreach ($grupos as $grupo) : ?>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= $grupo['subject'] ?></h5>
                        <p class="card-text"><?= (isset($grupo['desc'])) ? $grupo['desc'] : '' ?></p>
                        <p class="card-text">Owner: <?= (isset($grupo['owner'])) ? $grupo['owner'] : '' ?></p>
                        <p class="card-text">Subject Time: <?= $grupo['subjectTime'] ?></p>
                        <p class="card-text">Creation: <?= $grupo['creation'] ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
         
        </div>

        <!-- Botão para enviar os grupos selecionados por POST -->
        <button type="button" class="btn btn-primary mt-3" id="sendGroupsBtn">Enviar Grupos Selecionados</button>
    </div>


    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>


</body>

</html>