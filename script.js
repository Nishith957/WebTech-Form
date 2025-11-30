
$(function () {
    $('#appForm').on('submit', function (e) {
      
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

        $('#submitBtn').prop('disabled', true).text('Submitting...');
    });

    $('input, textarea, select').on('input change', function () {
        $('#formMessage').removeClass().text('');
        $('#submitBtn').prop('disabled', false).text('Submit Application');
    });
});

