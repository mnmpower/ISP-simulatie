<!-- Roep het dialoogvenster via de knop -->
<div class="col-12 mt-3">
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#mijnDialoogscherm">
        Open dialoogvenster
    </button>
</div>

<!-- Dialoogvenster -->
<div class="modal fade" id="mijnDialoogscherm" role="dialog">
    <div class="modal-dialog">
        <!-- Inhoud dialoogvenster -->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hoofding - dialoogvenster</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Hier komt de gewenste tekst.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal">Sluiten</button>
            </div>
        </div>
    </div>
</div>

<div class='col-12 mt-4'>
    <a id="terug" href="javascript:history.go(-1);">Terug</a>
</div>
