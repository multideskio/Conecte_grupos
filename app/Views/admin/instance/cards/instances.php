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