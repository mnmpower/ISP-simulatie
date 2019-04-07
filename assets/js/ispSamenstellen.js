var oldId1 = "";
var oldId2 = "";
var id1 = null;
var id2 = null;
var isp = [];

// Calendar settings
$('#uurrooster').fullCalendar({
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    defaultView: 'agendaWeek',
    weekends: false,
    nowIndicator: false,
    allDaySlot: false,
    minTime: "08:00:00",
    maxTime: "19:00:00",
    header: false,
    columnHeaderFormat: 'dddd',
    height: "auto"

});

// Calendar week
$('#calendar').fullCalendar('gotoDate', '2019-09-16');

// Mobile
$(window).resize(function () {
    if (600 < $(window).width()) {
        $('#uurrooster').fullCalendar('changeView', 'agendaWeek');
    } else {
        $('#uurrooster').fullCalendar('changeView', 'agendaDay');
    }
});

// Carousel Settings
$('.carousel').carousel(
    {
        interval: false
    });

// Klassen checkbox limit & AJAX Klas selection
$('.klasCheckbox').on('change', function () {
    if ($('.klasCheckbox:checked').length > 2) {
        this.checked = false;
    }

    var checked = [];
    $.each($(".klasCheckbox:checked"), function () {
        checked.push($(this).val());
    });

    console.log(checked);
    console.log(id1, id2);

    if (checkIfNew(checked[0], checked[1])) {
        if (checked[0] != null) {
            getKlasInfo(checked[0], 'klas1Titel', 'klas1Tekst');
        } else {
            emptyKlasInfo('klas1Titel', 'klas1Tekst')
        }
        if (checked[1] != null) {
            getKlasInfo(checked[1], 'klas2Titel', 'klas2Tekst');
        } else {
            emptyKlasInfo('klas2Titel', 'klas2Tekst')
        }
    }

});

function getKlasInfo(id, titel, tekst) {
    $('#' + tekst).append("<div class=\"centered lds-ring\"><div></div><div></div><div></div><div></div></div>");
    $('.lds-ring').toggle();
    $.ajax({
        type: "GET",
        url: site_url + "/student/haalAjaxOp_UurroosterPerKlas/",
        data: {klasId: id},
        success: function (output) {
            JSONoutput = JSON.parse(output);
            $('#' + titel).text(JSONoutput[0].lesWithVak.klas.naam);
            $('#' + tekst).text('');
            var html = "";
            html +=
                '<table class="table">\n' +
                '<tbody>\n'

            $.each(JSONoutput, function (i, item) {

                html +=
                    '<tr>\n' +
                    '<td>' + item.lesWithVak.vak.naam + '</td>\n' +
                    '<td>' + capitalizeFirstLetter(getDayName(item.datum)) + '</td>\n' +
                    '<td>' + item.startuur.slice(0, -3) + '</td>\n' +
                    '<td>' + item.einduur.slice(0, -3) + '</td>\n' +
                    '</tr>\n'
            });
            html +=
                '</tbody>\n' +
                '</table>';
            $('.lds-ring').toggle();
            $('#' + tekst).append(html);
        }
    });
}

function getVakInfo(id) {
    $('#klassenLijstFaseContainer').text('');
    $('#klassenLijstFaseContainer').append("<div class=\"centered lds-ring\"><div></div><div></div><div></div><div></div></div>");
    $('.lds-ring').toggle();
    $.ajax({
        type: "GET",
        url: site_url + "/student/haalAjaxOp_lesPerVak/",
        data: {vakId: id},
        success: function (output) {
            JSONoutput = JSON.parse(output);
            var html = "";
            html +=
                '<table class="table">\n' +
                '<tbody>\n'

            $.each(JSONoutput, function (i, item) {

                html +=
                    '<tr class="list-group-item-action vakButton lesButton';
                    if (isp.indexOf(item.id) != -1) {
                        html += ' activeButton'
                    }
                html +=
                    '" data-id="' + item.id + '">\n' +
                    '<td>' + item.klas.naam + '</td>\n' +
                    '<td>' + capitalizeFirstLetter(getDayName(item.datum)) + '</td>\n' +
                    '<td>' + item.startuur.slice(0, -3) + '</td>\n' +
                    '<td>' + item.einduur.slice(0, -3) + '</td>\n' +
                    '</tr>\n'
            });
            html +=
                '</tbody>\n' +
                '</table>';
            $('.lds-ring').toggle();
            $('#klassenLijstFaseContainer').append(html);
        }
    });
}

function emptyKlasInfo(titel, tekst) {
    $('#' + titel).text('Selecteer een klas..');
    $('#' + tekst).text('');
}

function checkIfNew(id1, id2) {
    var result = id1 != oldId1 || id2 != oldId2;
    oldId1 = id1;
    oldId2 = id2;
    return result;
}

function getDayName(dateStr) {
    var date = new Date(dateStr);
    return date.toLocaleDateString('nl-NL', {weekday: 'long'});
}

function capitalizeFirstLetter(string) {
    if (typeof string !== 'string') return '';
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function ToggleVakOn() {
        $('.faseList').toggle();
        $('#backButtonFase').toggle();
        $('#vakkenList').toggleClass('col-8').toggleClass('col-4');
        $('#klassenLijstFaseContainer').toggle();
        $("body").off( "click", ".vakButton", ToggleVakOn );
}

function ToggleVakOff() {
    $('.faseList').toggle();
    $('#backButtonFase').toggle();
    $('#vakkenList').toggleClass('col-8').toggleClass('col-4');
    $('#klassenLijstFaseContainer').toggle();
    $("body").on( "click", ".vakButton", ToggleVakOn );
}

function editISP(el) {
    var id = $(this).attr('data-id');
    var pos = isp.indexOf(id);
    if (pos != -1) {
        isp.splice(pos, 1);
        $(this).removeClass('activeButton');
    } else {
        isp.push(id);
        $(this).addClass('activeButton');
    }
    console.log(isp);
}



$("body")
    .on( "click", ".vakButton", ToggleVakOn)
    .on( "click", ".lesButton", editISP)
    .on( "click", "#backButtonFase", ToggleVakOff);

$('.vakButton').click(function () {
   var id = $(this).attr("data-id");
   getVakInfo(id);
});