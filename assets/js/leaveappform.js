document.addEventListener("DOMContentLoaded", function () {
    // Add event listener to the radio buttons with name "typeOfLeave"
    var leaveTypeRadios = document.querySelectorAll('input[name="typeOfLeave"]');
    var otherTypeOfLeave = document.querySelector('input[name="otherTypeOfLeave"]');
    var typeOfVacationLeave = document.querySelectorAll('input[name="typeOfVacationLeave"]');
    var typeOfSickLeave = document.querySelectorAll('input[name="typeOfSickLeave"]');
    var typeOfStudyLeave = document.querySelectorAll('input[name="typeOfStudyLeave"]');
    var typeOfOtherLeave = document.querySelectorAll('input[name="typeOfOtherLeave"]');

    leaveTypeRadios.forEach(function (radio) {
        radio.addEventListener("change", handleLeaveTypeChange);
    });

    otherTypeOfLeave.addEventListener("change", handleLeaveTypeChange);

    typeOfVacationLeave.forEach(function (radio) {
        radio.addEventListener("change", handleLeaveTypeChange);
    });

    typeOfSickLeave.forEach(function (radio) {
        radio.addEventListener("change", handleLeaveTypeChange);
    });

    typeOfStudyLeave.forEach(function (radio) {
        radio.addEventListener("change", handleLeaveTypeChange);
    });

    typeOfOtherLeave.forEach(function (radio) {
        radio.addEventListener("change", handleLeaveTypeChange);
    });

    // Initial state
    handleLeaveTypeChange();
});

// function handleOtherLeaveTypeChange() {
//     var otherTypeOfLeave = document.querySelector('input[name="otherTypeOfLeave"]');
//     var leaveTypeRadios = document.querySelectorAll('input[name="typeOfLeave"]');
//     if(otherTypeOfLeave.value !== ''){
//         leaveTypeRadios.forEach(function (radio) {
//         radio.checked = false;
//     });
//     leaveTypeRadios.value = '';
//     }
// }

