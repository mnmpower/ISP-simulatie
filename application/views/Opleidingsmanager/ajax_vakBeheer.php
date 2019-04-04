<table class="table table-striped">
    <tablebody>
        <tr>
            <th width="80%">Naam</th>
            <th width="10%"></th>
            <th width="10%"></th>
        </tr>
        <tr>
            <?php


            foreach ($vakken as $vak) {
                $wijzigButton = array('class' => 'btn btn-success wijzig', 'data-vakid' => $vak->id, 'data-toggle' => 'tooltip',
                    "title" => "Wijzig vak");
                $verwijderButton = array('class' => 'btn btn-danger verwijder', 'data-vakid' => $vak->id, 'data-toggle' => 'tooltip',
                    "title" => "Verwijder vak");
                echo "<td>$vak->naam</td>";
                echo "<td>" . form_button("knopwijzig" . $vak->id, '<i class="fas fa-edit"></i> Wijzig', $wijzigButton) . "</td>";
                echo "<td>" . form_button("knopverwijder" . $vak->id, '<i class="fas fa-trash-alt"></i> Verwijder', $verwijderButton) . "</td>";
                echo "</tr><tr>";
            }
            ?>
        </tr>
    </tablebody>
</table>
