

$('#simpanrkap').validate({
    rules: {
        r_aset: {
            required: true
        },
        r_liabilitas: {
            required: true
        },
        r_ekuitas: {
            required: true
        },
        r_pu: {
            required: true
        },
        r_ebitda: {
            required: true
        },
        r_bo: {
            required: true
        },
        r_lbtb: {
            required: true
        },
        r_lbep: {
            required: true
        },
        r_capex: {
            required: true
        },
        r_pajak: {
            required: true
        },
        r_sdm: {
            required: true
        }
    },
    submitHandler: function(form) {
        var typesubmit = $("input[type=submit][clicked=true]").val();
        var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
        $(processing_div).find(".ui-dialog-titlebar").css('display', 'none');
        $(form).ajaxSubmit({
            type: 'post',
            url: '/laporan/submitsimpanrkap',
            data: {
                source: typesubmit
            },
            dataType: 'json',
            beforeSubmit: function() {
                $(processing_div).dialog('open');
            },
            success: function(data) {
                $('#modaladdrkapusulan').modal('hide');
                $(processing_div).dialog('close').remove();
                swal(data.title, data.msg, data.flag);

                if (data.flag == 'success') {
                    tablerkapusulan.fnStandingRedraw();
                }

            },
            error: function(jqXHR, exception) {
                var msgerror = '';
                if (jqXHR.status === 0) {
                    msgerror = 'jaringan tidak terkoneksi.';
                } else if (jqXHR.status == 404) {
                    msgerror = 'Halamam tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msgerror = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msgerror = 'Requested JSON parse gagal.';
                } else if (exception === 'timeout') {
                    msgerror = 'RTO.';
                } else if (exception === 'abort') {
                    msgerror = 'Gagal request ajax.';
                } else {
                    msgerror = 'Error.\n' + jqXHR.responseText;
                }

                $('#modaladdrkapusulan').modal('hide');
                $(processing_div).dialog('close').remove();
                swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');

            }
        });
        return false;
    }
});



$('#simpanprognosa').validate({
    rules: {
        p_aset: {
            required: true
        },
        p_liabilitas: {
            required: true
        },
        p_ekuitas: {
            required: true
        },
        p_pu: {
            required: true
        },
        p_ebitda: {
            required: true
        },
        p_bo: {
            required: true
        },
        p_lbtb: {
            required: true
        },
        p_lbep: {
            required: true
        },
        p_capex: {
            required: true
        },
        p_pajak: {
            required: true
        },
        p_sdm: {
            required: true
        }
    },
    submitHandler: function(form) {
        var typesubmit = $("input[type=submit][clicked=true]").val();
        var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
        $(processing_div).find(".ui-dialog-titlebar").css('display', 'none');
        $(form).ajaxSubmit({
            type: 'post',
            url: '/laporan/submitsimpanprognosa',
            data: {
                source: typesubmit
            },
            dataType: 'json',
            beforeSubmit: function() {
                $(processing_div).dialog('open');
            },
            success: function(data) {
                $('#modaladdprognosa').modal('hide');
                $(processing_div).dialog('close').remove();
                swal(data.title, data.msg, data.flag);

                if (data.flag == 'success') {
                    tableprognosa.fnStandingRedraw();
                }

            },
            error: function(jqXHR, exception) {
                var msgerror = '';
                if (jqXHR.status === 0) {
                    msgerror = 'jaringan tidak terkoneksi.';
                } else if (jqXHR.status == 404) {
                    msgerror = 'Halamam tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msgerror = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msgerror = 'Requested JSON parse gagal.';
                } else if (exception === 'timeout') {
                    msgerror = 'RTO.';
                } else if (exception === 'abort') {
                    msgerror = 'Gagal request ajax.';
                } else {
                    msgerror = 'Error.\n' + jqXHR.responseText;
                }

                $('#modaladdprognosa').modal('hide');
                $(processing_div).dialog('close').remove();
                swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');

            }
        });
        return false;
    }
});


