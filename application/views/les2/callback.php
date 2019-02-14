<script>
    $(document).ready(function () {
        $("#herstel").hide();

        $("#oprolVersie1").click(function () {
            $("#oprolDit1").slideUp(1000);
            $("#oprolDit2").slideUp(1000);
            $("#herstel").show();
        });

        $("#oprolVersie2").click(function () {
            $("#oprolDit1").slideUp(1000, function () {
                $("#oprolDit2").slideUp(1000, function () {
                    $("#herstel").show();
                });
            });
        });

        $("#herstel").click(function () {
            $("#oprolDit1").show();
            $("#oprolDit2").show();
            $(this).hide();
        });
    });
</script>

<div class="col-12 mt-3">
    <?php
        echo "<p>" . form_button(array("content" => "Herstel", "class" => "btn btn-primary", "id" => "herstel")) . "</p>";
        echo "<p>" . form_button(array("content" => "Zonder callback", "class" => "btn btn-primary", "id" => "oprolVersie1")) . "</p>";
        echo "<p>" . form_button(array("content" => "Met callback", "class" => "btn btn-primary", "id" => "oprolVersie2")) . "</p>";
    ?>

    <div class="card bg-light mb-4" id="oprolDit1">
        <div class="card-body">
            Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer ut neque. Vivamus nisi metus,
            molestie vel, gravida in, condimentum sit amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra
            leo ut odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
        </div>
    </div>

    <div class="card bg-light" id="oprolDit2">
        <div class="card-body">
            Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at
            aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam.
            In suscipit faucibus urna.
        </div>
    </div>
</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>