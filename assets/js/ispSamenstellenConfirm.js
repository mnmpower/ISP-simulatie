 var isp1 = sessionStorage.getItem("isp1");
var isp2 = sessionStorage.getItem("isp2");


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

});

 $('#roosterConfirm').fullCalendar('gotoDate', '2019-09-16');
 $('#roosterConfirm2').fullCalendar('gotoDate', '2019-09-16');

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
        if (typeof lessen != 'undefined' && lessen.length != 0) {
            $.ajax({
                type: "GET",
                url: site_url + "/student/haalAjaxOp_lesKlas/",
                data: {lessen: JSON.stringify(postData)},
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
}

function deleteISP() {
    sessionStorage.setItem("isp1", null);
    sessionStorage.setItem("isp2", null);
    $('#ispCancelForm').submit();
}

function submitISP() {
    $('#isp1').val(sessionStorage.getItem("isp1"));
    $('#isp2').val(sessionStorage.getItem("isp2"));
    $('#ispConfirmForm').submit();
}

$("body")
    .on("click", "#ispCancel", deleteISP)
    .on("click", "#ispConfirm", submitISP);

 $( document ).ready(function () {
    updateRoosters(1, JSON.parse(isp1));
    updateRoosters(2, JSON.parse(isp2));
 });