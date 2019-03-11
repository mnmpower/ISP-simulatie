<div id="showAfspraakmaken">
    <div id="calendarContainer">
        <form id="docentIdForm">
            <div class="form-group">
                <label for="docentId">Selecteer een docent</label>
                <select class="form-control" id="docentId">
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
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Example select</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="First name">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Last name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Example textarea</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src='<?php echo base_url() ?>assets/js/Student_afspraakMaken.js'></script>
</div>