<?php
	require_once 'BaseController.php';
	require_once 'sektorModel.php';
	require_once 'bumnModel.php';
	require_once 'laporanBumnModel.php';
	require_once 'akunBumnModel.php';
	require_once 'outputPdfModel.php';
    require_once 'akunGlobalModel.php';
    require_once 'proyeksinergiModel.php';


/**
* 
*/
class TestlkpnController extends BaseController
{
	public function indexAction() {

        $lanjut = $this->getRequest()->getPost('lanjut');
        $this->view->lanjut = $lanjut;
        $this->view->jid = $this->jenis_lap_id;
        $opt = $this->getRequest()->getPost('opt');
        $this->view->opt = $opt;
        $kurs = $this->getRequest()->getPost('kurs');
        $this->view->kurs = $kurs;



        $bumnModel = new bumnModel($this->bumn_id, $this->tahun, $this->periode_id);
        $sektorModel = new sektorModel($this->sektor_id);
        $deputiModel = new deputiModel($this->deputi_id, $this->periode_id, $this->tahun);
        $laporanModel = new laporanBumnModel($this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id);
        $kursmanagerModel = new kursmanagerModel();


        $akunGlobalModel = new akunGlobalModel($this->jenis_lap_id, $this->tahun, $this->periode_id);
        //$laps = array(601 => 'Posisi Keuangan', 602 => 'Laba (Rugi)', 701 => 'Data Ringkasan');
        $laps = array(301 => 'Posisi Keuangan', 302 => 'Laba (Rugi)', 303 => 'Arus Kas');



        if (!$lanjut) {
            //$this->view->tahuns = Globals::getTahuns();
            $this->view->tahuns = array('2012' => 2012,'2013' => 2013,'2014' => 2014,'2015' => 2015, '2016' => 2016);
            $this->view->tahun = $this->tahun;

            $this->view->opts = array('semua' => 'Semua BUMN', 'sektoral' => 'Sektoral','struktural' => 'Struktural', 'tbk' => 'Semua BUMN Tbk', 'mino' => 'BUMN Minoritas');

            if ($opt == 'sektoral') {
                $this->view->sektors = $sektorModel->listSektors($this->SEKTORS);
                $this->view->sektor = $this->sektor_id;
            } else if ($opt == 'struktural') {
                $this->view->deputis = $deputiModel->listDeputis($this->DEPUTIS);
                $this->view->deputi = $this->deputi_id;

                //var_dump($this->ASDEPS);die();
                $this->view->asdeps = $deputiModel->deputiHasListAsdep($this->ASDEPS);
                $this->view->asdep = $this->asdep_id;
            }

            $user = $_SESSION['USERS_HAS_FIS']['EIS_ACCOUNT'];

            $this->view->userfis = $user;

            $select_periodes = array(6,10,1,2,3,5);
            $periodes = array();
            foreach ($akunGlobalModel->listPeriodes() as $periode_id => $periode_nama) {
                if (!in_array($periode_id, $select_periodes)) {
                    continue;
                }
                $periodes[$periode_id] = $periode_nama;
            }
            $this->view->periodes = $periodes;

            //$this->view->periodes = $akunGlobalModel->listPeriodes();
            $this->view->periode = $this->periode_id;

            //$this->view->jenis_laps = array(601 => 'Posisi keuangan', 602 => 'Laba (Rugi)', 701 => 'Data Ringkasan');
            //$this->view->jenis_laps = array(601 => 'Posisi keuangan', 602 => 'Laba (Rugi)', 701 => 'Data Ringkasan');
            $this->view->jenis_laps = array(301 => 'Posisi keuangan', 302 => 'Laba (Rugi)', 303 => 'Arus Kas');
            $this->view->jenis_lap = 301;
            $this->view->kurss=$kursmanagerModel->listkurs();
            $this->view->kurs = $kurs;
        } else {

            $user = $_SESSION['USERS_HAS_FIS']['EIS_ACCOUNT'];

            $this->view->info = $this->view->notifikasi ( 'Untuk PT Garuda Indonesia Dan PT Perusahaan Gas Negara, konversi Rupiah menggunakan nilai Tengah Kurs Transaksi Rp.11969 Masa  berlaku 30 Juni 2014', 'info' );

            if ($opt == 'sektoral') {
                $sektorModel = new sektorModel($this->sektor_id);
                $sektor_data = $sektorModel->sektorHasProfiles();

                $this->view->title_per = ', Sektor ' . $sektor_data['nama'];
            } else if ($opt == 'struktural') {


                $asdepModel = new asdepModel($this->asdep_id, $this->periode_id, $this->tahun);
                $asdep_data = $asdepModel->asdepHasProfiles();
                //echo 'test';die();
                $this->view->title_per = ', ' . $asdep_data['nama'];
            } else {
                $this->view->title_per = ' Semua BUMN';
            }

            $this->view->userfis = $user;
            $this->view->jid = $this->jenis_lap_id;
            $this->view->lap_nama = $laps[$this->jenis_lap_id];
            $this->view->tahun = $this->tahun;
            $this->view->periode = $this->periode_id;
            $this->view->kurss=$kursmanagerModel->listkurs();
            $this->view->kurs = $kurs;
        }
    }

