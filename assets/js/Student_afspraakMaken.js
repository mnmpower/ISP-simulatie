$('#calendar').fullCalendar({
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    defaultView: 'agendaWeek',
    weekends: false,
    nowIndicator: true,
    allDaySlot: false,
    minTime: "08:00:00",
    maxTime: "19:00:00",
    height: "auto",
    eventClick: function (calEvent, jsEvent, view) {
        if (calEvent.bezet == 1) {
            var docent = $('#docentId option:selected').text();
            $("#calendarModalDocent").val(docent);
            var startdate = new Date(calEvent.start);
            var enddate = new Date(calEvent.end);
            $("#calendarModalDate").val(startdate.getDate() + '/' + startdate.getUTCMonth() + '/' + startdate.getFullYear());
            $("#calendarModalTimeStart").val(startdate.getUTCHours() + ':' + (startdate.getMinutes() < 10 ? '0' : '') + startdate.getMinutes() + ' tot ' + enddate.getUTCHours() + ':' + (enddate.getMinutes() < 10 ? '0' : '') + enddate.getMinutes());
            $("#calendarModalTimeStart").val(startdate.getUTCHours() + ':' + (startdate.getMinutes() < 10 ? '0' : '') + startdate.getMinutes() + ' tot ' + enddate.getUTCHours() + ':' + (enddate.getMinutes() < 10 ? '0' : '') + enddate.getMinutes());
            $("#calendarModalPlaats").val(calEvent.plaats);
            $('#CalendarModal').modal();
            $('#calendarModalConfirm').click(function () {
                var description = $('#calendarModalDescription').val();
                var id = calEvent.eventid;

                $.ajax({
                    type: "GET",
                    url: site_url + "/student/afspraakToevoegen",
                    data: {description: description, id : id},
                    success: function () {
                        getAfsprakenByDocent();

                        $('#CalendarModal').modal('hide');
                    },
                    error: function (xhr, status, error) {
                        alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
                    }
                });
            });
        }
    }
});

$('#docentId').change(function () {
    getAfsprakenByDocent();
});

function getAfsprakenByDocent() {
    var persoonId = $('#docentId').val();
    $.ajax({
        type: "GET",
        url: site_url + "/student/haalAjaxOp_Afspraken/",
        data: {persoonId: persoonId},
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
                        'plaats' : item.plaats,
                        'color': 'red'
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
                        'plaats' : item.plaats,
                        'color': 'green'
                    });
            });
            $("#calendar").fullCalendar('removeEventSources');
            $("#calendar").fullCalendar('addEventSource', afsprakenBezet);
            $("#calendar").fullCalendar('addEventSource', afsprakenBeschikbaar);
        },
        error: function (xhr, status, error) {
            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
}

function filterByBeschikbaar(obj) {
    if (obj.beschikbaar == 1) {
        return false;
    } else {
        return true;
    }
}

function filterByBezet(obj) {
    if (obj.beschikbaar == 1) {
        return true;
    } else {
        return false;
    }
}

    $(window).resize(function () {
        if (600 < $(window).width()) {
            $('#calendar').fullCalendar('changeView', 'agendaWeek');}
        else {
            $('#calendar').fullCalendar('changeView', 'agendaDay');}
    });