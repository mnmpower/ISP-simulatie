<!--NAV-->
<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <a class="navbar-brand" href="<?php /*echo site_url() */?>"><img class="logo" src="assets/images/logos/tm_standaardlogo_negatief.png"></a>
    <button type="button" class="navbar-toggler" data-toggle="collapse"
            data-target="#bs-example-navbar-collapse-1">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- <div class="row"> TIJDELIJK DOOR MERGE
        <img src="/assets/images/logos/thomasmore.jpg" alt="thomasmore">
        <a class="navbar-brand" href="<//?php echo site_url() ?>">ISP</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1">
            <span class="navbar-toggler-icon"></span>
        </button>
        <p><//?php echo $loginnaam; ?></p>
    </div>-->

    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav">
            <?php foreach ($buttons as $button=>$link) {
                echo "<li>";
                echo "<a class=\"nav-link\" href=\'" . site_url() . $link . "\">" . $button . "</a>";
                echo "</li>";
            }?>
        </ul>
        <a href="test" class="nav-link uitlogKnop">Uitloggen</a>
    </div>

</nav>