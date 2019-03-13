$('#calendar').fullCalendar({
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    defaultView: 'agendaWeek',
    weekends: false,
    nowIndicator: true,
    allDaySlot: false,
    minTime: "06:00:00",
<<<<<<< HEAD
    eventSources: [{ events: [
        {
            title  : 'event1',
            start  : '2019-03-11T08:39:43',
            end    : '2019-03-11T09:39:43'
        },
        {
            title  : 'event2',
            start  : '2019-03-13T09:39:43',
            end    : '2019-03-13T10:39:43'
        }]}],
    dayClick: function(date, jsEvent, view) {

        //alert('Clickedon: ' + date.format());
=======
    eventClick: function (calEvent, jsEvent, view) {
        if (calEvent.bezet == 1) {
            //alert('Event: ' + calEvent.title);
            //alert('Event: ' + calEvent.eventid);
            //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
            //alert('View: ' + view.name);
            var docent = $('#docentId option:selected').text();
            $("#calendarModalDocent").val(docent);
            var startdate = new Date(calEvent.start);
            var enddate = new Date(calEvent.end);
            $("#calendarModalDate").val(startdate.getDate() + '/' + startdate.getUTCMonth() + '/' + startdate.getFullYear());
            $("#calendarModalTime").val(startdate.getUTCHours() + ':' + (startdate.getMinutes() < 10 ? '0' : '') + startdate.getMinutes() + ' tot ' + enddate.getUTCHours() + ':' + (enddate.getMinutes() < 10 ? '0' : '') + enddate.getMinutes());
            $("#calendarModalPlaats").val(calEvent.plaats);
            console.log(docent);
            $('#CalendarModal').modal();
            $('#calendarModalConfirm').click(function () {
                var description = $('#calendarModalDescription').val();
>>>>>>> Afspraken Maken Update, JS update

                console.log(postData);
                var dataString = JSON.stringify(postData);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: site_url + "/student/AfspraakToevoegen/",
                    data: {'description': description},
                    success: function (date) {

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
            console.log(outputBezet);
            console.log(outputBeschikbaar);
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