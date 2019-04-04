<table class="table table-striped">
    <thead>
        <tr>
            <th width="40%">Vak</th>
            <th width="40%">Klas</th>
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

