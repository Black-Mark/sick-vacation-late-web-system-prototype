document.addEventListener("DOMContentLoaded", function () {
    var workingDaysNum = document.getElementById('workingDays');

    var vacationLeaveTotalEarnedNum = document.getElementsByName('vacationLeaveTotalEarned');
    var vacationLeaveLessNum = document.getElementsByName('vacationLeaveLess');
    var vacationLeaveBalanceNum = document.getElementsByName('vacationLeaveBalance');

    var sickLeaveTotalEarnedNum = document.getElementsByName('sickLeaveTotalEarned');
    var sickLeaveLessNum = document.getElementsByName('sickLeaveLess');
    var sickLeaveBalanceNum = document.getElementsByName('sickLeaveBalance');

    function updateLeaveComputation (){
        //
    }

    $('#floatingPeriodEnd').on('change', function () {
        // validateDateInput(this);

        // Get the values of the two input fields
        var floatingPeriodValue = $('#floatingPeriod').val();
        var floatingPeriodEndValue = $('#floatingPeriodEnd').val();

        // Compare the values
        if (floatingPeriodValue > floatingPeriodEndValue) {
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
            containerPeriod = $('#floatingPeriod').val();
        }
        updateDays();
    });

    console.log(workingDaysNum.value);
    console.log(sickLeaveLessNum);

});