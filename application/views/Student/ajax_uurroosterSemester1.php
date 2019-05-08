<?php
/**
 * @file ajax_uurroosterSemester1.php
 * Ajaxpagina waarin de uurrooster (semester 1) van een klas wordt weergeven
 */
?>
<script>
    var klasid = "<?php
        echo $klas->id;
        ?>";
</script>
<div id="calendarContainer">
    <div id="calendar">
    </div>
</div>
<script src='<?php echo base_url() ?>assets/js/uurroosterWeergevenSemester1.js'></script>