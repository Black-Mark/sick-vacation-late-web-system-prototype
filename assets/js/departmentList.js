// Edit Modal Fetch and Reset
// Variable to store the state
var editDepartmentState = null;

$(document).ready(function () {
    $('.editDepartmentButton').click(function () {
        // Get data from the button
        var departmentId = $(this).data('department-id');
        var departmentName = $(this).data('department-name');
        var departmentHead = $(this).data('department-head');
        var departmentDescription = $(this).data('department-description');

        // Set form field values
        $('#floatingEditDepartmentId').val(departmentId);
        $('#floatingEditDepartmentName').val(departmentName);
        $('#floatingEditDepartmentHead').val(departmentHead);
        $('#floatingEditDepartmentDescription').val(departmentDescription);

        // Save the state
        editDepartmentState = {
            departmentId: departmentId,
            departmentName: departmentName,
            departmentHead: departmentHead,
            departmentDescription: departmentDescription,
        };
    });

    // Function to set data based on the saved state
    function setDataFromState() {
        if (editDepartmentState) {
            // Set form field values based on the saved state
            $('#floatingEditDepartmentId').val(editDepartmentState.departmentId);
            $('#floatingEditDepartmentName').val(editDepartmentState.departmentName);
            $('#floatingEditDepartmentHead').val(editDepartmentState.departmentHead);
            $('#floatingEditDepartmentDescription').val(editDepartmentState.departmentDescription);
        }
    }

    // Add click event handler for the Reset button
    $('#resetEditDepartmentInputs').click(function () {
        // Reset form fields to their initial values
        setDataFromState();
    });
});

// Delete Modal Fetch and Reset
// Variable to store the state
var deleteDepartmentState = null;

$(document).ready(function () {
    $('.deleteDepartmentButton').click(function () {
        // Get data from the button
        var deptId = $(this).data('dept-id');
        var deptName = $(this).data('dept-name');
        var deptHead = $(this).data('dept-head');
        var deptCount = $(this).data('dept-count');
        var deptDescription = $(this).data('dept-description');

        // Set form field values
        $('#floatingDeleteDeptId').val(deptId);
        $('#floatingDeleteDeptHead').val(deptHead);
        $('#floatingDeleteDeptDescription').val(deptDescription);

        // Set text for span elements
        $('#floatingDeleteDeptName').text(deptName);
        $('#floatingDeleteDeptCount').text(deptCount);

        // Save the state
        deleteDepartmentState = {
            deptId: deptId,
            deptName: deptName,
            deptHead: deptHead,
            deptCount: deptCount,
            deptDescription: deptDescription,
        };

        // Disable the selected department in the dropdown
        resetDropdown();
        disableSelectedDepartment();
    });

    // Function to disable the selected department in the dropdown
    function disableSelectedDepartment() {
        if (deleteDepartmentState) {
            var departmentAssigned = document.getElementById("floatingDepartmentReassigned");

            // Loop through the options in the select element
            for (var i = 0; i < departmentAssigned.options.length; i++) {
                if (departmentAssigned.options[i].value == deleteDepartmentState.deptId) {
                    departmentAssigned.options[i].disabled = true;
                    break;
                }
            }
        }
    }

    // Function to reset the dropdown
    function resetDropdown() {
        var departmentAssigned = document.getElementById("floatingDepartmentReassigned");

        // Loop through the options in the select element
        for (var i = 0; i < departmentAssigned.options.length; i++) {
            departmentAssigned.options[i].disabled = false;
        }
    }

    // Add event handler for modal close
    $('#deleteDepartment').on('hidden.bs.modal', function () {
        resetDropdown();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    var actionSet = document.getElementById("floatingActionSet");
    var departmentReassigned = document.getElementById("departmentAssigned");
    var departmentAssigned = document.getElementById("floatingDepartmentReassigned");

    // Function to toggle visibility and requirement of reason input based on status
    function toggleDeleteActionSet() {
        var selectedAction = actionSet.value;
        if (selectedAction == "Reassign") {
            departmentReassigned.style.display = "block";
            departmentAssigned.setAttribute("required", "required");
        } else {
            departmentReassigned.style.display = "none";
            departmentAssigned.removeAttribute("required");
        }
    }

    // Initial call to set initial state
    toggleDeleteActionSet();

    // Event listener for status change
    actionSet.addEventListener("change", toggleDeleteActionSet);
});
