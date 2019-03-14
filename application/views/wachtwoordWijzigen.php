<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Wachtwoord vergeten</h1>
        </div>
        <div class="col-md-6">
            <?php
            $attributes = array('name' => 'editPasswordForm');
            echo form_open();
            ?>
            <div class="form-group">
                <?php echo form_label('Loginnummer', 'nummer') . "\n"; ?>
                <?php echo form_input(array('name' => 'nummer', 'id' => 'nummer', 'class' => "form-control", 'placeholder' => "Studentennummer / Personeelsnummer")); ?>
            </div>
            <div class="form-group">
                <?php echo form_submit('knop', 'Wijzigen'); ?>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editPasswordForm').submit(function () {
        var nummer = $('#nummer').val();
        console.log(nummer);
        $.ajax({
            type: "GET",
            url: site_url + "/home/editPassword/",
            data: {nummer: nummer},
            success: function (output) {
                alert('Nieuw wachtwoord: ' + output);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    })
</script>