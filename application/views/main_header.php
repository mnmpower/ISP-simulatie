<?php
    $CI =& get_instance();
?>

<!--NAV-->
<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <a class="navbar-brand" href="<?php echo site_url() ?>"><?php echo toonAfbeelding('assets/images/logos/tm_standaardlogo_negatief.png', 'title="TM Logo" class="logo"')?></a>
    <button type="button" class="navbar-toggler" data-toggle="collapse"
            data-target="#bs-navbar-collapse-1">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="bs-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <?php foreach ($buttons as $button=>$link) {
                echo "<li>";
                echo "<a class='nav-link' href=" . $link . ">" . $button . "</a>";
                echo "</li>";
            }?>
            <?php if($CI->authex->isAangemeld() != false) {
                $attributes = array('class'=>'nav-link uitlogKnopMobile');
                echo anchor('home/uitloggen', 'Uitloggen', $attributes);
            } ?>
        </ul>
        <?php if($CI->authex->isAangemeld() != false) {
            $attributes = array('class'=>'nav-link uitlogKnop');
            echo anchor('home/uitloggen', 'Uitloggen <i class="fas fa-sign-out-alt"></i>', $attributes);
        } ?>
    </div>

</nav>
