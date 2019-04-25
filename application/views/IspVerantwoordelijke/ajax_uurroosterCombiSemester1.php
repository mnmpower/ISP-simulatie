<?php
/**
 * @file ajax_uurroosterCombiSemester1.php
 * Ajaxpagina waarin de uurrooster van semester 1 van een combistudent wordt weergeven
 */
?>
<script>
    var studentid = "<?php
        echo $studentId;
        ?>";
</script>
<div id="calendarContainer">
    <div id="calendar">
    </div>
</div>
<script src='<?php echo base_url() ?>assets/js/uurroosterCombiSemester1.js'></script>