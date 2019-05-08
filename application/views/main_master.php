<!DOCTYPE html>
<html lang="nl">

<!-- Inladen header, info, helpers, CSS ... -->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?php echo base_url() ?>/assets/images/logos/favicon.ico" type="image/x-icon">

        <title><?php echo $title ?></title>

        <!-- Bootstrap CSS -->
        <?php echo pasStylesheetAan("bootstrap.css"); ?>

        <!-- Custom CSS -->
        <?php echo pasStylesheetAan("footer.css"); ?>
        <?php echo pasStylesheetAan("header.css"); ?>
        <?php echo pasStylesheetAan("main.css"); ?>
        <?php echo haalJavascriptOp("jquery-3.3.1.js"); ?>
        <?php echo haalJavascriptOp("bootstrap.bundle.js"); ?>

        <!--Font awesome (CDN) -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css"
              integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU"
              crossorigin="anonymous">

        <script>
            var site_url = '<?php echo site_url(); ?>';
            var base_url = '<?php echo base_url(); ?>';
        </script>

        <!-- Plugins -->
        <?php if ($plugins != null) {
        foreach ($plugins as $line) {
            echo $line;
        }} ?>
    </head>

    <body>
    <!-- Inladen hoofding -->
    <?php echo $hoofding ?>

    <!--Inladen pagina-inhoud-->
    <?php echo $inhoud ?>

    <!--Inladen Footer-->
    <?php echo $footer ?>

    </body>
</html>
