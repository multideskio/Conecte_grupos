<h3 class="mb-0 pb-1">INSTÂNCIAS</h3>
<div class="row justify-content-center">
    <?php foreach ($instances as $instance) : ?>
        <div class="col-xl-4 d-flex justify-content-center">
            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0"><?= $instance['name'] ?></h6>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mx-auto avatar-md mb-3">
                        <img src="<?= $instance['profile_picture_url'] ?>" alt="" class="img-fluid rounded-circle">
                    </div>
                    <h5 class="card-title mb-1"><?= $instance['profile_name'] ?></h5>
                    <p class="text-muted mb-1"><?= $instance['profile_status'] ?></p>
                    <p class="text-muted mb-1" data-bs-toggle="tooltip" title="Sua chave API"><?= $instance['api_key'] ?></p>
                    <p class="text-muted mb-1" data-bs-toggle="tooltip" title="URL DA API"><?= $instance['server_url'] ?></p>
                    <p class="text-muted mb-1" data-bs-toggle="tooltip" title="Status da instância">
                        <?php if ($instance['status'] == 'open') : ?>
                            <span class="badge bg-success">Aberta</span>
                        <?php elseif ($instance['status'] == 'connecting') : ?>
                            <span class="badge bg-warning">Conectando</span>
                        <?php elseif ($instance['status'] == 'close') : ?>
                            <span class="badge bg-danger">Fechada</span>
                        <?php endif; ?>
                    </p>
                    <ul class="list-inline" style="font-size: 24px;">
                        <li class="list-inline-item">
                            <a href="javascript:void(0);" class="lh-3 align-middle link-success">
                                <i class="ri-camera-fill"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript:void(0);" class="lh-1 align-middle link-primary">
                                <i class="ri-loader-fill"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="javascript:void(0);" class="lh-1 align-middle link-danger">
                                <i class="ri-login-box-line"></i>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-footer text-center m-0 p-0">
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#novaCampanaModal">Criar Campanha</button>
                        <button type="button" class="btn btn-dark">Agendar mensagem</button>
                        <button type="button" class="btn btn-dark">Enviar mensagem</button>
                    </div>
                </div>
            </div>
        </div><!-- end col -->
    <?php endforeach; ?>
</div><!-- end row -->