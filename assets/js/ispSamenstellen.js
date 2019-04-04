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

$('#calendar').fullCalendar('gotoDate','2019-09-16');

$(window).resize(function () {
    if (600 < $(window).width()) {
        $('#uurrooster').fullCalendar('changeView', 'agendaWeek');
    }
    else {
        $('#uurrooster').fullCalendar('changeView', 'agendaDay');
    }
});

// Carousel Settings
$('.carousel').carousel(
    {
        interval: false
    });

// Klassen checkbox limit
$('.klasCheckbox').on('change', function() {
    if($('.klasCheckbox:checked').length > 2) {
        this.checked = false;
    }
});