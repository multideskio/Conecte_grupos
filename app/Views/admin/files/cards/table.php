<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col">Titulo</th>
                        <th scope="col">URL</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($files as $file) : ?>
                        <tr class="">
                            <td scope="row"><?= $file['id'] ?></td>
                            <td>
                                <?= $file['title'] ?> <br>
                                <img src="<?= cdngroup($file['slug']) ?>" width="100px" class="img img-fluid rounded" alt="<?= $file['id'] ?>">
                            </td>
                            <td>
                                <a href="<?= cdngroup($file['slug']) ?>" target="_blank">
                                    <?= cdngroup($file['slug']) ?>
                                </a>
                            </td>
                            <td>R1C3</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <th>id</th>
                    <th>Titulo</th>
                    <th>URL</th>
                    <th>Ações</th>
                </tfoot>
            </table>
        </div>
    </div>
</div>