$('#simpankpku').validate({
    rules: {
        kpku_1: {
            required: true
        },
        kpku_2: {
            required: true
        },
        kpku_3: {
            required: true
        },
        kpku_4: {
            required: true
        },
        kpku_5: {
            required: true
        },
        kpku_6: {
            required: true
        },
        kpku_7: {
            required: true
        },
        tahunbumn: {
            required: true
        },
        file_pendukung: {
            required: true
        },
        kpkubumn: {
            required: true
        }
    },
    submitHandler: function(form) {
        var typesubmit = $("input[type=submit][clicked=true]").val();
        var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
        $(processing_div).find(".ui-dialog-titlebar").css('display', 'none');
        $(form).ajaxSubmit({
            type: 'post',
            url: '/kinerja/submitkpku',
            data: {
                source: typesubmit
            },
            dataType: 'json',
            beforeSubmit: function() {
                $(processing_div).dialog('open');
            },
            success: function(data) {
                $('#modaladdkpku').modal('hide');
                $('#modaladdkpku').on('hidden.bs.modal', function () {
                    $(this).find("input,textarea,select,file").val('').end();

                });
                $(processing_div).dialog('close').remove();
                swal(data.title, data.msg, data.flag);

                if (data.flag == 'success') {
                    tablekpku.fnStandingRedraw();
                }

            },
            error: function(jqXHR, exception) {
                var msgerror = '';
                if (jqXHR.status === 0) {
                    msgerror = 'jaringan tidak terkoneksi.';
                } else if (jqXHR.status == 404) {
                    msgerror = 'Halamam tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msgerror = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msgerror = 'Requested JSON parse gagal.';
                } else if (exception === 'timeout') {
                    msgerror = 'RTO.';
                } else if (exception === 'abort') {
                    msgerror = 'Gagal request ajax.';
                } else {
                    msgerror = 'Error.\n' + jqXHR.responseText;
                }

                $('#modaladdkpku').modal('hide');
                $(processing_div).dialog('close').remove();
                swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');

            }
        });
        return false;
    }
});

$('#simpanlkpn').validate({
    rules: {
        tahunbumn: {
            required: true
        },
        lkpnbumn: {
            required: true
        },
        periodebumn: {
            required: true
        }
    },
    submitHandler: function(form) {
        var typesubmit = $("input[type=submit][clicked=true]").val();
        var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
        $(processing_div).find(".ui-dialog-titlebar").css('display', 'none');
        $(form).ajaxSubmit({
            type: 'post',
            url: '/testlkpn/submitview',
            data: {
                source: typesubmit
            },
            dataType: 'json',
            beforeSubmit: function() {
                $(processing_div).dialog('open');
            },
            success: function(data) {
                $('#modaladdlkpn').modal('hide');
                $('#modaladdlkpn').on('hidden.bs.modal', function () {
                    $(this).find("input,textarea,select,file").val('').end();

                });
                $(processing_div).dialog('close').remove();
                swal(data.title, data.msg, data.flag);

                if (data.flag == 'success') {
                    tablelkpn.fnStandingRedraw();
                }

            },
            error: function(jqXHR, exception) {
                var msgerror = '';
                if (jqXHR.status === 0) {
                    msgerror = 'jaringan tidak terkoneksi.';
                } else if (jqXHR.status == 404) {
                    msgerror = 'Halamam tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msgerror = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msgerror = 'Requested JSON parse gagal.';
                } else if (exception === 'timeout') {
                    msgerror = 'RTO.';
                } else if (exception === 'abort') {
                    msgerror = 'Gagal request ajax.';
                } else {
                    msgerror = 'Error.\n' + jqXHR.responseText;
                }

                $('#modaladdlkpn').modal('hide');
                $(processing_div).dialog('close').remove();
                swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');

            }
        });
        return false;
    }
});

/**
 * Untuk Delete data Keuangan RKAP Usulan
 * @param  {[type]} id_pemiliksaham [description]
 * @return {[type]}                 [description]
 */
