<?php
/**
 * @file index.php
 * View waarin de ingediende ISP's van de student wordt weergegeven
 * Krijgt een $persoonobject binnen
 */
?>
<div class="container70">
    <h1>
        <?php
            echo $title
        ?>
    </h1>
    <table class="table">
        <tbody>
        <tr>
            <th class="text-uppercase">Studentennummer</th>
            <th class="text-uppercase">Naam</th>
            <th class="text-uppercase">Aantal studiepunten</th>
            <th class="text-uppercase">Advies</th>
        </tr>

        <?php
        foreach ($ingediendeIspStudenten as $student) {
            echo "<tr><td>$student->nummer</td>";
            echo "<td>$student->naam</td>";
            echo "<td>$student->studiepunten</td>";
            echo "<td>$student->advies</td></tr>";
        }
        ?>

        </tbody>
    </table>


</div>