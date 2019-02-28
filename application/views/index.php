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
            <?php
                $attributes = array('name' => 'mijnFormulier');
                echo form_open('controleerInloggen', $attributes);
            ?>
            <div class="form-group">
                <?php echo form_label('Login nummer', 'login') . "\n"; ?>
                <?php echo form_input(array('name' => 'login', 'id' => 'login', 'class' => "form-control", 'placeholder' => "Studentennummer / Personeelsnummer")); ?>
            </div>
            <div class="form-group">
                <?php echo form_label('Wachtwoord', 'wachtwoord') . "\n" ?>
                <?php echo form_password(array('name' => 'wachtwoord', 'id' => 'wachtwoord', 'class' => "form-control", 'placeholder' => "Wachtwoord")); ?>
            </div>
            <div class="form-group">
                <?php echo form_submit('knop', 'Inloggen'); ?>
            </div>
            <?php echo form_close(); ?>
            <?php echo anchor('', 'Wachtwoord vergeten'); ?><br><br>
            <?php echo anchor('Student/index', 'Student'); ?><br>
            <?php echo anchor('Docent/index', 'Docent'); ?><br>
            <?php echo anchor('IspVerantwoordelijke/index', 'IspVerantwoordelijke'); ?><br>
            <?php echo anchor('Opleidingsmanager/index', 'Opleidingsmanager'); ?>
        </div>
    </div>
</div>