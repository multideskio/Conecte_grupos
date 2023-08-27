<!-- modalViewMessage Modal -->
<div class="modal fade" id="modalViewMessage" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="modalViewMessageLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-5">
                <div class="mt-4">
                    <h5 class="mb-4">
                        <b>Titulo:</b> <span id="messageTitleView"></span>
                    </h5>
                    <div id="mb-4">
                        <b>Data de envio: </b><span id="messageDateSendView"></span>
                        <b>Data cadastro: </b><span id="messageDateView"></span><br>
                    </div>
                    <div class="mb-3 mt-3">
                        <b>Sua mensagem:</b>
                        <div id="messageMessageView"></div>
                    </div>
                    <div class="mb-3">
                        <b>Arquivo:</b>
                        <div id="messageArchiveView"></div>
                    </div>
                    <div class="mb-3">
                        <b>Enviado para:</b>
                        <div id="messageDestineView"></div>
                    </div>
                    <div class="hstack gap-2 justify-content-center mt-5">
                        <a href="javascript:void(0);" class="btn btn-link link-danger fw-medium" data-bs-dismiss="modal">
                            <i class="ri-close-line me-1 align-middle"></i> Fechar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>