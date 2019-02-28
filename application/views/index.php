<?php
/**
 * Created by PhpStorm.
 * User: jinte
 * Date: 28/02/2019
 * Time: 13:36
 */
?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Login</h1>
        </div>
        <div class="col-md-6">
            <?php echo form_open('', array("id" => "loginFormulier")) . "\n"; ?>
            <div class="form-group">
                <?php echo form_label('Login nummer', 'login') . "\n"; ?>
                <?php echo form_input(array('name' => 'login', 'id' => 'login', 'class' => "form-control", 'placeholder' => "Studentennummer / Personeelsnummer")); ?>
            </div>
            <div class="form-group">
                <?php echo form_label('Wachtwoord', 'wachtwoord') . "\n" ?>
                <?php echo form_input(array('name' => 'wachtwoord', 'id' => 'wachtwoord', 'class' => "form-control", 'placeholder' => "Wachtwoord", 'type' => 'password')); ?>
            </div>
            <?php echo form_close() . "\n"; ?>
        </div>
    </div>
</div>