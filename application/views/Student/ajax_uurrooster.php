<script>
    var klasid = "<?php
        echo $klas->id;
        ?>";
</script>
<div id="showAfspraakmaken">
    <?php
    echo '<p>' . $semester . '</p>';
    ?>
    <div id="calendarContainer">
        <div id="calendar">
        </div>
    </div>
    <?php
        if ($semester == 'Semester 1'){
            echo '<script src=\'<?php echo base_url() ?>assets/js/uurroosterWeergevenSemester1.js\'></script>';
        }
        else{
            echo '<script src=\'<?php echo base_url() ?>assets/js/uurroosterWeergevenSemester2.js\'></script>';
        }
    ?>
</div>