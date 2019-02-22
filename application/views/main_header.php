<!--navigatie-->
<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <a class="navbar-brand" href="<?php echo site_url() ?>"><img class="logo" src="assets/images/logos/tm_standaardlogo_negatief.png"></a>
    <button type="button" class="navbar-toggler" data-toggle="collapse"
            data-target="#bs-example-navbar-collapse-1">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <?php foreach ($knoppen as $knop=>$link) {
                echo "<li>";
                echo "<a class=\"nav-link\" href=\'" . site_url() . $link . "\">" . $knop . "</a>";
                echo "</li>";
            }?>
        </ul>
    </div>
</nav>