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
            <div class="col-sm"><?php if ($maartenRol != null) {echo $maartenRol;} else {echo "-";}?></div>
            <div class="col-sm">Christel Maes</div>
        </div>
        <!-- Row 3 -->
        <div class="row">
            <div class="col-sm">Ingelaere Tijl</div>
            <div class="col-sm">Documentbeheerder</div>
            <div class="col-sm"><?php if ($tijlRol != null) {echo $tijlRol;} else {echo "-";}?></div>
            <div class="col-sm"></div>
        </div>
        <!-- Row 4 -->
        <div class="row">
            <div class="col-sm">Kempeneer Sacha</div>
            <div class="col-sm"></div>
            <div class="col-sm"><?php if ($sachaRol != null) {echo $sachaRol;} else {echo "-";}?></div>
            <div class="col-sm"><img src="assets/images/logos/omnidatafooter.png"></div>
        </div>
        <!-- Row 5 -->
        <div class="row">
            <div class="col-sm">Michiels Jinte</div>
            <div class="col-sm"></div>
            <div class="col-sm"><?php if ($jinteRol != null) {echo $jinteRol;} else {echo "-";}?></div>
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
            <div class="col-sm"><?php if ($maartenRol != null) {echo $maartenRol;} else {echo "-";}?></div>
        </div>
        <!-- Row 3 -->
        <div class="row">
            <div class="col-sm">Ingelaere Tijl</div>
            <div class="col-sm">Documentbeheerder</div>
            <div class="col-sm"><?php if ($tijlRol != null) {echo $tijlRol;} else {echo "-";}?></div>
        </div>
        <!-- Row 4 -->
        <div class="row">
            <div class="col-sm">Kempeneer Sacha</div>
            <div class="col-sm"></div>
            <div class="col-sm"><?php if ($sachaRol != null) {echo $sachaRol;} else {echo "-";}?></div>
        </div>
        <!-- Row 5 -->
        <div class="row">
            <div class="col-sm">Michiels Jinte</div>
            <div class="col-sm"></div>
            <div class="col-sm"><?php if ($jinteRol != null) {echo $jinteRol;} else {echo "-";}?></div>
        </div>
    </div>
        <div class="container containerTabletLogos">
            <div class="row">
                <div class="col-sm"><img class="logo" src="assets/images/logos/tm_standaardlogo_negatief_zw_0.png"></div>
                <div class="col-sm"><div class="font-weight-bold">Coach:</div><div>Christel Maes</div></div>
                <div class="col-sm align-self-center"><img class="logo" src="assets/images/logos/omnidatafooter.png"></div>
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