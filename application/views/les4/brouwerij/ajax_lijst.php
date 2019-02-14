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
        foreach ($brouwerijen as $brouwerij) {
            echo "<tr>\n";
            echo "<td>" . $brouwerij->naam . "</td>";

            echo "<td>";
            $extraButton = array('class' => 'btn btn-success wijzig', 'data-soortid' => $brouwerij->id, 'data-toggle' => 'tooltip',
                "title" => "Biersoort wijzigen");
            echo form_button("knopwijzig" . $brouwerij->id, "<i class=\"fas fa-edit\"></i> Wijzig", $extraButton);
            echo "</td>";

            echo "<td>";
            $extraButton = array('class' => 'btn btn-danger schrap', 'data-soortid' => $brouwerij->id, 'data-toggle' => 'tooltip',
                "title" => "Biersoort verwijderen");
            echo form_button("knopverwijder" . $brouwerij->id, "<i class=\"fas fa-trash-alt\"></i> Verwijder", $extraButton);
            echo "</td>\n";
            echo "</tr>\n";
        }
    ?>
    </tbody>
</table>