function ondeletekeurksap(id_keurkap) {
    swal({
        title: "Pesan Konfirmasi ?",
        text: "Yakin hapus data ? ",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Hapus data",
        cancelButtonText: "Tidak",
        closeOnConfirm: false
    },
    function() {
    	var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
    	$(processing_div).find(".ui-dialog-titlebar").css('display', 'none');
        $.ajax({
            url: '/laporan/deleterkapusulan',
            data: {
                id_keurkap: id_keurkap
            },
            type: 'post',
            dataType: 'json',
            beforeSend: function() {
                $(processing_div).dialog('open');
            },
            success: function(data) {
                $(processing_div).dialog('close').remove();
                swal(data.title, data.msg, data.flag);

                if (data.flag == 'success') {
                    tablerkapusulan.fnStandingRedraw();
                }
            },
            error: function(jqXHR, exception) {
                var msgerror = '';
                if (jqXHR.status === 0) {
                    msgerror = 'jaringan tidak terkoneksi.';
                } else if (jqXHR.status == 404) {
                    msgerror = 'Halamam tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msgerror = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msgerror = 'Requested JSON parse gagal.';
                } else if (exception === 'timeout') {
                    msgerror = 'RTO.';
                } else if (exception === 'abort') {
                    msgerror = 'Gagal request ajax.';
                } else {
                    msgerror = 'Error.\n' + jqXHR.responseText;
                }
                $(processing_div).dialog('close').remove();
                swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');
            }
        });
    });
}




/**
 * Untuk Delete data Keuangan RKAP Usulan
 * @param  {[type]} id_pemiliksaham [description]
 * @return {[type]}                 [description]
 */
function ondeletekeuprog(id_keuprog) {
    swal({
        title: "Pesan Konfirmasi ?",
        text: "Yakin hapus data ? ",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Hapus data",
        cancelButtonText: "Tidak",
        closeOnConfirm: false
    },
    function() {
    	var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
    	$(processing_div).find(".ui-dialog-titlebar").css('display', 'none');
        $.ajax({
            url: '/laporan/deleteprog',
            data: {
                id_keuprog: id_keuprog
            },
            type: 'post',
            dataType: 'json',
            beforeSend: function() {
                $(processing_div).dialog('open');
            },
            success: function(data) {
                $(processing_div).dialog('close').remove();
                swal(data.title, data.msg, data.flag);

                if (data.flag == 'success') {
                    tableprognosa.fnStandingRedraw();
                }
            },
            error: function(jqXHR, exception) {
                var msgerror = '';
                if (jqXHR.status === 0) {
                    msgerror = 'jaringan tidak terkoneksi.';
                } else if (jqXHR.status == 404) {
                    msgerror = 'Halamam tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msgerror = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msgerror = 'Requested JSON parse gagal.';
                } else if (exception === 'timeout') {
                    msgerror = 'RTO.';
                } else if (exception === 'abort') {
                    msgerror = 'Gagal request ajax.';
                } else {
                    msgerror = 'Error.\n' + jqXHR.responseText;
                }
                $(processing_div).dialog('close').remove();
                swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');
            }
        });
    });
}


/**
 * Untuk Delete data Laporan Kinerja KPKU
 * @param  {[type]} id_pemiliksaham [description]
 * @return {[type]}                 [description]
 */
function ondeletekpku(id_kpku) {
    swal({
        title: "Pesan Konfirmasi ?",
        text: "Yakin hapus data ? ",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Hapus data",
        cancelButtonText: "Tidak",
        closeOnConfirm: false
    },
    function() {
        var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
        $(processing_div).find(".ui-dialog-titlebar").css('display', 'none');
        $.ajax({
            url: '/kinerja/deleterkinerjakpku',
            data: {
                id_kpku: id_kpku
            },
            type: 'post',
            dataType: 'json',
            beforeSend: function() {
                $(processing_div).dialog('open');
            },
            success: function(data) {
                $(processing_div).dialog('close').remove();
                swal(data.title, data.msg, data.flag);

                if (data.flag == 'success') {
                    tablekpku.fnStandingRedraw();
                }
            },
            error: function(jqXHR, exception) {
                var msgerror = '';
                if (jqXHR.status === 0) {
                    msgerror = 'jaringan tidak terkoneksi.';
                } else if (jqXHR.status == 404) {
                    msgerror = 'Halamam tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msgerror = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msgerror = 'Requested JSON parse gagal.';
                } else if (exception === 'timeout') {
                    msgerror = 'RTO.';
                } else if (exception === 'abort') {
                    msgerror = 'Gagal request ajax.';
                } else {
                    msgerror = 'Error.\n' + jqXHR.responseText;
                }
                $(processing_div).dialog('close').remove();
                swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');
            }
        });
    });
}


/**
 * Untuk Verifikasi Sukses data Laporan Kinerja KPKU
 * @param  {[type]} id_pemiliksaham [description]
 * @return {[type]}                 [description]
 */
