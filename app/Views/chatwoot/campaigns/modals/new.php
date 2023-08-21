<div class="modal fade" id="novaCampanaModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="novaCampanaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="novaCampanaModalLabel">Criar campanha</h5>
                <p>Criar campanhas ajuda organizar seus grupos para enviar mensagens</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open('api/v1/campaigns', ['id' => 'createCampaigns']) ?>
            <div class="modal-body">
                <div class="status alert alert-warning" style="display: none;">
                </div>
                <div class="mt-3">
                    <label for="name">Nome para sua campanha</label>
                    <input type="text" class="form-control" name="name" require maxlength="80" minlength="5">
                </div>
                <div class="mt-3">
                    <label for="description">Descrição da sua campanha</label>
                    <input type="text" class="form-control" name="description" require maxlength="80" minlength="5">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Criar</button>
            </div>
            </form>
        </div>
    </div>
</div>