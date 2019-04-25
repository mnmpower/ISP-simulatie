<h2>Fase 1</h2>
<div class="row">
    <div class="col-6">
        <h3>Semester 1</h3>
        <table class="table">
            <tr>
                <th style="width: 60%">Vak</th>
                <th style="width: 40%">Studiepunten</th>
            </tr>
            <?php
                foreach ($vakken as $vak) {
                    if($vak->fase == 1 && $vak->semester == 1) {
                        echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
                    }
                    if($vak->fase == 1 && $vak->semester == 3) {
                        echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
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
            foreach ($vakken as $vak) {
                if($vak->fase == 1 && $vak->semester == 2) {
                    echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
                }
                if($vak->fase == 1 && $vak->semester == 3) {
                    echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
                }
            }
            ?>
        </table>
    </div>
</div>
<h2>Fase 2</h2>
<div class="row">
    <div class="col-6">
        <h3>Semester 1</h3>
        <table class="table">
            <tr>
                <th style="width: 60%">Vak</th>
                <th style="width: 40%">Studiepunten</th>
            </tr>
            <?php
            foreach ($vakken as $vak) {
                if($vak->fase == 2 && $vak->semester == 1) {
                    echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
                }
                if($vak->fase == 2 && $vak->semester == 3) {
                    echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
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
            foreach ($vakken as $vak) {
                if($vak->fase == 2 && $vak->semester == 2) {
                    echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
                }
                if($vak->fase == 2 && $vak->semester == 3) {
                    echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
                }
            }
            ?>
        </table>
    </div>
</div>
<h2>Fase 3</h2>
<div class="row">
    <div class="col-6">
        <h3>Semester 1</h3>
        <table class="table">
            <tr>
                <th style="width: 60%">Vak</th>
                <th style="width: 40%">Studiepunten</th>
            </tr>
            <?php
            foreach ($vakken as $vak) {
                if($vak->fase == 3 && $vak->semester == 1) {
                    echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
                }
                if($vak->fase == 3 && $vak->semester == 3) {
                    echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
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
            foreach ($vakken as $vak) {
                if($vak->fase == 3 && $vak->semester == 2) {
                    echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
                }
                if($vak->fase == 3 && $vak->semester == 3) {
                    echo '<tr><td>' . $vak->naam . '</td><td>' . $vak->studiepunt . '</td></tr>';
                }
            }
            ?>
        </table>
    </div>
</div>