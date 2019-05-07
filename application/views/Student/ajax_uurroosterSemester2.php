<?php
/**
 * @file ajax_uurroosterSemester2.php
 * Ajaxpagina waarin de uurrooster (semester 2) van een klas wordt weergeven
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
<script src='<?php echo base_url() ?>assets/js/uurroosterWeergevenSemester2.js'></script>