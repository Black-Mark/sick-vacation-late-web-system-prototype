// <!-- Checking Check Values -->
$(document).ready(function () {
    $("#clearAddEmployeeInputs").click(function () {
        $("#addEmployee :input:not(:submit)").val('');
        $("#addEmployee select").prop('selectedIndex', 0);

        var currentDate = new Date().toISOString().split('T')[0];
        $("#floatingDateStarted").val(currentDate);
    });


    // Get all selected rows
    // $('#OLDdeleteEmployees').on('click', function () {
    //     // let selectedRows = table.rows({ selected: true }).data().toArray();
    //     // console.log(selectedRows);

    //     let selectedData = table.rows({ selected: true }).data().pluck(0).toArray();
    //     console.log(selectedData);
    // });
});

function printSelectedValues() {
    var checkboxes = document.getElementsByName('selectedEmployee[]');
    var selectedValues = [];

    // Iterate through checkboxes and check if they are checked
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            selectedValues.push(checkboxes[i].value);
        }
    }

    console.log(selectedValues);
    // console.log("Selected values: " + selectedValues.join(', '));
}

// <!-- Disable Multiple Select Button -->
document.addEventListener('DOMContentLoaded', function () {
    var checkboxes = document.getElementsByName('selectedEmployee[]');
    var deleteEmployeesButton = document.getElementById('deleteMultipleEmployeeBTN');
    var editEmployeesButton = document.getElementById('editMultipleEmployeeBTN');
    var selectedEmpIDInput = document.getElementById('selectedEmpID');

    // Add event listener to checkboxes
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            updateDeleteEmployeesButtonState();
        });
    });

    // Function to update the state of the delete button
    function updateDeleteEmployeesButtonState() {
        var selectedValues = Array.from(checkboxes).filter(checkbox => checkbox.checked).map(checkbox => checkbox.value);
        deleteEmployeesButton.disabled = selectedValues.length <= 1;
        editEmployeesButton.disabled = selectedValues.length <= 1;

        // Convert the array to JSON and update the value of the hidden input
        selectedEmpIDInput.value = JSON.stringify(selectedValues);
    }

    // Initial update of the delete button state
    updateDeleteEmployeesButtonState();
});

// <!-- Edit Modal Fetch and Reset -->

// Variable to store the state
var editEmployeeState = null;

$(document).ready(function () {
    $('.editEmployeeButton').click(function () {
        // Get data from the button
        var employeeId = $(this).data('employee-id');
        var role = $(this).data('role');
        var email = $(this).data('email');
        var password = $(this).data('password');
        var firstName = $(this).data('first-name');
        var middleName = $(this).data('middle-name');
        var lastName = $(this).data('last-name');
        var suffix = $(this).data('suffix');
        var age = $(this).data('age');
        var sex = $(this).data('sex');
        var civilStatus = $(this).data('civil-status');
        var department = $(this).data('department');
        var jobPosition = $(this).data('job-position');
        var dateStarted = $(this).data('date-started');

        // Set form field values
        $('#floatingEditOldEmployeeId').val(employeeId);
        $('#floatingEditEmployeeId').val(employeeId);
        $('#floatingEditSelectRole').val(role);
        $('#floatingEditEmail').val(email);
        $('#floatingEditPassword').val(password);
        $('#floatingEditFirstName').val(firstName);
        $('#floatingEditMiddleName').val(middleName);
        $('#floatingEditLastName').val(lastName);
        $('#floatingEditSuffix').val(suffix);
        $('#floatingEditAge').val(age);
        $('#floatingEditSex').val(sex);
        $('#floatingEditCivilStatus').val(civilStatus);
        $('#floatingEditDepartmentSelect').val(department);
        $('#floatingEditJobPosition').val(jobPosition);
        $('#floatingEditDateStarted').val(dateStarted);

        // Save the state
        editEmployeeState = {
            employeeId: employeeId,
            role: role,
            email: email,
            password: password,
            firstName: firstName,
            middleName: middleName,
            lastName: lastName,
            suffix: suffix,
            age: age,
            sex: sex,
            civilStatus: civilStatus,
            department: department,
            jobPosition: jobPosition,
            dateStarted: dateStarted
        };
    });

    // Function to set data based on the saved state
    function setDataFromState() {
        if (editEmployeeState) {
            // Set form field values based on the saved state
            $('#floatingEditOldEmployeeId').val(editEmployeeState.employeeId);
            $('#floatingEditEmployeeId').val(editEmployeeState.employeeId);
            $('#floatingEditSelectRole').val(editEmployeeState.role);
            $('#floatingEditEmail').val(editEmployeeState.email);
            $('#floatingEditPassword').val(editEmployeeState.password);
            $('#floatingEditFirstName').val(editEmployeeState.firstName);
            $('#floatingEditMiddleName').val(editEmployeeState.middleName);
            $('#floatingEditLastName').val(editEmployeeState.lastName);
            $('#floatingEditSuffix').val(editEmployeeState.suffix);
            $('#floatingEditAge').val(editEmployeeState.age);
            $('#floatingEditSex').val(editEmployeeState.sex);
            $('#floatingEditCivilStatus').val(editEmployeeState.civilStatus);
            $('#floatingEditDepartmentSelect').val(editEmployeeState.department);
            $('#floatingEditJobPosition').val(editEmployeeState.jobPosition);
            $('#floatingEditDateStarted').val(editEmployeeState.dateStarted);
        }
    }

    // Add click event handler for the Reset button
    $('#resetEditEmployeeInputs').click(function () {
        // Reset form fields to their initial values
        setDataFromState();
    });
});