$(document).ready(function () {
    $('#calendar').fullCalendar({
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

    $('#calendar').fullCalendar('gotoDate','2019-09-16');

    var lessen = getLessenFromStudent(studentid);
    console.log('na ajax');
    $(window).resize(function () {
        if (600 < $(window).width()) {
            $('#calendar').fullCalendar('changeView', 'agendaWeek');
        }
        else {
            $('#calendar').fullCalendar('changeView', 'agendaDay');
        }
    });
});

function getLessenFromStudent(id) {

    $.ajax({
        url: site_url + "/IspVerantwoordelijke/haalJsonOp_lessenPerStudent/"+id.toString(),
        type: "get",
        dataType: 'json',
        success: function (lessen) {
            var studentLessen = {events: []};
            lessen.forEach(function (les) {
                if (les.semester == 1 || les.semester == 3){
                    studentLessen.events.push({
                        'title': les.vaknaam,
                        'start': les.datum + 'T' + les.startuur,
                        'end': les.datum + 'T' + les.einduur,
                        // 'eventid': les.id,
                        'color': '#6d96ff'
                    });
                }
            });

            $("#calendar").fullCalendar('addEventSource', studentLessen);
        },
        error: function (xhr, status, error) {
            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
}