<?= $this->section('cssLink') ?>

<?= $this->endSection() ?>
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title mb-0 flex-grow-1">Criando campanha</h3>
            </div>
            <div class="card-body p-5">
                
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