<?php
/**
 * Created by PhpStorm.
 * User: jinte
 * Date: 28/02/2019
 * Time: 13:36
 */
?>

<div class="container70">
    <div class="row">
        <div class="col-12">
            <h1><i class="fas fa-key 2x"></i> Login</h1>
        </div>
        <div class="col-md-6">
            <?php
                $attributes = array('name' => 'mijnFormulier');
                echo form_open('home/controleerInloggen', $attributes);
            ?>
            <div class="form-group">
                <?php echo form_label('Loginnummer', 'nummer') . "\n"; ?>
                <?php echo form_input(array('name' => 'nummer', 'id' => 'nummer', 'class' => "form-control", 'placeholder' => "Studentennummer / Personeelsnummer")); ?>
            </div>
            <div class="form-group">
                <?php echo form_label('Wachtwoord', 'wachtwoord') . "\n" ?>
                <?php echo form_password(array('name' => 'wachtwoord', 'id' => 'wachtwoord', 'class' => "form-control", 'placeholder' => "Wachtwoord")); ?>
            </div>
            <div class="form-group loginButtons">
                <?php $loginAttributes = array('class' => 'form-control btn-outline-dark btn menuButton'); ?>
                <?php echo form_submit('knop', 'Inloggen', $loginAttributes); ?>
            </div>
            <?php echo form_close(); ?>
            <?php $loginAttributes['class'] .= ' loginButtons'?>
            <?php echo anchor('home/showWachtwoordWijzigen', 'Wachtwoord vergeten', $loginAttributes); ?>
        </div>
    </div>
</div>