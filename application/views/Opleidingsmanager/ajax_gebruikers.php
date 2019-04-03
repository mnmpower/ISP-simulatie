<table class="table table-striped">
    <thead>
        <tr>
            <th width="35%">Naam</th>
            <th width="20%">Nummer</th>
            <th width="25%">Soort</th>
            <th width="10%"></th>
            <th width="10%"></th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($gebruikers as $gebruiker) {
                echo "<tr>\n";
                echo "<td>" . $gebruiker->naam . "</td>";
                echo "<td>" . $gebruiker->nummer . "</td>";
                echo "<td>" . $gebruiker->type->soort . "</td>";

                echo "<td>";
                $extraButton = array('class' => 'btn btn-success wijzig', 'data-gebruikerid' => $gebruiker->id, 'data-toggle' => 'tooltip',
                    "title" => "Gebruiker wijzigen");
                echo form_button("knopwijzig" . $gebruiker->id, "<i class=\"fas fa-edit\"></i> Wijzig", $extraButton);
                echo "</td>";

                echo "<td>";
                $extraButton = array('class' => 'btn btn-danger schrap', 'data-gebruikerid' => $gebruiker->id, 'data-toggle' => 'tooltip',
                    "title" => "Gebruiker verwijderen");
                echo form_button("knopverwijder" . $gebruiker->id, "<i class=\"fas fa-trash-alt\"></i> Verwijder", $extraButton);
                echo "</td>\n";
                echo "</tr>\n";
            }
        ?>
    </tbody>
</table>

