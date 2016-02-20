$(document).ready(function(){

	
	$.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings ){
	  return {
	    "iStart":         oSettings._iDisplayStart,
	    "iEnd":           oSettings.fnDisplayEnd(),
	    "iLength":        oSettings._iDisplayLength,
	    "iTotal":         oSettings.fnRecordsTotal(),
	    "iFilteredTotal": oSettings.fnRecordsDisplay(),
	    "iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
	    "iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
	  };
	};

	$.fn.dataTableExt.oApi.fnStandingRedraw = function(oSettings) {
	  if(oSettings.oFeatures.bServerSide === false){
	      var before = oSettings._iDisplayStart;
	      oSettings.oApi._fnReDraw(oSettings);
	      oSettings._iDisplayStart = before;
	      oSettings.oApi._fnCalculateEnd(oSettings);
	  }
	  oSettings.oApi._fnDraw(oSettings);
	};

	tablelogpelaporan = $('#tablelogpelaporan').dataTable({
	    "sDom": '<"toolbar">rt<"clear"><"pesanpesan">tip',
	    "bJQueryUI": false,
	    "iDisplayLength": 10,
	    "bAutoWidth": false,       
	    "bProcessing": true,
	    "bServerSide": true,
	    "bScrollCollapse": true,
	    "sServerMethod" : "POST",
	    "sAjaxSource": "/view/jsontablelogpelaporanbumn",
	    "fnServerParams": function (aoData) {
                aoData.push(
                             {name: "bumnsearch", value: $("#bumnsearch").val()},
                             {name: "periodesearch", value: $("#periodesearch").val()},
                             {name: "statussearch", value: $("#statussearch").val()}
                )
        },
	    "sPaginationType": "full_numbers",
	    "aoColumns": [
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false}
	        ],
	    "bFilter": true,
	    "fnInitComplete": function() {
                    var panjang = $("#tablelogpelaporan").width();    
                    $("#tablelogpelaporan").css("width",panjang);
                    $("#div1").width(panjang);
        }
	});

	$("#bumnsearch").change( function () {
        tablelogpelaporan.fnFilter( this.value, "bumnsearch");
    });

    $("#periodesearch").change( function () {
        tablelogpelaporan.fnFilter( this.value, "periodesearch");
    });

    $("#statussearch").change( function () {
        tablelogpelaporan.fnFilter( this.value, "statussearch");
    });



    /**
	 *  Untuk Datatable View Kurs Manager
	 */

	tablerkapusulan = $('#tablerkapusulan').dataTable({
	    "sDom": '<"toolbar">rt<"clear"><"pesanpesan">tip',
	    "bJQueryUI": false,
	    "iDisplayLength": 10,
	    "bAutoWidth": false,       
	    "bProcessing": true,
	    "bServerSide": true,
	    "bScrollCollapse": true,
	    "sServerMethod" : "POST",
	    "sAjaxSource": "/laporan/jsontablerkapusulan",
	    "sPaginationType": "full_numbers",
	    "aoColumns": [
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false}
	        ],
	    "bFilter": true
	});

	
	/**
	 *  Untuk Datatable View Kurs Manager
	 */

	tableprognosa = $('#tableprognosa').dataTable({
	    "sDom": '<"toolbar">rt<"clear"><"pesanpesan">tip',
	    "bJQueryUI": false,
	    "iDisplayLength": 10,
	    "bAutoWidth": false,       
	    "bProcessing": true,
	    "bServerSide": true,
	    "bScrollCollapse": true,
	    "sServerMethod" : "POST",
	    "sAjaxSource": "/laporan/jsontableprognosa",
	    "sPaginationType": "full_numbers",
	    "aoColumns": [
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false}
	        ],
	    "bFilter": true
	});


	/**
	 *  Untuk Datatable View Kinerja KPKU
	 */

	tablekpku = $('#tablekpku').dataTable({
	    "sDom": '<"toolbar">rt<"clear"><"pesanpesan">tip',
	    "bJQueryUI": false,
	    "iDisplayLength": 10,
	    "bAutoWidth": false,       
	    "bProcessing": true,
	    "bServerSide": true,
	    "bScrollCollapse": true,
	    "sServerMethod" : "POST",
	    "sAjaxSource": "/kinerja/jsontablekpku",
	    "fnServerParams": function (aoData) {
                aoData.push(
                             {name: "kpkubumnsearch", value: $("#kpkubumnsearch").val()},
                             {name: "kpkutahunsearch", value: $("#kpkutahunsearch").val()}
                )
        },
	    "sPaginationType": "full_numbers",
	    "aoColumns": [
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false}
	        ],
	    "bFilter": true
	});

	$("#kpkubumnsearch").change( function () {
        tablekpku.fnFilter( this.value, "kpkubumnsearch");
    });

    $("#kpkutahunsearch").change( function () {
        tablekpku.fnFilter( this.value, "kpkutahunsearch");
    });


	$("#r_aset").keyup(function(){
        var penetapan = $("#r_aset").val().replace(/\./ig , "");
        $("#r_aset").val(penetapan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
    });

	/**
	 *  Untuk Datatable View LKPN Test
	 */

	tablelkpn = $('#tablelkpn').dataTable({
	    "sDom": '<"toolbar">rt<"clear"><"pesanpesan">tip',
	    "bJQueryUI": false,
	    "iDisplayLength": 10,
	    "bAutoWidth": false,       
	    "bProcessing": true,
	    "bServerSide": true,
	    "bScrollCollapse": true,
	    "sServerMethod" : "POST",
	    "sAjaxSource": "/testlkpn/jsontablelkpn",
	    "fnServerParams": function (aoData) {
                aoData.push(
                             {name: "bumnsearch", value: $("#bumnsearch").val()},
                             {name: "tahunsearch", value: $("#tahunsearch").val()}
                             {name: "periodesearch", value: $("#periodesearch").val()}
                )
        },
	    "sPaginationType": "full_numbers",
	    "aoColumns": [
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false}
	        ],
	    "bFilter": true
	});

	$("#bumnsearch").change( function () {
        tablelkpn.fnFilter( this.value, "bumnsearch");
    });

    $("#tahunsearch").change( function () {
        tablelkpn.fnFilter( this.value, "tahunsearch");
    });

    $("#periodesearch").change( function () {
        tablelkpn.fnFilter( this.value, "periodesearch");
    });


    /**
	 *  Untuk Datatable View Anak Perusahaan
	 */

	tableanakperush = $('#tableanakperush').dataTable({
	    "sDom": '<"toolbar">rt<"clear"><"pesanpesan">tip',
	    "bJQueryUI": false,
	    "iDisplayLength": 10,
	    "bAutoWidth": false,       
	    "bProcessing": true,
	    "bServerSide": true,
	    "bScrollCollapse": true,
	    "sServerMethod" : "POST",
	    "sAjaxSource": "/view/jsontableanakperush",
	    "fnServerParams": function (aoData) {
                aoData.push(
                             {name: "anakbumnsearch", value: $("#anakbumnsearch").val()},
                             {name: "jenisanakbumnsearch", value: $("#jenisanakbumnsearch").val()}
                )
        },
	    "sPaginationType": "full_numbers",
	    "aoColumns": [
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false},
	            { "bSortable": false}
	        ],
	    "bFilter": true
	});

	$("#anakbumnsearch").change( function () {
        tableanakperush.fnFilter( this.value, "anakbumnsearch");
    });

    $("#jenisanakbumnsearch").change( function () {
        tableanakperush.fnFilter( this.value, "jenisanakbumnsearch");
    });


    function onviewfile(file){
	    var dialoginternal_pdf_box = $(dialoginternal_pdf).clone();
	    $(dialoginternal_pdf_box).css('visibility', 'visible');
	                                  
	    $(dialoginternal_pdf_box).dialog({
	        autoOpen: true,
	        modal: true, 
	        height:500,
	        width: 800,
	        title: 'Laporan PDF',
	        resizable: false,     
	        close: function (event, ui) {
	                $(this).remove();
	        }
	    });
	    
	    var urlpage = '/generated/showpdf/file/'+file;
	    
	    
	    $("#pdfObjectinternal").attr({
	        data: urlpage,
			type: 'application/pdf'
	    });
	}
    
});