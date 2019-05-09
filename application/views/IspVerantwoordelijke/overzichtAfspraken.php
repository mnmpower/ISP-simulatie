<?php
/**
 * @file overzichtAfspraken.php
 * View waarin een kalender met de docent zijn afspraken en vrije momenten wordt weergegeven
 */
?>
<div class="container70">
<div id="showOverzichtAfspraken">
    <div id="calendarContainer">
        <div id="calendarDocent">
        </div>
    </div>

    <div class="modal fade" id="CalendarModal" tabindex="-1" role="dialog" aria-labelledby="CalendarModal"
               aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLongTitle">Afspraak Overzicht</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open(); ?>
                    <div class="form-group row">
                        <?php
                        echo form_label('Locatie:', 'calendarModalPlaatsDocent', array('class' => 'col-sm-3 col-form-label'));
                        echo form_input(array('type' => 'text', 'class' => 'col-sm-6 form-control', 'id' => 'calendarModalPlaatsDocent'));
                        ?>
                    </div>
                    <div class="form-group row">
                        <?php
                        echo form_label('Datum:', 'calendarModalDateDocent', array('class' => 'col-sm-3 col-form-label'));
                        echo form_input(array('type' => 'date', 'class' => 'col-sm-6 form-control', 'id' => 'calendarModalDateDocent'));
                        ?>
                    </div>
                    <div class="form-group row">
                        <?php
                        echo form_label('Tijd:', 'calendarModalTimeDocent', array('class' => 'col-sm-3 col-form-label'));
                        echo form_input(array('type' => 'time', 'class' => 'col-sm-3 form-control', 'id' => 'calendarModalTimeStartDocent'));
                        echo "<p class='col-form-label timeTot'>tot</p>";
                        echo form_input(array('type' => 'time', 'class' => 'col-sm-3 form-control', 'id' => 'calendarModalTimeStopDocent'));
                        ?>
                    </div>
                    <div id="calendarModalDescriptionGroup">
                    <?php
                    echo form_label('Extra opmerkingen:', 'calendarModalDescriptionDocent');
                    echo form_textarea(array('class' => 'form-control', 'id' => 'calendarModalDescriptionDocent', 'rows' => '3'));
                    ?>
                    </div>
                    <?php echo form_close() ?>
                </div>
                <div class="modal-footer">
                    <div>
                    <button type="button" class="btn btn-outline-danger" id="calendarModalDelete" data-toggle="tooltip" data-placement="top" title="Verwijder moment"><i class="far fa-trash-alt"></i></button>
                    <button type="button" class="btn btn-outline-warning" id="calendarModalEmpty" data-toggle="tooltip" data-placement="top" title="Zet als vrij moment"><i class="far fa-calendar-minus"></i></button>
                    <button type="button" class="btn btn-outline-success" id="calendarModalSave" data-toggle="tooltip" data-placement="top" title="Opslaan"><i class="far fa-save"></i></button>
                    </div>
                    <button type="button" class="btn btn-primary" id="calendarModalDismiss" data-dismiss="modal">Sluiten</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="CalendarModalToevoegen" tabindex="-1" role="dialog" aria-labelledby="CalendarModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Moment toevoegen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open(); ?>
                    <div class="form-group row">
                        <?php
                        echo form_label('Locatie:', 'calendarModalPlaatsToevoegen', array('class' => 'col-sm-3 col-form-label'));
                        echo form_input(array('type' => 'text', 'class' => 'col-sm-6 form-control', 'id' => 'calendarModalPlaatsToevoegen', 'required' => 'true'));
                        ?>
                    </div>
                    <div class="form-group row">
                        <?php
                        echo form_label('Datum:', 'calendarModalDateToevoegen', array('class' => 'col-sm-3 col-form-label'));
                        echo form_input(array('type' => 'date', 'class' => 'col-sm-6 form-control', 'id' => 'calendarModalDateToevoegen', 'required' => 'true'));
                        ?>
                    </div>
                    <div class="form-group row">
                        <?php
                        echo form_label('Tijd:', 'calendarModalTimeToevoegen', array('class' => 'col-sm-3 col-form-label'));
                        echo form_input(array('type' => 'time', 'class' => 'col-sm-3 form-control', 'id' => 'calendarModalTimeStartToevoegen', 'required' => 'true'));
                        echo "<p class='col-form-label timeTot'>tot</p>";
                        echo form_input(array('type' => 'time', 'class' => 'col-sm-3 form-control', 'id' => 'calendarModalTimeStopToevoegen', 'required' => 'true'));
                        ?>
                    </div>
                    <div class="form-group row">
                        <?php echo form_label('Herhaal:', 'calendarModalHerhaalToevoegen', array('class' => 'col-sm-3 col-form-label')); ?>
                                <select class="form-control col-sm-6" id="calendarModalHerhaalToevoegen">
                                    <option value="0" selected="selected">Herhaal niet</option>
                                    <option value="1">Herhaal 1 week</option>
                                    <?php for ($i = 2; $i <= 10; $i++) {
                                        echo "<option value='". $i ."'>Herhaal " . $i . " weken</option>";
                                    } ?>
                                </select>
                    </div>
                    <?php echo form_close() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                    <button type="submit" class="btn btn-primary" id="calendarModalMomentToevoegen">Bevestigen</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src='<?php echo base_url() ?>assets/js/IspVerantwoordelijke_overzichtAfspraken.js'></script>
</div>