function onsukseskpku(id_kpku) {
    swal({
        title: "Pesan Konfirmasi ?",
        text: "Verifikasi data ? ",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Verifikasi data",
        cancelButtonText: "Tidak",
        closeOnConfirm: false
    },
    function() {
        var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
        $(processing_div).find(".ui-dialog-titlebar").css('display', 'none');
        $.ajax({
            url: '/kinerja/sukseskinerjakpku',
            data: {
                id_kpku: id_kpku
            },
            type: 'post',
            dataType: 'json',
            beforeSend: function() {
                $(processing_div).dialog('open');
            },
            success: function(data) {
                $(processing_div).dialog('close').remove();
                swal(data.title, data.msg, data.flag);

                if (data.flag == 'success') {
                    tablekpku.fnStandingRedraw();
                }
            },
            error: function(jqXHR, exception) {
                var msgerror = '';
                if (jqXHR.status === 0) {
                    msgerror = 'jaringan tidak terkoneksi.';
                } else if (jqXHR.status == 404) {
                    msgerror = 'Halamam tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msgerror = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msgerror = 'Requested JSON parse gagal.';
                } else if (exception === 'timeout') {
                    msgerror = 'RTO.';
                } else if (exception === 'abort') {
                    msgerror = 'Gagal request ajax.';
                } else {
                    msgerror = 'Error.\n' + jqXHR.responseText;
                }
                $(processing_div).dialog('close').remove();
                swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');
            }
        });
    });
}


function onbatalkpku(id_kpku)
{
    //$('#modalbatalkpku').modal('show');

    var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
    $.ajax({
        type: 'post',
        url: '/kinerja/getkpkubyid',
        data: {
            id_kpku: id_kpku
        },
        dataType: 'json',
        beforeSubmit: function() {
            $(processing_div).dialog('open');
        },
        success: function(data) {
            $(processing_div).dialog('close').remove();
            $('#modalbatalkpku').modal('show');

            $('#bumnkpkuid').val(data.id);
        },
        error: function(jqXHR, exception) {
            var msgerror = '';
            if (jqXHR.status === 0) {
                msgerror = 'jaringan tidak terkoneksi.';
            } else if (jqXHR.status == 404) {
                msgerror = 'Halaman tidak ditemukan. [404]';
            } else if (jqXHR.status == 500) {
                msgerror = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msgerror = 'Requested JSON parse gagal.';
            } else if (exception === 'timeout') {
                msgerror = 'RTO.';
            } else if (exception === 'abort') {
                msgerror = 'Gagal request ajax.';
            } else {
                msgerror = 'Error.\n' + jqXHR.responseText;
            }
            $(processing_div).dialog('close').remove();
            swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');
        }
    });
}


$('#simpaninvalidkpku').validate({
    rules: {
        invalidkpku: {
            required: true
        },
        bumnkpkuid: {
            required: true
        }
    },
    submitHandler: function(form) {
        var typesubmit = $("input[type=submit][clicked=true]").val();
        var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
        $(processing_div).find(".ui-dialog-titlebar").css('display', 'none');
        $(form).ajaxSubmit({
            type: 'post',
            url: '/kinerja/invalidkpku',
            data: {
                source: typesubmit
            },
            dataType: 'json',
            beforeSubmit: function() {
                $(processing_div).dialog('open');
            },
            success: function(data) {
                $('#modalbatalkpku').modal('hide');
                $('#modalbatalkpku').on('hidden.bs.modal', function () {
                    $(this).find("input,textarea,select").val('').end();

                });
                $(processing_div).dialog('close').remove();
                swal(data.title, data.msg, data.flag);

                if (data.flag == 'success') {
                    tablekpku.fnStandingRedraw();
                }

            },
            error: function(jqXHR, exception) {
                var msgerror = '';
                if (jqXHR.status === 0) {
                    msgerror = 'jaringan tidak terkoneksi.';
                } else if (jqXHR.status == 404) {
                    msgerror = 'Halamam tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msgerror = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msgerror = 'Requested JSON parse gagal.';
                } else if (exception === 'timeout') {
                    msgerror = 'RTO.';
                } else if (exception === 'abort') {
                    msgerror = 'Gagal request ajax.';
                } else {
                    msgerror = 'Error.\n' + jqXHR.responseText;
                }

                $('#modalbatalkpku').modal('hide');
                $(processing_div).dialog('close').remove();
                swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');

            }
        });
        return false;
    }
});


