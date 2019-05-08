<?php
/**
 * @file ajax_lessen.php
 * Ajaxpagina waarin de CRUD voor het beheren van de lessen wordt weergeven
 */
?>
<!-- Bootstrap CSS -->
<?php echo pasStylesheetAan("bootstrap.css"); ?>
<?php echo haalJavascriptOp("jquery-3.3.1.js"); ?>
<?php echo haalJavascriptOp("bootstrap.bundle.js"); ?>

<!-- Plugins -->
<?php if ($plugins != null) {
	foreach ($plugins as $line) {
		echo $line;
	}} ?>
<table data-toggle="table" class="table-striped table-borderless table-hover ">
    <thead>
        <tr>
            <th data-sortable="true" width="30%">Vak</th>
            <th data-sortable="true" width="20%">Klas</th>
            <th width="30%">Moment</th>
            <th width="10%"></th>
            <th width="10%"></th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($lessen as $les) {
                echo "<tr>\n";
                echo "<td>" . $les->vak->naam . "</td>";
                echo "<td>" . $les->klas->naam . "</td>";
                echo "<td>" . $les->dag . ' (Blok ' . $les->blok . ')' . "</td>";

                echo "<td>";
                $extraButton = array('class' => 'btn btn-success wijzig', 'data-lesid' => $les->id, 'data-toggle' => 'tooltip',
                    "title" => "Les wijzigen");
                echo form_button("knopwijzig" . $les->id, "<i class=\"fas fa-edit\"></i> Wijzig", $extraButton);
                echo "</td>";

                echo "<td>";
                $extraButton = array('class' => 'btn btn-danger schrap', 'data-lesid' => $les->id, 'data-toggle' => 'tooltip',
                    "title" => "Les verwijderen");
                echo form_button("knopverwijder" . $les->id, "<i class=\"fas fa-trash-alt\"></i> Verwijder", $extraButton);
                echo "</td>\n";
                echo "</tr>\n";
            }
        ?>
    </tbody>
</table>

