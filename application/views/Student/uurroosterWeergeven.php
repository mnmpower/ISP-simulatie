<?php
/**
 * @file uurroosterWeergeven.php
 * View waarin de student zijn/haar klasvoorkeur kan doorgeven
 * Gebruikt ajax-call om de uurroosters van de klassen op te halen
 */
?>
<script>
	klasId = "<?php echo $klas->id; ?>";

    function haalUurroosterOp(klasId, semesterId) {
        $.ajax({
            type: "GET",
            url: site_url + "/student/haalAjaxOp_Uurrooster/",
            data: {klasId: klasId, semesterId: semesterId},
            success: function(output) {
                $('#uurrooster').html(output);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        semesterId = $('#semesterkeuze').val();
        haalUurroosterOp(klasId, semesterId);

        $("#semesterkeuze").change(function () {
            semesterId = $('#semesterkeuze').val();
            haalUurroosterOp(klasId, semesterId);
        });
    });

</script>
<?php
    $semesterOpties = array('Semester 1', 'Semester 2');
?>
<div class="container70">
    <div class="row">
        <h1 class="col">Uurrooster <?php if($klas != null ) { echo $klas->naam; }?></h1>
        <?php $backButtonAttributes = array('class' => 'backButton col-sm');
        echo form_open_multipart("student/setType", $backButtonAttributes); ?>
        <button class="form-control btn-primary text-white btn">
            <i class="fas fa-chevron-left"></i> Terug naar menu
        </button>
        <?php echo form_close(); ?>
    </div>
    <?php
        $semesterattributes = array('id' => 'semesterkeuze', 'class' => 'form-control');
        echo form_dropdown('semester', $semesterOpties, '0', $semesterattributes);
    ?>

    <div id="uurrooster" class=" mt-4 mb-3"></div>
</div>