    public function generateexcellkpnAction(){
        error_reporting(E_ALL);

        $this->_helper->viewRenderer->setNoRender(true);
        $this->view->layout()->disableLayout();



        //start isi
        $opt = $this->getRequest()->getParam('opt');


        //echo $opt;die();
        $type = $this->getRequest()->getParam('type');

        $sektorModel = new sektorModel($this->sektor_id);
        $bumnModel = new bumnModel($this->bumn_id, $this->tahun, $this->periode_id);
        $asdepModel = new asdepModel($this->asdep_id, $this->periode_id, $this->tahun);
        $akunGlobalModel = new akunGlobalModel($this->jenis_lap_id, $this->tahun, $this->periode_id);
        $laporanBumnModel = new laporanBumnModel($this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id);

        $list_sektor = $sektorModel->listSektors($this->SEKTORS);

         if ($opt == 'semua') {
            $bumnModel->bumn_id = $this->BUMNS;
            $bumns = $bumnModel->listBumns();
        } else if ($opt == 'sektoral') {
            $bumns = $sektorModel->sektorHasBumns($this->BUMNS, $this->tahun, $this->periode_id);
        } else if ($opt == 'struktural') {
            $bumns = $asdepModel->asdepHasBumns2($this->BUMNS);
        }

        //var_dump($bumns);die();

        foreach($bumns as $bumn_id => $bumn_nama)
            {
                $tot = array();
                $rs = $akunGlobalModel->akunGlobalHasTrxGlobalLkpn($bumn_id);
                $ls = $laporanBumnModel->statuspemasukandatalkpnneraca($this->jenis_lap_id,$bumn_id,$this->periode_id);

                /*while(!$ls->EOF){
                    $test = $ls->fields['status_pelaporan_id'];
                    $ls->MoveNext();
                }*/
                foreach ($ls as $status) {
                    $bumn_ids = $status['bumn_id'];
                    $laporan = $status['jenis_lap_id'];
                    $status_id = $status['status_pelaporan_id'];
                    $update = $status['tanggal'];
                    $users_login = $status['users_login'];
                    $statuspelaporan[$bumn_id][$laporan] = $status_id;
                    $statuspelaporanupdate[$bumn_id][$laporan] = $update;
                    $statuspelaporanby[$bumn_id][$laporan] = $users_login;
                }


                //var_dump($ls);
                while(!$rs->EOF){
                    $kode = $rs->fields['kode'];
                    $jumlah =($rs->fields['jumlah'])?$rs->fields['jumlah']:0;
                    $tot[$kode] = $jumlah;
                    $rs->MoveNext();
                }

                $data = array();
                if($this->jenis_lap_id == 601)
                {

                    if($bumn_ids == $bumn_id){
                            switch ($status_id) {
                                case 20:
                                    $hasils = 'UNVERIFIED';
                                    break;
                                case 40:
                                    $hasils = 'VERIFIED';
                                    break;
                                case 5:
                                    $hasils = 'INVALID';
                                    break;
                            }

                        $data['Status'] = $hasils;
                    } else {
                        $data['Status'] = 'UNFILLED';;
                    }


                    if ($this->periode_id == 5 || $this->periode_id == 6){
                        #tingkat Kesehatan
                        $sehat = $tot['05'];

                        switch ($sehat) {
                            case 0:
                                $hasil = "Tidak Ada Data";
                                break;
                            case 1:
                                $hasil = "Sehat AAA";
                                break;
                            case 2:
                                $hasil = "Sehat AA";
                                break;
                            case 3:
                                $hasil = "Sehat A";
                                break;
                            case 4:
                                $hasil = "Kurang Sehat BBB";
                                break;
                            case 5:
                                $hasil = "Kurang Sehat BB";
                                break;
                            case 6:
                                $hasil = "Kurang Sehat B";
                                break;
                            case 7:
                                $hasil = "Tidak Sehat CCC";
                                break;
                            case 8:
                                $hasil = "Tidak Sehat CC";
                                break;
                            case 9:
                                $hasil = "TIdak Sehat C";
                                break;
                            case 10:
                                $hasil = "Tercapai";
                                break;
                            case 11:
                                $hasil = "Tidak Tercapai";
                                break;
                            case 12:
                                $hasil = "NA";
                                break;
                        }

                        $data['Tingkat Kesehatan'] = $hasil;
                    }



                    //$data['Tingkat Kesehatan'] = $hasil;

                    #Aktiva Lancar
                    $data['Aset Lancar'] = $tot['0101'];
                    #Aktiva Tidak Lancar
                    $data['Aset Tidak Lancar'] = $tot['0102'];
                    #Aktiva Tidak Lancar
                    //$data['Aset Lainnya'] = $tot['0103'];
                    #Total Aktiva
                    $data['Total Aset'] = $tot['01'];
                    #Kewajiban Jangka Pendek
                    $data['Liabilitas Jangka Pendek'] = $tot['0201'];
                    #Kewajiban Jangka Panjang
                    $data['Liabilitas Jangka Panjang'] = $tot['0202'];
                    #Total Kewajiban
                    $data['Total Liabilitas'] = $tot['02'];
                    #Modal Saham
                    $data['Modal Saham'] = $tot['030101'];
                    #Tambahan Modal Disetor
                    $data['Tambahan Modal Disetor'] = $tot['030102'];
                    #BYPDS
                    $data['BPYBDS'] = $tot['030103'];
                    #Ekuitas Lainnya
                    $data['Ekuitas Lainnya'] = $tot['030104'];
                    #Laba Ditahan
                    $data['Saldo Laba'] = $tot['030105'];

                    $data['Ekuitas Yang Diatribusikan Kepada Pemilik Entitas Induk'] = $tot['0301'];

                    $data['Kepentingan Non Pengendali'] = $tot['0302'];
                    #Total Ekuitas
                    $data['Jumlah Ekuitas'] = $tot['03'];

                    $bumnModel->bumn_id = $bumn_id;
                    $tot_kepemilikan = $bumnModel->bumnHasPemilikPemerintah();
                    #Saham Negara (%)
                    $data['(%) Saham Negara'] = $tot['06']*100;
                    #Kepemilikan Negara (%)
                    $data['Kepemilikan Negara'] =$tot['04'];
                }elseif ($this->jenis_lap_id == 602) {

                    if($bumn_ids == $bumn_id){
                            switch ($status_id) {
                                case 20:
                                    $hasils = 'UNVERIFIED';
                                    break;
                                case 40:
                                    $hasils = 'VERIFIED';
                                    break;
                                case 5:
                                    $hasils = 'INVALID';
                                    break;
                            }

                        $data['Status'] = $hasils;
                    } else {
                        $data['Status'] = 'UNFILLED';;
                    }

                    #Pendapatan Usaha
                    $data['Pendapatan Usaha'] = $tot['01'];
                    #Beban Usaha
                    $data['HPP'] = $tot['02'];
                    #Pendapatan Kotor
                    $data['Laba Kotor (Gross Margin)'] = $tot['03'];
                    #Pendapatan Lain-lain
                    $data['Beban Usaha'] = $tot['04'];
                    #Beban Lain-lain
                    $data['Laba Usaha'] = $tot['05'];
                    #Laba(Rugi) Sebelum PKLB
                    $data['Pendapatan Lain-Lain'] = $tot['06'];

                    $data['Beban Lain-Lain'] = $tot['07'];
                    #PKLB
                    $data['EBIT'] = $tot['08'];
                    #Laba(Rugi) Sebelum Pajak
                    $data['Beban Bunga'] = $tot['09'];
                    #Pajak Penghasilan
                    $data['Laba Sebelum Pajak'] = $tot['10'];
                    #Laba(Rugi) Bersih
                    $data['Pajak'] = $tot['11'];
                    $data['Laba (Rugi) Tahun Berjalan'] = $tot['12'];
                    $data['Pendapatan (Beban) Komprehensif'] = $tot['13'];
                    $data['Laba (Rugi) Komprehensif'] = $tot['14'];
                    $data['Laba (Rugi) Tahun Berjalan Yang Diatribusikan Ke Entitas Induk'] = $tot['15'];
                    $data['Laba (Rugi) Komprehensif Yang Diatribusikan Ke Entitas Induk'] = $tot['16'];
                }else
                {

                    if($bumn_ids == $bumn_id){
                            switch ($status_id) {
                                case 20:
                                    $hasils = 'UNVERIFIED';
                                    break;
                                case 40:
                                    $hasils = 'VERIFIED';
                                    break;
                                case 5:
                                    $hasils = 'INVALID';
                                    break;
                            }

                        $data['Status'] = $hasils;
                    } else {
                        $data['Status'] = 'UNFILLED';;
                    }

                    #Pendapatan

                    $data['IIa. Smt I 2013'] = $tot['0104'];

                    $data['Ia. RKAP 2014'] = $tot['0101'];

                    $data['IIIa. Real s.d Smt I 2014'] = $tot['0102'];

                    $data['IVa. Perkiraan s.d akhir Tahun'] = $tot['0103'];

                    #Laba Bersih Tahun Berjalan
                    $data['IIb. Smt I 2013'] = $tot['0204'];

                    $data['Ib RKAP 2014'] = $tot['0201'];

                    $data['IIIb. Real s.d Smt I 2014'] = $tot['0202'];

                    $data['IVb. Perkiraan s.d akhir Tahun'] = $tot['0203'];

                    #Total Aset
                    $data['IIb. Smt I 2013'] = $tot['0204'];

                    $data['Ic. RKAP 2014'] = $tot['0301'];

                    $data['IIIc. Real s.d Smt I 2014'] = $tot['0302'];

                    $data['IVc. Perkiraan s.d akhir Tahun'] = $tot['0303'];

                    #Total Ekuitas
                    $data['IId. Smt I 2013'] = $tot['0404'];

                    $data['Id. RKAP 2014'] = $tot['0401'];

                    $data['IIId. Real s.d Smt I 2014'] = $tot['0402'];

                    $data['IVd. Perkiraan s.d akhir Tahun'] = $tot['0403'];

                    #Capex
                    $data['IIe. Smt I 2013'] = $tot['0504'];

                    $data['Ie. RKAP 2014'] = $tot['0501'];

                    $data['IIe. Real s.d Smt I 2014'] = $tot['0502'];

                    $data['IIIe. Perkiraan s.d akhir Tahun'] = $tot['0503'];

                    #Opex
                    $data['IIf. Smt I 2013'] = $tot['0604'];

                    $data['If. RKAP 2014'] = $tot['0601'];

                    $data['IIf. Real s.d Smt I 2014'] = $tot['0602'];

                    $data['IIIf. Perkiraan s.d akhir Tahun'] = $tot['0603'];

                    #Pajak
                    $data['Ig. Real s.d Smt I 2013'] = $tot['0702'];

                    $data['IIg. Real s.d Smt I 2014'] = $tot['0701'];


                }

                $lkpp_bumns[$bumn_nama] = $data;

            }
        //end isi

        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Kementerian BUMN")
                                     ->setLastModifiedBy("Kementerian BUMN")
                                     ->setTitle("Office 2007 XLSX Test Document")
                                     ->setSubject("Office 2007 XLSX Test Document")
                                     ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                     ->setKeywords("office 2007 openxml php")
                                     ->setCategory("Laporan LKPN");

        $columnID = 'B';
        foreach($data as $data_nama => $data_jumlah) {
           $objPHPExcel->getActiveSheet()->setCellValue($columnID.'3', $data_nama);
           $columnID++;
        }

        $row=4;
        foreach ($lkpp_bumns as $bumn_nama => $bumn_data) {
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $bumn_nama);
            $row++;
            $col='B';


            foreach ($bumn_data as $title => $jumlah) {


                if($jumlah == NULL || $jumlah == ''){
                    $hasils = 0;
                } else {
                    $hasils = $jumlah;
                }
                if (is_string($hasils)) {
                        $string = ereg_replace("[^0-9]", "", $hasils);
                    if (ctype_digit($string)) {
                        $hasil = $this->_helper->formatAngka($string, 1, 1);
                    } else {
                        $hasil = $hasils;
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($col.($row-1),$hasils);
                } else {
                    $hasil = $this->_helper->formatAngka($hasils, 1, 1);
                    $objPHPExcel->getActiveSheet()->setCellValue($col.($row-1),$hasils);
                }

                $tot_all[$title] +=$jumlah;
                $col++;
            }
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,'Grand Total');

            $coll = 'B';

            foreach ($tot_all as $jumlah) {
                $objPHPExcel->getActiveSheet()->setCellValue($coll.$row,$jumlah);
                $coll++;
            }

        }
        $row++;


        for($col = 'A'; $col !== 'BB'; $col++) {
            $objPHPExcel->getActiveSheet()
                ->getColumnDimension($col)
                ->setAutoSize(true);
        }

        $objPHPExcel->getActiveSheet()
        ->getStyle('B3:Z3')
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objPHPExcel->getActiveSheet()
        ->getStyle('C1:S160')
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

        $objPHPExcel->getActiveSheet()->getStyle('C1:S160')->getNumberFormat()->setFormatCode('0#,#');

        //footer


        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getActiveSheet()->setTitle('A1');

        // Redirect output to a client’s web browser (Excel2007)

        if($this->periode_id == 5){
            $namapeiod = 'unaudited';
        } elseif($this->periode_id == 6){
            $namapeiod = 'audited';
        } else {
            $namapeiod = 'semester I';
        }

        if($this->jenis_lap_id == 601){
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fis_lkpn_neraca_'.$this->tahun.'_'.$namapeiod.'.xlsx"');
            header('Cache-Control: max-age=0');
        } else {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="fis_lkpn_labarugi_'.$this->tahun.'_'.$namapeiod.'.xlsx"');
            header('Cache-Control: max-age=0');
        }