function oneditkpku(id_kpku)
{

    var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
    $.ajax({
        type: 'post',
        url: '/kinerja/getkpkubyid',
        data: {
            id_kpku: id_kpku
        },
        dataType: 'json',
        beforeSubmit: function() {
            $(processing_div).dialog('open');
        },
        success: function(data) {
            $(processing_div).dialog('close').remove();
            $('#modaleditkpku').modal('show');

            $('#editkpkuid').val(data.id);
            $('#editkpku_1').val(data.kpku_1);
            $('#editkpku_2').val(data.kpku_2);
            $('#editkpku_3').val(data.kpku_3);
            $('#editkpku_4').val(data.kpku_4);
            $('#editkpku_5').val(data.kpku_5);
            $('#editkpku_6').val(data.kpku_6);
            $('#editkpku_7').val(data.kpku_7);
            $('#edittahunbumn').val(data.tahun);
            $('#editkpkubumn').val(data.bumn_id);
        },
        error: function(jqXHR, exception) {
            var msgerror = '';
            if (jqXHR.status === 0) {
                msgerror = 'jaringan tidak terkoneksi.';
            } else if (jqXHR.status == 404) {
                msgerror = 'Halaman tidak ditemukan. [404]';
            } else if (jqXHR.status == 500) {
                msgerror = 'Internal Server Error [500].';
            } else if (exception === 'parsererror') {
                msgerror = 'Requested JSON parse gagal.';
            } else if (exception === 'timeout') {
                msgerror = 'RTO.';
            } else if (exception === 'abort') {
                msgerror = 'Gagal request ajax.';
            } else {
                msgerror = 'Error.\n' + jqXHR.responseText;
            }
            $(processing_div).dialog('close').remove();
            swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');
        }
    });
}


$('#simpaneditkpku').validate({
    rules: {
        kpku_1: {
            required: true
        },
        kpku_2: {
            required: true
        },
        kpku_3: {
            required: true
        },
        kpku_4: {
            required: true
        },
        kpku_5: {
            required: true
        },
        kpku_6: {
            required: true
        },
        kpku_7: {
            required: true
        },
        tahunbumn: {
            required: true
        },
        file_pendukung: {
            required: false
        },
        kpkubumn: {
            required: true
        },
        editkpkuid: {
            required: false
        }
    },
    submitHandler: function(form) {
        var typesubmit = $("input[type=submit][clicked=true]").val();
        var processing_div = $('<div></div>').html('<p>Sedang Proses. Mohon untuk ditunggu sesaat.</p>').dialog({autoOpen: false, modal: true, bgiframe: true, title: 'Processing...', dialogClass: 'alert'});
        $(processing_div).find(".ui-dialog-titlebar").css('display', 'none');
        $(form).ajaxSubmit({
            type: 'post',
            url: '/kinerja/submiteditkpku',
            data: {
                source: typesubmit
            },
            dataType: 'json',
            beforeSubmit: function() {
                $(processing_div).dialog('open');
            },
            success: function(data) {
                $('#modaleditkpku').modal('hide');
                $('#modaleditkpku').on('hidden.bs.modal', function () {
                    $(this).find("input,textarea,select,file").val('').end();

                });
                $(processing_div).dialog('close').remove();
                swal(data.title, data.msg, data.flag);

                if (data.flag == 'success') {
                    tablekpku.fnStandingRedraw();
                }

            },
            error: function(jqXHR, exception) {
                var msgerror = '';
                if (jqXHR.status === 0) {
                    msgerror = 'jaringan tidak terkoneksi.';
                } else if (jqXHR.status == 404) {
                    msgerror = 'Halamam tidak ditemukan. [404]';
                } else if (jqXHR.status == 500) {
                    msgerror = 'Internal Server Error [500].';
                } else if (exception === 'parsererror') {
                    msgerror = 'Requested JSON parse gagal.';
                } else if (exception === 'timeout') {
                    msgerror = 'RTO.';
                } else if (exception === 'abort') {
                    msgerror = 'Gagal request ajax.';
                } else {
                    msgerror = 'Error.\n' + jqXHR.responseText;
                }

                $('#modaleditkpku').modal('hide');
                $(processing_div).dialog('close').remove();
                swal("Error System", msgerror + ', coba ulangi kembali !!!', 'error');

            }
        });
        return false;
    }
});