<?php

require_once 'BaseController.php';
require_once 'sektorModel.php';
require_once 'laporanBumnModel.php';
require_once 'bumnModel.php';
//require_once 'testingModel.php';
//require_once 'bumnSwotModel.php';

class TestController extends BaseController
{
    
	public function echoAction()
	{
		
		//$this->_helper->viewRenderer->setNoRender(true);
		//$this->view->layout()->disableLayout();
        $lanjut = $this->getRequest ()->getPost ( 'lanjut' );
		$lanjut2 = $this->getRequest ()->getParam ( 'lanjut' );
        
		$this->view->lanjut = $lanjut;
		$this->view->lanjut2 = $lanjut2;
		$this->view->form_action = $this->_helper->url ( '', '' );
		
		$this->view->tahun = $this->tahun;
		$this->view->tahuns = Globals::getTahuns ();
		
		$baseModel = new baseModel ( );
		$this->view->periode = $this->periode_id;
		$this->view->periodes = $baseModel->listPeriodes ();
        
        $bumnModel = new bumnModel($this->bumn_id, $this->tahun, $this->periode_id);
		$data_bumn = $bumnModel->bumnHasProfiles();
        $this->view->nama_bumn = $data_bumn['nama'];
		
		if (! $lanjut && ! $lanjut2) 
		{
			$sektorModel = new sektorModel ( $this->sektor_id );
			$this->view->sektors = $sektorModel->listSektors ( $this->SEKTORS );
			$this->view->sektor = $this->sektor_id;
			
			$this->view->bumns = $sektorModel->sektorHasBumns ( $this->BUMNS, $this->tahun, $this->periode_id );
			$this->view->bumn = $this->bumn_id;
		} 
		else 
		{
			//			$laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $this->tahun, $this->periode_id );
			//			$this->view->laps_profil = $laporanBumnModel->laporanBumnHasViewStatusLaporan ( 'input' );
		}
        
		
	}
    
    public function homeshowAction(){
        $this->clearSentHeader ();
        
        echo 'test';
        
        //$tahun = $_GET['tahun'];
//        $periode = $_GET['periode'];
//        
//        $laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $tahun, $periode );
//        list($lengkap, $data) = $laporanBumnModel->laporanBumnHasLaporanPdf2();
        
        //echo '<script type="text/javascript" src="'.$this->baseUrl.'js/zapatec/zapatec.js"></script>';
//        echo "<div id='modul' class='contentdata-modul'>";
//        
//        if(($this->GROUPS['induk'] == 20000 || $this->GROUPS['induk'] == 1) && $laporanBumnModel->laporanBumnHasValidTo2('finish') && !$laporanBumnModel->laporanBumnHasValidTo2('posted'))
//
//		{}
//		  
//        $btn_finalisasi = '';
//		//echo($laporanBumnModel->laporanBumnHasValidTo('final'));die();exit;
//		if($this->GROUPS['induk'] == 60000 && $laporanBumnModel->laporanBumnHasValidTo2('final') && !$laporanBumnModel->laporanBumnHasValidTo2('posted'))
//		{
//        
//        	$btn_finalisasi = '<input type="button" value="Finalisasi" class="inputsubmit" onclick="location.href=\'/laporan/finalisasi\'">';	
//		}
//		
//		if($laporanBumnModel->laporanBumnHasValidTo2('posted'))
//		{
//			//echo $this->view->notifikasi('<b>Status Pelaporan FINAL</b><br>Validasi laporan selesai.','info');
//		}
//        
//        echo '<div class="clear">';
//		echo $this->view->tableStatusLaporanHelper2 ( $laporanBumnModel->laporanBumnHasViewStatusLaporan2 ( 'input', 1,true ));
//		//echo $this->view->tableStatusLaporanPdf($data, $this->GROUPS['induk']);
//		
//		//$nb =($this->GROUPS['induk'] == 20000 || $this->GROUPS['induk'] == 1)?'<font color="red">*</font> Status laporan harus FINISHED. &nbsp;&nbsp;<font color="red">**</font> Berkas laporan PDF harus diupload.':'<font color="red">*</font> Status laporan harus VERIFIED.';
//		echo '</div>';
//		//echo '<div style="float:left">'.$nb.'</div>';	
//		echo '<div style="float:right">'.$button_bars.'</div>';
//        echo "</div>";
    }
    
