<?php
/**
 * @file afspraakMaken.php
 * View waarin een kalender met de docent zijn afspraken en vrije momenten wordt weergegeven
 * Krijgt een array van $persoonobjecten binnen
 */
?>
<div id="showAfspraakmaken">
    <div id="calendarContainer">
        <form id="docentIdForm">
            <div class="form-group">
                <select class="form-control" id="docentId">
                    <option selected="selected">Kies een docent..</option>
                    <?php foreach ($docenten as $docent) {
                        echo "<option value='" . $docent->id . "'>" . $docent->naam . "</option>";
                    } ?>
                </select>
            </div>
        </form>

        <div id="calendar">

        </div>
    </div>

    <div class="modal fade" id="CalendarModal" tabindex="-1" role="dialog" aria-labelledby="CalendarModal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Afspraak maken</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open(); ?>
                        <div class="form-group row">
                            <?php
                            echo form_label('Docent:', 'calendarModalDocent', array('class' => 'col-sm-2 col-form-label'));
                            echo form_input(array('type' => 'text', 'readonly' => 'true', 'class' => 'col-sm-10 form-control-plaintext', 'id' => 'calendarModalDocent'));
                            ?>
                        </div>
                        <div class="form-group row">
                            <?php
                            echo form_label('Locatie:', 'calendarModalPlaats', array('class' => 'col-sm-2 col-form-label'));
                            echo form_input(array('type' => 'text', 'readonly' => 'true', 'class' => 'col-sm-10 form-control-plaintext', 'id' => 'calendarModalPlaats'));
                            ?>
                        </div>
                        <div class="form-group row">
                            <?php
                            echo form_label('Datum:', 'calendarModalDate', array('class' => 'col-sm-2 col-form-label'));
                            echo form_input(array('type' => 'text', 'readonly' => 'true', 'class' => 'col-sm-10 form-control-plaintext', 'id' => 'calendarModalDate'));
                            ?>
                        </div>
                        <div class="form-group row">
                            <?php
                            echo form_label('Tijd:', 'calendarModalTime', array('class' => 'col-sm-2 col-form-label'));
                            echo form_input(array('type' => 'text', 'readonly' => 'true', 'class' => 'col-sm-10 form-control-plaintext', 'id' => 'calendarModalTime'));
                            ?>
                        </div>
                        <?php
                        echo form_label('Extra opmerkingen:', 'calendarModalDescription');
                        echo form_textarea(array('class' => 'form-control', 'id' => 'calendarModalDescription', 'rows' => '3'));
                        ?>
                    <?php echo form_close() ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                    <button type="submit" class="btn btn-primary" id="calendarModalConfirm">Bevestigen</button>
                </div>
            </div>
        </div>
    </div>

    <script src='<?php echo base_url() ?>assets/js/Student_afspraakMaken.js'></script>
</div>