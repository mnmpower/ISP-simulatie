<div class="container">
    <h1>
        Wat voor traject volg je?
    </h1>
    <p>Indien je een standaard traject volgt (alle vakken van het jaar in kwestie, dus 60 studiepunten), betekent dit dat je een model-student bent. Indien je nog vakken meeneemt van één van de vorige fases of reeds vakken van een volgende fase opneemt ben je een combi-student.</p>
    <p>Wens je om een andere reden zelf je uurrooster samen te stellen kies je ook voor combi-student. </p>
    <?php
        $attributen = array(    'name'  => 'mijnFormulier',
                                'id'    => 'mijnFormulier',
                                'role'  => 'form');

        echo form_open('student/home_student', $attributen);
        echo "<h3>Gelieve een keuze te maken</h3>";
        $modelattributen = array('name' => 'model', "id" => "model", 'class' => 'form-control');
        echo form_submit('model', 'Model-student', $modelattributen);
        $combiattributen = array('name' => 'combi', "id" => "combi", 'class' => 'form-control');
        echo form_submit('combi', 'Combi-student', $combiattributen);
        echo form_close();
    ?>
</div>