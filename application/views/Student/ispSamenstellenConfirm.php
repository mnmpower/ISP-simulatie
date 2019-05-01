<div class="container container90 containerISP">
    <h1>Semester 1</h1>
    <div id="roosterConfirm"></div>
    <h1>Semester 2</h1>
    <div id="roosterConfirm2"></div>
    <div class="row" id="confirmButtons">
        <form id="ispCancelForm" action="home_student" class="col">
        <div id="ispCancel" class="container col flex-column d-flex">
            <div class="flex-grow-1 centered activeButton confirmButton">
                <p>Annuleren</p>
                <i class="fas fa-trash-alt fa-5x"></i>
            </div>
        </div>
        </form>
        <form  method="get" id="ispConfirmForm" action="ispSubmit" class="col">
            <input type="hidden" id="isp1" name="isp1" value="test">
            <input type="hidden" id="isp2" name="isp2">
        <div id="ispConfirm" class="container col flex-column d-flex">
            <div class="flex-grow-1 centered activeButton confirmButton">
                <p>Bevestigen</p>
                <i class="fas fa-chevron-right fa-5x"></i>
            </div>
        </div>
        </form>
    </div>
</div>
<script src='<?php echo base_url() ?>assets/js/ispSamenstellenConfirm.js'></script>