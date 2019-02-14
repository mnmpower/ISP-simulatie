<script>


	function verwijderTabs() {
        $(".extratab").remove();
        $("a.nav-link:not(.active)").remove();
    }

    function voegTabToe(naam, inhoud) {
        var id = $(".nav-tabs").children().length;
        $("#firsta").closest('li').after('<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#menu' + id + '">' + naam + '</a></li>');
        $('.tab-content').append('<div class="tab-pane fade extratab p-3" id="menu' + id + '">' + inhoud + '</div>');
    }

    function haalProducten(brouwerijId) {
        // hier vervolledigen (oef 2)
		$.ajax({
			type: "GET",
			url: site_url + "/les4/haalJsonOp_ProductenPerBrouwerij",
			data: {brouwerijId: brouwerijId},
			success: function (producten) {
				verwijderTabs();
				$.each(producten, function (i, product){
					var naam = product.naam;
					var uitleg = product.uitleg;
					var foto = product.afbeelding;
					inhoud = "<div class='row'><h3 class='col-12'>"+ naam +"</h3><div class='col-5'>" + "<img src='"+base_url + "/assets/images/fotos/"+foto+"' alt='"+naam+"'>" + "</div><div class='col-7'>" + uitleg + "</div></div>";
					voegTabToe(naam, inhoud);
				});
			},
			error: function (xhr, status, error) {
				alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
			}
		});

    }

    $(document).ready(function() {

        $("#brouwerij").change(function() {
            haalProducten($(this).val());
        });

    });

</script>

<div class="col-12 mt-3">
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" data-toggle="tab" id="firsta" href="#home">Brouwerijen</a></li>
		<?php

		?>
    </ul>

    <div class="tab-content">
        <div id="home" class="tab-pane fade show active p-3">
            <h3>Brouwerijen</h3>
            <p>
                <?php
                    echo form_listbox_pro('brouwerij', $brouwerijen, 'id', 'naam', '0', array("id" => "brouwerij", "class" => "form-control", "size" => "10"))
                ?>
            </p>
        </div>
    </div>
</div>

<div class='col-12 mt-4'>
    <a id="terug" href="javascript:history.go(-1);">Terug</a>
</div>
