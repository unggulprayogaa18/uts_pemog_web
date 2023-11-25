function submitForm() {
    var formData = $('#pasienForm').serialize();

    $.ajax({
        type: 'POST',
        url: 'config/create.php',
        data: formData,
        success: function (response) {
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                untukindex();
            } else {
                console.error('Koneksi Gagal:', response.message);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}


function untukindex() {
    $('#tabelforindex').empty();
    $.ajax({
        type: 'GET',
        url: 'config/get_data.php',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Koneksi Berhasil:', response.message);
                updateTableIndex(response.data_pasien);
            } else {
                console.error('Koneksi Gagal:', response.message);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function updateTableIndex(dataPasien) {
    var rowsPerPage = 10; // Jumlah baris per halaman
    var totalPages = Math.ceil(dataPasien.length / rowsPerPage);
    $('#pagination').twbsPagination({
        totalPages: totalPages,
        visiblePages: totalPages > 10 ? 10 : totalPages,
        onPageClick: function (event, page) {
            displayDataByPageIndex(page, dataPasien, rowsPerPage);
        }
    });
    displayDataByPageIndex(1, dataPasien, rowsPerPage);
}

function displayDataByPageIndex(page, dataPasien, rowsPerPage) {
    $('#tabelforindex').empty();
    var startIndex = (page - 1) * rowsPerPage;
    var endIndex = startIndex + rowsPerPage;
    for (var i = startIndex; i < endIndex && i < dataPasien.length; i++) {
        var pasien = dataPasien[i];
        var row = '<tr>' +
            '<td>' + pasien.idpasien + '</td>' +
            '<td>' + pasien.nama + '</td>' +
            '<td>' + pasien.jenis_kelamin + '</td>' +
            '<td>' + pasien.ciri_ciri + '</td>' +
            '<td>' + pasien.status_pasien + '</td>' +
            '<td>' + pasien.id_kamar + '</td>' +
            '<td>' +
            '<button class="btn btn-info btn-sm" onclick="editData(' + pasien.idpasien + ')" id="tombol_edit_' + pasien.idpasien + '">Edit</button> ' +
            '<button class="btn btn-success btn-sm" onclick="simpanData(' + pasien.idpasien + ')" id="tombol_simpan_' + pasien.idpasien + '" style="display: none;">Simpan</button>' +
            '<button class="btn btn-danger btn-sm" onclick="deleteData(' + pasien.idpasien + ')"  >Delete</button>' +
            '</td>' +
            '</tr>';
        $('#tabelforindex').append(row);
    }
}


function editData(idPasien) {
    $('[id^=tombol_simpan_]').css('display', 'none');
    $('[id^=tombol_edit_]').css('display', 'inline-block');
    $.ajax({
        type: 'POST',
        url: 'config/edit.php',
        data: {
            idpasien: idPasien
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $('#nama').val(response.data_pasien.nama);
                $('#jenis_kelamin').val(response.data_pasien.jenis_kelamin);
                $('#ciri_ciri').val(response.data_pasien.ciri_ciri);
                $('#status_pasien').val(response.data_pasien.status_pasien);
                $('#id_kamar').val(response.data_pasien.id_kamar);
                alert("Anda yakin ingin mengubah id : " + idPasien);
                $('#tombol_edit_' + idPasien).hide();
                $('#tombol_simpan_' + idPasien).css('display', 'inline-block');
                $('#daftarkan').css('display', 'none');
                $('#tombol_simpan_' + idPasien).attr('data-id', idPasien);
                $('#pasienForm').show();

            } else {
                alert('Gagal mengambil data pasien: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            alert('Terjadi kesalahan: ' + error);
        }
    });
}


function refreshdata(idPasien) {
    $('#tombol_simpan_' + idPasien).css('display', 'none');
    $('#daftarkan').css('display', 'inline-block');


}

function simpanData(idPasien) {
    var nama = $('#nama').val();
    var jenis_kelamin = $('#jenis_kelamin').val();
    var ciri_ciri = $('#ciri_ciri').val();
    var status_pasien = $('#status_pasien').val();
    var id_kamar = $('#id_kamar').val();

    $.ajax({
        type: 'GET',
        url: 'config/edit.php',
        data: {
            idpasien: idPasien,
            nama: nama,
            jenis_kelamin: jenis_kelamin,
            ciri_ciri: ciri_ciri,
            status_pasien: status_pasien,
            id_kamar: id_kamar
        },
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                console.log('Perubahan berhasil disimpan:', response.message);
                alert('Perubahan berhasil disimpan!');
                untukindex();
                refreshdata();
                batalin();
            } else {
                console.error('Gagal menyimpan perubahan:', response.message);
                alert('Gagal menyimpan perubahan!');
            }
        },
        error: function (xhr, status, error) {
            console.error('Terjadi kesalahan:', error);
            alert('Terjadi kesalahan saat menyimpan perubahan!');
        }
    });
}


function batalin() {
    var formData = $('#pasienForm').serialize();
    document.getElementById('pasienForm').reset();
}


function deleteData(idPasien) {
    var confirmation = confirm('Apakah Anda yakin ingin menghapus data dengan ID Pasien ' + idPasien + '?');

    if (confirmation) {
        $.ajax({
            type: 'GET',
            url: 'config/delete.php', // Change this to the appropriate URL for your delete operation
            data: {
                idpasien: idPasien
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    console.log('Perubahan berhasil dihapus:', response.message);
                    alert('Perubahan berhasil dihapus!');
                    untukindex();
                } else {
                    console.error('Gagal  dihapus:', response.message);
                    alert('Gagal  dihapus!');
                }
            },
            error: function (xhr, status, error) {
                console.error('Terjadi kesalahan:', error);
                alert('Terjadi kesalahan saat menghapus data!');
            }
        });
    }
}





$('#searchInput').on('input', function () {
    var keyword = $(this).val();
    pencarianaaa(keyword);
});


function pencarianaaa(keyword) {
    $('#tabelforindex').empty();
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
                updateTableIndex(response.data_pasien);
            } else {
                console.error('Pencarian Gagal:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('Terjadi kesalahan:', error);
        }
    });
}



function logout() {
    $.ajax({
        type: 'POST',
        url: 'config/loggout.php',
        dataType: 'json',   
        success: function (response) {
            if (response.status === 'success') {
               
                window.location.href = 'home.php';
                alert( response.message);
            } else {
                alert('Logout failed. ' + response.message);
            }
        },
        error: function (error) {
            console.log(error);
            alert('An error occurred during the logout process.');
        }
    });
}
untukindex();