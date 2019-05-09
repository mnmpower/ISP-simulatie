// Kalender genereren
$('#calendarDocent').fullCalendar({
    customButtons: {
        buttonToevoegen: {
            text: 'Moment toevoegen',
            click: function () {
                openToevoegenModal();
            }
        }
    },
    header: {
        left: 'title',
        right: 'buttonToevoegen today, prev, next'
    },
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    defaultView: 'agendaWeek',
    weekends: false,
    nowIndicator: true,
    allDaySlot: false,
    minTime: "08:00:00",
    maxTime: "19:00:00",
    themeSystem: 'bootstrap4',
    height: "auto",
    // Clickevent voor evenementen met data
    eventClick: function (calEvent, jsEvent, view) {

        // Modal genereren
        var startdate = new Date(calEvent.start);
        var enddate = new Date(calEvent.end);
        if (calEvent.bezet == 0) {
            $("#ModalLongTitle").text("Afspraak: " + calEvent.title);
            $("#calendarModalEmpty").show();
            $("#calendarModalDescriptionGroup").show();
        } else {
            $("#ModalLongTitle").text('Vrij moment');
            $("#calendarModalEmpty").hide();
            $("#calendarModalDescriptionGroup").hide();
        }
        var test = startdate.getFullYear() + '-' + ('0' + (startdate.getUTCMonth() + 1)).slice(-2) + '-' + ('0' + startdate.getDate()).slice(-2);
        $("#calendarModalDateDocent").val(test.toString());
        $("#calendarModalTimeStartDocent").val(('0' + startdate.getUTCHours()).slice(-2) + ':' + (startdate.getMinutes() < 10 ? '0' : '') + startdate.getMinutes());
        $("#calendarModalTimeStopDocent").val(('0' + enddate.getUTCHours()).slice(-2) + ':' + (enddate.getMinutes() < 10 ? '0' : '') + enddate.getMinutes());
        $("#calendarModalPlaatsDocent").val(calEvent.plaats);
        $("#calendarModalDescriptionDocent").val(calEvent.description);
        $('#CalendarModal').modal();

        // Afspraak Updaten opvragen
        $('#calendarModalSave').click(function () {
            var id = calEvent.eventid;
            afspraakUpdate(id);
        });

        // Afspraak Verwijderen opvragen
        $('#calendarModalDelete').click(function () {
            var id = calEvent.eventid;
            afspraakVerwijder(id);
        });

        // Afspraak Wissen opvragen
        $('#calendarModalEmpty').click(function () {
            var id = calEvent.eventid;
            afspraakEmpty(id);
        });
    }
});

// Velden leegmaken bij modal sluit
$('#calendarModalDismiss').click(function () {
    $('#calendarModalPlaatsDocent').val('');
    $('#calendarModalDateDocent').val('');
    $('#calendarModalTimeStartDocent').val('');
    $('#calendarModalTimeStopDocent').val('');
    $('#calendarModalDescriptionDocent').val('');
});

// Afspraken opvragen bij loadup
getAfsprakenByDocent();

