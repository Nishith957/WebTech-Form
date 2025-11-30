// Client-side small validation and nicer UX using jQuery
$(function () {
    $('#appForm').on('submit', function (e) {
        // simple client-side checks
        const fn = $('#firstname').val().trim();
        const ln = $('#lastname').val().trim();
        const email = $('#email').val().trim();

        if (!fn || !ln) {
            e.preventDefault();
            $('#formMessage').removeClass().addClass('error').text('First and last name are required.');
            return;
        }
        if (!email) {
            e.preventDefault();
            $('#formMessage').removeClass().addClass('error').text('Email is required.');
            return;
        }

        // allow form to submit to process.php (server-side will validate too)
        $('#submitBtn').prop('disabled', true).text('Submitting...');
        // If user has JS disabled, the form still posts — server handles validation
    });

    // Clear message when user edits
    $('input, textarea, select').on('input change', function () {
        $('#formMessage').removeClass().text('');
        $('#submitBtn').prop('disabled', false).text('Submit Application');
    });
});
