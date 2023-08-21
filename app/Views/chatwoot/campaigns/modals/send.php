<div class="modal fade" id="sendMessageModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="sendMessageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendMessageModalLabel">Envio instântaneo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('api/v1/groups/send', ['id' => 'sendGroups']) ?>
            <div class="modal-body">
                <div class="status alert alert-warning" style="display: none;">

                </div>
                <textarea class="form-control" name="destino" id="valoresSelecionados" cols="30" rows="2" readonly></textarea>
                <div class="mt-3">
                    <label for="message">Sua mensagem</label>
                    <textarea name="message" id="message" class="form-control" cols="30" rows="10"></textarea>
                </div>
                <div class="mt-3">
                    <label for="mentions">Mencionar</label>
                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                        <input type="checkbox" class="form-check-input" id="mentions" name="mentions" checked="" value="1">
                        <label class="form-check-label" for="mentions">Mencionar</label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
            </form>
        </div>
    </div>
</div>