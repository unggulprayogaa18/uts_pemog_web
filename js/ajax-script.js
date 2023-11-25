function untukhome() {
    $('#tabeluntukdetail').empty();

    $.ajax({
        type: 'GET',
        url: 'config/get_data.php',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                updateTableHome(response.data_pasien);
            } else {
                console.error('Koneksi Gagal:', response.message);
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}

function updateTableHome(data_pasien) {
    var rowsPerPage = 10;
    var totalPages = Math.ceil(data_pasien.length / rowsPerPage);

    $('#pagination09').twbsPagination({
        totalPages: totalPages,
        visiblePages: totalPages > 10 ? 10 : totalPages,
        onPageClick: function (event, page) {
            displayDataByPagehome(page, data_pasien, rowsPerPage);
        }
    });
    displayDataByPagehome(1, data_pasien, rowsPerPage);
}

function displayDataByPagehome(page, data_pasien, rowsPerPage) {
    $('#tabeluntukdetail').empty();

    var startIndex = (page - 1) * rowsPerPage;
    var endIndex = startIndex + rowsPerPage;

    for (var i = startIndex; i < endIndex && i < data_pasien.length; i++) {
        var pasien = data_pasien[i];
        var row = '<tr>' +
            '<td>' + pasien.nama + '</td>' +
            '<td>' + pasien.jenis_kelamin + '</td>' +
            '<td>' + pasien.ciri_ciri + '</td>' +
            '<td>' + pasien.status_pasien + '</td>' +
            '<td>' + pasien.id_kamar + '</td>' +
            '</tr>';
        $('#tabeluntukdetail').append(row);
    }
}

$('#searchInputdetail').on('input', function () {
    var keyword = $(this).val();
    pencarian(keyword);

});

function pencarian(keyword) {
    $('#tabeluntukdetail').empty();
    $.ajax({
        type: 'GET',
        url: 'config/search.php',
        data: {
            keyword: keyword
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Pencarian Berhasil:', response.message);
                updateTableHome(response.data_pasien);
            } else {
                console.error('Pencarian Gagal:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Terjadi kesalahan:', error);
        }
    });
}




untukhome();