function handleLeaveTypeChange() {
    var typeOfLeave = document.querySelector('input[name="typeOfLeave"]:checked') ? document.querySelector('input[name="typeOfLeave"]:checked').value : '';
    var typeOfVacationLeave = document.querySelector('input[name="typeOfVacationLeave"]:checked') ? document.querySelector('input[name="typeOfVacationLeave"]:checked').value : '';
    var typeOfSickLeave = document.querySelector('input[name="typeOfSickLeave"]:checked') ? document.querySelector('input[name="typeOfSickLeave"]:checked').value : '';

    // Disable all leaveclass inputs
    var leaveClassInputs = document.querySelectorAll('.leave-app-form-leaveclass-container input');
    leaveClassInputs.forEach(function (input) {
        input.disabled = true;
    });

    var vacationLeaveType = document.querySelectorAll('input[name="typeOfVacationLeave"]');
    var sickLeaveType = document.querySelectorAll('input[name="typeOfSickLeave"]');
    var studyLeaveType = document.querySelectorAll('input[name="typeOfStudyLeave"]');
    var otherLeaveType = document.querySelectorAll('input[name="typeOfOtherLeave"]');

    var otherTypeOfLeaveInput = document.querySelector('input[name="otherTypeOfLeave"]');

    // Enable specific inputs based on typeOfLeave
    if (typeOfLeave === 'Vacation Leave') {
        enableInputs(['typeOfVacationLeave']);
        if (typeOfVacationLeave == "Within the Philippines") {
            enableInputs(['typeOfVacationLeaveWithin']);
            resetInputs(['typeOfVacationLeaveAbroad']);
        } else if (typeOfVacationLeave == "Abroad") {
            enableInputs(['typeOfVacationLeaveAbroad']);
            resetInputs(['typeOfVacationLeaveWithin']);
        }

        // Resets Inputs
        resetInputs(['typeOfSickLeaveInHospital']);
        resetInputs(['typeOfSickLeaveOutPatient']);
        resetInputs(['typeOfSickLeaveOutPatientOne']);
        sickLeaveType.forEach(function (input) {
            input.checked = false;
        });

        resetInputs(['typeOfSpecialLeaveForWomen']);
        resetInputs(['typeOfSpecialLeaveForWomenOne']);

        studyLeaveType.forEach(function (input) {
            input.checked = false;
        });

        // otherLeaveType.forEach(function (input) {
        //     input.checked = false;
        // });

    } else if (typeOfLeave === 'Sick Leave') {
        enableInputs(['typeOfSickLeave']);
        if (typeOfSickLeave == "In Hospital") {
            enableInputs(['typeOfSickLeaveInHospital']);
            resetInputs(['typeOfSickLeaveOutPatient']);
            resetInputs(['typeOfSickLeaveOutPatientOne']);
        } else if (typeOfSickLeave == "Out Patient") {
            enableInputs(['typeOfSickLeaveOutPatient']);
            enableInputs(['typeOfSickLeaveOutPatientOne']);
            resetInputs(['typeOfSickLeaveInHospital']);
        }

        // Resets Inputs
        resetInputs(['typeOfVacationLeaveWithin']);
        resetInputs(['typeOfVacationLeaveAbroad']);
        vacationLeaveType.forEach(function (input) {
            input.checked = false;
        });

        resetInputs(['typeOfSpecialLeaveForWomen']);
        resetInputs(['typeOfSpecialLeaveForWomenOne']);

        studyLeaveType.forEach(function (input) {
            input.checked = false;
        });

        // otherLeaveType.forEach(function (input) {
        //     input.checked = false;
        // });

    } else if (typeOfLeave === 'Special Leave Benefits for Women') {
        enableInputs(['typeOfSpecialLeaveForWomen', 'typeOfSpecialLeaveForWomenOne']);

        // Resets Inputs
        resetInputs(['typeOfVacationLeaveWithin']);
        resetInputs(['typeOfVacationLeaveAbroad']);
        vacationLeaveType.forEach(function (input) {
            input.checked = false;
        });

        resetInputs(['typeOfSickLeaveInHospital']);
        resetInputs(['typeOfSickLeaveOutPatient']);
        resetInputs(['typeOfSickLeaveOutPatientOne']);
        sickLeaveType.forEach(function (input) {
            input.checked = false;
        });

        studyLeaveType.forEach(function (input) {
            input.checked = false;
        });

        // otherLeaveType.forEach(function (input) {
        //     input.checked = false;
        // });

    } else if (typeOfLeave === 'Study Leave') {
        enableInputs(['typeOfStudyLeave']);

        // Resets Inputs
        resetInputs(['typeOfVacationLeaveWithin']);
        resetInputs(['typeOfVacationLeaveAbroad']);
        vacationLeaveType.forEach(function (input) {
            input.checked = false;
        });

        resetInputs(['typeOfSickLeaveInHospital']);
        resetInputs(['typeOfSickLeaveOutPatient']);
        resetInputs(['typeOfSickLeaveOutPatientOne']);
        sickLeaveType.forEach(function (input) {
            input.checked = false;
        });

        resetInputs(['typeOfSpecialLeaveForWomen']);
        resetInputs(['typeOfSpecialLeaveForWomenOne']);

        // otherLeaveType.forEach(function (input) {
        //     input.checked = false;
        // });
    } else {
        // Resets Inputs
        resetInputs(['typeOfVacationLeaveWithin']);
        resetInputs(['typeOfVacationLeaveAbroad']);
        vacationLeaveType.forEach(function (input) {
            input.checked = false;
        });

        resetInputs(['typeOfSickLeaveInHospital']);
        resetInputs(['typeOfSickLeaveOutPatient']);
        resetInputs(['typeOfSickLeaveOutPatientOne']);
        sickLeaveType.forEach(function (input) {
            input.checked = false;
        });

        resetInputs(['typeOfSpecialLeaveForWomen']);
        resetInputs(['typeOfSpecialLeaveForWomenOne']);

        studyLeaveType.forEach(function (input) {
            input.checked = false;
        });

        // otherLeaveType.forEach(function (input) {
        //     input.checked = false;
        // });
    }

    if (otherTypeOfLeaveInput.value.trim() !== '') {
        // leaveTypeRadios.forEach(function (radio) {
        //     radio.checked = false;
        // });
        enableInputs(['typeOfOtherLeave']);
    }

    function enableInputs(inputNames) {
        inputNames.forEach(function (inputName) {
            var inputs = document.querySelectorAll('input[name="' + inputName + '"]');
            inputs.forEach(function (input) {
                input.disabled = false;
            });
        });
    }

    function resetInputs(inputNames) {
        inputNames.forEach(function (inputName) {
            var inputs = document.querySelectorAll('input[name="' + inputName + '"]');
            inputs.forEach(function (input) {
                input.value = '';
            });
        });
    }
}