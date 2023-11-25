
// Fungsi untuk melakukan pengiriman AJAX
function loginadmin() {
    var formData = {
        username: $('#username').val(),
        password: $('#password').val()
    };
      console.log(formData);
    $.ajax({
        type: 'POST',
        url: 'config/login_proses.php',
        data: formData,
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                window.location.href = 'index.php';
            } else {
                alert('Login gagal. ' + response.message);
            }
        },
        error: function (error) {
            console.log(error);
            alert('Kesalahan pada username atau password');
        }
    });
}
