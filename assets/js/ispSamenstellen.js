var oldId1 = "";
var oldId2 = "";
var id1 = "";
var id2 = "";

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
    $.ajax({
        type: "GET",
        url: site_url + "/student/haalAjaxOp_UurroosterPerKlas/",
        data: {klasId: id},
        success: function (output) {
            JSONoutput = JSON.parse(output);
            console.log(JSONoutput);
            $('#' + titel).text(JSONoutput[0].lesWithVak.klas.naam);
            $('#' + tekst).text('');
            var html = "";
            html +=
                '<table class="table">\n' +
                '<tbody>\n'

            $.each( JSONoutput, function( i, item ) {

                html +=
                    '<tr>\n' +
                    '<td>' + item.lesWithVak.vak.naam +'</td>\n' +
                    '<td>' + capitalizeFirstLetter(getDayName(item.datum)) + '</td>\n' +
                    '<td>' + item.startuur.slice(0, -3) + '</td>\n' +
                    '<td>' + item.einduur.slice(0, -3) + '</td>\n' +
                    '</tr>\n'
            });
            html +=
                '</tbody>\n' +
                '</table>';
            $('#' + tekst).append(html);
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

function getDayName(dateStr)
{
    var date = new Date(dateStr);
    return date.toLocaleDateString('nl-NL', { weekday: 'long' });
}

function capitalizeFirstLetter(string) {
    if (typeof string !== 'string') return '';
    return string.charAt(0).toUpperCase() + string.slice(1);
}