// Afspraak updaten
function afspraakUpdate(id) {
    var plaats = $('#calendarModalPlaatsDocent').val();
    var datum = $('#calendarModalDateDocent').val();
    var start = $('#calendarModalTimeStartDocent').val();
    var end = $('#calendarModalTimeStopDocent').val();
    var description = $('#calendarModalDescriptionDocent').val();

    $.ajax({
        type: "GET",
        url: site_url + "/docent/afspraakUpdate/",
        data: {
            'id': id,
            'plaats': plaats,
            'datum': datum,
            'start': start,
            'end': end,
            'description': description,
        },
        success: function () {
            getAfsprakenByDocent();
            $('#CalendarModal').modal('hide');
            $('#calendarModalPlaatsDocent').val('');
            $('#calendarModalDateDocent').val('');
            $('#calendarModalTimeStartDocent').val('');
            $('#calendarModalTimeStopDocent').val('');
            $('#calendarModalDescriptionDocent').val('');
        },
        error: function (xhr, status, error) {
            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
}

function afspraakEmpty(id) {
    $.ajax({
        type: "GET",
        url: site_url + "/docent/afspraakEmpty/",
        data: {
            'id': id,
        },
        success: function () {
            getAfsprakenByDocent();
            $('#CalendarModal').modal('hide');
            $('#calendarModalPlaatsDocent').val('');
            $('#calendarModalDateDocent').val('');
            $('#calendarModalTimeStartDocent').val('');
            $('#calendarModalTimeStopDocent').val('');
            $('#calendarModalDescriptionDocent').val('');
        },
        error: function (xhr, status, error) {
            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
}

// Afspraak verwijderen
function afspraakVerwijder(id) {
    $.ajax({
        type: "GET",
        url: site_url + "/docent/afspraakVerwijder/",
        data: {
            'id': id,
        },
        success: function () {
            getAfsprakenByDocent();
            $('#CalendarModal').modal('hide');
            $('#calendarModalPlaatsDocent').val('');
            $('#calendarModalDateDocent').val('');
            $('#calendarModalTimeStartDocent').val('');
            $('#calendarModalTimeStopDocent').val('');
            $('#calendarModalDescriptionDocent').val('');
        },
        error: function (xhr, status, error) {
            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
}



// Moment toevoegen modal genereren
function openToevoegenModal() {
    $('#CalendarModalToevoegen').modal();
}

// Moment toevoegen opvragen en velden leegmaken
$('#calendarModalMomentToevoegen').click(function () {
    momentToevoegen();
    $('#calendarModalPlaatsToevoegen').val('');
    $('#calendarModalDateToevoegen').val('');
    $('#calendarModalTimeStartToevoegen').val('');
    $('#calendarModalTimeStopToevoegen').val('');
    $('#calendarModalHerhaalToevoegen').val('');
});

// Moment toevoegen
function momentToevoegen() {
    var plaats = $('#calendarModalPlaatsToevoegen').val();
    var datum = $('#calendarModalDateToevoegen').val();
    var start = $('#calendarModalTimeStartToevoegen').val() + ':00';
    var end = $('#calendarModalTimeStopToevoegen').val() + ':00';
    var herhaal = $('#calendarModalHerhaalToevoegen').val();
    $.ajax({
        type: "GET",
        url: site_url + "/docent/momentToevoegen/",
        data: {
            'plaats': plaats,
            'datum': datum,
            'start': start,
            'end': end,
            'herhaal': herhaal
        },
        success: function (output) {
            getAfsprakenByDocent();
            $('#CalendarModalToevoegen').modal('hide');

        },
        error: function (xhr, status, error) {
            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });

}

// Afspraken ophalen van docent
function getAfsprakenByDocent() {
    $.ajax({
        type: "GET",
        url: site_url + "/docent/haalAjaxOp_AfsprakenDocent/",
        success: function (output) {
            var outputJSON = JSON.parse(output);
            var outputBezet = outputJSON.filter(filterByBeschikbaar);
            var outputBeschikbaar = outputJSON.filter(filterByBezet);
            var afsprakenBezet = {events: []};
            var afsprakenBeschikbaar = {events: []};
            outputBezet.map(function (item) {
                afsprakenBezet.events.push(
                    {
                        'title': item.persoon.naam,
                        'start': item.datum + 'T' + item.startuur,
                        'end': item.datum + 'T' + item.einduur,
                        'eventid': item.id,
                        'bezet': item.beschikbaar,
                        'plaats': item.plaats,
                        'color': 'red',
                        'description': item.extraOpmerking
                    });
            });
            outputBeschikbaar.map(function (item) {
                afsprakenBeschikbaar.events.push(
                    {
                        'title': 'Vrij ' + item.plaats,
                        'start': item.datum + 'T' + item.startuur,
                        'end': item.datum + 'T' + item.einduur,
                        'eventid': item.id,
                        'bezet': item.beschikbaar,
                        'plaats': item.plaats,
                        'color': 'green'
                    });
            });
            $("#calendarDocent").fullCalendar('removeEventSources');
            $("#calendarDocent").fullCalendar('addEventSource', afsprakenBezet);
            $("#calendarDocent").fullCalendar('addEventSource', afsprakenBeschikbaar);
        },
        error: function (xhr, status, error) {
            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
}

// Filter functie voor getAfsprakenByDocent()
function filterByBeschikbaar(obj) {
    if (obj.beschikbaar == 1) {
        return false;
    } else {
        return true;
    }
}

// Filter functie voor getAfsprakenByDocent()
function filterByBezet(obj) {
    if (obj.beschikbaar == 1) {
        return true;
    } else {
        return false;
    }
}

// Mobiele versie
$(window).resize(function () {
    if (600 < $(window).width()) {
        $('#calendarDocent').fullCalendar('changeView', 'agendaWeek');
    } else {
        $('#calendarDocent').fullCalendar('changeView', 'agendaDay');
    }
});

// Tooltips activeren
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});