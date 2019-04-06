<div class="container container90 containerISP">
    <div class="row">
        <div class="container col-2 flex-column d-flex containersISP">
            <div class="flex-grow-1" id="klassenContainer">
                <h5>Klassen:</h5>
                <?php
                echo form_open();
                foreach ($klassen as $klas) {
                    echo "<div class='form-check' id='KlassenCheckContainer'>";
                    echo form_checkbox('klas' . $klas->id, $klas->id, false, array('class' => 'form-check-input klasCheckbox'));
                    echo form_label($klas->naam, 'klas' . $klas->id, array('class' => 'form-check-label'));
                    echo "</div>";
                }
                echo form_close();
                ?>
            </div>
        </div>
        <div class="container col-10 containersISP">
            <div id="carouselWarnings" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators indicatorsPad">
                    <li data-target="#carouselWarnings" data-slide-to="0" class="active"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="alert alert-primary alertPad role="alert">
                            <i class="fas fa-info-circle"></i>
                            Geen fouten gedetecteerd.
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselWarnings" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselWarnings" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <div id="uurrooster"></div>
        </div>
    </div>
    <div class="row ScrollKlasParent">
        <div class="container col-6 flex-column d-flex containersISP">
            <div id="klaskeuze1Container" class="flex-grow-1">
                <div class="centered">
                    <h5 id="klas1Titel" class="bg-primary text-white">Selecteer een klas..</h5>
                </div>
                <div id="klas1Tekst" class="ScrollChild">
                </div>
            </div>
        </div>
        <div class="container col-6 flex-column d-flex containersISP">
            <div id="klaskeuze2Container" class="flex-grow-1 ScrollParent">
                <div class="centered">
                    <h5 id="klas2Titel" class="bg-primary text-white">Selecteer een klas..</h5>
                </div>
                <div id="klas2Tekst" class="ScrollChild">
                </div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="alert alert-primary col-12" role="alert">
        <div class="col-1 float-left"><i class="fas fa-info-circle fa-2x"></i></div><br>
    </div>
</div>
    <div class="row">
        <div class="container col-10 flex-column d-flex containersISP paddingR20">
            <div id="vakkenkeuzeContainer" class="flex-grow-1">
                <div class="row ScrollParent rowTabList">
                    <div class="btn" id="backButtonFase">
                        <i class="fas fa-chevron-left"></i>
                    </div>
                    <div class="col-4 faseList padding0">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-fase1-list"
                               data-toggle="list" href="#list-fase1" role="tab" aria-controls="home">Fase 1</a>
                            <a class="list-group-item list-group-item-action" id="list-fase2-list" data-toggle="list"
                               href="#list-fase2" role="tab" aria-controls="profile">Fase 2</a>
                            <a class="list-group-item list-group-item-action" id="list-fase3-list" data-toggle="list"
                               href="#list-fase3" role="tab" aria-controls="messages">Fase 3</a>
                        </div>
                    </div>
                    <div class="col-8 ScrollChild padding0" id="vakkenList">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="list-fase1" role="tabpanel"
                                 aria-labelledby="list-fase1-list">
                                <?php foreach ($vakken as $vak) {
                                    if ($vak->fase == 1) {
                                        echo "<div>";
                                        echo "<button type='button' class='btn list-group-item list-group-item-action vakButton'>" . $vak->naam ."</button>";
                                        echo "</div>";
                                    }
                                }
                                ?>
                            </div>
                            <div class="tab-pane fade" id="list-fase2" role="tabpanel"
                                 aria-labelledby="list-fase2-list">
                                <?php foreach ($vakken as $vak) {
                                    if ($vak->fase == 2) {
                                        echo "<div>";
                                        echo "<button type='button' class='btn list-group-item list-group-item-action vakButton'>" . $vak->naam ."</button>";
                                        echo "</div>";
                                    }
                                }
                                ?>
                            </div>
                            <div class="tab-pane fade h-25" id="list-fase3" role="tabpanel"
                                 aria-labelledby="list-fase3-list">
                                <?php foreach ($vakken as $vak) {
                                    if ($vak->fase == 3) {
                                        echo "<div>";
                                        echo "<button type='button' class='btn list-group-item list-group-item-action vakButton'>" . $vak->naam ."</button>";
                                        echo "</div>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col padding0" id="klassenLijstFaseContainer">
                        <p>Test</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container col-2 flex-column d-flex containersISP">
            <div id="semesterkeuzeContainer" class="flex-grow-1 centered">
                <p>Semester 2</p>
                <i class="fas fa-chevron-right fa-5x"></i>
            </div>
        </div>
    </div>
</div>
</div>

<script src='<?php echo base_url() ?>assets/js/ispSamenstellen.js'></script>