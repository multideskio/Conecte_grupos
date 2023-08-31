<div class="row">

    <?php
    foreach ($campanhas as $campanha) : ?>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"><?= $campanha['name'] ?></h4>
                    <div class="flex-shrink-0">
                        <div class="dropdown card-header-dropdown">
                            <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="text-muted"><i class="mdi mdi-dots-vertical align-middle fs-3 ms-0"></i></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="#">Editar</a>
                                <a class="dropdown-item" href="#">Atualizar membros</a>
                                <a class="dropdown-item" href="#">Fechar grupos em massa</a>
                                <a class="dropdown-item" href="#">Leads</a>
                                <a class="dropdown-item" href="#">Relatórios</a>
                                <a class="dropdown-item" href="#">Revisar links dos grupos</a>
                                <a class="dropdown-item" href="#">Remover membros</a>
                                <a class="dropdown-item" href="#">Excluir</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body ">
                    <div class="mx-auto avatar-md mb-4 text-center">
                        <?php $img = $files->select('slug')->find($campanha['image']) ?>
                        <img src="<?= (cdngroup($img['slug'])) ?? null ?>" alt="Image groups" class="img-fluid rounded-circle">
                    </div>
                    <div class="card-title mb-2 text-center fs-6">
                        <?= site_url("g/d/{$campanha['slug']}") ?>
                    </div>
                    <div class="">
                        <div class="mb-2">
                            <b>Grupos: </b>0
                        </div>
                        <div class="mb-2">
                            <b>Limite de membros: </b>0
                        </div>
                        <div class="mb-2">
                            <b>Membros: </b>0
                        </div>
                        <div class="mb-2">
                            <b>Cliques: </b>0
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-success btn-lg fs-5">
                            Ver grupos
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>