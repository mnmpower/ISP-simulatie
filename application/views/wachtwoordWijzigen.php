<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Wachtwoord vergeten</h1>
        </div>
        <div class="col-md-6">
            <?php
            $attributes = array('name' => 'editPasswordForm');
            echo form_open('home/editPassword', $attributes);
            ?>
            <div class="form-group">
                <?php echo form_label('Login nummer', 'nummer') . "\n"; ?>
                <?php echo form_input(array('name' => 'nummer', 'id' => 'nummer', 'class' => "form-control", 'placeholder' => "Studentennummer / Personeelsnummer")); ?>
            </div>
            <div class="form-group">
                <?php echo form_submit('knop', 'Wijzigen'); ?>
            </div>
        </div>
    </div>
</div>