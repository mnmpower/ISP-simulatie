<footer class="footer font-weight-light">
    <!-- Footer Desktop -->
    <div class="container desktopFooter">
        <!-- Row 1 -->
        <div class="row font-weight-bold">
            <div class="col-sm">Team 22:</div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
            <div class="col-sm">Coach:</div>
        </div>
        <!-- Row 2 -->
        <div class="row">
            <div class="col-sm">Michiels Maarten</div>
            <div class="col-sm">Teamleider</div>
            <div class="col-sm"><?php echo $roles['maarten']; ?></div>
            <div class="col-sm">Christel Maes</div>
        </div>
        <!-- Row 3 -->
        <div class="row">
            <div class="col-sm">Ingelaere Tijl</div>
            <div class="col-sm">Documentbeheerder</div>
            <div class="col-sm"><?php echo $roles['tijl']; ?></div>
            <div class="col-sm"></div>
        </div>
        <!-- Row 4 -->
        <div class="row">
            <div class="col-sm">Kempeneer Sacha</div>
            <div class="col-sm"></div>
            <div class="col-sm"><?php echo $roles['sacha']; ?></div>
            <div class="col-sm"><?php echo toonAfbeelding('assets/images/logos/omnidatafooter.png', 'title="TM Logo" class="logoFooter"')?></div>
        </div>
        <!-- Row 5 -->
        <div class="row">
            <div class="col-sm">Michiels Jinte</div>
            <div class="col-sm"></div>
            <div class="col-sm"><?php echo $roles['jinte']; ?></div>
            <div class="col-sm"></div>
        </div>
    </div>

    <!-- Footer Tablet -->
    <div class="tabletFooter text-center">
    <div class="container">
        <!-- Row 1 -->
        <div class="row font-weight-bold">
            <div class="col-sm">Team 22:</div>
            <div class="col-sm"></div>
            <div class="col-sm"></div>
        </div>
        <!-- Row 2 -->
        <div class="row">
            <div class="col-sm">Michiels Maarten</div>
            <div class="col-sm">Teamleider</div>
            <div class="col-sm"><?php echo $roles['maarten']; ?></div>
        </div>
        <!-- Row 3 -->
        <div class="row">
            <div class="col-sm">Ingelaere Tijl</div>
            <div class="col-sm">Documentbeheerder</div>
            <div class="col-sm"><?php echo $roles['tijl']; ?></div>
        </div>
        <!-- Row 4 -->
        <div class="row">
            <div class="col-sm">Kempeneer Sacha</div>
            <div class="col-sm"></div>
            <div class="col-sm"><?php echo $roles['sacha']; ?></div>
        </div>
        <!-- Row 5 -->
        <div class="row">
            <div class="col-sm">Michiels Jinte</div>
            <div class="col-sm"></div>
            <div class="col-sm"><?php echo $roles['jinte']; ?></div>
        </div>
    </div>
        <div class="container containerTabletLogos">
            <div class="row">
                <div class="col-sm"><?php echo toonAfbeelding('assets/images/logos/tm_standaardlogo_negatief_zw_0.png', 'title="TM Logo" class="logoFooter"')?></div>
                <div class="col-sm"><div class="font-weight-bold">Coach:</div><div>Christel Maes</div></div>
                <div class="col-sm align-self-center"><?php echo toonAfbeelding('assets/images/logos/omnidatafooter.png', 'title="TM Logo" class="logoFooter"')?></div>
            </div>
        </div>
    </div>

    <!-- Footer Phone -->
    <div class="container mobileFooter text-center">
        <div class="font-weight-bold">Team 22:</div>
        <div>Michiels Maarten - Teamleider</div>
        <div>Ingelaere Tijl - Documentbeheerder</div>
        <div>Kempeneer Sacha</div>
        <div>Michiels Jinte</div>
        <br>
        <div class="font-weight-bold">Coach:</div>
        <div>Christel Maes</div>
    </div>
</footer>