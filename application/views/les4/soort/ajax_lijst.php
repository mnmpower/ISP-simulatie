<table class="table">
    <thead>
    <tr>
        <th width="80%">Naam</th>
        <th width="10%"></th>
        <th width="10%"></th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach ($soorten as $soort) {
            echo "<tr>\n";
            echo "<td>" . $soort->naam . "</td>";

            echo "<td>";
            $extraButton = array('class' => 'btn btn-success wijzig', 'data-soortid' => $soort->id, 'data-toggle' => 'tooltip',
                "title" => "Biersoort wijzigen");
            echo form_button("knopwijzig" . $soort->id, "<i class=\"fas fa-edit\"></i> Wijzig", $extraButton);
            echo "</td>";

            echo "<td>";
            $extraButton = array('class' => 'btn btn-danger schrap', 'data-soortid' => $soort->id, 'data-toggle' => 'tooltip',
                "title" => "Biersoort verwijderen");
            echo form_button("knopverwijder" . $soort->id, "<i class=\"fas fa-trash-alt\"></i> Verwijder", $extraButton);
            echo "</td>\n";
            echo "</tr>\n";
        }
    ?>
    </tbody>
</table>

