<script>
    $(document).ready(function () {
        $("#toon").hide();
        $("#uitrol").hide();
        $("#ophelder").hide();

        // verschillende verdwijneffecten

        $("#verberg").click(function () {
            $("#verbergDit").hide(1000);
            $("#toon").show(1000);
            $(this).hide();

        });

        $("#oprol").click(function () {
            $("#oprolDit").slideUp(1000);
            $("#uitrol").show(1000);
            $(this).hide();
        });

        $("#vervaag").click(function () {
            $("#vervaagDit").fadeOut(1000);
            $("#ophelder").show(1000);
            $(this).hide();
        });

        // verschillende tooneffecten

        $("#toon").click(function () {
            $("#verbergDit").show(1000);
            $("#verberg").show(1000);
            $(this).hide();
        });

        $("#uitrol").click(function () {
            $("#oprolDit").slideDown(1000);
            $("#oprol").show(1000);
            $(this).hide();
        });

        $("#ophelder").click(function () {
            $("#vervaagDit").fadeIn(1000);
            $("#vervaag").show(1000);
            $(this).hide();
        });
    });
</script>

<div class="col-12 mt-3">
    <?php
        echo "<p>" . form_button(array("content" => "Verberg met vertraging",
                "class" => "btn btn-primary", "id" => "verberg"));
        echo form_button(array("content" => "Toon met vertraging",
                "class" => "btn btn-primary", "id" => "toon")) . "</p>";
    ?>
    <div class="card bg-light mb-4" id="verbergDit">
        <div class="card-body">
            Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
            ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
            amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
            odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
        </div>
    </div>

    <?php
        echo "<p>" . form_button(array("content" => "Oprollen met vertraging",
                "class" => "btn btn-primary", "id" => "oprol"));
        echo form_button(array("content" => "Uitrollen met vertraging",
                "class" => "btn btn-primary", "id" => "uitrol")) . "</p>";
    ?>
    <div class="card bg-light mb-4" id="oprolDit">
        <div class="card-body">
            Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
            purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
            velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
            suscipit faucibus urna.
        </div>
    </div>

    <?php
        echo "<p>" . form_button(array("content" => "Vervagen met vertraging",
                "class" => "btn btn-primary", "id" => "vervaag"));
        echo form_button(array("content" => "Ophelderen met vertraging",
                "class" => "btn btn-primary", "id" => "ophelder")) . "</p>";
    ?>
    <div class="card bg-light" id="vervaagDit">
        <div class="card-body">
            Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
            Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
            ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
            lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
        </div>
    </div>
</div>

<div class='col-12 mt-4'><a id="terug" href="javascript:history.go(-1);">Terug</a></div>