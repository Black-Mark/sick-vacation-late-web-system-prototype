// <!-- Leave Fata Form -->

document.addEventListener("DOMContentLoaded", function () {
    // Get the first element with the class "selectedYear"
    let selectedYearElement = document.getElementById("selectedYear");

    // Check if the element exists before trying to access its content
    if (selectedYearElement) {
        // Retrieve the content of the element
        let selectedYearContent = selectedYearElement.textContent || selectedYearElement.innerText;

        // Convert the content to a number
        let selectedYear = parseInt(selectedYearContent, 10);

        // Check if the conversion was successful
        if (!isNaN(selectedYear)) {
            // console.log("Selected year as a number: " + selectedYear);
        } else {
            // console.error("Failed to convert to a number. Check the content of the span element.");
        }
    } else {
        // console.error("Element with class 'selectedYear' not found.");
    }
});


var addLeaveDataRecordState = null;
var currentYear = new Date().getFullYear();
var addPeriod = null;
var addPeriodEnd = null;
var addDateOfAction = null;

$(document).ready(function () {
    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }

    // function validateDateInput(inputField) {
    //     var selectedDate = new Date($(inputField).val());

    //     // Format the selected date for comparison
    //     var formattedSelectedDate = formatDate(selectedDate);

    //     // Format January 1st of the selected year for comparison
    //     var formattedJanuary1 = formatDate(new Date(selectedYear, 0, 1));

    //     // Format December 31st of the selected year for comparison
    //     var formattedDecember31 = formatDate(new Date(selectedYear, 12, 31));

    //     // Check if selectedDate is within the range January 1st to December 31st of the selected year
    //     if (!(formattedJanuary1 <= formattedSelectedDate && formattedSelectedDate <= formattedDecember31)) {
    //         $(inputField).val(formattedJanuary1);
    //         Toastify({
    //             text: 'Enter Date Based on the Selected Year!',
    //             duration: 3000,
    //             newWindow: true,
    //             close: true,
    //             gravity: 'top',
    //             position: 'center',
    //             style: {
    //                 background: '#fca100',
    //             },
    //             stopOnFocus: true,
    //         }).showToast();
    //     }
    // }

    function computeDays(startDate, endDate) {
        const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
        const start = new Date(startDate);
        const end = new Date(endDate);

        const diffDays = Math.round(Math.abs((start - end) / oneDay)) + 1;
        return diffDays;
    }

    function updateDays() {
        const period = $('#floatingPeriod').val();
        const periodEnd = $('#floatingPeriodEnd').val();

        // Check if both period and periodEnd have valid values
        if (period && periodEnd) {
            const days = computeDays(period, periodEnd);
            $('#floatingDayInput').val(days);
        }
    }

    // $('#floatingDateOfAction').on('change', function () {
    //     validateDateInput(this);
    // });

    var containerPeriod = null;
    var containerPeriodEnd = null;

    $('#floatingPeriod').on('change', function () {
        // validateDateInput(this);

        // Get the values of the two input fields
        var floatingPeriodValue = $('#floatingPeriod').val();
        var floatingPeriodEndValue = $('#floatingPeriodEnd').val();

        // Compare the values
        if (floatingPeriodValue >= floatingPeriodEndValue) {
            $('#floatingPeriodEnd').val(floatingPeriodValue);
            Toastify({
                text: 'Period should not be Greater Than the Period End!',
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: 'top',
                position: 'center',
                style: {
                    background: '#fca100',
                },
                stopOnFocus: true,
            }).showToast();
        } else {
            updateDays();
            containerPeriod = $('#floatingPeriod').val();
            containerPeriodEnd = $('#floatingPeriodEnd').val();
        }
    });

    $('#floatingPeriodEnd').on('change', function () {
        // validateDateInput(this);

        // Get the values of the two input fields
        var floatingPeriodValue = $('#floatingPeriod').val();
        var floatingPeriodEndValue = $('#floatingPeriodEnd').val();

        // Compare the values
        if (floatingPeriodValue >= floatingPeriodEndValue) {
            $('#floatingPeriodEnd').val(floatingPeriodValue);
            Toastify({
                text: 'Period should not be Greater Than the Period End!',
                duration: 3000,
                newWindow: true,
                close: true,
                gravity: 'top',
                position: 'center',
                style: {
                    background: '#fca100',
                },
                stopOnFocus: true,
            }).showToast();
        } else {
            updateDays();
            containerPeriod = $('#floatingPeriod').val();
            containerPeriodEnd = $('#floatingPeriodEnd').val();
        }
    });

    $('#createInitialRecord').click(function () {
        if (selectedYear == currentYear) {
            addPeriod = formatDate(new Date());
            addPeriodEnd = formatDate(new Date());
            addDateOfAction = formatDate(new Date());
        } else {
            // If not the current year, set values to January 01, selectedYear
            addPeriod = addPeriodEnd = formatDate(new Date(selectedYear, 0, 1));
            addDateOfAction = formatDate(new Date(selectedYear, 0, 1));
        }

        // Set form field values
        $('#floatingPeriod').val(addPeriod);
        $('#floatingPeriodEnd').val(addPeriodEnd);
        $('#floatingDateOfAction').val(addDateOfAction);

        // Save the state
        addLeaveDataRecordState = {
            period: addPeriod,
            periodEnd: addPeriodEnd,
            dateOfAction: addDateOfAction,
        };
    });

    $('.addNewLeaveDataRecord').click(function () {
        // addPeriod = addPeriodEnd = formatDate(new Date(selectedYear, 0, 1));
        // addDateOfAction = formatDate(new Date(selectedYear, 0, 1));

        addPeriod = $(this).data('period-date');
        addPeriodEnd = $(this).data('period-end-date');
        addDateOfAction = $(this).data('date-of-action');

        // Set form field values
        $('#floatingNewPeriod').val(addPeriod);
        $('#floatingNewPeriodEnd').val(addPeriodEnd);
        $('#floatingNewDateOfAction').val(addDateOfAction);

        // Save the state
        addLeaveDataRecordState = {
            period: addPeriod,
            periodEnd: addPeriodEnd,
            dateOfAction: addDateOfAction,
        };
    });

    $('.editLeaveDataRecord').click(function () {
        // Set form field values
        var editPeriodStart = $(this).data('period-start');
        var editPeriodEnd = $(this).data('period-end');
        var editParticularType = $(this).data('particular-type');
        var editParticularLabel = $(this).data('particular-label');
        var editInputDay = $(this).data('input-day');
        var editInputHour = $(this).data('input-hour');
        var editInputMinute = $(this).data('input-minute');
        var editDateOfAction = $(this).data('date-of-action');

        // Set form field values
        $('#floatingEditPeriod').val(editPeriodStart);
        $('#floatingEditPeriodEnd').val(editPeriodEnd);
        $('#floatingEditParticularType').val(editParticularType);
        $('#floatingEditParticularLabel').val(editParticularLabel);
        $('#floatingEditDayInput').val(editInputDay);
        $('#floatingEditHourInput').val(editInputHour);
        $('#floatingEditMinuteInput').val(editInputMinute);
        $('#floatingEditDateOfAction').val(editDateOfAction);

        // Save the state
        editLeaveDataRecordState = {
            periodStart: editPeriodStart,
            periodEnd: editPeriodEnd,
            particularType: editParticularType,
            particularLabel: editParticularLabel,
            inputDay: editInputDay,
            inputHour: editInputHour,
            inputMinute: editInputMinute,
            dateOfAction: editDateOfAction,
        };
    });

    function setEditDataFromState() {
        // Set form field values from the editLeaveDataRecordState object
        $('#floatingEditPeriod').val(editLeaveDataRecordState.periodStart);
        $('#floatingEditPeriodEnd').val(editLeaveDataRecordState.periodEnd);
        $('#floatingEditParticularType').val(editLeaveDataRecordState.particularType);
        $('#floatingEditParticularLabel').val(editLeaveDataRecordState.particularLabel);
        $('#floatingEditDayInput').val(editLeaveDataRecordState.inputDay);
        $('#floatingEditHourInput').val(editLeaveDataRecordState.inputHour);
        $('#floatingEditMinuteInput').val(editLeaveDataRecordState.inputMinute);
        $('#floatingEditDateOfAction').val(editLeaveDataRecordState.dateOfAction);
    }

    $('.clearEditLeaveDataInputs').click(function () {
        // Reset form fields to their initial values
        $(":input:not(:submit, :hidden)").val('');
        $("select").prop('selectedIndex', 0);
        setEditDataFromState();
    });

    // Function to set data based on the saved state
    function setAddDataFromState() {
        if (addLeaveDataRecordState) {
            // Set form field values based on the saved state
            $('#floatingPeriod').val(addLeaveDataRecordState.period);
            $('#floatingPeriodEnd').val(addLeaveDataRecordState.periodEnd);
            $('#floatingDateOfAction').val(addLeaveDataRecordState.dateOfAction);
            $('#floatingNewPeriod').val(addLeaveDataRecordState.period);
            $('#floatingNewPeriodEnd').val(addLeaveDataRecordState.periodEnd);
            $('#floatingNewDateOfAction').val(addLeaveDataRecordState.dateOfAction);
        }
    }

    // Add click event handler for the Reset button
    $('.clearAddLeaveDataInputs').click(function () {
        // Reset form fields to their initial values
        $(":input:not(:submit, :hidden)").val('');
        $("select").prop('selectedIndex', 0);
        setAddDataFromState();
    });
});