    public function echoshowAction() 
	{
		
        //$this->view->layout()->disableLayout();
        
        $tahun = $_GET['tahun'];
        $periode = $_GET['periode'];
        
        //echo $tahun;
        //die();
        //print_r($_POST);
		//$lanjut2 = $this->getRequest ()->getParam ( 'lanjut' );
        
        //echo $this->bumn_id;
        //echo $tahun;
        //echo $periode;
        
		$laporanBumnModel = new laporanBumnModel ( $this->JENIS_LAPS, $this->bumn_id, $tahun, $periode );
		list($lengkap, $data) = $laporanBumnModel->laporanBumnHasLaporanPdf2();
		//echo var_dump($lengkap);
        $this->clearSentHeader ();
        echo '<script type="text/javascript" src="'.$this->baseUrl.'js/zapatec/zapatec.js"></script>';
        echo "<div id='modul' class='contentdata-modul'>";
        
		/*if(!$lengkap && ($this->GROUPS['induk'] == 20000 || $this->GROUPS['induk'] == 1))
		{
			echo $this->view->notifikasi('<b>Laporan berkas pdf belum lengkap</b><br>Status laporan FINISHED tidak dapat dicapai apabila berkas laporan PDF belum diupload.','info');
		}*/
		
		//if(($this->GROUPS['induk'] == 20000 || $this->GROUPS['induk'] == 1) && $laporanBumnModel->laporanBumnHasValidTo('finish') && $lengkap && !$laporanBumnModel->laporanBumnHasValidTo('posted'))
		//echo $this->GROUPS['induk'].':'.$laporanBumnModel->laporanBumnHasValidTo('finish') ;die();
		if(($this->GROUPS['induk'] == 20000 || $this->GROUPS['induk'] == 1) && $laporanBumnModel->laporanBumnHasValidTo2('finish') && !$laporanBumnModel->laporanBumnHasValidTo2('posted'))

		{
			//echo $this->view->notifikasi('<b>Status Pelaporan FINISHED untuk laporan yang harus diisi.</b><br>Verifikasi dan finalisasi laporan sudah bisa dilakukan oleh verifikator.','info');	
		}		
		
		
		$btn_finalisasi = '';
		//echo($laporanBumnModel->laporanBumnHasValidTo('final'));die();exit;
		if($this->GROUPS['induk'] == 60000 && $laporanBumnModel->laporanBumnHasValidTo2('final') && !$laporanBumnModel->laporanBumnHasValidTo2('posted'))
		{
			//echo "masuk";die('test');
			//echo $this->view->notifikasi('<b>FINALISASI laporan sudah bisa dilakukan</b>','info');	
			$btn_finalisasi = '<input type="button" value="Finalisasi" class="inputsubmit" onclick="location.href=\'/laporan/finalisasi\'">';	
		}
		
		if($laporanBumnModel->laporanBumnHasValidTo2('posted'))
		{
			//echo $this->view->notifikasi('<b>Status Pelaporan FINAL</b><br>Validasi laporan selesai.','info');
		}		
		
		
		
		//$button = $this->view->buttonHelper ( $this->view->baseUrl );
		//$button_bars = $btn_finalisasi.'&nbsp;&nbsp;&nbsp;'.$button['btn_cetak'].'&nbsp;&nbsp;&nbsp;'.$button['btn_back_status_laporan'].'&nbsp;&nbsp;&nbsp;';
		
		//echo '<div style="float:left">&nbsp;&nbsp;&nbsp;' . '<label>Tahun Buku <label>' . $this->view->formSelect ( 'tahun', $this->tahun, array ('onchange' => 'this.form.submit()' ), Globals::getTahuns () ) . ' <label> Status <label>' . $this->view->formSelect ( 'periode_id', $this->periode_id, array ('onchange' => 'this.form.submit()' ), $laporanBumnModel->listPeriodes () ) . $this->view->formHidden ( 'lanjut', 'true' ) . '</div>';
		//echo '<div style="float:right">'.$button_bars.'</div>';
		echo '<div class="clear">';
		echo $this->view->tableStatusLaporanHelper2 ( $laporanBumnModel->laporanBumnHasViewStatusLaporan2 ( 'input', 1,true ));
		//echo $this->view->tableStatusLaporanPdf($data, $this->GROUPS['induk']);
		
		//$nb =($this->GROUPS['induk'] == 20000 || $this->GROUPS['induk'] == 1)?'<font color="red">*</font> Status laporan harus FINISHED. &nbsp;&nbsp;<font color="red">**</font> Berkas laporan PDF harus diupload.':'<font color="red">*</font> Status laporan harus VERIFIED.';
		echo '</div>';
		//echo '<div style="float:left">'.$nb.'</div>';	
		echo '<div style="float:right">'.$button_bars.'</div>';
        echo "</div>";
	}
}

?>