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
                <ol class="carousel-indicators">
                    <li data-target="#carouselWarnings" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselWarnings" data-slide-to="1"></li>
                    <li data-target="#carouselWarnings" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <p>TEST</p>
                    </div>
                    <div class="carousel-item">
                        <p>TEST2</p>
                    </div>
                    <div class="carousel-item">
                        <p>TEST3</p>
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
    <div class="row">
        <div class="container col-6 flex-column d-flex containersISP">
            <div id="klaskeuze1Container" class="flex-grow-1">
                <p>TEST KLAS 1</p>
            </div>
        </div>
        <div class="container col-6 flex-column d-flex containersISP">
            <div id="klaskeuze2Container" class="flex-grow-1">
                <p>TEST KLAS 2</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="container col-10 flex-column d-flex containersISP">
            <div id="vakkenkeuzeContainer" class="flex-grow-1">
                <div class="row">
                    <div class="col-4">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-fase1" role="tab" aria-controls="home">Fase 1</a>
                            <a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-fase2" role="tab" aria-controls="profile">Fase 2</a>
                            <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-fase3" role="tab" aria-controls="messages">Fase 3</a>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="list-fase1" role="tabpanel" aria-labelledby="list-home-list">
                                <?php foreach ($vakken as $vak) {
                                    if ($vak->fase == 1) {
                                    echo "<div class='form-check' id='vakkenCheckContainer'>";
                                    echo form_checkbox('vak' . $vak->id, $vak->id, false, array('class' => 'form-check-input vakCheckbox'));
                                    echo form_label($vak->naam, 'vak' . $vak->id, array('class' => 'form-check-label'));
                                    echo "</div>";
                                    }
                                }
                                ?>
                            </div>
                            <div class="tab-pane fade" id="list-fase2" role="tabpanel" aria-labelledby="list-profile-list">
                                <?php foreach ($vakken as $vak) {
                                    if ($vak->fase == 2) {
                                        echo "<div class='form-check' id='vakkenCheckContainer'>";
                                        echo form_checkbox('vak' . $vak->id, $vak->id, false, array('class' => 'form-check-input vakCheckbox'));
                                        echo form_label($vak->naam, 'vak' . $vak->id, array('class' => 'form-check-label'));
                                        echo "</div>";
                                    }
                                }
                                ?>
                            </div>
                            <div class="tab-pane fade h-25" id="list-fase3" role="tabpanel" aria-labelledby="list-messages-list">
                                <?php foreach ($vakken as $vak) {
                                    if ($vak->fase == 3) {
                                        echo "<div class='form-check' id='vakkenCheckContainer'>";
                                        echo form_checkbox('vak' . $vak->id, $vak->id, false, array('class' => 'form-check-input vakCheckbox'));
                                        echo form_label($vak->naam, 'vak' . $vak->id, array('class' => 'form-check-label'));
                                        echo "</div>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container col-2 flex-column d-flex containersISP">
            <div id="semesterkeuzeContainer" class="flex-grow-1">
            <p>TEST VOLGEND SEMESTER</p>
            </div>
        </div>
    </div>
</div>

<script src='<?php echo base_url() ?>assets/js/ispSamenstellen.js'></script>