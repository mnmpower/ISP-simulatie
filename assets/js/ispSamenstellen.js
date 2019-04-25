var id1 = 'a';
var id2 = 'b';
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
    height: "auto",
    slotEventOverlap: false

});

// Calendar week
$('#uurrooster').fullCalendar('gotoDate', '2019-09-16');

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
$('.klasbutton').click(function () {
    var selected = $(this).attr('data-klas');
    var el = this;


    if (id1 == selected) {
        id1 = 'a';
        toggleKlas(0, el);
        removeKlasISP(1);
        emptyKlasInfo('klas1Titel', 'klas1Tekst');
    } else if (id2 == selected) {
        id2 = 'b';
        toggleKlas(0, el);
        removeKlasISP(2);
        emptyKlasInfo('klas2Titel', 'klas2Tekst');
    } else if (id1 == 'a' && selected != id2) {
        id1 = selected;
        toggleKlas(1, el);
        getKlasInfo(id1, 'klas1Titel', 'klas1Tekst');
    } else if (id2 == 'b' && selected != id2) {
        id2 = selected;
        toggleKlas(1, el);
        getKlasInfo(id2, 'klas2Titel', 'klas2Tekst');
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
                '<tbody>\n';

            $.each(JSONoutput, function (i, item) {
                isp.push(item.id);
                html +=
                    '<tr class="list-group-item-action klasVakbutton activeButton' +
                    '" data-id="' + item.id + '">\n' +
                    '<td>' + item.lesWithVak.vak.naam + '</td>\n' +
                    '<td>' + capitalizeFirstLetter(getDayName(item.datum)) + '</td>\n' +
                    '<td>' + item.startuur.slice(0, -3) + '</td>\n' +
                    '<td>' + item.einduur.slice(0, -3) + '</td>\n';

                if (isp.indexOf(item.id) != -1) {
                    html += '<td><i class="fas fa-check"></i></td>';
                } else {
                    html += '<td><i class="fas fa-check invisible"></i></td>';
                }

                html += '</tr>\n'
            });
            html +=
                '</tbody>\n' +
                '</table>';
            $('.lds-ring').toggle();
            $('#' + tekst).append(html);
            console.log(isp);
            updateRooster();
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
                    '<td>' + item.einduur.slice(0, -3) + '</td>\n';

                if (isp.indexOf(item.id) != -1) {
                    html += '<td><i class="fas fa-check"></i></td>';
                } else {
                    html += '<td><i class="fas fa-check invisible"></i></td>';
                }
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
    $("body").off("click", ".vakButton", ToggleVakOn);
}

function ToggleVakOff() {
    $('.faseList').toggle();
    $('#backButtonFase').toggle();
    $('#vakkenList').toggleClass('col-8').toggleClass('col-4');
    $('#klassenLijstFaseContainer').toggle();
    $("body").on("click", ".vakButton", ToggleVakOn);
}

function editISPAttr() {
    var id = $(this).attr('data-id');
    var pos = isp.indexOf(id);
    if (pos != -1) {
        isp.splice(pos, 1);
        checkButton(id, false);
    } else {
        isp.push(id);
        checkButton(id, true);
    }
    console.log(isp);
    updateRooster();
}

function toggleKlas(toggle, el) {
    if (toggle != 1) {
        $(el).removeClass('activeKlas').find('.fa-check').addClass('invisible');
    } else {
        $(el).addClass('activeKlas').find('.fa-check').removeClass('invisible');
    }
}

function removeKlasISP(nr) {
    if (nr == 1) {
        $('#klas1Tekst > table > tbody > tr').each(function () {
            var id = $(this).attr('data-id');
            var pos = isp.indexOf(id);
            isp.splice(pos, 1);
        })
    }
    if (nr == 2) {
        $('#klas2Tekst > table > tbody > tr').each(function () {
            var id = $(this).attr('data-id');
            var pos = isp.indexOf(id);
            isp.splice(pos, 1);
        })
    }
    console.log(isp);
    updateRooster();
}

function updateRooster() {
    if (isp != '') {
        var lessen = isp;
        postData = JSON.stringify(lessen);
        $.ajax({
            type: "GET",
            url: site_url + "/student/haalAjaxOp_lesKlas/",
            data: {lessen: postData},
            success: function (data) {
                var rooster = JSON.parse(data);
                console.log(rooster);
                var roosterEvents = {events: []};
                var i = 0;
                var alerts = false;
                $('.carousel-inner').empty();
                $('.carousel-indicators').empty();
                rooster.map(function (item) {
                    if (item.vak.volgtijdelijkheidInfo != null) {
                        alerts = true;
                        i++;
                        $('.carousel-inner').append(
                        '<div class="carousel-item">' +
                            '<div class="alert alert-warning alertPad" role="alert">' +
                            '<i class="fas fa-exclamation-triangle"></i>' +
                            item.vak.naam + ': ' + item.vak.volgtijdelijkheidInfo +
                        '</div>'
                        );
                        if (i == 1) {
                            $('.carousel-item').addClass('active');
                        }
                        $('.carousel-indicators').append(
                        '<li data-target="#carouselWarnings" data-slide-to="' + i + '"</li>'
                        )
                    }
                    roosterEvents.events.push(
                        {
                            'title': item.klas.naam + '\n' + item.vak.naam,
                            'start': item.datum + 'T' + item.startuur,
                            'end': item.datum + 'T' + item.einduur,
                            'color': '#cce5ff'
                        });
                });
                $('#carouselWarnings').carousel(
                    {interval: 5000}
                );
                $("#uurrooster").fullCalendar('removeEventSources');
                $("#uurrooster").fullCalendar('addEventSource', roosterEvents);
                if (alerts == false) {
                    resetAlerts();
                }
            }, error: function (e) {
                console.log(e.message);
            }
        });
    } else {
        $("#uurrooster").fullCalendar('removeEventSources');
        resetAlerts();
    }
}

$("body")
    .on("click", ".vakButton", ToggleVakOn)
    .on("click", ".lesButton", editISPAttr)
    .on("click", "#backButtonFase", ToggleVakOff)
    .on("click", ".klasVakbutton", editISPAttr)
    .on("click", "#semesterkeuzeContainer", continueISP);

$('.vakButton').click(function () {
    var id = $(this).attr("data-vakId");
    getVakInfo(id);
});

function resetAlerts() {
    $('.carousel-inner').empty().append(
        '<div id="#defaultAlert" class="carousel-item active">' +
        '<div class="alert alert-primary alertPad active" role="alert">' +
        '<i class="fas fa-info-circle"></i>' +
        'Geen fouten gedetecteerd.' +
        '</div>'
    );
    $('.carousel-indicators').empty().append('<li data-target="#carouselWarnings" data-slide-to="0" class="active"></li>');
}


function continueISP() {
    sessionStorage.setItem("isp1", JSON.stringify(isp));
    $('#gotoSemester2').submit();
}

function checkButton(id, checked) {
    $('[data-id=' + id + ']').each(function() {
        if (checked == true) {
            $(this).addClass('activeButton').find('.fa-check').removeClass('invisible');
        }
        else {
            $(this).removeClass('activeButton').find('.fa-check').addClass('invisible');
        }
    });
}