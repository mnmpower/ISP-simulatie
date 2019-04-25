<script>

    $(document).ready(function () {
        if ("<?php echo $_COOKIE[$cookie_name]; ?>" == "uit"){
            $('#knop').html('Walkthrough ingeschakeld');
            $('#knop').addClass('btn-success');
        }
        else{
            $('#knop').html('Walkthrough uitgeschakeld');
            $('#knop').addClass('btn-danger');
        }
    });
</script>
<button id="knop" class="btn"></button>