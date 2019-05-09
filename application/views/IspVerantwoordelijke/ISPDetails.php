<?php
/**
 * @file ISPDetails.php
 * View waarin de details van een student zijn ISP worden weergegeven en de ISP verantwoordelijk advies kan geven aan de student
 * Krijgt een $persoonobject met bijhorende $les- en $vakobjecten binnen
 * Gebruikt ajax-call om de uurrooster van de student op te halen
 */
?>
<script>
    function haalUurroosterOp(semesterId, studentId) {
        $.ajax({
            type: "GET",
            url: site_url + "/IspVerantwoordelijke/haalAjaxOp_UurroosterCombi/",
            data: {semesterId: semesterId, studentId: studentId},
            success: function(output) {
                $('#uurrooster').html(output);
            },
            error: function (xhr, status, error) {
                alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
            }
        });
    }

    $(document).ready(function () {
        haalUurroosterOp(0, <?php echo $student->id ?>);

        $("#semesterkeuze").change(function () {
            var semesterId = $('#semesterkeuze').val();
            haalUurroosterOp(semesterId, <?php echo $student->id ?>);
        });
    });

</script>
<div class="container70">
    <h1>
        <i class="fas fa-info-circle"></i> ISP Details
    </h1>
    <div class="row">
        <?php
        echo "<div class='col-3'><h5>Studentennummer: </h5><p>" . $student->nummer . "</p></div>";
        echo "<div class='col-3'><h5>Naam: </h5><p>" . $student->naam . "</p></div>";
        if ($student->ispMededeling != null){
            echo "<div class='col-6'><h5>Opmerking van de student: </h5><p>" . $student->ispMededeling . "</p></div>";
        }
        ?>
    </div>
    <h5 class="titlesBlue"> Vakken</h5>
    <div class="row">
        <div class="col-6">
            <h3>Semester 1</h3>
            <table class="table">
                <tr>
                    <th style="width: 60%">Vak</th>
                    <th style="width: 40%">Studiepunten</th>
                </tr>
                <?php
                $tabel1 = array();
                foreach ($student->persoonLessen as $persoonles) {
                    if($persoonles->lesWithVak->vak->semester != 2 && !in_array($persoonles->lesWithVak->vak->naam, $tabel1)) {
                        array_push($tabel1, $persoonles->lesWithVak->vak->naam);
                        echo '<tr><td>' . $persoonles->lesWithVak->vak->naam . '</td><td>' . $persoonles->lesWithVak->vak->studiepunt . '</td></tr>';
                    }
                }
                ?>
            </table>
        </div>
        <div class="col-6">
            <h3>Semester 2</h3>
            <table class="table">
                <tr>
                    <th style="width: 60%">Vak</th>
                    <th style="width: 40%">Studiepunten</th>
                </tr>
                <?php
                $tabel2 = array();
                foreach ($student->persoonLessen as $persoonles) {
                    if($persoonles->lesWithVak->vak->semester != 1 && !in_array($persoonles->lesWithVak->vak->naam, $tabel2)) {
                        array_push($tabel2, $persoonles->lesWithVak->vak->naam);
                        echo '<tr><td>' . $persoonles->lesWithVak->vak->naam . '</td><td>' . $persoonles->lesWithVak->vak->studiepunt . '</td></tr>';
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <h5 class="titlesBlue"> Studiepunten</h5>
    <?php
        echo "<h5>Totaal opgenomen studiepunten: " . $studiepunten . "</h5></br>"; ?>
    <h5 class="titlesBlue"> Uurrooster</h5>
    <?php
        $semesterOpties = array('Semester 1', 'Semester 2');
        $semesterattributes = array('id' => 'semesterkeuze', 'class' => 'form-control ISPDetailsMargin');
        echo form_dropdown('semester', $semesterOpties, '0', $semesterattributes);
    ?>

    <div id="uurrooster"></div>
    </br>
    <h5 class="titlesBlue"> Advies voor studenten:</h5>
    <?php
    $attributes = array('name' => 'mijnFormulier');
    echo form_open('IspVerantwoordelijke/adviesOpslaan', $attributes);
    echo form_hidden('student', json_encode($student,TRUE));
    $adviesattributes = array('class' => 'form-control', 'id' => 'TextBoxAdvies');
    echo form_textarea('advies', $student->advies, $adviesattributes);
    echo "<div class='row'><div class='col-6'>";
    $submitattributes = array('class' => 'form-control btn-primary btn menuButton marginButton', 'id' => 'ButtonSubmitAdvies' );
    echo form_submit('opslaan', 'Advies opslaan', $submitattributes);
    echo "</div><div class='col-6'>";
    $overzichtattributes = array('class' => 'form-control btn-primary btn menuButton marginButton', 'id' => 'ButtonOverzicht' );
    echo form_submit('overzicht', 'Naar ISP overzicht', $overzichtattributes);
    echo "</div></div>";
    echo form_close();
    ?>
</div>
