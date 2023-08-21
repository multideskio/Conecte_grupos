<!-- modalQrCode Modal -->
<div class="modal fade" id="modalQrCode" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalQrCodeLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <img class="img-fluid" id="imageQrCode" alt="qrcode">
                <div class="mt-4">
                    <h4 class="mb-3">Leia o QrCode para conectar</h4>
                    <p class="text-muted mb-4">Após <span id="countdown">30</span> segundos a página será atualizada</p>
                    <div class="hstack gap-2 justify-content-center">
                        <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Cancelar</a>
                        <a href="javascript:void(0);" class="btn btn-success">Completo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>