document.addEventListener('DOMContentLoaded', function () {
    var typeOfLeaveOrig = document.getElementById('typeOfLeaveOrig');
    var workingDaysOrig = document.getElementById('workingDaysOrig');
    var inclusiveDateStartOrig = document.getElementById('inclusiveDateStartOrig');
    var inclusiveDateEndOrig = document.getElementById('inclusiveDateEndOrig');
    var inclusiveDateOneOrig = document.getElementById('inclusiveDateOneOrig');
    var inclusiveDateTwoOrig = document.getElementById('inclusiveDateTwoOrig');
    var inclusiveDateThreeOrig = document.getElementById('inclusiveDateThreeOrig');

    var inclusiveDateStart = document.getElementById('inclusiveDateStart');
    var inclusiveDateEnd = document.getElementById('inclusiveDateEnd');
    var inclusiveDateOne = document.getElementById('inclusiveDateSelectOne');
    var inclusiveDateTwo = document.getElementById('inclusiveDateSelectTwo');
    var inclusiveDateThree = document.getElementById('inclusiveDateSelectThree');

    function initializeForm() {
        inclusiveDateStart.value = inclusiveDateStartOrig.value;
        inclusiveDateEnd.value = inclusiveDateEndOrig.value;
        inclusiveDateOne.value = inclusiveDateOneOrig.value;
        inclusiveDateTwo.value = inclusiveDateTwoOrig.value;
        inclusiveDateThree.value = inclusiveDateThreeOrig.value;
        workingDays.value = workingDaysOrig.value;
    }

    // Initialize the working days value on page load
    initializeForm();
});

document.addEventListener("DOMContentLoaded", function () {

    var leaveTypeRadios = document.querySelectorAll('input[name="typeOfLeave"]');

    var typeOfLeave = document.querySelector('input[name="typeOfLeave"]:checked') ? document.querySelector('input[name="typeOfLeave"]:checked').value : '';
    var workingDaysNum = document.getElementById('workingDays');

    var vacationLeaveTotalEarnedNum = document.getElementsByName('vacationLeaveTotalEarned')[0];
    var vacationLeaveLessNum = document.getElementsByName('vacationLeaveLess')[0];
    var vacationLeaveBalanceNum = document.getElementsByName('vacationLeaveBalance')[0];

    var sickLeaveTotalEarnedNum = document.getElementsByName('sickLeaveTotalEarned')[0];
    var sickLeaveLessNum = document.getElementsByName('sickLeaveLess')[0];
    var sickLeaveBalanceNum = document.getElementsByName('sickLeaveBalance')[0];

    var daysWithPayNum = document.getElementsByName('dayWithPay')[0];
    var daysWithoutPayNum = document.getElementsByName('dayWithoutPay')[0];

    function updateLeaveComputation() {
        var typeOfLeave = document.querySelector('input[name="typeOfLeave"]:checked') ? document.querySelector('input[name="typeOfLeave"]:checked').value : '';
        console.log(typeOfLeave);
        if (typeOfLeave == "Sick Leave") {
            var sickLeaveTotal = parseFloat(sickLeaveTotalEarnedNum.value) || 0;
            var sickLeaveUsed = parseFloat(workingDaysNum.value) || 0;
            var sickLeaveBalance = sickLeaveTotal - sickLeaveUsed;
            sickLeaveLessNum.value = sickLeaveUsed.toFixed(2);
            sickLeaveBalanceNum.value = sickLeaveBalance.toFixed(2);

            var vacationLeaveTotal = parseFloat(vacationLeaveTotalEarnedNum.value) || 0;
            var vacationLeaveUsed = parseFloat(0) || 0;
            var vacationLeaveBalance = vacationLeaveTotal - vacationLeaveUsed;
            vacationLeaveLessNum.value = vacationLeaveUsed.toFixed(2);
            vacationLeaveBalanceNum.value = vacationLeaveBalance.toFixed(2);

            if (sickLeaveTotal < sickLeaveUsed) {
                daysWithPayNum.value = sickLeaveTotal;
                daysWithoutPayNum.value = sickLeaveUsed - sickLeaveTotal;
            } else if (sickLeaveTotal >= sickLeaveUsed) {
                daysWithPayNum.value = sickLeaveUsed;
                daysWithoutPayNum.value = 0;
            }
        } else if (typeOfLeave == "Vacation Leave" || typeOfLeave == "Forced Leave") {
            var sickLeaveTotal = parseFloat(sickLeaveTotalEarnedNum.value) || 0;
            var sickLeaveUsed = parseFloat(0) || 0;
            var sickLeaveBalance = sickLeaveTotal - sickLeaveUsed;
            sickLeaveLessNum.value = sickLeaveUsed.toFixed(2);
            sickLeaveBalanceNum.value = sickLeaveBalance.toFixed(2);

            var vacationLeaveTotal = parseFloat(vacationLeaveTotalEarnedNum.value) || 0;
            var vacationLeaveUsed = parseFloat(workingDaysNum.value) || 0;
            var vacationLeaveBalance = vacationLeaveTotal - vacationLeaveUsed;
            vacationLeaveLessNum.value = vacationLeaveUsed.toFixed(2);
            vacationLeaveBalanceNum.value = vacationLeaveBalance.toFixed(2);

            if (vacationLeaveTotal < vacationLeaveUsed) {
                daysWithPayNum.value = vacationLeaveTotal;
                daysWithoutPayNum.value = vacationLeaveUsed - vacationLeaveTotal;
            } else if (vacationLeaveTotal >= vacationLeaveUsed) {
                sickLeaveLessNum.value = sickLeaveUsed;
                vacationLeaveLessNum.value = vacationLeaveUsed;
                
                daysWithPayNum.value = vacationLeaveUsed;
                daysWithoutPayNum.value = 0;
            }
        } else {
            var sickLeaveTotal = parseFloat(sickLeaveTotalEarnedNum.value) || 0;
            var sickLeaveUsed = parseFloat(0) || 0;
            var sickLeaveBalance = sickLeaveTotal - sickLeaveUsed;
            sickLeaveLessNum.value = sickLeaveUsed.toFixed(2);
            sickLeaveBalanceNum.value = sickLeaveBalance.toFixed(2);

            var vacationLeaveTotal = parseFloat(vacationLeaveTotalEarnedNum.value) || 0;
            var vacationLeaveUsed = parseFloat(0) || 0;
            var vacationLeaveBalance = vacationLeaveTotal - vacationLeaveUsed;
            vacationLeaveLessNum.value = vacationLeaveUsed.toFixed(2);
            vacationLeaveBalanceNum.value = vacationLeaveBalance.toFixed(2);

            daysWithPayNum.value = workingDaysNum.value;
            daysWithoutPayNum.value = 0;
        }
    }

    // workingDaysNum.addEventListener('change', function () {
    //     updateLeaveComputation();
    // });

    leaveTypeRadios.forEach(function (radio) {
        radio.addEventListener("change", updateLeaveComputation);
    });

    workingDaysNum.addEventListener('input', updateLeaveComputation);
    sickLeaveTotalEarnedNum.addEventListener('input', updateLeaveComputation);
    vacationLeaveTotalEarnedNum.addEventListener('input', updateLeaveComputation);

    // updateLeaveComputation();
});
