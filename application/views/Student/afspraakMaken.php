<div id="showAfspraakmaken">
    <div id="calendarContainer">
        <form id="docentIdForm">
            <div class="form-group">
                <select class="form-control" id="docentId">
                    <option selected="selected">Kies een docent..</option>
                    <?php foreach ($docenten as $docent) {echo "<option value='" . $docent->id . "'>" . $docent->naam . "</option>";}?>
                </select>
            </div>
        </form>

        <div id="calendar">

        </div>
    </div>

    <div class="modal fade" id="CalendarModal" tabindex="-1" role="dialog" aria-labelledby="CalendarModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Afspraak maken</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group row">
                            <label for="calendarModalDocent" class="col-sm-2 col-form-label">Docent:</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="calendarModalDocent" value="TEST">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="calendarModalPlaats" class="col-sm-2 col-form-label">Locatie:</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="calendarModalPlaats" value="TEST">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="calendarModalDate" class="col-sm-2 col-form-label">Datum:</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="calendarModalDate" value="TEST">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="calendarModalTime" class="col-sm-2 col-form-label">Tijd:</label>
                            <div class="col-sm-10">
                                <input type="text" readonly class="form-control-plaintext" id="calendarModalTime" value="TEST">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Extra opmerkingen:</label>
                            <textarea class="form-control" id="calendarModalDescription" rows="3"></textarea>
                        </div>
                    </form>
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