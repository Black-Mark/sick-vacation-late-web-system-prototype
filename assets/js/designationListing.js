$(document).ready(function () {
    // Use event delegation to handle click events on dynamically created elements
    $('#designations').on('click', '.editDesignationButton', function () {
        // Get data from the button
        var designationId = $(this).data('designation-id');
        var designationName = $(this).data('designation-name');
        var designationDescription = $(this).data('designation-description');

        // Set form field values
        $('#floatingEditDesignationId').val(designationId);
        $('#floatingEditDesignationName').val(designationName);
        $('#floatingEditDesignationDescription').val(designationDescription);

        // Save the state
        editDesignationState = {
            designationId: designationId,
            designationName: designationName,
            designationDescription: designationDescription,
        };
    });

    $('#designations').on('click', '.deleteDesignationButton', function () {
        // Get data from the button
        var designationId = $(this).data('designation-id');
        var designationName = $(this).data('designation-name');
        var designationCount = $(this).data('designation-count');

        // Set form field values
        $('#floatingDeleteDesignationId').val(designationId);
        $('#floatingDeleteDesignationName').text(designationName);
        $('#floatingDeleteDesignationCount').text(designationCount);
    });

    // Function to set data based on the saved state
    function setDataFromState() {
        if (editDesignationState) {
            // Set form field values based on the saved state
            $('#floatingEditDesignationId').val(editDesignationState.designationId);
            $('#floatingEditDesignationName').val(editDesignationState.designationName);
            $('#floatingEditDesignationDescription').val(editDesignationState.designationDescription);

        }
    }

    // Add click event handler for the Reset button
    $('#resetEditDesignationInputs').click(function () {
        // Reset form fields to their initial values
        setDataFromState();
    });
});