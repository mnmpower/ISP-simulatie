$('#calendar').fullCalendar({
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    defaultView: 'agendaWeek',
    weekends: false,
    nowIndicator: true,
    allDaySlot: false,
    minTime: "06:00:00",
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

        //alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

        //alert('Current view: ' + view.name);
        $('#CalendarModal').modal();
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
        success: function(output) {
            console.log(output);
            $('#calendar').fullCalendar({
            });

        },
        error: function (xhr, status, error) {
            alert("-- ERROR IN AJAX --\n\n" + xhr.responseText);
        }
    });
}