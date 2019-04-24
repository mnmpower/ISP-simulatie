// Calendar settings
$('#roosterConfirm, #roosterConfirm2').fullCalendar({
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
    slotEventOverlap: false,
    gotoDate: '2019-09-16'

});

// Mobile
$(window).resize(function () {
    if (600 < $(window).width()) {
        $('#roosterConfirm').fullCalendar('changeView', 'agendaWeek');
        $('#roosterConfirm2').fullCalendar('changeView', 'agendaWeek');
    } else {
        $('#roosterConfirm').fullCalendar('changeView', 'agendaDay');
        $('#roosterConfirm2').fullCalendar('changeView', 'agendaDay');
    }
});

function updateRoosters(roosterNr, isp) {
        var lessen = isp;
        postData = lessen;
        console.log(lessen);
        $.ajax({
            type: "GET",
            url: site_url + "/student/haalAjaxOp_lesKlas/",
            data: {lessen: postData},
            success: function (data) {
                var rooster = JSON.parse(data);
                var roosterEvents = {events: []};
                rooster.map(function (item) {
                    roosterEvents.events.push(
                        {
                            'title': item.klas.naam + '\n' + item.vak.naam,
                            'start': item.datum + 'T' + item.startuur,
                            'end': item.datum + 'T' + item.einduur,
                            'color': '#cce5ff'
                        });
                });
                console.log(roosterEvents);
                if (roosterNr == 1) {
                    $('#roosterConfirm').fullCalendar('removeEventSources');
                    $('#roosterConfirm').fullCalendar('addEventSource', roosterEvents);

                }
                if (roosterNr == 2) {
                    $('#roosterConfirm2').fullCalendar('removeEventSources');
                    $('#roosterConfirm2').fullCalendar('addEventSource', roosterEvents);
                }
            }, error: function (e) {
                console.log(e.message);
            }
        });
}

function continueISP() {
    $('#gotoSemester2').submit();
}

updateRoosters(1, sessionStorage.getItem("ISP1"));
updateRoosters(2, sessionStorage.getItem("ISP2"));