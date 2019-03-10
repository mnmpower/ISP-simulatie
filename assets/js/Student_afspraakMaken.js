$('#calendar').fullCalendar({
    schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
    defaultView: 'timelineWeek',
    header: {
        left: 'teacherButton',
        center: 'title'
    },
    customButtons: {
        teacherButton: {
            text: 'Docent kiezen',
            click: function() {
                alert('clicked the custom button!');
            }
        }
    },

});
