<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
    Launch static backdrop modal
</button>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?= form_open_multipart('api/v1/campaigns', 'class="needs-validation" novalidate') ?>
            <div class="modal-body">
                <div>
                    <div class="mb-4 text-center">
                        <div class="profile-user position-relative d-inline-block mx-auto mb-2">
                            <img src="/assets/images/users/user-dummy-img.jpg" class="rounded-circle avatar-lg img-thumbnail user-profile-image" alt="user-profile-image">
                            <div class="avatar-xs p-0 rounded-circle profile-photo-edit">
                                <input id="profile-img-file-input" type="file" class="profile-img-file-input" accept="image/png, image/jpeg" name="imageGroup">
                                <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                                    <span class="avatar-title rounded-circle bg-light text-body">
                                        <i class="ri-camera-fill"></i>
                                    </span>
                                </label>
                            </div>
                        </div>
                        <h5 class="fs-14">Add Image</h5>
                    </div>
                    <div class="mb-3">
                        <label for="tituloCampanha">Título da campanha</label><br>
                        <span class="text-muted">Informe um titulo para identificar sua campanha</span>
                        <input type="text" class="form-control" id="tituloCampanha" name="tituloCampanha" required minlength="6" placeholder="Lançamento...">
                    </div>
                    <div class="mb-3">
                        <label for="timeStart">Data da veiculação</label> <br>
                        <span class="text-muted">Referente a data que a campanha ficará ativa pela plataforma</span>
                        <div class="input-group">
                            <input type="text" class="form-control border-0 dash-filter-picker shadow flatpickr-input" readonly="readonly" id="timeStart" name="timeStart" required>
                            <div class="input-group-text bg-primary border-primary text-white">
                                <i class="ri-calendar-2-line"></i>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="automatic">Automatizar criação de grupos?</label> <br>
                        <span class="text-muted">Automatiza a criação de grupos quando o grupo já estiver cheio</span>
                        <select name="automatic" id="automatic" class="form-select" required>
                            <option value="" selected>Selecione</option>
                            <option value="1">Sim</option>
                            <option value="0">Não</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="slug">Defina uma URL</label> <br>
                        <span class="text-muted">A url que será compartilhada com seus contatos</span>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon3"><?= site_url('g/d/') ?></span>
                            <input type="text" class="form-control" name="slug" id="slug" required minlength="6">
                        </div>
                        <div id="slugStatus"></div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-info" id="btnInicia">Iniciar campanha</button>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Understood</button>
</div>
        </form>
        </div>
    </div>
</div>