        /*header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="fis_lkpn_neraca.xlsx"');
        header('Cache-Control: max-age=0');*/

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
    }

    public function generatedatalkpnAction() {
        $this->clearSentHeader();

        $opt = $this->getRequest()->getParam('opt');

        $jid = $this->getRequest()->getParam('jid');

        $sektorModel = new sektorModel($this->sektor_id);
        $bumnModel = new bumnModel($this->bumn_id, $this->tahun, $this->periode_id);
        $asdepModel = new asdepModel($this->asdep_id, $this->periode_id, $this->tahun);
        $akunGlobalModel = new akunGlobalModel($this->jenis_lap_id, $this->tahun, $this->periode_id);
        $laporanBumnModel = new laporanBumnModel($this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id);

        $list_sektor = $sektorModel->listSektors($this->SEKTORS);


        if ($opt == 'semua') {
            $bumnModel->bumn_id = $this->BUMNS;
            $bumns = $bumnModel->listBumnsNonMino();
        } else if ($opt == 'sektoral') {
            $bumns = $sektorModel->sektorHasBumnsholding($this->BUMNS, $this->tahun, $this->periode_id);
        } else if ($opt == 'struktural') {
            $bumns = $asdepModel->asdepHasBumnsholding($this->BUMNS);
        } else if ($opt == 'tbk'){
            $bumnModel->bumn_id = $this->BUMNS;
            $bumns = $bumnModel->listBumnsTbk();
        } else if ($opt == 'mino'){
            $bumnModel->bumn_id = $this->BUMNS;
            $bumns = $bumnModel->listBumnsMino();
        }

        foreach($bumns as $bumn_id => $bumn_nama){

            $akunGlobalModel->deleteAkunGlobalHasTrxGlobaBumn($bumn_id);
            
            $akunGlobalModel->updateTrxGlobalBumn3($bumn_id);
            
            $akunGlobalModel->sumIndukTrxGlobalBumn($bumn_id,$this->sektor_id);
        }

        //echo 'ok';

        //echo '<script type="text/javascript">return window.self.location = \'/view/rekaplkpn/lanjut/1\';</script>';

        $div2= '<div class="alert alert-warning alert-dismissible" role="alert">';
        $div2 .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        $div2 .='<div class="bd"><b>Update Data LKPN selesai dilakukan</b></div>';
        $div2 .='</div>';
        echo $div2;

        //return window.self.location = \'/view/rekaplkpn/lanjut/1\';
    }

    public function generaterekaplkpnAction() {
        $this->clearSentHeader();

        //echo 'test';die();
        $opt = $this->getRequest()->getParam('opt');

        $type = $this->getRequest()->getParam('type');

        $kurss = $this->getRequest()->getParam('kurs');

        //echo $kurss;

        $sektorModel = new sektorModel($this->sektor_id);
        $bumnModel = new bumnModel($this->bumn_id, $this->tahun, $this->periode_id);
        $asdepModel = new asdepModel($this->asdep_id, $this->periode_id, $this->tahun);
        $akunGlobalModel = new akunGlobalModel($this->jenis_lap_id, $this->tahun, $this->periode_id);
        $laporanBumnModel = new laporanBumnModel($this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id);

        $list_sektor = $sektorModel->listSektors($this->SEKTORS);


         if ($opt == 'semua') {
            $bumnModel->bumn_id = $this->BUMNS;
            $bumns = $bumnModel->listBumnsNonMino();
        } else if ($opt == 'sektoral') {
            $bumns = $sektorModel->sektorHasBumnsholding($this->BUMNS, $this->tahun, $this->periode_id);
        } else if ($opt == 'struktural') {
            $bumns = $asdepModel->asdepHasBumnsholding($this->BUMNS);
        } else if ($opt == 'tbk'){
            $bumnModel->bumn_id = $this->BUMNS;
            $bumns = $bumnModel->listBumnsTbk();
        } else if ($opt == 'mino'){
            $bumnModel->bumn_id = $this->BUMNS;
            $bumns = $bumnModel->listBumnsMino();
        }

        foreach($bumns as $bumn_id => $bumn_nama)
            {
                $tot = array();

                /*$akunGlobalModel->deleteAkunGlobalHasTrxGlobaBumn($bumn_id);
            
                $akunGlobalModel->updateTrxGlobalBumn3($bumn_id);
            
                $akunGlobalModel->sumIndukTrxGlobalBumn($bumn_id,$this->sektor_id);*/
                

                $rs = $akunGlobalModel->akunGlobalHasTrxGlobalRekapLkpn($bumn_id);
                $tot_kepemilikan = $bumnModel->bumnHasPemilikPemerintah($bumn_id);
                $sehat = $bumnModel->getbumnsehats($bumn_id);


                

                //var_dump($sehat);die();

                $ls = $laporanBumnModel->statuspemasukandatalkpnneraca($this->jenis_lap_id,$bumn_id,$this->periode_id);

                /*while(!$ls->EOF){
                    $test = $ls->fields['status_pelaporan_id'];
                    $ls->MoveNext();
                }*/
                foreach ($ls as $status) {
                    $bumn_ids = $status['bumn_id'];
                    $laporan = $status['jenis_lap_id'];
                    $status_id = $status['status_pelaporan_id'];
                    $update = $status['tanggal'];
                    $users_login = $status['users_login'];
                    $statuspelaporan[$bumn_id][$laporan] = $status_id;
                    $statuspelaporanupdate[$bumn_id][$laporan] = $update;
                    $statuspelaporanby[$bumn_id][$laporan] = $users_login;
                }


                //var_dump($ls);
                while(!$rs->EOF){
                    $kode = $rs->fields['kode'];
                    $jumlah =($rs->fields['jumlah'])?$rs->fields['jumlah']:0;
                    $tot[$kode] = $jumlah;
                    $rs->MoveNext();
                }

                $data = array();
                if($this->jenis_lap_id == 301)
                {

                    if($bumn_ids == $bumn_id){
                            switch ($status_id) {
                                case 20:
                                    $hasils = '<font color="brown"><b>UNVERIFIED</b></font>';
                                    break;
                                case 40:
                                    $hasils = '<font color="green"><b>VERIFIED</b></font>';
                                    break;
                                case 5:
                                    $hasils = '<font color="red"><b>INVALID</b></font>';
                                    break;
                                case 10:
                                    $hasils = '<font color="brown"><b>INPROGRES</b></font>';
                                    break;
                            }

                        $data['Status'] = $hasils;
                    } else {
                        $data['Status'] = '<font color="black"><b>UNFILLED</b></font>';;
                    }



                    if($bumn_id == '2001' || $bumn_id == '2904' || $bumn_id == '3201' || $bumn_id == '3505'|| $bumn_id == '3002' || $bumn_id == '3105'){
                        $kurs = $kurss;
                    } else {
                        $kurs = 1;
                    }



                    //$data['Tingkat Kesehatan'] = $sehat;


                    #Aktiva Lancar
                    $data['Aset Lancar'] = $tot['0101'] * $kurs;
                    #Aktiva Tidak Lancar
                    $data['Aset Tidak Lancar'] = $tot['0102'] * $kurs;
                    #Total Aktiva
                    $data['Total Aset'] = $tot['01'] * $kurs;
                    #Kewajiban Jangka Pendek
                    $data['Liabilitas Jangka Pendek'] = $tot['0201'] * $kurs;
                    #Kewajiban Jangka Panjang
                    $data['Liabilitas Jangka Panjang'] = $tot['0202'] * $kurs;
                    #Total Kewajiban
                    $data['Total Liabilitas'] = $tot['02'] * $kurs;
                    #Modal Saham
                    $data['Modal Saham'] = $tot['030101'] * $kurs;
                    #Tambahan Modal Disetor
                    $data['Tambahan Modal Disetor'] = $tot['030102'] * $kurs;
                    #BYPDS
                    $data['BPYBDS'] = $tot['030103'] * $kurs;
                    #Ekuitas Lainnya
                    $data['Ekuitas Lainnya'] = ($tot['030105']+$tot['030107']+$tot['030113']+$tot['030115']+$tot['030119']+$tot['030123']+$tot['030145']+$tot['030181']) * $kurs;
                    #Laba Ditahan
                    $data['Saldo Laba'] = $tot['030104'] * $kurs;

                    $data['Ekuitas Yang Diatribusikan Kepada Pemilik Entitas Induk'] = $tot['0301'] * $kurs;

                    $data['Kepentingan Non Pengendali'] = $tot['0302'] * $kurs;
                    #Total Ekuitas
                    $data['Jumlah Ekuitas'] = $tot['03'] * $kurs;

                    $bumnModel->bumn_id = $bumn_id;


                    #Saham Negara (%)
                    $data['(%) Saham Negara'] = $tot_kepemilikan*'1000000';
                    #Kepemilikan Negara (%)
                    $data['Kepemilikan Negara'] = (($tot_kepemilikan*'1000000' * $tot['03']/1000000) * $kurs)/100;


                }elseif ($this->jenis_lap_id == 302) {

                    if($bumn_ids == $bumn_id){
                            switch ($status_id) {
                                case 20:
                                    $hasils = '<font color="brown"><b>UNVERIFIED</b></font>';
                                    break;
                                case 40:
                                    $hasils = '<font color="green"><b>VERIFIED</b></font>';
                                    break;
                                case 5:
                                    $hasils = '<font color="red"><b>INVALID</b></font>';
                                    break;
                                case 10:
                                    $hasils = '<font color="brown"><b>INPROGRES</b></font>';
                                    break;

                            }

                        $data['Status'] = $hasils;
                    } else {
                        $data['Status'] = '<font color="black"><b>UNFILLED</b></font>';;
                    }

                    if($bumn_id == '2001' || $bumn_id == '2904' || $bumn_id == '3201' || $bumn_id == '3505' || $bumn_id == '3105' || $bumn_id == '3002'){
                        $kurs = $kurss;
                    } else {
                        $kurs = 1;
                    }


                    #Pendapatan Usaha
                    $data['Pendapatan Usaha'] = $tot['01'] * $kurs;
                    #Beban Usaha

                    if($bumn_id == '0101' || $bumn_id == '0102' || $bumn_id == '0103' || $bumn_id == '0104'){
                        $hpp = abs($tot['02']);
                        $pajak = abs($tot['07']);
                        $labakotorbank = ($tot['01'] - $hpp);
                        $labarugitahunberjalan = ($tot['06'] - $pajak);
                    } else {
                        $hpp = $tot['02'];
                        $pajak = $tot['07'];
                        $labakotorbank = ($tot['01'] - $tot['02']);
                        $labarugitahunberjalan = ($tot['06'] - $pajak);
                    }

                    $data['HPP'] = $hpp * $kurs;
                    #Pendapatan Kotor
                    $data['Laba Kotor (Gross Margin)'] = $labakotorbank * $kurs;
                    #Pendapatan Lain-lain
                    $data['Beban Usaha'] = $tot['14'] * $kurs;
                    #Beban Lain-lain
                    $data['Laba Usaha'] = $tot['03'] * $kurs;
                    #Laba(Rugi) Sebelum PKLB
                    $data['Pendapatan Lain-Lain'] = $tot['04'] * $kurs;

                    $data['Beban Lain-Lain'] = $tot['05'] * $kurs;
                    #PKLB
                    $data['Laba Sebelum Pajak'] = $tot['06'] * $kurs;
                    #Laba(Rugi) Bersih
                    $data['Pajak'] = $pajak * $kurs;
                    $data['Laba Rugi Tahun Berjalan'] = $labarugitahunberjalan * $kurs;
                    $data['Pendapatan (Beban) Komprehensif'] = $tot['09'] * $kurs;
                    $data['Laba Rugi Komprehensif'] = $tot['10'] * $kurs;
                    $data['Laba (Rugi) Tahun Berjalan Yang Diatribusikan Ke Entitas Induk'] = $tot['11'] * $kurs;
                    $data['Laba (Rugi) Komprehensif Yang Diatribusikan Ke Entitas Induk'] = $tot['12'] * $kurs;
                    $data['Opex'] = (($tot['02']+$tot['14']+$tot['05'])-($tot['1408']-$tot['0501']))* $kurs;
                    $data['Ebitda'] = ($tot['17'])*$kurs;



                } elseif ($this->jenis_lap_id == 303) {

                    if($bumn_ids == $bumn_id){
                            switch ($status_id) {
                                case 20:
                                    $hasils = '<font color="brown"><b>UNVERIFIED</b></font>';
                                    break;
                                case 40:
                                    $hasils = '<font color="green"><b>VERIFIED</b></font>';
                                    break;
                                case 5:
                                    $hasils = '<font color="red"><b>INVALID</b></font>';
                                    break;
                                case 10:
                                    $hasils = '<font color="brown"><b>INPROGRES</b></font>';
                                    break;

                            }

                        $data['Status'] = $hasils;
                    } else {
                        $data['Status'] = '<font color="black"><b>UNFILLED</b></font>';;
                    }

                    if($bumn_id == '2001' || $bumn_id == '2904' || $bumn_id == '3201' || $bumn_id == '3505' || $bumn_id == '3105' || $bumn_id == '3002'){
                        $kurs = $kurss;
                    } else {
                        $kurs = 1;
                    }


                    $data['Arus Kas dari Aktivitas Operasi'] = $tot['01'] * $kurs;
                    #Pendapatan Kotor
                    $data['Arus Kas dari Aktivitas Pendanaan'] = $tot['02'] * $kurs;
                    #Pendapatan Lain-lain
                    $data['Arus Kas dari Aktivitas Investasi'] = $tot['03'] * $kurs;
                    #Beban Lain-lain
                    $data['Kenaikan Neto Kas Dan Setara Kas'] = $tot['04'] * $kurs;
                    #Laba(Rugi) Sebelum PKLB
                    $data['Dampak Perubahan Selisih Kurs'] = $tot['05'] * $kurs;

                    $data['Kas Dan Setara Kas Awal Tahun'] = $tot['06'] * $kurs;
                    #PKLB
                    $data['Kas Dan Setara Kas Akhir Tahun'] = $tot['07'] * $kurs;



                }

                $lkpp_bumns[$bumn_nama] = $data;

            }

        if ($type == 'web') {


            if ($this->jenis_lap_id == 701){
                $table .= '<table id="example" cellpadding="0" cellspacing="0" border="0" width="auto">';
                $table .= '<thead><tr>';

                $table .= '<th> </th><th colspan="4">I Pendapatan</th><th colspan="4">II Laba Bersih Tahun Berjalan</th><th colspan="4">III Total Aset</th><th colspan="4">IV Total Ekuitas</th><th colspan="4">V Capex</th><th colspan="4">VI Opex</th><th colspan="2">VII Pajak</th>';
                $table .= '</tr><tr>';
                $table .= '<th>BUMN</th>';
                foreach ($data as $data_nama => $data_jumlah) {

                    $table .= '<th>' . $data_nama . '</th>';
                }

                $table .= '</tr></thead><tbody>';

                foreach ($lkpp_bumns as $bumn_nama => $bumn_data) {
                    $table .= '<tr>';
                    $table .='<td>&nbsp;<b>' . $bumn_nama . '</b></td>';


                    foreach ($bumn_data as $title => $jumlah) {

                            if (is_string($jumlah)) {
                                $string = ereg_replace("[^0-9]", "", $jumlah);
                                if (ctype_digit($string)) {
                                    if($jumlah < 0){
                                        /*if($bumn_id == '2001' || $bumn_id == '2904' || $bumn_id == '3201' || $bumn_id == '3505'|| $bumn_id == '3002'){
                                            $jmls = ($jumlah*12440);
                                        }
                                        $table .='<td align="right">(' . $this->_helper->formatAngka($jmls, 0, 1000000) . ')</td>';*/
                                        $table .='<td align="right">(' . $this->_helper->formatAngka($jumlah, 0, 1000000) . ')</td>';
                                    } else {
                                        $table .='<td align="right">'. $this->_helper->formatAngka($jumlah, 0, 1000000) .'</td>';
                                    }
                                            //$table .='<td align="right">' . $this->_helper->formatAngka($jumlah, 0, 1) . '</td>';
                                } else {
                                    $table .='<td>' . $jumlah . '</td>';
                                }
                            } else {
                                $table .='<td align="right">' . $this->_helper->formatAngka($jumlah, 0, 1000000) . '</td>';
                            }

                        $tot_all[$title] +=$jumlah;

                    }


                    $table .='</tr>';

                }

                $table .='</tbody>';

                $table .='<tfoot><tr>';
                $table .='<td align="right" style="background-color:#F0F0F6">Grand Total</td>';


                foreach ($tot_all as $jumlah) {

                    $stringtot = ereg_replace("[^0-9]", "", $jumlah);
                    if ($jumlah == 'UNFILLED' || $jumlah == 'UNVERIFIED' || $jumlah == 'VERIFIED' || $jumlah == 'INVALID'){
                        $table .='<td style="background-color:#F0F0F6">&nbsp;</td>';
                    } else {
                        if($jumlah < 0){

                            $table .='<td style="background-color:#F0F0F6" align="right">      (' . $this->_helper->formatAngka(abs($jumlah), 0, 1) . ')</td>';
                        } else {

                            $table .='<td style="background-color:#F0F0F6" align="right">      '. $this->_helper->formatAngka($jumlah, 0, 1) .'</td>';
                            }
                    }

                }


                $table .='</tr></tfoot>';

                $table .='</table>';

                echo $table;
            } else {
                $table .= '<table table id="example" class="table table-striped table-bordered" cellpadding="0" cellspacing="0">';
                $table .= '<thead><tr>';

                $table .= '<th width="369">BUMN</th>';

                $tot_all = array();
                foreach ($data as $data_nama => $data_jumlah) {

                        $table .= '<th>' . $data_nama . '</th>';
                }
                $table .='</tr></thead><tbody>';

                $no=1;
                foreach ($lkpp_bumns as $bumn_nama => $bumn_data) {

                    $table .= '<tr>';

                    if($bumn_nama == 'PT Bank Bukopin'){
                        $table .='<td>&nbsp;<font color="red"><b>'.$no.' ' . $bumn_nama . '</b></font></td>';
                    } else {
                        $table .='<td>&nbsp;<b>'.$no.' ' . $bumn_nama . '</b></td>';
                    }

                    //$table .= '<tr>';
                    //$table .='<td class="fixed">&nbsp;<b>'.$no.' ' . $bumn_nama . '</b></td>';



                    foreach ($bumn_data as $title => $jumlah) {


                            if (is_string($jumlah)) {
                                $string = ereg_replace("[^0-9]", "", $jumlah);
                                if (ctype_digit($string)) {

                                    if($jmls < 0){
                                        $table .='<td align="right">(' . $this->_helper->formatAngka($jumlah, 0, 1000000) . ')</td>';
                                    } else {
                                        $table .='<td align="right">'. $this->_helper->formatAngka($jumlah, 0, 1000000) .'</td>';
                                    }
                                            //$table .='<td align="right">' . $this->_helper->formatAngka($jumlah, 0, 1) . '</td>';
                                } else {
                                    $table .='<td>' . $jumlah . '</td>';
                                }
                            } else {
                                $table .='<td align="right">' . $this->_helper->formatAngka($jumlah, 0, 1000000) . '</td>';
                            }

                        $tot_all[$title] +=$jumlah;

                    }

                    $no++;
                    $table .='</tr>';

                }

                $table .='</tbody>';

                $table .='<tfoot><tr>';
                $table .='<td style="background-color:#F0F0F6">Grand Total</td>';


                foreach ($tot_all as $jumlah) {

                    $stringtot = ereg_replace("[^0-9]", "", $jumlah);
                    if ($jumlah == 'UNFILLED' || $jumlah == 'UNVERIFIED' || $jumlah == 'VERIFIED' || $jumlah == 'INVALID'){
                        $table .='<td style="background-color:#F0F0F6">&nbsp;</td>';
                    } else {
                        if($jumlah < 0){

                            $table .='<td style="background-color:#F0F0F6" align="center">      (' . $this->_helper->formatAngka(abs($jumlah), 0, 1000000) . ')</td>';
                        } else {

                            $table .='<td style="background-color:#F0F0F6" align="center">      '. $this->_helper->formatAngka($jumlah, 0, 1000000) .'</td>';
                            }
                    }

                }


                $table .='</tr></tfoot>';

                $table .='</table>';

                $table .="<script>$(processing_div).dialog('close').remove();</script>";


                echo $table;
            }

        }
    }

    public function generatelkpnAction() {
        $this->clearSentHeader();
        $opt = $this->getRequest()->getParam('opt');

        $type = $this->getRequest()->getParam('type');

        $sektorModel = new sektorModel($this->sektor_id);
        $bumnModel = new bumnModel($this->bumn_id, $this->tahun, $this->periode_id);
        $asdepModel = new asdepModel($this->asdep_id, $this->periode_id, $this->tahun);
        $akunGlobalModel = new akunGlobalModel($this->jenis_lap_id, $this->tahun, $this->periode_id);
        $laporanBumnModel = new laporanBumnModel($this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id);

        $list_sektor = $sektorModel->listSektors($this->SEKTORS);

         if ($opt == 'semua') {
            $bumnModel->bumn_id = $this->BUMNS;
            $bumns = $bumnModel->listBumnsholding();
        } else if ($opt == 'sektoral') {
            $bumns = $sektorModel->sektorHasBumnsholding($this->BUMNS, $this->tahun, $this->periode_id);
        } else if ($opt == 'struktural') {
            $bumns = $asdepModel->asdepHasBumnsholding($this->BUMNS);
        } else if ($opt == 'tbk'){
            $bumnModel->bumn_id = $this->BUMNS;
            $bumns = $bumnModel->listBumnsTbk();
        }

        foreach($bumns as $bumn_id => $bumn_nama)
            {
                $tot = array();

                $rs = $akunGlobalModel->akunGlobalHasTrxGlobalLkpn($bumn_id);



                $ls = $laporanBumnModel->statuspemasukandatalkpnneraca($this->jenis_lap_id,$bumn_id,$this->periode_id);

                /*while(!$ls->EOF){
                    $test = $ls->fields['status_pelaporan_id'];
                    $ls->MoveNext();
                }*/
                foreach ($ls as $status) {
                    $bumn_ids = $status['bumn_id'];
                    $laporan = $status['jenis_lap_id'];
                    $status_id = $status['status_pelaporan_id'];
                    $update = $status['tanggal'];
                    $users_login = $status['users_login'];
                    $statuspelaporan[$bumn_id][$laporan] = $status_id;
                    $statuspelaporanupdate[$bumn_id][$laporan] = $update;
                    $statuspelaporanby[$bumn_id][$laporan] = $users_login;
                }


                //var_dump($ls);
                while(!$rs->EOF){
                    $kode = $rs->fields['kode'];
                    $jumlah =($rs->fields['jumlah'])?$rs->fields['jumlah']:0;
                    $tot[$kode] = $jumlah;
                    $rs->MoveNext();
                }

                $data = array();
                if($this->jenis_lap_id == 601)
                {

                    if($bumn_ids == $bumn_id){
                            switch ($status_id) {
                                case 20:
                                    $hasils = '<font color="brown"><b>UNVERIFIED</b></font>';
                                    break;
                                case 40:
                                    $hasils = '<font color="green"><b>VERIFIED</b></font>';
                                    break;
                                case 5:
                                    $hasils = '<font color="red"><b>INVALID</b></font>';
                                    break;
                            }

                        $data['Status'] = $hasils;
                    } else {
                        $data['Status'] = '<font color="black"><b>UNFILLED</b></font>';;
                    }


                    if ($this->periode_id == 5 || $this->periode_id == 6){
                        #tingkat Kesehatan
                        $sehat = $tot['05'];

                        switch ($sehat) {
                            case 0:
                                $hasil = "Tidak Ada Data";
                                break;
                            case 1:
                                $hasil = "Sehat AAA";
                                break;
                            case 2:
                                $hasil = "Sehat AA";
                                break;
                            case 3:
                                $hasil = "Sehat A";
                                break;
                            case 4:
                                $hasil = "Kurang Sehat BBB";
                                break;
                            case 5:
                                $hasil = "Kurang Sehat BB";
                                break;
                            case 6:
                                $hasil = "Kurang Sehat B";
                                break;
                            case 7:
                                $hasil = "Tidak Sehat CCC";
                                break;
                            case 8:
                                $hasil = "Tidak Sehat CC";
                                break;
                            case 9:
                                $hasil = "TIdak Sehat C";
                                break;
                            case 10:
                                $hasil = "Tercapai";
                                break;
                            case 11:
                                $hasil = "Tidak Tercapai";
                                break;
                            case 12:
                                $hasil = "NA";
                                break;
                        }

                        $data['Tingkat Kesehatan'] = $hasil;
                    }



                    //$data['Tingkat Kesehatan'] = $hasil;

                    if($status_id == 40 || $status_id == 5){
                        #Aktiva Lancar
                        $data['Aset Lancar'] = $tot['0101'];
                        #Aktiva Tidak Lancar
                        $data['Aset Tidak Lancar'] = $tot['0102'];
                        #Aktiva Tidak Lancar
                        //$data['Aset Lainnya'] = $tot['0103'];
                        #Total Aktiva
                        $data['Total Aset'] = $tot['01'];
                        #Kewajiban Jangka Pendek
                        $data['Liabilitas Jangka Pendek'] = $tot['0201'];
                        #Kewajiban Jangka Panjang
                        $data['Liabilitas Jangka Panjang'] = $tot['0202'];
                        #Total Kewajiban
                        $data['Total Liabilitas'] = $tot['02'];
                        #Modal Saham
                        $data['Modal Saham'] = $tot['030101'];
                        #Tambahan Modal Disetor
                        $data['Tambahan Modal Disetor'] = $tot['030102'];
                        #BYPDS
                        $data['BPYBDS'] = $tot['030103'];
                        #Ekuitas Lainnya
                        $data['Ekuitas Lainnya'] = $tot['030104'];
                        #Laba Ditahan
                        $data['Saldo Laba'] = $tot['030105'];

                        $data['Ekuitas Yang Diatribusikan Kepada Pemilik Entitas Induk'] = $tot['0301'];

                        $data['Kepentingan Non Pengendali'] = $tot['0302'];
                        #Total Ekuitas
                        $data['Jumlah Ekuitas'] = $tot['03'];

                        $bumnModel->bumn_id = $bumn_id;
                        $tot_kepemilikan = $bumnModel->bumnHasPemilikPemerintah();
                        #Saham Negara (%)
                        $data['(%) Saham Negara'] = $tot['06']*100;
                        #Kepemilikan Negara (%)
                        $data['Kepemilikan Negara'] =$tot['04'];
                    } else {
                        #Aktiva Lancar
                        $data['Aset Lancar'] = 0;
                        #Aktiva Tidak Lancar
                        $data['Aset Tidak Lancar'] = 0;
                        #Aktiva Tidak Lancar
                        //$data['Aset Lainnya'] = 0;
                        #Total Aktiva
                        $data['Total Aset'] = 0;
                        #Kewajiban Jangka Pendek
                        $data['Liabilitas Jangka Pendek'] = 0;
                        #Kewajiban Jangka Panjang
                        $data['Liabilitas Jangka Panjang'] = 0;
                        #Total Kewajiban
                        $data['Total Liabilitas'] = 0;
                        #Modal Saham
                        $data['Modal Saham'] = 0;
                        #Tambahan Modal Disetor
                        $data['Tambahan Modal Disetor'] = 0;
                        #BYPDS
                        $data['BPYBDS'] = 0;
                        #Ekuitas Lainnya
                        $data['Ekuitas Lainnya'] = 0;
                        #Laba Ditahan
                        $data['Saldo Laba'] = 0;

                        $data['Ekuitas Yang Diatribusikan Kepada Pemilik Entitas Induk'] = 0;

                        $data['Kepentingan Non Pengendali'] = 0;
                        #Total Ekuitas
                        $data['Jumlah Ekuitas'] = 0;

                        $bumnModel->bumn_id = $bumn_id;
                        $tot_kepemilikan = $bumnModel->bumnHasPemilikPemerintah();
                        #Saham Negara (%)
                        $data['(%) Saham Negara'] = 0;
                        #Kepemilikan Negara (%)
                        $data['Kepemilikan Negara'] =0;
                    }

                }elseif ($this->jenis_lap_id == 602) {

                    if($bumn_ids == $bumn_id){
                            switch ($status_id) {
                                case 20:
                                    $hasils = '<font color="brown"><b>UNVERIFIED</b></font>';
                                    break;
                                case 40:
                                    $hasils = '<font color="green"><b>VERIFIED</b></font>';
                                    break;
                                case 5:
                                    $hasils = '<font color="red"><b>INVALID</b></font>';
                                    break;
                            }

                        $data['Status'] = $hasils;
                    } else {
                        $data['Status'] = '<font color="black"><b>UNFILLED</b></font>';;
                    }

                    if($status_id == 40 || $status_id == 5){
                        #Pendapatan Usaha
                        $data['Pendapatan Usaha'] = $tot['01'];
                        #Beban Usaha
                        $data['HPP'] = $tot['02'];
                        #Pendapatan Kotor
                        $data['Laba Kotor (Gross Margin)'] = $tot['03'];
                        #Pendapatan Lain-lain
                        $data['Beban Usaha'] = $tot['04'];
                        #Beban Lain-lain
                        $data['Laba Usaha'] = $tot['05'];
                        #Laba(Rugi) Sebelum PKLB
                        $data['Pendapatan Lain-Lain'] = $tot['06'];

                        $data['Beban Lain-Lain'] = $tot['07'];
                        #PKLB
                        $data['EBIT'] = $tot['08'];
                        #Laba(Rugi) Sebelum Pajak
                        $data['Beban Bunga'] = $tot['09'];
                        #Pajak Penghasilan
                        $data['Laba Sebelum Pajak'] = $tot['10'];
                        #Laba(Rugi) Bersih
                        $data['Pajak'] = $tot['11'];
                        $data['Laba Rugi Tahun Berjalan'] = $tot['12'];
                        $data['Pendapatan (Beban) Komprehensif'] = $tot['13'];
                        $data['Laba Rugi Komprehensif'] = $tot['14'];
                        $data['Laba (Rugi) Tahun Berjalan Yang Diatribusikan Ke Entitas Induk'] = $tot['15'];
                        $data['Laba (Rugi) Komprehensif Yang Diatribusikan Ke Entitas Induk'] = $tot['16'];
                    } else {
                        #Pendapatan Usaha
                        $data['Pendapatan Usaha'] = 0;
                        #Beban Usaha
                        $data['HPP'] = 0;
                        #Pendapatan Kotor
                        $data['Laba Kotor (Gross Margin)'] = 0;
                        #Pendapatan Lain-lain
                        $data['Beban Usaha'] = 0;
                        #Beban Lain-lain
                        $data['Laba Usaha'] = 0;
                        #Laba(Rugi) Sebelum PKLB
                        $data['Pendapatan Lain-Lain'] = 0;

                        $data['Beban Lain-Lain'] = 0;
                        #PKLB
                        $data['EBIT'] = 0;
                        #Laba(Rugi) Sebelum Pajak
                        $data['Beban Bunga'] = 0;
                        #Pajak Penghasilan
                        $data['Laba Sebelum Pajak'] = 0;
                        #Laba(Rugi) Bersih
                        $data['Pajak'] = 0;
                        $data['Laba Rugi Tahun Berjalan'] = 0;
                        $data['Pendapatan (Beban) Komprehensif'] = 0;
                        $data['Laba Rugi Komprehensif'] = 0;
                        $data['Laba (Rugi) Tahun Berjalan Yang Diatribusikan Ke Entitas Induk'] = 0;
                        $data['Laba (Rugi) Komprehensif Yang Diatribusikan Ke Entitas Induk'] = 0;
                    }


                }else
                {

                    if($bumn_ids == $bumn_id){
                            switch ($status_id) {
                                case 20:
                                    $hasils = '<font color="brown"><b>UNVERIFIED</b></font>';
                                    break;
                                case 40:
                                    $hasils = '<font color="green"><b>VERIFIED</b></font>';
                                    break;
                                case 5:
                                    $hasils = '<font color="red"><b>INVALID</b></font>';
                                    break;
                            }

                        $data['Status'] = $hasils;
                    } else {
                        $data['Status'] = '<font color="black"><b>UNFILLED</b></font>';;
                    }

                    #Pendapatan

                    $data['IIa. Smt I 2013'] = $tot['0104'];

                    $data['Ia. RKAP 2014'] = $tot['0101'];

                    $data['IIIa. Real s.d Smt I 2014'] = $tot['0102'];

                    $data['IVa. Perkiraan s.d akhir Tahun'] = $tot['0103'];

                    #Laba Bersih Tahun Berjalan
                    $data['IIb. Smt I 2013'] = $tot['0204'];

                    $data['Ib RKAP 2014'] = $tot['0201'];

                    $data['IIIb. Real s.d Smt I 2014'] = $tot['0202'];

                    $data['IVb. Perkiraan s.d akhir Tahun'] = $tot['0203'];

                    #Total Aset
                    $data['IIb. Smt I 2013'] = $tot['0204'];

                    $data['Ic. RKAP 2014'] = $tot['0301'];

                    $data['IIIc. Real s.d Smt I 2014'] = $tot['0302'];

                    $data['IVc. Perkiraan s.d akhir Tahun'] = $tot['0303'];

                    #Total Ekuitas
                    $data['IId. Smt I 2013'] = $tot['0404'];

                    $data['Id. RKAP 2014'] = $tot['0401'];

                    $data['IIId. Real s.d Smt I 2014'] = $tot['0402'];

                    $data['IVd. Perkiraan s.d akhir Tahun'] = $tot['0403'];

                    #Capex
                    $data['IIe. Smt I 2013'] = $tot['0504'];

                    $data['Ie. RKAP 2014'] = $tot['0501'];

                    $data['IIe. Real s.d Smt I 2014'] = $tot['0502'];

                    $data['IIIe. Perkiraan s.d akhir Tahun'] = $tot['0503'];

                    #Opex
                    $data['IIf. Smt I 2013'] = $tot['0604'];

                    $data['If. RKAP 2014'] = $tot['0601'];

                    $data['IIf. Real s.d Smt I 2014'] = $tot['0602'];

                    $data['IIIf. Perkiraan s.d akhir Tahun'] = $tot['0603'];

                    #Pajak
                    $data['Ig. Real s.d Smt I 2013'] = $tot['0702'];

                    $data['IIg. Real s.d Smt I 2014'] = $tot['0701'];


                }

                $lkpp_bumns[$bumn_nama] = $data;

            }

        if ($type == 'web') {


            if ($this->jenis_lap_id == 701){
                $table .= '<table id="example" cellpadding="0" cellspacing="0" border="0" width="auto">';
                $table .= '<thead><tr>';

                $table .= '<th> </th><th colspan="4">I Pendapatan</th><th colspan="4">II Laba Bersih Tahun Berjalan</th><th colspan="4">III Total Aset</th><th colspan="4">IV Total Ekuitas</th><th colspan="4">V Capex</th><th colspan="4">VI Opex</th><th colspan="2">VII Pajak</th>';
                $table .= '</tr><tr>';
                $table .= '<th>BUMN</th>';
                foreach ($data as $data_nama => $data_jumlah) {

                    $table .= '<th>' . $data_nama . '</th>';
                }

                $table .= '</tr></thead><tbody>';

                foreach ($lkpp_bumns as $bumn_nama => $bumn_data) {
                    $table .= '<tr>';
                    $table .='<td class="fixed">&nbsp;<b>' . $bumn_nama . '</b></td>';


                    foreach ($bumn_data as $title => $jumlah) {

                            if (is_string($jumlah)) {
                                $string = ereg_replace("[^0-9]", "", $jumlah);
                                if (ctype_digit($string)) {
                                    if($jumlah < 0){
                                        $table .='<td align="right">(' . $this->_helper->formatAngka(abs($jumlah), 0, 1) . ')</td>';
                                    } else {
                                        $table .='<td align="right">'. $this->_helper->formatAngka($jumlah, 0, 1) .'</td>';
                                    }
                                            //$table .='<td align="right">' . $this->_helper->formatAngka($jumlah, 0, 1) . '</td>';
                                } else {
                                    $table .='<td>' . $jumlah . '</td>';
                                }
                            } else {
                                $table .='<td align="right">' . $this->_helper->formatAngka($jumlah, 0, 1) . '</td>';
                            }

                        $tot_all[$title] +=$jumlah;

                    }


                    $table .='</tr>';

                }

                $table .='</tbody>';

                $table .='<tfoot><tr>';
                $table .='<td align="right" style="background-color:#F0F0F6">Grand Total</td>';


                foreach ($tot_all as $jumlah) {

                    $stringtot = ereg_replace("[^0-9]", "", $jumlah);
                    if ($jumlah == 'UNFILLED' || $jumlah == 'UNVERIFIED' || $jumlah == 'VERIFIED' || $jumlah == 'INVALID'){
                        $table .='<td style="background-color:#F0F0F6">&nbsp;</td>';
                    } else {
                        if($jumlah < 0){

                            $table .='<td style="background-color:#F0F0F6" align="right">      (' . $this->_helper->formatAngka(abs($jumlah), 0, 1) . ')</td>';
                        } else {

                            $table .='<td style="background-color:#F0F0F6" align="right">      '. $this->_helper->formatAngka($jumlah, 0, 1) .'</td>';
                            }
                    }

                }


                $table .='</tr></tfoot>';

                $table .='</table>';

                echo $table;
            } else {
                $table .= '<table table id="example" class="table table-striped table-bordered" cellpadding="0" cellspacing="0">';
                $table .= '<thead><tr>';

                $table .= '<th>BUMN</th>';

                $tot_all = array();
                foreach ($data as $data_nama => $data_jumlah) {

                        $table .= '<th>' . $data_nama . '</th>';
                }
                $table .='</tr></thead><tbody>';

                $no=1;
                foreach ($lkpp_bumns as $bumn_nama => $bumn_data) {

                    $table .= '<tr>';

                    if($bumn_nama == 'PT Bank Bukopin'){
                        $table .='<td class="fixed">&nbsp;<font color="red"><b>'.$no.' ' . $bumn_nama . '</b></font></td>';
                    } else {
                        $table .='<td class="fixed" >&nbsp;<b>'.$no.' ' . $bumn_nama . '</b></td>';
                    }

                    //$table .= '<tr>';
                    //$table .='<td class="fixed">&nbsp;<b>'.$no.' ' . $bumn_nama . '</b></td>';



                    foreach ($bumn_data as $title => $jumlah) {

                            if (is_string($jumlah)) {
                                $string = ereg_replace("[^0-9]", "", $jumlah);
                                if (ctype_digit($string)) {
                                    if($jumlah < 0){
                                        $table .='<td align="right">(' . $this->_helper->formatAngka(abs($jumlah), 0, 1) . ')</td>';
                                    } else {
                                        $table .='<td align="right">'. $this->_helper->formatAngka($jumlah, 0, 1) .'</td>';
                                    }
                                            //$table .='<td align="right">' . $this->_helper->formatAngka($jumlah, 0, 1) . '</td>';
                                } else {
                                    $table .='<td>' . $jumlah . '</td>';
                                }
                            } else {
                                $table .='<td align="right">' . $this->_helper->formatAngka($jumlah, 0, 1) . '</td>';
                            }

                        $tot_all[$title] +=$jumlah;

                    }

                    $no++;
                    $table .='</tr>';

                }

                $table .='</tbody>';

                $table .='<tfoot><tr>';
                $table .='<td style="background-color:#F0F0F6">Grand Total</td>';


                foreach ($tot_all as $jumlah) {

                    $stringtot = ereg_replace("[^0-9]", "", $jumlah);
                    if ($jumlah == 'UNFILLED' || $jumlah == 'UNVERIFIED' || $jumlah == 'VERIFIED' || $jumlah == 'INVALID'){
                        $table .='<td style="background-color:#F0F0F6">&nbsp;</td>';
                    } else {
                        if($jumlah < 0){

                            $table .='<td style="background-color:#F0F0F6" align="center">      (' . $this->_helper->formatAngka(abs($jumlah), 0, 1) . ')</td>';
                        } else {

                            $table .='<td style="background-color:#F0F0F6" align="center">      '. $this->_helper->formatAngka($jumlah, 0, 1) .'</td>';
                            }
                    }

                }


                $table .='</tr></tfoot>';

                $table .='</table>';


                echo $table;
            }

        }
    }
	
    public function formAction(){
        $this->view->tahuns = array('2012' => 2012,'2013' => 2013,'2014' => 2014,'2015' => 2015, '2016' => 2016);
        $this->view->tahun = $this->tahun;

        $this->view->periodes = array( 0 => 'SEMUA', 12 => 'RJPP', 7 => 'RKAP Usulan',1 => 'Triwulan I', 2 => 'Semester',3 => 'Triwulan III',8 => 'Prognosa',  5 => 'Tahunan Unaudited', 6 => 'Tahunan Audited',9 => 'Restated');
        $this->view->periode = $this->periode;

        $simpan = $this->getRequest()->getPost('simpan');
        $this->view->simpan = $simpan;
        $saham = $this->getRequest()->getParam('saham');
        $tot_aset = $this->getRequest()->getParam('tot_aset');
        $tot_lia = $this->getRequest()->getParam('tot_lia');
        $tot_ekui = $this->getRequest()->getParam('tot_ekui');
        $ekui_atribusi = $this->getRequest()->getParam('ekui_atribusi');
        $pend_usaha = $this->getRequest()->getParam('pend_usaha');
        $laba = $this->getRequest()->getParam('laba');
        $laba_atribusi = $this->getRequest()->getParam('laba_atribusi');
        $modal = $this->getRequest()->getParam('modal');
        $sdm = $this->getRequest()->getParam('sdm');
        $pajak = $this->getRequest()->getParam('pajak');
        $dividen = $this->getRequest()->getParam('dividen');
        $aset_lancar = $this->getRequest()->getParam('aset_lancar');
        $aset_tdklancar = $this->getRequest()->getParam('aset_tdklancar');
        $lia_pdk = $this->getRequest()->getParam('lia_pdk');
        $lia_pjg = $this->getRequest()->getParam('lia_pjg');
        $saldo_laba = $this->getRequest()->getParam('saldo_laba');
    }

    public function rekapAction(){

        $proyeksinergimodel = new proyeksinergiModel();
        $bumnmodel = new bumnModel($this->bumn_id, $this->tahun, $this->periode_id);
        //$akunglobalmodel = new akunGlobalModel($this->jenis_lap_id, $this->tahun, $this->periode_id);
        $combobumn = $proyeksinergimodel->getbumnbysession2();
        $this->view->combobumn2 = $combobumn;
        $this->view->cntcombobumn = count($combobumn);

        $this->view->tahuns = Globals::getTahuns();

        $comboperiode = $bumnmodel->periode();
        $this->view->comboperiodes = $comboperiode;
        $this->view->cntperiode = count($comboperiode);

        $this->view->groupinduk = $_SESSION['USERS_HAS_FIS']['EIS_GROUPS']['induk'];
    }

    public function jsontablelkpnAction(){

        $this->clearSentHeader();

        $laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id );

        $jsondatalkpn = $laporanBumnModel->getjsontablelkpn($this->BUMNS);

        echo $jsontablelkpn;
        die();
    }

    public function submitkpkuAction(){

        $laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id );
        $bumnModel = new bumnModel ( $this->bumn_id, $this->tahun, $this->periode_id );

        $bumn_id = $this->getRequest()->getPost('kpkubumn');
        $periode_id = 6;
        $tahun = $this->getRequest()->getPost('tahunbumn');
        $status = 'Unverified';
        $kpku_1 = str_replace(',','',$this->getRequest()->getPost('kpku_1'));
        $kpku_2 = str_replace(',','',$this->getRequest()->getPost('kpku_2'));
        $kpku_3 = str_replace(',','',$this->getRequest()->getPost('kpku_3'));
        $kpku_4 = str_replace(',','',$this->getRequest()->getPost('kpku_4'));
        $kpku_5 = str_replace(',','',$this->getRequest()->getPost('kpku_5'));
        $kpku_6 = str_replace(',','',$this->getRequest()->getPost('kpku_6'));
        $kpku_7 = str_replace(',','',$this->getRequest()->getPost('kpku_7'));
        $total = ($kpku_1+$kpku_2+$kpku_3+$kpku_4+$kpku_5+$kpku_6+$kpku_7);


        $data = $bumnModel->bumnHasProfilesUploadCentral($bumn_id);

        $newfile = $data ['id2'] . '-' . $tahun . '-' . $periode_id . '-' .'26.pdf';



        if($total >= '00,00' || $total == '0' || $total == '0,00'){
            $nilai_kpku = 'Early Development';
        }

        if ($total > '276,00' && $total <= '375,00'){
            
            $nilai_kpku = 'Early Result';
        }

        if ($total > '375,00' && $total <= '475,00'){
            
            $nilai_kpku = 'Early Improvement';
        }

        if ($total > '475,00' && $total <= '575,00'){
            
            $nilai_kpku = 'Good Performance';
        }

        if ($total > '575,00' && $total <= '675,00'){
            
            $nilai_kpku = 'Emerging Industry Leader';
        }

        if ($total > '675,00' && $total <= '775,00'){
            
            $nilai_kpku = 'Industry Leader';
        }

        if ($total > '775,00' && $total <= '875,00'){
            
            $nilai_kpku = 'Benchmark Leader';
        }

        if ($total > '875,00'){
            
            $nilai_kpku = 'World Class Leader';
        }


        $allowpdf = array('pdf');
        $uploaddir= '../etc/misc/upload/';


        if($_FILES['file_pendukung']['name'] != ''){
            $ext = strtolower(pathinfo(basename($_FILES['file_pendukung']['name']),PATHINFO_EXTENSION));
            if(in_array(strtolower($ext), $allowpdf)){
               $newnamefisik = uniqid().'.'.$ext;
                        
               $dirupload = $this->__dirupload.'monitorproyeksinergi/';                   
               if(move_uploaded_file($_FILES['file_pendukung']['tmp_name'], $uploaddir.''.$newfile)){
                  $berkas_pdf = $newfile;
               }            
            }else{
                  $save = false;
                  $msg .= 'Ekstensi '.$ext.' tidak diijinkan pada aplikasi ini';  
            }
         }


        
        $fields = array('bumn_id' => $bumn_id, 'periode_id' => $periode_id, 'tahun' => $tahun, 'kpku_1' => $kpku_1, 'kpku_2' => $kpku_2, 'kpku_3' => $kpku_3, 'kpku_4' => $kpku_4, 'kpku_5' => $kpku_5, 'kpku_6' => $kpku_6, 'kpku_7' => $kpku_7, 'total' => $total, 'tingkat_kpku' => $nilai_kpku, 'berkas_pdf' => $berkas_pdf, 'status' => $status);

        try {
            $laporanBumnModel->insertKinerjaKpku($fields);
            $save = true;
        } catch (Exception $e) {
            $save = false;
        }
        

        if($save == true){
         $flag = 'success';
         $msg = 'Sukses';
         $title = 'Sukses Menambahkan Data';           
            } else {
         $flag = 'error';
         $msg = 'Gagal Simpan Data';
         $title = 'Error';          
            }

        $json = array(
          'flag' => $flag,
          'msg' => $msg,
          'title' => $title
         );        
        echo json_encode($json);
        die();
    }

    public function submitviewAction(){

        $laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id );
        //$bumnModel = new bumnModel ( $this->bumn_id, $this->tahun, $this->periode_id );

        $tahun = $this->getRequest()->getPost('tahunbumn');
        $bumn_id = $this->getRequest()->getPost('lkpnbumn');
        $periode_id = $this->getRequest()->getPost('periodebumn');
        $saham = str_replace(',','',$this->getRequest()->getPost('saham'));
        $aset = str_replace(',','',$this->getRequest()->getPost('aset'));
        $liabilitas = str_replace(',','',$this->getRequest()->getPost('liabilitas'));
        $ekuitas = str_replace(',','',$this->getRequest()->getPost('ekuitas'));
        $pend_usaha = str_replace(',','',$this->getRequest()->getPost('pend_usaha'));
        $laba = str_replace(',','',$this->getRequest()->getPost('laba'));
        $laba_atribusi = str_replace(',','',$this->getRequest()->getPost('laba_atribusi'));
        $modal = str_replace(',','',$this->getRequest()->getPost('modal'));
        $sdm = str_replace(',','',$this->getRequest()->getPost('sdm'));
        $pajak = str_replace(',','',$this->getRequest()->getPost('pajak'));
        $dividen = str_replace(',','',$this->getRequest()->getPost('dividen'));
        $ebitda = str_replace(',','',$this->getRequest()->getPost('ebitda'));
        $kas_operasi = str_replace(',','',$this->getRequest()->getPost('kas_operasi'));
        
        $fields = array('tahun' => $tahun, 'bumn_id' => $bumn_id, 'periode_id' => $periode_id, 'saham' => $saham, 'aset' => $aset, 'liabilitas' => $liabilitas, 'ekuitas' => $ekuitas, 'pend_usaha' => $pend_usaha, 'laba' => $laba, 'laba_atribusi' => $laba_atribusi, 'modal' => $modal, 'sdm' => $sdm, 'pajak' => $pajak, 'dividen' => $dividen, 'ebitda' => $ebitda, 'kas_operasi' => $kas_operasi);

        try {
            $laporanBumnModel->insertLkpn($fields);
            $save = true;
        } catch (Exception $e) {
            $save = false;
        }
        

        if($save == true){
         $flag = 'success';
         $msg = 'Sukses';
         $title = 'Sukses Menambahkan Data';           
            } else {
         $flag = 'error';
         $msg = 'Gagal Simpan Data';
         $title = 'Error';          
            }

        $json = array(
          'flag' => $flag,
          'msg' => $msg,
          'title' => $title
         );        
        echo json_encode($json);
        die();
    }

    public function deleterkinerjakpkuAction(){

        $laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id );

        $id_kpku = $this->getRequest ()->getPost ( 'id_kpku' );

        try {
            $laporanBumnModel->deleteKinerjaKpku($id_kpku);
            $save = true;
        } catch (Exception $e) {
            $save = false;
        }

        if($save == true){
         $flag = 'success';
         $msg = 'Sukses Verifikasi Data KPKU';
         $title = 'Sukses';           
            } else {
         $flag = 'error';
         $msg = 'Gagal Simpan Data';
         $title = 'Error';          
            }

        $json = array(
          'flag' => $flag,
          'msg' => $msg,
          'title' => $title
         );        
        echo json_encode($json);
        die();
    }

    public function sukseskinerjakpkuAction(){

        $laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id );

        $id_kpku = $this->getRequest ()->getPost ( 'id_kpku' );

        $fields = array('status' => 'Verified', 'pesan' => '');

        try {
            $laporanBumnModel->updateKinerjaKpku($fields, $id_kpku);
            $save = true;
        } catch (Exception $e) {
            $save = false;
        }

        if($save == true){
         $flag = 'success';
         $msg = 'Sukses Menghapus Data KPKU';
         $title = 'Sukses';           
            } else {
         $flag = 'error';
         $msg = 'Gagal Simpan Data';
         $title = 'Error';          
            }

        $json = array(
          'flag' => $flag,
          'msg' => $msg,
          'title' => $title
         );        
        echo json_encode($json);
        die();
    }

    public function invalidrekapAction(){

        $laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id );

        $bumnkpkuid = $this->getRequest ()->getPost ( 'bumnkpkuid' );

        $invalidkpku = $this->getRequest()->getPost('invalidkpku');

        $fields = array('pesan' => $invalidkpku, 'status' => 'Invalid');

        try {
            $laporanBumnModel->updateKinerjaKpku($fields, $bumnkpkuid);
            $save = true;
        } catch (Exception $e) {
            $save = false;
        }

        if($save == true){
         $flag = 'success';
         $msg = 'Sukses Invalid Data KPKU';
         $title = 'Sukses';           
            } else {
         $flag = 'error';
         $msg = 'Gagal Simpan Data';
         $title = 'Error';          
            }

        $json = array(
          'flag' => $flag,
          'msg' => $msg,
          'title' => $title
         );        
        echo json_encode($json);
        die();
    }

    public function getrekapbyidAction(){

        $this->clearSentHeader();

        $id_lkpn = $this->getRequest ()->getPost ( 'id' );

        $laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id );
       
        $result = $laporanBumnModel->getlaplkpnbyid($id_lkpn);

        $json['id'] = $result[0]['id'];

        $json['saham'] = $result[0]['saham'];
        $json['aset'] = $result[0]['aset'];
        $json['liabilitas'] = $result[0]['liabilitas'];
        $json['ekuitas'] = $result[0]['ekuitas'];
        $json['pend_usaha'] = $result[0]['pend_usaha'];
        $json['laba'] = $result[0]['laba'];
        $json['laba_atribusi'] = $result[0]['laba_atribusi'];
        $json['modal'] = $result[0]['modal'];
        $json['sdm'] = $result[0]['sdm'];
        $json['pajak'] = $result[0]['pajak'];
        $json['dividen'] = $result[0]['dividen'];
        $json['ebitda'] = $result[0]['ebitda'];
        $json['kas_koperasi'] = $result[0]['kas_koperasi'];
        $json['laba_atribusi'] = $result[0]['laba_atribusi'];
        $json['periode_id'] = $result[0]['periode_id'];
        $json['tahun'] = $result[0]['tahun'];
        $json['bumn_id'] = $result[0]['bumn_id'];

        echo json_encode($json);

        die();        
    }

    public function submiteditrekapAction(){

        $laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id );

        $editkpkuid = $this->getRequest ()->getPost ( 'editkpkuid' );

        $bumn_id = $this->getRequest()->getPost('kpkubumn');
        $periode_id = 6;
        $tahun = $this->getRequest()->getPost('tahunbumn');
        $status = 'Unverified';
        $kpku_1 = str_replace(',','',$this->getRequest()->getPost('kpku_1'));
        $kpku_2 = str_replace(',','',$this->getRequest()->getPost('kpku_2'));
        $kpku_3 = str_replace(',','',$this->getRequest()->getPost('kpku_3'));
        $kpku_4 = str_replace(',','',$this->getRequest()->getPost('kpku_4'));
        $kpku_5 = str_replace(',','',$this->getRequest()->getPost('kpku_5'));
        $kpku_6 = str_replace(',','',$this->getRequest()->getPost('kpku_6'));
        $kpku_7 = str_replace(',','',$this->getRequest()->getPost('kpku_7'));
        $total = ($kpku_1+$kpku_2+$kpku_3+$kpku_4+$kpku_5+$kpku_6+$kpku_7);


        if($total >= '00,00' || $total == '0' || $total == '0,00'){
            $nilai_kpku_edit = 'Early Development';
        }

        if ($total > '276,00' && $total <= '375,00'){
            
            $nilai_kpku_edit = 'Early Result';
        }

        if ($total > '375,00' && $total <= '475,00'){
            
            $nilai_kpku_edit = 'Early Improvement';
        }

        if ($total > '475,00' && $total <= '575,00'){
            
            $nilai_kpku_edit = 'Good Performance';
        }

        if ($total > '575,00' && $total <= '675,00'){
            
            $nilai_kpku_edit = 'Emerging Industry Leader';
        }

        if ($total > '675,00' && $total <= '775,00'){
            
            $nilai_kpku_edit = 'Industry Leader';
        }

        if ($total > '775,00' && $total <= '875,00'){
            
            $nilai_kpku_edit = 'Benchmark Leader';
        }

        if ($total > '875,00'){
            
            $nilai_kpku_edit = 'World Class Leader';
        }

        
        $fields = array('bumn_id' => $bumn_id, 'periode_id' => $periode_id, 'tahun' => $tahun, 'kpku_1' => $kpku_1, 'kpku_2' => $kpku_2, 'kpku_3' => $kpku_3, 'kpku_4' => $kpku_4, 'kpku_5' => $kpku_5, 'kpku_6' => $kpku_6, 'kpku_7' => $kpku_7, 'total' => $total, 'tingkat_kpku' => $nilai_kpku_edit, 'status' => $status);

        try {
            $laporanBumnModel->updateKinerjaKpku($fields, $editkpkuid);
            $save = true;
        } catch (Exception $e) {
            $save = false;
        }

        if($save == true){
         $flag = 'success';
         $msg = 'Sukses Edit Data KPKU';
         $title = 'Sukses';           
            } else {
         $flag = 'error';
         $msg = 'Gagal Edit Data';
         $title = 'Error';          
            }

        $json = array(
          'flag' => $flag,
          'msg' => $msg,
          'title' => $title
         );        
        echo json_encode($json);
        die();
    }

    public function viewAction(){

        $proyeksinergimodel = new proyeksinergiModel();
        $bumnmodel = new bumnModel($this->bumn_id, $this->tahun, $this->periode_id);
        $combobumn = $proyeksinergimodel->getbumnbysession2();
        $this->view->combobumn2 = $combobumn;
        $this->view->cntcombobumn = count($combobumn);

        $this->view->tahuns = Globals::getTahuns();

        $comboperiode = $bumnmodel->periode();
        $this->view->comboperiodes = $comboperiode;
        $this->view->cntperiode = count($comboperiode);

        $this->view->groupinduk = $_SESSION['USERS_HAS_FIS']['EIS_GROUPS']['induk'];
    }

}


