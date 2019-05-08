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
<div class="container">
    <h1>Uurrooster <?php if($klas != null ) { echo $klas->naam; }?></h1>
    <?php
        $semesterattributes = array('id' => 'semesterkeuze', 'class' => 'form-control');
        echo form_dropdown('semester', $semesterOpties, '0', $semesterattributes);
    ?>
    <div id="uurrooster"></div>
</div>
