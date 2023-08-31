<?= $this->section('cssLink') ?>

<?= $this->endSection() ?>
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0 flex-grow-1">Criando campanha</h3>
            </div>
            <div class="card-body p-5">
                <?= form_open_multipart('api/v1/campaigns', 'class="needs-validation" novalidate') ?>
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
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->section('js') ?>

<script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/l10n/pt.js"></script>

<!-- prismjs plugin -->
<script src="/assets/libs/prismjs/prism.js"></script>

<script src="/assets/js/pages/form-validation.init.js"></script>

<!-- form wizard init -->
<script src="/assets/js/pages/form-wizard.init.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    flatpickr("#timeStart", {
        mode: "range",
        dateFormat: "d/m/Y",
        locale: "pt",
    });

    function slugify(text) {
        return text
            .toLowerCase()
            .replace(/ /g, '-')
            .replace(/[^\w-]+/g, '');
    }

    function checkSlugAvailability(slug) {
        $.get(baseUrl + "api/v1/campaigns/slug/" + slug, function(data) {
            if (data.exists) {
                $('#slugStatus').text('Este slug já está em uso.');
                $("#btnInicia").prop('disabled', true);
            } else {
                $("#btnInicia").prop('enable', true);
                $('#slugStatus').text('Teste');
            }
        });
    }

    $(document).ready(function() {
        $('#tituloCampanha').keyup(function() {
            const inputTextValue = $(this).val();
            const slug = slugify(inputTextValue);
            $('#slug').val(slug);
            checkSlugAvailability(slug);
        });

        $('#slug').keyup(function() {
            const inputTextValue = $(this).val();
            const slug = slugify(inputTextValue);
            $(this).val(slug);
            checkSlugAvailability(slug);
        });

        // Restante do seu código...
    });
</script>
<?= $this->endSection() ?>