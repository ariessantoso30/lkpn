<?php
class laporanBumnModel extends baseModel {
	public $bumn_id;
	public $tahun;
	public $periode_id;
	public $jenis_lap_ids;
	public $bln;
	public $is_pso;
	public $is_tbk;
	public $thnPos;

	public function __construct($jenis_lap_ids, $bumn_id, $tahun, $periode_id,$bln=0,$is_pso=0,$is_tbk=0) {
		$this->db = Globals::getDBConnection ();
		$this->db2 = Globals::getDBConnection2 ();
		$this->jenis_lap_ids = $jenis_lap_ids;
		$this->bumn_id = $bumn_id;
		$this->tahun = $tahun;
		$this->periode_id = $periode_id;
		$this->bln = $bln;
		$this->is_pso = $is_pso;
		$this->is_tbk = $is_tbk;
	}

	public function laporanBumnHasKategoriLaporan($kategori = 'input_profil') {
	   //echo print_r($this->jenis_lap_ids);
		if (count ( $this->jenis_lap_ids ) < 1)
			return array ();

		//		$jenis_laps = $this->listJenislap ( $this->jenis_lap_ids );
		//		$_j = array ();
		//
		//		foreach ( $jenis_laps as $jenis_lap_id => $jenis_lap_nama ) {
		//			if ($kategori == 'input_profil' && $jenis_lap_id < 300) {
		//				$_j [$jenis_lap_id] = $jenis_lap_nama;
		//
		//			} else if ($kategori == 'input' && $jenis_lap_id >= 300) {
		//				$_j [$jenis_lap_id] = $jenis_lap_nama;
		//			}
		//		}
		//		return $_j;
		//$where = ($kategori == 'input_profil') ? 'and id < 300' : 'and id >= 300';
		//
		//
		
            if($kategori == 'input_profil'){
                $where = 'and id <= 200';
            } elseif($kategori == 'keuangan') {
                $where = 'and id >= 300 and id < 400';
            } elseif($kategori == 'kontribusi') {
            	$where = 'and id >= 500';
            } elseif($kategori == 'lkpn') {
            	$where = 'and id in (308,309)';
            } else {	
            	if($this->periode_id == 6){
		            if($kategori == 'input_profil'){
		                $where = 'and id < 300';
		            } else {
		                //$where = 'and id >= 100';
		                $where = 'and id in (100,110,120,130,140,150,200,210,220,250,300,301,302,303,321,400,410,430,470,500,510,520)';
		            }
		            
		        } elseif ($this->periode_id == 10) {
		        	$where = 'and id in (200,210,220,250,300,301,302,303,321,400,410,430)';
		        } elseif ($this->periode_id == 7) {
		        	$where = 'and id in (900,904,906,910,911,912,913)';
		        } else {
		            $where = 'and id in (200,210,220,250,300,301,302,303,321,400,410,430,470)';
		        }
            	
            }

		/*
        if($this->periode_id == 6){
            if($kategori == 'input_profil'){
                $where = 'and id < 300';
            } else {
                $where = 'and id >= 200';
            }
            
        } else {
            $where = 'and id >= 300';
        }
		*/
        /*if($_SESSION['USERS_HAS_FIS']['FIS_ACCOUNT']=='sys_eis' || $_SESSION['USERS_HAS_FIS']['FIS_ACCOUNT']=='zalfriej' || $_SESSION['USERS_HAS_FIS']['FIS_ACCOUNT']=='super_eis'){
			$LAPORAN_REQUIRED = array (210, 220, 250, 301, 302, 303, 410, 430, 455, 460, 495, 510 );

			$sql = 'select id, nama, freetext from jenis_lap where active = \'t\' and id in(300, 301, 302, 303, 304, 307, 500, 510, 308, 309, 496, 400, 200, 210, 220, 230, 240, 250) and id >= 300 order by id'
		}*/

		//echo $where;


		$sql = 'select id, nama, freetext from jenis_lap where active = \'t\' and id in('.implode(', ',$this->jenis_lap_ids).')' . $where . ' order by id';
        /*echo '<pre>';
        echo $sql;
       echo '</pre>';*/
		$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}

	public function laporanBumnHasKategoriLaporanAo($kategori = 'input_profil') {
	   //echo print_r($this->jenis_lap_ids);
		if (count ( $this->jenis_lap_ids ) < 1)
			return array ();

		//		$jenis_laps = $this->listJenislap ( $this->jenis_lap_ids );
		//		$_j = array ();
		//
		//		foreach ( $jenis_laps as $jenis_lap_id => $jenis_lap_nama ) {
		//			if ($kategori == 'input_profil' && $jenis_lap_id < 300) {
		//				$_j [$jenis_lap_id] = $jenis_lap_nama;
		//
		//			} else if ($kategori == 'input' && $jenis_lap_id >= 300) {
		//				$_j [$jenis_lap_id] = $jenis_lap_nama;
		//			}
		//		}
		//		return $_j;
		//$where = ($kategori == 'input_profil') ? 'and id < 300' : 'and id >= 300';
		//
		//
		
		if($kategori == 'input_profil'){
                $where = 'and id <= 200';
            } elseif($kategori == 'keuangan') {
                $where = 'and id >= 300 and id < 400';
            } elseif($kategori == 'kontribusi') {
            	$where = 'and id >= 500';
            } elseif($kategori == 'lkpn') {
            	$where = 'and id in (308,309)';
            } else {	
            	if($this->periode_id == 6){
		            if($kategori == 'input_profil'){
		                $where = 'and id < 300';
		            } else {
		                //$where = 'and id >= 100';
		                $where = 'and id in (200,290)';
		            }
		            
		        } elseif ($this->periode_id == 10) {
		        	$where = 'and id in (200,290)';
		        } elseif ($this->periode_id == 7) {
		        	$where = 'and id in (200,290)';
		        } else {
		            $where = 'and id in (200,290)';
		        }
            	
            }

		/*
        if($this->periode_id == 6){
            if($kategori == 'input_profil'){
                $where = 'and id < 300';
            } else {
                $where = 'and id >= 200';
            }
            
        } else {
            $where = 'and id >= 300';
        }
		*/
        /*if($_SESSION['USERS_HAS_FIS']['FIS_ACCOUNT']=='sys_eis' || $_SESSION['USERS_HAS_FIS']['FIS_ACCOUNT']=='zalfriej' || $_SESSION['USERS_HAS_FIS']['FIS_ACCOUNT']=='super_eis'){
			$LAPORAN_REQUIRED = array (210, 220, 250, 301, 302, 303, 410, 430, 455, 460, 495, 510 );

			$sql = 'select id, nama, freetext from jenis_lap where active = \'t\' and id in(300, 301, 302, 303, 304, 307, 500, 510, 308, 309, 496, 400, 200, 210, 220, 230, 240, 250) and id >= 300 order by id'
		}*/

		//echo $where;


		$sql = 'select id, nama, freetext from jenis_lap where active = \'t\' and id in('.implode(', ',$this->jenis_lap_ids).')' . $where . ' order by id';
        /*echo '<pre>';
        echo $sql;
       echo '</pre>';*/
		$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}

	public function persendatamasukneraca()
	{
		$sql = 'select count(bumn_nama) from bumn_master_baruv3 where bumn_id in (SELECT
					DISTINCT(bumn_id)
				FROM
					transaksi_global_lkpn
				WHERE
					tahun = ' . $this->tahun . '
				AND jenis_lap_id = 601
				AND periode_id = 2 order by bumn_id ASC)';
		$number = $this->db2->GetOne ( $sql );

		return $number;
	}

	public function persendatamasuklabarugi()
	{
		$sql = 'select count(bumn_nama) from bumn_master_baruv3 where bumn_id in (SELECT
					DISTINCT(bumn_id)
				FROM
					transaksi_global_lkpn
				WHERE
					tahun = ' . $this->tahun . '
				AND jenis_lap_id = 602
				AND periode_id = 2 order by bumn_id ASC)';
		$number = $this->db2->GetOne ( $sql );

		return $number;
	}

	public function persendatamasukdataconf()
	{
		$sql = 'select count(bumn_nama) from bumn_master_baruv3 where bumn_id in (SELECT
					DISTINCT(bumn_id)
				FROM
					transaksi_global_lkpn
				WHERE
					tahun = ' . $this->tahun . '
				AND jenis_lap_id = 701
				AND periode_id = 2 order by bumn_id ASC)';
		$number = $this->db2->GetOne ( $sql );

		return $number;
	}


	public function ambiltanggalmasuk($bumn_id,$periode_id)
	{
		/*$sql = 'SELECT
					tanggal::timestamp::date
				FROM
					status_pemasukan_bumn
				WHERE
					tanggal = (
						SELECT
							MAX (a.tanggal)
						FROM
							status_pemasukan_bumn a
						WHERE
							a.bumn_id = \'' . $bumn_id . '\'
						AND a.tahun = ' . $this->tahun . '
						AND a.periode_id = ' . $periode_id . '
						AND a. status_pelaporan_id = 40
					)ORDER BY
						tanggal desc
						LIMIT 1';*/

		$sql = 'SELECT
					EXTRACT(DAY FROM tanggal) as hari,
				  EXTRACT(MONTH FROM tanggal) as bulan,
				  EXTRACT(YEAR FROM tanggal) as tahun
				FROM
					status_pemasukan_bumn
				WHERE
					tanggal = (
						SELECT
							MAX (A .tanggal)
						FROM
							status_pemasukan_bumn A
						WHERE
							A .bumn_id = \'' . $bumn_id . '\'
						AND A .tahun = ' . $this->tahun . '
						AND A .periode_id = ' . $periode_id . '
						AND A .status_pelaporan_id = 40
					)ORDER BY
						tanggal DESC
						LIMIT 1';

		//echo $sql;die();

		$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}


	public function cekdatamasukregneracabumn($bumn_ids){

		$sql = 'SELECT
					b.bumn_nama AS bumn_nama,
					CASE when a.status_pelaporan_id = 5 then \'INVALID\'
							 when a.status_pelaporan_id = 20 then \'UNVERIFIED\'
							 when a.status_pelaporan_id = 40 then \'VERIFIED\'
							 when a.status_pelaporan_id = 10 then \'INPROGRESS\'
							 else \'UNFILLED\'
					END as status,
					MAX (A .tanggal) AS tanggal,
					A.pesan AS pesan
				FROM
					status_pemasukan_bumn A,
					bumn_master_baruv3 b
				WHERE
					A .tahun = 2015
				AND A .periode_id = 5
				AND A .jenis_lap_id = 301
				AND A .bumn_id = b.bumn_id
				AND b.bumn_id IN (\''.implode("','", $bumn_ids).'\') 
									GROUP BY
										b.bumn_id,
										b.bumn_nama,
										a.tanggal,
										a.pesan,
										A .status_pelaporan_id
										ORDER BY
											a.tanggal DESC';

		//echo $sql;
		$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}

	public function cekdatamasukreglabarugibumn($bumn_ids){

		$sql = 'SELECT
					b.bumn_nama AS bumn_nama,
					CASE when a.status_pelaporan_id = 5 then \'INVALID\'
							 when a.status_pelaporan_id = 20 then \'UNVERIFIED\'
							 when a.status_pelaporan_id = 40 then \'VERIFIED\'
							 when a.status_pelaporan_id = 10 then \'INPROGRESS\'
							 else \'UNFILLED\'
					END as status,
					MAX (A .tanggal) AS tanggal,
					A.pesan AS pesan
				FROM
					status_pemasukan_bumn A,
					bumn_master_baruv3 b
				WHERE
					A .tahun = 2015
				AND A .periode_id = 5
				AND A .jenis_lap_id = 302
				AND A .bumn_id = b.bumn_id
				AND b.bumn_id IN (\''.implode("','", $bumn_ids).'\') 
									GROUP BY
										b.bumn_id,
										b.bumn_nama,
										a.tanggal,
										a.pesan,
										A .status_pelaporan_id
										ORDER BY
											a.tanggal DESC';

		//echo $sql;
		$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}

	public function cekdatamasukregaruskasbumn($bumn_ids){

		$sql = 'SELECT
					b.bumn_nama AS bumn_nama,
					CASE when a.status_pelaporan_id = 5 then \'INVALID\'
							 when a.status_pelaporan_id = 20 then \'UNVERIFIED\'
							 when a.status_pelaporan_id = 40 then \'VERIFIED\'
							 when a.status_pelaporan_id = 10 then \'INPROGRESS\'
							 else \'UNFILLED\'
					END as status,
					MAX (A .tanggal) AS tanggal,
					A.pesan AS pesan
				FROM
					status_pemasukan_bumn A,
					bumn_master_baruv3 b
				WHERE
					A .tahun = 2015
				AND A .periode_id = 5
				AND A .jenis_lap_id = 303
				AND A .bumn_id = b.bumn_id
				AND b.bumn_id IN (\''.implode("','", $bumn_ids).'\') 
									GROUP BY
										b.bumn_id,
										b.bumn_nama,
										a.tanggal,
										a.pesan,
										A .status_pelaporan_id
										ORDER BY
											a.tanggal DESC';

		//echo $sql;
		$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}


    //and b.bumn_id in(\''.implode("','", $bumn_ids).'\')
	public function cekdatamasuklkpnneracasemester($bumn_ids){

		$sql = 'SELECT
					b.bumn_nama AS bumn_nama,
					CASE when a.status_pelaporan_id = 5 then \'INVALID\'
							 when a.status_pelaporan_id = 20 then \'UNVERIFIED\'
							 when a.status_pelaporan_id = 40 then \'VERIFIED\'
							 else \'UNFILLED\'
					END as status,
					MAX (A .tanggal) AS tanggal,
					A.pesan AS pesan
				FROM
					status_pemasukan_bumn A,
					bumn_master_baruv3 b
				WHERE
					A .tahun = 2014
				AND A .periode_id = 5
				AND A .jenis_lap_id = 601
				AND A .bumn_id = b.bumn_id
				AND b.bumn_id IN (\''.implode("','", $bumn_ids).'\') 
									GROUP BY
										b.bumn_id,
										b.bumn_nama,
										a.tanggal,
										a.pesan,
										A .status_pelaporan_id
										ORDER BY
											a.tanggal DESC';

		//echo $sql;
		$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}

	public function cekdatamasuklkpnlabarugisemester($bumn_ids){

		$sql = 'SELECT
					b.bumn_nama AS bumn_nama,
					CASE when a.status_pelaporan_id = 5 then \'INVALID\'
							 when a.status_pelaporan_id = 20 then \'UNVERIFIED\'
							 when a.status_pelaporan_id = 40 then \'VERIFIED\'
							 else \'UNFILLED\'
					END as status,
					MAX (A .tanggal) AS tanggal,
					a.pesan as pesan
				FROM
					status_pemasukan_bumn A,
					bumn_master_baruv3 b
				WHERE
					A .tahun = 2014
				AND A .periode_id = 5
				AND A .jenis_lap_id = 602
				AND A .bumn_id = b.bumn_id
				AND b.bumn_id IN (\''.implode("','", $bumn_ids).'\') 
									GROUP BY
										b.bumn_id,
										b.bumn_nama,
										a.tanggal,
										a.pesan,
										A .status_pelaporan_id
										ORDER BY
											a.tanggal DESC';

		/*$sql = 'select bumn_nama from bumn_master_baruv3 where bumn_id in (SELECT
					DISTINCT(bumn_id)
				FROM
					transaksi_global_lkpn
				WHERE
					tahun = 2014
				AND jenis_lap_id = 602
				AND periode_id = 5 
				AND bumn_id in (\''.implode("','", $bumn_ids).'\') order by bumn_id ASC)';*/
		$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}

	public function cekdatamasuklkpndataconfsemester($bumn_ids){
		$sql = 'select bumn_nama from bumn_master_baruv3 where bumn_id in (SELECT
					DISTINCT(bumn_id)
				FROM
					transaksi_global_lkpn
				WHERE
					tahun = ' . $this->tahun . '
				AND jenis_lap_id = 701
				AND periode_id = 2 
				AND bumn_id in (\''.implode("','", $bumn_ids).'\') order by bumn_id ASC)';
		$rows = $this->db2->GetAll ( $sql );
		//echo $sql;
		return $rows;
	}

	public function statuspemasukandatalkpnneraca($jenis_lap_id,$bumn_ids,$periode_id){
		$sql = 'SELECT
					A .*
				FROM
					status_pemasukan_bumn A
				LEFT JOIN (
					SELECT
						tahun,
						periode_id,
						bumn_id,
						jenis_lap_id,
						MAX (tanggal) AS tanggal,
						1 AS FLAG
					FROM
						status_pemasukan_bumn
					GROUP BY
						tahun,
						periode_id,
						bumn_id,
						jenis_lap_id
					ORDER BY
						tahun,
						periode_id,
						bumn_id,
						jenis_lap_id
				) b ON A .tahun = b.tahun
				AND A .periode_id = b.periode_id
				AND A .bumn_id = b.bumn_id
				AND A .jenis_lap_id = b.jenis_lap_id
				AND A .tanggal = b.tanggal
				WHERE
					A .tahun = ' . $this->tahun . '
				AND A .periode_id = ' . $periode_id . '
				AND b. FLAG = 1
				AND A .jenis_lap_id = ' . $jenis_lap_id . '
				AND A .bumn_id = \'' . $bumn_ids . '\' limit 1;';

				//echo $sql;

				$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}

	public function statuspemasukandatarekapbumn($jenis_lap_id,$bumn_ids,$periode_id,$tahun){
		$sql = 'SELECT
					A .*
				FROM
					status_pemasukan_bumn A
				LEFT JOIN (
					SELECT
						tahun,
						periode_id,
						bumn_id,
						jenis_lap_id,
						MAX (tanggal) AS tanggal,
						1 AS FLAG
					FROM
						status_pemasukan_bumn
					GROUP BY
						tahun,
						periode_id,
						bumn_id,
						jenis_lap_id
					ORDER BY
						tahun,
						periode_id,
						bumn_id,
						jenis_lap_id
				) b ON A .tahun = b.tahun
				AND A .periode_id = b.periode_id
				AND A .bumn_id = b.bumn_id
				AND A .jenis_lap_id = b.jenis_lap_id
				AND A .tanggal = b.tanggal
				WHERE
					A .tahun = ' . $tahun . '
				AND A .periode_id = ' . $periode_id . '
				AND b. FLAG = 1
				AND A .jenis_lap_id = ' . $jenis_lap_id . '
				AND A .bumn_id = \'' . $bumn_ids . '\' limit 1; ';

				//echo $sql;

				$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}

	public function laporanBumnHasLkpnLaporan()
	{
		$sql = 'select id, nama, freetext from jenis_lap where active = \'t\' and id in(600,601,602,700,701) order by id';
        //echo '<pre>';
        //echo $sql;
//        echo '</pre>';
		$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}


	public function statuslaporanlkpn($jenis_lap_id,$bumn_id,$periode_id){
		//echo('masuk');die();
		$sql = 'select a.nama, b.status_pelaporan_id, b.users_login, MAX (b.tanggal) AS tanggal from status_pemasukan a, status_pemasukan_bumn b
				where a.id = b.status_pelaporan_id
				and b.jenis_lap_id = ' . $jenis_lap_id . '
				and b.tahun = ' . $this->tahun . '
				and b.periode_id = ' . $periode_id . '
				and b.bumn_id = \'' . $bumn_id . '\'';
				//and (b.status_pelaporan_id = 40 or b.status_pelaporan_id = 50)';
		//$sql .= ($this->bln == 0)?"":" and date_part('year',b.tanggal) <= ".$this->thnPos." and date_part('month',b.tanggal) <= ".$this->bln;
		$sql .= ' GROUP BY a.nama, b.status_pelaporan_id, b.users_login limit 1';
		//echo ($sql);
		$rs = $this->db2->execute ( $sql ) or die ( $dbconn->ErrorMsg () );		

		return $rs;
	}

	public function laporanBumnHasStatusLaporan($jenis_lap_id) {
		//echo('masuk');die();
		$sql = 'select a.nama, b.status_pelaporan_id, b.users_login, to_char(b.tanggal,\'DD-MM-YYYY,  HH:MI\') as tanggal, b.tanggal as tgl from status_pemasukan a, status_pemasukan_bumn b
				where a.id = b.status_pelaporan_id
				and b.jenis_lap_id = ' . $jenis_lap_id . '
				and b.tahun = ' . $this->tahun . '
				and b.periode_id = ' . $this->periode_id . '
				and b.bumn_id = \'' . $this->bumn_id . '\'';
				//and (b.status_pelaporan_id = 40 or b.status_pelaporan_id = 50)';
		//$sql .= ($this->bln == 0)?"":" and date_part('year',b.tanggal) <= ".$this->thnPos." and date_part('month',b.tanggal) <= ".$this->bln;
		$sql .= ' order by tgl desc
				limit 1
				';
		//echo ($sql);
		$row = $this->db2->GetRow ( $sql );
		return $row;

	}

	public function laporanBumnHasStatusLaporanVerified($jenis_lap_id) {
		//echo('masuk');die();
		$sql = 'select a.nama, b.status_pelaporan_id, b.users_login, to_char(b.tanggal,\'DD-MM-YYYY,  HH:MI\') as tanggal, b.tanggal as tgl from status_pemasukan a, status_pemasukan_bumn b
				where a.id = b.status_pelaporan_id
				and b.jenis_lap_id = ' . $jenis_lap_id . '
				and b.tahun = ' . $this->tahun . '
				and b.periode_id = ' . $this->periode_id . '
				and b.bumn_id = \'' . $this->bumn_id . '\'
				and (b.status_pelaporan_id = 40 or b.status_pelaporan_id = 50)';
		
		$sql .= ' order by tgl desc
				limit 1';
		//echo ($sql);
		$row = $this->db2->GetRow ( $sql );
		return $row;

	}


	public function laporanGcgHasStatusLaporan($jenis_lap_id) {
		//echo('masuk');die();
		$sql = 'select a.nama, b.pesan, b.status_pelaporan_id, b.users_login, to_char(b.tanggal,\'DD-MM-YYYY,  HH:MI\') as tanggal, b.tanggal as tgl from status_pemasukan a, status_pemasukan_bumn b
				where a.id = b.status_pelaporan_id
				and b.jenis_lap_id = ' . $jenis_lap_id . '
				and b.tahun = ' . $this->tahun . '
				and b.periode_id = ' . $this->periode_id . '
				and b.bumn_id = \'' . $this->bumn_id . '\'
				and (b.status_pelaporan_id = 20)';
		
		$sql .= ' order by tgl desc
				limit 1';
		//echo ($sql);die();
		$row = $this->db2->GetRow ( $sql );
		return $row;

	}


	public function laporanBumnLkpnHasInputLaporan($jenis_lap_id) {
		//echo('masuk');die();
		$sql = 'select a.nama, b.status_pelaporan_id, b.users_login, to_char(b.tanggal,\'DD-MM-YYYY,  HH:MI\') as tanggal, b.tanggal as tgl, b.pesan as pesan from status_pemasukan a, status_pemasukan_bumn b
				where a.id = b.status_pelaporan_id
				and b.jenis_lap_id = \'' . $jenis_lap_id . '\'
				and b.tahun = ' . $this->tahun . '
				and b.periode_id = ' . $this->periode_id . '
				and b.bumn_id = \'' . $this->bumn_id . '\'';
				//and (b.status_pelaporan_id = 40 or b.status_pelaporan_id = 50)';
		//$sql .= ($this->bln == 0)?"":" and date_part('year',b.tanggal) <= ".$this->thnPos." and date_part('month',b.tanggal) <= ".$this->bln;
		$sql .= ' order by tgl desc
				limit 1
				';
		//echo ($sql);
		$row = $this->db2->GetRow ( $sql );
		return $row;

	}


    
    public function laporanBumnHasInputLaporan($jenis_lap_id) {
		//echo('masuk');die();
		$sql = 'select a.nama, b.status_pelaporan_id, b.users_login, to_char(b.tanggal,\'DD-MM-YYYY,  HH:MI\') as tanggal, b.tanggal as tgl, b.pesan as pesan from status_pemasukan a, status_pemasukan_bumn b
				where a.id = b.status_pelaporan_id
				and b.jenis_lap_id = \'' . $jenis_lap_id . '\'
				and b.tahun = ' . $this->tahun . '
				and b.periode_id = ' . $this->periode_id . '
				and b.bumn_id = \'' . $this->bumn_id . '\'';
				//and (b.status_pelaporan_id = 40 or b.status_pelaporan_id = 50)';
		//$sql .= ($this->bln == 0)?"":" and date_part('year',b.tanggal) <= ".$this->thnPos." and date_part('month',b.tanggal) <= ".$this->bln;
		$sql .= ' order by tgl desc
				limit 1;
				';
		//echo ($sql);
		$row = $this->db2->GetRow ( $sql );
		return $row;

	}
    
    public function laporanRequired(){
        $sql = "select jenis_lap_id from bumn_laporan where bumn_id = '1906' and tahun = 2011 and periode_id = 6";
        $list = $this->db2->getRow ( $sql );
        
        $listbaru = $list['jenis_lap_id'];
        //var_dump($list['jenis_lap_id']); exit();
        
        //$listt = explode(",", $list['jenis_lap_id']);
        //echo $list; exit();
        $sql1 = "SELECT
                	id
                FROM
                	jenis_lap
                WHERE
                	id IN ($listbaru)";
        $row = $this->db2->GetRow ( $sql1 );
        
        //echo $sql1; exit();
    }
    
    
    public function laporanBumnHasValid($status)
    {

		if($this->periode_id == 6 || $this->periode_id == 5){
		    $LAPORAN_REQUIRED = array (110, 120, 130, 140, 150, 210, 220,230, 250, 301, 302, 303,321, 510, 520);
        } else {
            $LAPORAN_REQUIRED = array (210,220,250,301,302,303,321);
        }
        
        switch($status)
		{
			case 'invalid':
				$status_id = 5;
				break;
			case 'inprogress':
				$status_id = 10;
				break;
			case 'unverified':
				$status_id = 20;
				break;
			case 'verified':
				$status_id = 40;
				break;
		}
        
        $valid = array(1);
		foreach($LAPORAN_REQUIRED as $jid)
		{
			$status = $this->laporanBumnHasInputLaporan($jid);
			//echo $status['status_pelaporan_id'];
			//echo var_dump($status);
			if($status)
			{
				if($status['status_pelaporan_id'] < $status_id){
					$valid[] = 0;
				}
				
			}
			else
				$valid[] = 1;


		}
		
		return (in_array(0,$valid))?true:false;
        
    }

	public function laporanBumnHasValidTo($status)
	{

		if($this->periode_id == 6){
		    $LAPORAN_REQUIRED = array (110,130,140,150,210,220,250,301,302,303,321,510,520,802,803,805,807,808,809,811,812,813);
        } elseif ($this->periode_id == 11 || $this->periode_id == 12 || $this->periode_id == 7) {
        	$LAPORAN_REQUIRED = '';
        } elseif ($this->periode_id == 10) {
        	$LAPORAN_REQUIRED = array(210,220, 250,301, 302, 303, 321, 809,811);
        } else {
            $LAPORAN_REQUIRED = array (210,220,250,301,302,303,321,809);
        }

		switch($status)
		{
			case 'invalid':
				$status_id = 5;
				break;
			case 'inprogress':
				$status_id = 10;
				break;
			case 'unverified':
				$status_id = 20;
				break;
			case 'verified':
				$status_id = 40;
				break;
		}



		$valid = array();
		foreach($LAPORAN_REQUIRED as $jid)
		{
			//$status = $this->laporanBumnHasStatusLaporan($jid);
			$status = $this->laporanBumnHasInputLaporan($jid);

			if($status['status_pelaporan_id'] == NULL){
				$valid[] = 0;
			} else {
				if($status['status_pelaporan_id'] < $status_id){
					$valid[] = 0;                                      
				} else{
					$valid[] = 1;
				}
			}

		}
		
		return (in_array(0,$valid))?false:true;
	}

	public function laporanLkpnminHasInputLaporan($laps_kategori = 'input_profil',$user_group,$pdf = true)
	{
		$LAPORAN_REQUIRED = array (601,602);

		$laps = $this->laporanBumnHasLKPNLaporan();

		$view_status_laporan = array();

		foreach($laps as $jenis_laps){
            if (substr ( $this->bumn_id, 0, 2 ) != '01' and ($jenis_laps ['id'] == 305 or $jenis_laps['id'] == 492)) {
				//do nothing
			}else{
                if (($this->is_pso != 1) && ($jenis_laps['id'] == 498) ){
					//do nothing
				}/*elseif (($this->is_tbk != 1) && ($jenis_laps['id'] == 495) ){
					//do nothing
				}*/
				elseif (($this->bumn_id == 3301) && ($jenis_laps['id'] == 240)){
				    //var_dump($jenis_laps['id']);
				}
				elseif (($this->is_tbk == 1) && ($jenis_laps['id'] == 240) ){
					//do nothing
                    //var_dump($jenis_laps['id']);
				}else{
				    $lap_status = $this->laporanBumnLkpnHasInputLaporan( $jenis_laps ['id'] );
                    //var_dump($lap_status);
                    
                    if ($user_group == 20000 || $user_group == 1) {
					   
                        
						if ($lap_status['status_pelaporan_id'] == 5) {
							$status = 'INVALID';
							$notif = 'Terjadi Kesalahan';
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							/*$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED ) && $lap_status ['status_pelaporan_id'] == 10) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
                            //echo $jenis_lap_nama;
                            //$status = 'INPROGRESS';
                            if($lap_status['status_pelaporan_id'] == 5){
                            	$lap_status['nama'] = 'INVALID';
                            }
                            
							$status = ($pdf) ? $lap_status ['nama'] : 'INPROGRESS';
                            if($lap_status ['tanggal'] == ''){
                                $notif = '';
                            } else {
                                $notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
                            }*/
                            
                            //$status = 'VERIFIED';
                            //echo $status;
                            //var_dump($jenis_laps);
                            
						} elseif($lap_status['status_pelaporan_id'] == 10){
							$status = 'INPROGRESS';
							$notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif($lap_status['status_pelaporan_id'] == 20){
							$status = 'UNVERIFIED';
							$notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif ($lap_status['status_pelaporan_id'] == 40) {
							$status = 'VERIFIED';
							$notif = 'Verifikasi Selesai';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} else {
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							$status = 'UNFILLED';
                            //$notifikasi = 'Menunggu Verfikasi Kementerian BUMN';
						}
						//if ($user_group == 20000)
					} else if (($user_group == 60000 || $user_group == 700 || $user_group == 1)) {
						if ($lap_status['status_pelaporan_id'] == 5) {
							$status = 'INVALID';
							$notif = 'Terjadi Kesalahan';
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							/*if ($pdf) {
								$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED ) && $lap_status ['status_pelaporan_id'] <= 40) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
								$status = $lap_status ['nama'];
                                $notif = '<font color="green">Siap Diverifikasi</font>';
							} else {
								$jenis_lap_nama = $jenis_laps ['nama'];
								$status = 'INPOGRESS';
                                $notif = '<font color="red">Berkas PDF Belum Lengkap (Siap Diverifikasi)</font>';
							}*/

						} elseif ($lap_status['status_pelaporan_id'] == 10) {
							$status = 'INPROGRESS';
							$notif = 'Laporan Belum Lengkap';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif ($lap_status['status_pelaporan_id'] == 20) {
							$status = 'UNVERIFIED';
							$notif = 'Siap Diverifikasi';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif ($lap_status['status_pelaporan_id'] == 40) {
							$status = 'VERIFIED';
							$notif = 'Verifikasi Selesai';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} else {
							$jenis_lap_nama = $jenis_laps ['nama'];
							$status = 'UNFILLED';
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
                            //$notifikasi = 'Siap Untuk Diverifikasi';
						}
					}
                    
					$view_status_laporan [$jenis_laps ['id']] ['nama'] = $jenis_lap_nama;
					$view_status_laporan [$jenis_laps ['id']] ['status'] = $status;
					$view_status_laporan [$jenis_laps ['id']] ['user'] = ($lap_status) ? $lap_status ['users_login'] : '';
					$view_status_laporan [$jenis_laps ['id']] ['tanggal'] = ($lap_status) ? $lap_status ['tanggal'] : '';
					                    
					$view_status_laporan [$jenis_laps ['id']] ['method'] = $this->laporanLkpnminInputMethod ($laps_kategori, $jenis_laps ['id'], $jenis_laps ['freetext'], $user_group, ($lap_status) ? $lap_status ['status_pelaporan_id'] : 0 );
                    /*if($view_status_laporan [$jenis_laps ['id']] ['method'] == ''){
                        $view_status_laporan [$jenis_laps ['id']] ['notif'] = 'Laporan Belum Di Selesaikan';
                    } else {
                        $view_status_laporan [$jenis_laps ['id']] ['notif'] = $notif;
                    }*/
                    $view_status_laporan [$jenis_laps ['id']] ['notif'] = $notif;

                    $view_status_laporan [$jenis_laps ['id']] ['pesan'] = ($lap_status) ? $lap_status ['pesan'] : '';
				}
			}
        }
        return $view_status_laporan;
	}

	public function laporanLkpnHasInputLaporan($laps_kategori = 'input_profil',$user_group,$pdf = true)
	{
		$LAPORAN_REQUIRED = array (601,602);

		$laps = $this->laporanBumnHasLKPNLaporan();

		$view_status_laporan = array();

		foreach($laps as $jenis_laps){
            if (substr ( $this->bumn_id, 0, 2 ) != '01' and ($jenis_laps ['id'] == 305 or $jenis_laps['id'] == 492)) {
				//do nothing
			}else{
                if (($this->is_pso != 1) && ($jenis_laps['id'] == 498) ){
					//do nothing
				}/*elseif (($this->is_tbk != 1) && ($jenis_laps['id'] == 495) ){
					//do nothing
				}*/
				elseif (($this->bumn_id == 3301) && ($jenis_laps['id'] == 240)){
				    //var_dump($jenis_laps['id']);
				}
				elseif (($this->is_tbk == 1) && ($jenis_laps['id'] == 240) ){
					//do nothing
                    //var_dump($jenis_laps['id']);
				}else{
				    $lap_status = $this->laporanBumnLkpnHasInputLaporan( $jenis_laps ['id'] );
                    //var_dump($lap_status);
                    
                    if ($user_group == 20000 || $user_group == 1) {
					   
                        
						if ($lap_status['status_pelaporan_id'] == 5) {
							$status = 'INVALID';
							$notif = 'Terjadi Kesalahan';
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							/*$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED ) && $lap_status ['status_pelaporan_id'] == 10) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
                            //echo $jenis_lap_nama;
                            //$status = 'INPROGRESS';
                            if($lap_status['status_pelaporan_id'] == 5){
                            	$lap_status['nama'] = 'INVALID';
                            }
                            
							$status = ($pdf) ? $lap_status ['nama'] : 'INPROGRESS';
                            if($lap_status ['tanggal'] == ''){
                                $notif = '';
                            } else {
                                $notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
                            }*/
                            
                            //$status = 'VERIFIED';
                            //echo $status;
                            //var_dump($jenis_laps);
                            
						} elseif($lap_status['status_pelaporan_id'] == 10){
							$status = 'INPROGRESS';
							$notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif($lap_status['status_pelaporan_id'] == 20){
							$status = 'UNVERIFIED';
							$notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif ($lap_status['status_pelaporan_id'] == 40) {
							$status = 'VERIFIED';
							$notif = 'Verifikasi Selesai';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} else {
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							$status = 'UNFILLED';
                            //$notifikasi = 'Menunggu Verfikasi Kementerian BUMN';
						}
						//if ($user_group == 20000)
					} else if (($user_group == 60000 || $user_group == 700 || $user_group == 1)) {
						if ($lap_status['status_pelaporan_id'] == 5) {
							$status = 'INVALID';
							$notif = 'Terjadi Kesalahan';
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							/*if ($pdf) {
								$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED ) && $lap_status ['status_pelaporan_id'] <= 40) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
								$status = $lap_status ['nama'];
                                $notif = '<font color="green">Siap Diverifikasi</font>';
							} else {
								$jenis_lap_nama = $jenis_laps ['nama'];
								$status = 'INPOGRESS';
                                $notif = '<font color="red">Berkas PDF Belum Lengkap (Siap Diverifikasi)</font>';
							}*/

						} elseif ($lap_status['status_pelaporan_id'] == 10) {
							$status = 'INPROGRESS';
							$notif = 'Laporan Belum Lengkap';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif ($lap_status['status_pelaporan_id'] == 20) {
							$status = 'UNVERIFIED';
							$notif = 'Siap Diverifikasi';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif ($lap_status['status_pelaporan_id'] == 40) {
							$status = 'VERIFIED';
							$notif = 'Verifikasi Selesai';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} else {
							$jenis_lap_nama = $jenis_laps ['nama'];
							$status = 'UNFILLED';
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
                            //$notifikasi = 'Siap Untuk Diverifikasi';
						}
					}
                    
					$view_status_laporan [$jenis_laps ['id']] ['nama'] = $jenis_lap_nama;
					$view_status_laporan [$jenis_laps ['id']] ['status'] = $status;
					$view_status_laporan [$jenis_laps ['id']] ['user'] = ($lap_status) ? $lap_status ['users_login'] : '';
					$view_status_laporan [$jenis_laps ['id']] ['tanggal'] = ($lap_status) ? $lap_status ['tanggal'] : '';
					                    
					$view_status_laporan [$jenis_laps ['id']] ['method'] = $this->laporanLkpnInputMethod ($laps_kategori, $jenis_laps ['id'], $jenis_laps ['freetext'], $user_group, ($lap_status) ? $lap_status ['status_pelaporan_id'] : 0 );
                    /*if($view_status_laporan [$jenis_laps ['id']] ['method'] == ''){
                        $view_status_laporan [$jenis_laps ['id']] ['notif'] = 'Laporan Belum Di Selesaikan';
                    } else {
                        $view_status_laporan [$jenis_laps ['id']] ['notif'] = $notif;
                    }*/
                    $view_status_laporan [$jenis_laps ['id']] ['notif'] = $notif;

                    $view_status_laporan [$jenis_laps ['id']] ['pesan'] = ($lap_status) ? $lap_status ['pesan'] : '';
				}
			}
        }
        return $view_status_laporan;
	}

        //penambahan untuk akses periode_jenis_lap by annas
        
        public function inputMethod($jenis_lap_id, $freetext=false, $user_group, $status_laporan_id=NULL,$data_pdf){
            require_once 'akunBumnModel.php';
            $akunBumnModel = new akunBumnModel ($this->bumn_id, $jenis_lap_id, $this->tahun, $this->periode_id );

            list($lengkap, $data) = $this->laporanBumnHasLaporanPdf();

            $admin = $this->pengantarbumn();

            if($this->tahun >= 2015){

            	$ceksurat = ($admin[0]['tgl_surat'])?true:false;
            } else {

            	$ceksurat = true;
            }

            //$ceksurat = ($admin[0]['tgl_surat'])?true:false;

            $method = '';

            if (($user_group == 20000 || $user_group == 1) && $status_laporan_id <= 20){
                //user admin BUMN dan super eis
                if ($jenis_lap_id > 100 && $jenis_lap_id < 300)  {
                    //input penilaian kinerja dan profil
                    $method = '<a type="button" href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'" class="btn btn-default btn-xs"><b>WEB</b></a>';
                }  elseif ($jenis_lap_id > 300 && $jenis_lap_id < 400) {
                    //input untuk laporan keuangan

                    if ($jenis_lap_id == 301 || $jenis_lap_id == 302 || $jenis_lap_id == 303){
                        $cekakun = $akunBumnModel->akunBumnHasIsi3($this->tahun, $this->periode_id,$jenis_lap_id,$this->bumn_id);
                    }

                    if($jenis_lap_id == 321){
                    	//$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'" class="btn btn-default btn-xs"><b>WEB</b></a>';
                    	$method = '<a href="/keuangan/capex" class="btn btn-default btn-xs"><b>WEB</b></a>';
                    } elseif ($jenis_lap_id == 311) {
                    	$method = '<a href="/laporan/keurkapusulan" class="btn btn-default btn-xs"><b>WEB</b></a>';
                    } else {
                    	if ($cekakun != 0){
	                        $method = '<a href="/laporan/generate/method/download/type/xls/jid/' . $jenis_lap_id . '" class="btn btn-default btn-xs"><b>DOWNLOAD</b></a> ';
				$method .= '<b>|</b> <a href="/laporan/generate/method/upload/type/xls/jid/' . $jenis_lap_id . '" class="btn btn-default btn-xs"><b>UPLOAD</b></a> ';
	                    } else {
	                        $method = 'Template Belum Tersedia, Harap Hubungi Kementerian BUMN';
	                    }
                    }
                                        
                } elseif ($jenis_lap_id > 400 && $jenis_lap_id < 500) {
                    //input laporan operasional
                    if ($jenis_lap_id == 410 || $jenis_lap_id == 430 || $jenis_lap_id == 470) {
                        $cekakun = $akunBumnModel->akunBumnHasIsi3($this->tahun, $this->periode_id,$jenis_lap_id,$this->bumn_id);
                        if ($cekakun != 0){
                            $method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '" class="btn btn-default btn-xs">Web</a> ';
                            $method .= '<b>|</b> <a href="/laporan/generatenonkeu/method/download/type/xls/jid/' . $jenis_lap_id . '"><b>DOWNLOAD</b></a> ';
			    $method .= '<b>|</b> <a href="/laporan/generatenonkeu/method/upload/type/xls/jid/' . $jenis_lap_id . '" class="btn btn-default btn-xs"><b>UPLOAD</b></a> ';
                        } else {
                            $method = '<a href="/admin/akunbumnnonkeu/bumn_id/'.$this->bumn_id.'/jenis_lap_id/'.$jenis_lap_id.'/periode_id/'.$this->periode_id.'/tahun/'.$this->tahun.'/lanjut/1"><b>Buat Template Akun</b></a> ';
			}
                    } else {
			$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
                    }
                }  elseif ($jenis_lap_id > 500 && $jenis_lap_id < 600) {
                    //kontribusi kepada negara
                    if ($jenis_lap_id == 510) {
                        //$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'" class="btn btn-default btn-xs"><b>WEB</b> </a>';
                        $method = '<a href="/keuangan/pajak/" class="btn btn-default btn-xs"><b>WEB</b> </a>';
                    } elseif ($jenis_lap_id == 520) {
                        $method .= '<a href="/dividen/penetapan/" class="btn btn-default btn-xs"><b>PENETAPAN</b></a> ';
                        $method .= '| <a href="/dividen/setoran/" class="btn btn-default btn-xs"><b>PENYETORAN</b></a> ';
                    }
                } elseif ($jenis_lap_id > 800 && $jenis_lap_id < 900) {
                    //pdf
                    foreach ($data_pdf as $value) {
                        if ($value['jenis_lap_id'] == $jenis_lap_id) {

                        	//href="/profil/viewpdfprofile?file='.$value['file'].'" target="_blank"

                        	//$file = '<a class="modalButton" data-toggle="modal" data-src="http://www.youtube.com/embed/Oc8sWN_jNF4?rel=0&wmode=transparent&fs=0" data-height=320 data-width=450 data-target="#myModal">Click me</a>';
                        	//$test = onviewfile(\''.$value['file'].'\');

                            $file =($value['file'])?'<a style="cursor:pointer" onclick="onviewfile(\''.$value['file'].'\');" class="btn btn-default btn-xs"><b>Lihat Berkas</b></a>':'<font color="red"><b>PDF Not Found.</b></font> ';
                            $deletefile = ($value['file'])?'<a style="cursor:pointer" onclick="deletefilepdf(\''.$value['file'].'\','.$jenis_lap_id.');" class="btn btn-default btn-xs"<b>Hapus Berkas</b></a>':' ';
                            $upload = ($value['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$value['id'].'/lapid/'.$jenis_lap_id.'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$value['id'].'/lapid/'.$jenis_lap_id.'">Upload Berkas</a>';
                            
                            $htmlupload = ($value['file'])?'<button data-target="#laporanPDF'.$value['id'].'" data-toggle="modal" class="btn btn-default btn-xs" type="button"><b>Ubah Berkas</b>
</button>':'<button data-target="#laporanPDF'.$value['id'].'" data-toggle="modal" class="btn btn-default btn-xs" type="button"><b>Upload Berkas</b>
</button>';

                            $htmlupload .= '
                            <div class="modal fade" id="laporanPDF'.$value['id'].'" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel">
							  <div class="modal-dialog" role="document">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h4 class="modal-title" id="myModalLabel">Upload Laporan PDF</h4>
							        <div id="notifikasi"></div>
							      </div>
							      <div class="modal-body">
							        <fieldset style="width: 100%;" class="panel">
										<div class="panel panel-primary">
										    <div class="panel-body">
										      <form method="post" id="uploadpdf" name="uploadpdf">
												   <div class="form-group">
												   	   <label class="col-sm-2 control-label">Berkas PDF</label><div class="col-sm-2"><input type="file" id="lappdf'.$value['id'].'" name="lappdf'.$value['id'].'"></div>
												   </div>
												  <button type="button" value="Lanjut" onclick="uploadproses(\'pdf\',\''.$value['id'].'\',\''.$jenis_lap_id.'\')" class="btn btn btn-warning">Upload</button>
												  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
												  
												</form>
										    </div>
										  </div>
									</fieldset>
							      </div>
							    </div>
							  </div>
							</div>';

							$method .= $file.' '.$deletefile.' '.$htmlupload;

							//$method .= $file.' | '.$upload;

                            break;
                        }
                    }   
                }
            }  elseif (($ceksurat && $lengkap) && ($status_laporan_id >= 20 && $status_laporan_id < 40)  && $user_group == 700) {
                //untuk verifikasi
                if ($jenis_lap_id > 100 && $jenis_lap_id < 300)  {
                    //input penilaian kinerja dan profil
                    $method = '<a href="/profil/j' . $jenis_lap_id . '">Verifikasi</a>';
                } elseif ($jenis_lap_id > 300 && $jenis_lap_id < 400) {

                	if($jenis_lap_id == 321){
                		$method = '<a href="/keuangan/capex" class="btn btn-default btn-xs">Verifikasi</a>';
                	} elseif ($jenis_lap_id == 311) {
                		$method = '<a href="/laporan/keurkapusulan" class="btn btn-default btn-xs">Verifikasi</a>';
                	} else {
                		$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">verifikasi</a> ';
                	}
                    //$method = ($jenis_lap_id == 321) ? '<a href="/keuangan/capex" class="btn btn-default btn-xs"><b>WEB</b></a>' : '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">verifikasi</a> ';
                } /*elseif ($jenis_lap_id == 311) {
                    	$method = '<a href="/laporan/keurkapusulan" class="btn btn-default btn-xs"><b>WEB</b></a>';
                } */elseif ($jenis_lap_id > 400 && $jenis_lap_id < 500) {
                    if ($akunBumnModel->akunBumnHasFreeText ()){
                        $method = '<input type="button" class="inputsubmit" onclick="verifikasi();" value="Verifikasi">';
                    } else {
                        $method = '<input type="button" class="inputsubmit" onclick="verifikasi();" value="Verifikasi">';
                    }                    
                } elseif ($jenis_lap_id > 500 && $jenis_lap_id < 600) {
                    if ($jenis_lap_id == 520){
                        $method .= '<a href="/dividen/penetapan/"><b>PENETAPAN</b></a> ';
                        $method .= '| <a href="/dividen/setoran/"><b>PENYETORAN</b></a> ';
                    }
                    if ($jenis_lap_id == 510) {
                        //$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'"><b>verifikasi</b> </a>';
                        $method = '<a href="/keuangan/pajak/"><b>verifikasi</b> </a>';
                    }                    
                } elseif ($jenis_lap_id > 800 && $jenis_lap_id < 900) {
                    foreach ($data_pdf as $value) {
                        if ($value['jenis_lap_id'] == $jenis_lap_id) {
                            //$file =($value['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$value['file'].'\')" ><img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> ';
                            //$file =($value['file'])?'<a style="cursor:pointer" onclick="onviewfile(\''.$value['file'].'\');" class="btn btn-default btn-xs">Lihat Berkas</a>':'<font color="red"><b>PDF Not Found.</b></font> ';
                            $file = ($value['file'])?'<a onclick="location.href=\'/generated/pdf/file/' . $value['file'] . '\'" class="btn btn-default btn-xs">Lihat Berkas</a>':'<font color="red"><b>PDF Not Found.</b></font> '; 
                            /*$upload = ($value['file'])?'<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myVerifikasi" id="tolakbutton">Verifikasi
</button>':'PDF belum diupload';*/
							/* <input type="button" value="Ditolak" onclick="verifikasilapbatal('do','301');" class="btn btn-danger">*/
							$upload = ($value['file'])?' <input type="button" class="btn btn-success btn-xs" onclick="verifikasilapproses(\''.$jenis_lap_id.'\');" value="Diterima"> <button  type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myVerifikasi">Ditolak</button> <input id="do" type="hidden" name="do" value="do"><input id="jenislap" type=hidden name="jenislap" value="'.$jenis_lap_id.'">':'PDF belum diupload';
                            $method .= $file.' '.$upload;
                            break;
                        }
                    }
                }                 
            } elseif(($ceksurat && $lengkap) && $status_laporan_id == 40 && ($user_group == 700 || $user_group == 1)) {
            	if ($jenis_lap_id > 800 && $jenis_lap_id < 900) {
            		foreach ($data_pdf as $value) {
                        if ($value['jenis_lap_id'] == $jenis_lap_id) {
                            //$file =($value['file'])?'<a style="cursor:pointer" onclick="onviewfile(\''.$value['file'].'\');" class="btn btn-default btn-xs">Lihat Berkas</a>':'<font color="red"><b>PDF Not Found.</b></font> ';
                            $file = ($value['file'])?'<a onclick="location.href=\'/generated/pdf/file/' . $value['file'] . '\'" class="btn btn-default btn-xs">Lihat Berkas</a>':'<font color="red"><b>PDF Not Found.</b></font> ';
                            $deletefile = ($value['file'])?'<a style="cursor:pointer" onclick="deletefilepdf(\''.$value['file'].'\','.$jenis_lap_id.');" class="btn btn-default btn-xs">Hapus Berkas</a>':' ';
                            $method = $file.$deletefile.' <button class="btn btn-danger btn-xs" type="button" onclick="verifikasicancel('.$jenis_lap_id.');">BATAL VERIFIKASI</button>';
                            
                            break;
                        }
                    }
            	} else {
            		$method = '<button class="btn btn-danger btn-xs" type="button" onclick="verifikasicancel('.$jenis_lap_id.');">BATAL VERIFIKASI</button>';
            	}
                /*----batal verifikasi----*/
                //$method = '<button class="btn btn-danger btn-xs" type="button" onclick="verifikasicancel('.$jenis_lap_id.');">BATAL VERIFIKASI</button>';
            } elseif (($ceksurat && $lengkap) && $status_laporan_id == 40 && $user_group == 20000) {
            	if ($jenis_lap_id > 800 && $jenis_lap_id < 900) {
            		foreach ($data_pdf as $value) {
                        if ($value['jenis_lap_id'] == $jenis_lap_id) {
                            //$file =($value['file'])?'<a style="cursor:pointer" onclick="onviewfile(\''.$value['file'].'\');" class="btn btn-default btn-xs">Lihat Berkas</a>':'<font color="red"><b>PDF Not Found.</b></font> ';
                            $file = ($value['file'])?'<a onclick="location.href=\'/generated/pdf/file/' . $value['file'] . '\'" class="btn btn-default btn-xs">Lihat Berkas</a>':'<font color="red"><b>PDF Not Found.</b></font> ';
                            $method = $file;
                            
                            break;
                        }
                    }
            	}
            }
        return $method;
    }
        
        public function kategoriLaporan() {
            $sql = 'SELECT pjl.*, jl.nama, jl.heading
                    FROM periode_jenis_lap pjl LEFT JOIN jenis_lap jl ON jl."id" = pjl.jenis_lap_id
                    WHERE periode_id = '.$this->periode_id.' '
                    . ' ORDER BY pjl.jenis_lap_id ASC';
            $row = $this->db->FetchAll( $sql );
            return $row;
        }

        public function cekKategoriLaporan($bumn_id,$periode,$jid,$tahun) {
            /*$sql = 'SELECT
						A .bumn_id,
						A .jenis_lap_id,
						CASE when a.status_pelaporan_id = 5 then \'INVALID\'
												 when a.status_pelaporan_id = 10 then \'INPROGRESS\'
												 when a.status_pelaporan_id = 20 then \'UNVERIFIED\'
												 when a.status_pelaporan_id = 40 then \'VERIFIED\'
												 else \'UNFILLED\'
					  END as status,
						A .pesan,
						b.required
					FROM
						status_pemasukan_bumn A,
						periode_jenis_lap B
					WHERE
						A .periode_id = b.periode_id
					AND A .jenis_lap_id = b.jenis_lap_id
					AND A .tahun = '.$tahun.'
					AND A .periode_id = '.$periode.'
					AND A .bumn_id = \''.$bumn_id.'\'
					AND A .jenis_lap_id = '.$jid.'; ';*/


					$sql = 'SELECT
						A .bumn_id,
						A .jenis_lap_id,
						A .status_pelaporan_id,
						A .pesan,
						A .tanggal,
						b.required
					FROM
						status_pemasukan_bumn A,
						periode_jenis_lap B
					WHERE
						A .periode_id = b.periode_id
					AND A .jenis_lap_id = b.jenis_lap_id
					AND A .tahun = '.$tahun.'
					AND A .periode_id = '.$periode.'
					AND A .bumn_id = \''.$bumn_id.'\'
					AND A .jenis_lap_id = '.$jid.'; ';

			//echo $sql;
            $row = $this->db->FetchAll( $sql );
            return $row;
        }
        
        public function viewInputLaporanBumn($user_group) {
            $laporan = $this->kategoriLaporan();
            $status_laporan = array();
            $data = $this->getPDFlaporan();
            //echo "<pre>"; print_r($laporan);die();

            foreach($laporan as $lap){
                 $postfix = '';
                 $lap_status = $this->laporanBumnHasInputLaporan ($lap['jenis_lap_id']);
                 $status = $lap_status['nama'];
                 switch ($lap_status['status_pelaporan_id']) {
                     case 5: //invalid
                         $notif = 'Lihat Kolom Pesan untuk melihat hasil verifikasi';
                         $status = ' <font color="red"><b>INVALID</b></font>';
                         break;
                     case 10: //inprogress
                         $notif = '<font color="orange">Pengisian Laporan Belum selesai</font>';
                         $status = ' <font color="brown"><b>INPROGRESS</b></font>';
                         break;
                     case 20: //unverified
                         if ($user_group == 20000 || $user_group == 1) {
                            $notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
                         }elseif ($user_group == 60000 || $user_group == 700) {
                            $notif = 'Laporan Siap diverifikasi';
                         }
                         $status = ' <font color="brown"><b>UNVERIFIED</b></font>';			
                         break;
                     case 40: //verified
                         $notif = 'Verifikasi Selesai';
                         $status = ' <font color="green"><b>VERIFIED</b></font>';
                         break;
                     default: //unfilled
                         
                         $status = ($lap['heading']? '':'<font color="black"><b>UNFILLED</b></font>');
                         $postfix = ($lap['required']? '<font color="red"><b>*</b></font>' : '');                         
                         break;
                }

                if (($lap['periode_id'] == 7 || $lap['periode_id'] == 10) && $lap['jenis_lap_id'] == 809 ) {
                    $nama = 'RKAP';
                } else {
                    $nama = $lap['nama'];
                }


            	$status_laporan [$lap ['jenis_lap_id']] ['nama'] = $nama.$postfix;
                $status_laporan [$lap ['jenis_lap_id']] ['status'] = $status;
                $status_laporan [$lap ['jenis_lap_id']] ['user'] = ($lap_status) ? $lap_status ['users_login'] : '';
                $status_laporan [$lap ['jenis_lap_id']] ['tanggal'] = ($lap_status) ? $lap_status ['tanggal'] : '';

                /*if(($user_group == 20000 || $user_group == 1) && $lap_status['status_pelaporan_id'] == 20 && $srt == 't'){
                	 $status_laporan [$lap ['jenis_lap_id']] ['method'] = '';
                } else {
                	 $status_laporan [$lap ['jenis_lap_id']] ['method'] = $this->inputMethod($lap['jenis_lap_id'], NULL, $user_group, ($lap_status) ? $lap_status ['status_pelaporan_id'] : 0,$data);
                }*/

                $status_laporan [$lap ['jenis_lap_id']] ['method'] = $this->inputMethod($lap['jenis_lap_id'], NULL, $user_group, ($lap_status) ? $lap_status ['status_pelaporan_id'] : 0,$data);
                $status_laporan [$lap ['jenis_lap_id']] ['heading'] = $lap['heading'];
                $status_laporan [$lap ['jenis_lap_id']] ['pesan'] = ($lap_status) ? $lap_status ['pesan'] : '';
                $status_laporan [$lap ['jenis_lap_id']] ['notif'] = ($lap['heading']? ' ' : $notif);
                


       
            }
            return $status_laporan;
         
        }
        
        public function saveStatusPemasukanpdf($jenis_lap_id, $status_id, $tahun, $periode_id ) {
            $account = 'Admin FIS';
          //  $sql = 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$tahun.' and periode_id = '.$periode_id.'  and status_pelaporan_id = 20;';
           // $sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$tahun.' and periode_id = '.$periode_id.'  and status_pelaporan_id = 5;';
           // $sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$tahun.' and periode_id = '.$periode_id.'  and status_pelaporan_id = 10;';
          //  $sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$tahun.' and periode_id = '.$periode_id.'  and status_pelaporan_id = 40;';
           // $sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$tahun.' and periode_id = '.$periode_id.'  and status_pelaporan_id = '.$status_id.' and users_login = \''.$account.'\';';
            $sql = 'insert into status_pemasukan_bumn(bumn_id, jenis_lap_id, status_pelaporan_id, tahun, periode_id, tanggal, users_login)
                                    values(\'' . $this->bumn_id . '\', ' . $jenis_lap_id . ', ' . $status_id . ', ' . $tahun . ', ' . $periode_id . ', now(), \'' . $account . '\');';
            echo ($sql); //die();
           // $this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}
    
       
         public function getPDFtahunperiode($tahun,$periode) {
            require_once 'bumnModel.php';
            //$bumnModel = new bumnModel ( $this->bumn_id, $tahun, $periode );
            
            $sql = 'select id2 from bumn_fis where tahun = 2014 and periode_id = 6 and id=\'' . $this->bumn_id . '\'';
            
            $bumns = $this->db2->GetRow($sql);
            $bumn_id2 = $bumns['id2'];
            $sql = 'SELECT ap."id", ap.nama, ap.jenis_lap_id FROM attachment_pdf ap, periode_jenis_lap pjl 
                    WHERE ap.jenis_lap_id = pjl.jenis_lap_id AND pjl.periode_id ='.$this->periode_id;
             
            $row = $this->db->fetchAll($sql);  
            $files =$row;
            $data = array();               
            foreach ($files as $pdf) {
                $file_name = $bumn_id2 . '-' . $tahun . '-' . $periode . '-' . $pdf['id'] . '.pdf';
                $file = Globals::getConfig ()->dirs->upload . $file_name;

                if (! file_exists ( $file )) {
                       // $returnValue [] = 0;
                        $file_name = false;
                }

                $temp['id'] = $pdf['id'];
                $temp['nama'] = $pdf['nama'];
                $temp['file'] = $file_name;
                $temp['periode_id'] = $periode;
                $temp['jenis_lap_id'] = $pdf['jenis_lap_id'];
                $data [] = $temp;
            }
          
            return $data;
            
        }
        
         //cek pdf bumn by annas
        public function getPDFlaporan() {
            require_once 'bumnModel.php';
            $bumnModel = new bumnModel ( $this->bumn_id, $this->tahun, $this->periode_id );
            $bumns = $bumnModel->getId2Bumn();
            $bumn_id2 = $bumns['id2'];
          
            $files = $this->getPDFid();
            $data = array();               
            foreach ($files as $pdf) {
                $file_name = $bumn_id2 . '-' . $this->tahun . '-' . $this->periode_id . '-' . $pdf['id'] . '.pdf';
                $file = Globals::getConfig ()->dirs->upload . $file_name;

                if (! file_exists ( $file )) {
                       // $returnValue [] = 0;
                        $file_name = false;
                }

                $temp['id'] = $pdf['id'];
                $temp['nama'] = $pdf['nama'];
                $temp['file'] = $file_name;
                $temp['jenis_lap_id'] = $pdf['jenis_lap_id'];
                $data [] = $temp;
            }
          
            return $data;
            
        }
        
        public function getPDFid(){
            $sql = 'SELECT ap."id", ap.nama, ap.jenis_lap_id FROM attachment_pdf ap, periode_jenis_lap pjl
                    WHERE ap.jenis_lap_id = pjl.jenis_lap_id AND pjl.periode_id ='.$this->periode_id;
             
            $row = $this->db->fetchAll($sql);
            return $row;
        }
        public function getPdfNamaByJenisLap($jenis_lap_id){
            $sql = 'SELECT nama FROM attachment_pdf WHERE jenis_lap_id ='.$jenis_lap_id;
            $row = $this->db->fetchRow($sql);
            return $row;
        }
        
    public function laporanBumnHasViewInputLaporan($laps_kategori = 'input_profil',$user_group,$pdf = true,$rest)
    {
	if($this->periode_id == 6 || $this->periode_id == 2){
	    if($this->is_tbk == 1) {
	      $LAPORAN_REQUIRED = array (110,120,130,140,150,210, 220, 250, 301, 302, 303,321, 510,520);
	    } else {
	      $LAPORAN_REQUIRED = array (110,120,130,140,150,210, 220, 250, 301, 302, 303,321, 510,520);
	    }
        } else {
            $LAPORAN_REQUIRED = array (210,220,250,301, 302, 303,321,510);
        }
        
        $laps = $this->laporanBumnHasKategoriLaporan($laps_kategori);
        $view_status_laporan = array();
      
        foreach($laps as $jenis_laps){
            if (substr ( $this->bumn_id, 0, 2 ) != '01' and ($jenis_laps ['id'] == 305 or $jenis_laps['id'] == 492)) {
				//do nothing
            } else {
                if (($this->is_pso != 1) && ($jenis_laps['id'] == 498) ){
					//do nothing
		} elseif (($this->bumn_id == 3301) && ($jenis_laps['id'] == 240) && ($jenis_laps['id'] == 140)){
				
                    } elseif (($this->is_tbk == 1) && ($jenis_laps['id'] == 240) && ($jenis_laps['id'] == 140)){
					//do nothing
                        }elseif (($jenis_laps['id'] == 602) && ($jenis_laps['id'] == 601) ){
					//do nothing
                            }else{
				    $lap_status = $this->laporanBumnHasInputLaporan ( $jenis_laps ['id'] );
                    //var_dump($lap_status);
                    
                                if ($user_group == 20000 || $user_group == 1) {
                                    if ($lap_status['status_pelaporan_id'] == 5) {
					$status = 'INVALID';
					$notif = 'Terjadi Kesalahan';

					if($jenis_laps['id'] == 901 || $jenis_laps['id'] == 902 || $jenis_laps['id'] == 903 || $jenis_laps['id'] == 904){
                                            $jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">**</font>' : $jenis_laps ['nama'];
                                            } elseif ($jenis_laps['id'] == 905 || $jenis_laps['id'] == 906 || $jenis_laps['id'] == 907 || $jenis_laps['id'] == 908 || $jenis_laps['id'] == 909) {
                                                    $jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">***</font>' : $jenis_laps ['nama'];
                                                    } else {
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
                                                    }

							
                            
					} elseif($lap_status['status_pelaporan_id'] == 10){
                                                $status = 'INPROGRESS';
						$notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
						$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif($lap_status['status_pelaporan_id'] == 20){
							$status = 'UNVERIFIED';
							$notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
							$jenis_lap_nama = $jenis_laps ['nama'];
                                                         } elseif ($lap_status['status_pelaporan_id'] == 40){
                                                            $status = 'VERIFIED';
                                                            $notif = 'Verifikasi Selesai';
                                                            $jenis_lap_nama = $jenis_laps ['nama'];
                                                            } else {
                                                                if($jenis_laps['id'] == 901 || $jenis_laps['id'] == 902 || $jenis_laps['id'] == 903 || $jenis_laps['id'] == 904){
                                                                    $jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">**</font>' : $jenis_laps ['nama'];
                                                                } elseif ($jenis_laps['id'] == 905 || $jenis_laps['id'] == 906 || $jenis_laps['id'] == 907 || $jenis_laps['id'] == 908 || $jenis_laps['id'] == 909) {
                                                                    $jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">***</font>' : $jenis_laps ['nama'];
                                                                     } else {
                                                                        $jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
                                                                     }
							
                                                                $status = 'UNFILLED';
                                                             //   $notifikasi = ' ';
                                                            }
						//if ($user_group == 20000)
				} else if (($user_group == 60000 || $user_group == 700)) {
                                            if ($lap_status['status_pelaporan_id'] == 5) {
						$status = 'INVALID';
						$notif = 'Terjadi Kesalahan';
						$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
                                            } elseif ($lap_status['status_pelaporan_id'] == 10) {
                                                    $status = 'INPROGRESS';
                                                    $notif = 'Laporan Belum Lengkap';
                                                    $jenis_lap_nama = $jenis_laps ['nama'];
                                                    } elseif ($lap_status['status_pelaporan_id'] == 20) {
                                                            $status = 'UNVERIFIED';
                                                            $notif = 'Siap Diverifikasi';
                                                            $jenis_lap_nama = $jenis_laps ['nama'];
                                                            } elseif ($lap_status['status_pelaporan_id'] == 40) {
                                                                $status = 'VERIFIED';
                                                                $notif = 'Verifikasi Selesai';
                                                                $jenis_lap_nama = $jenis_laps ['nama'];
                                                                } else {
                                                                   // $jenis_lap_nama = $jenis_laps ['nama'];
                                                                    $status = 'UNFILLED';
                                                                    $jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
                            //$notifikasi = 'Siap Untuk Diverifikasi';
                                                                }
					}

				$view_status_laporan [$jenis_laps ['id']] ['nama'] = $jenis_lap_nama;
				$view_status_laporan [$jenis_laps ['id']] ['status'] = $status;
				$view_status_laporan [$jenis_laps ['id']] ['user'] = ($lap_status) ? $lap_status ['users_login'] : '';
				$view_status_laporan [$jenis_laps ['id']] ['tanggal'] = ($lap_status) ? $lap_status ['tanggal'] : '';
				$view_status_laporan [$jenis_laps ['id']] ['method'] = $this->laporanBumnInputMethod($rest,$laps_kategori, $jenis_laps ['id'], $jenis_laps ['freetext'], $user_group, ($lap_status) ? $lap_status ['status_pelaporan_id'] : 0 );
//                    
                               // if ($jenis_laps['id'] == 520) {
//                                 //   echo $user_group;die();                    
                                // $view_status_laporan [$jenis_laps ['id']] ['pesan'] = 'Pengisian dividen dapat dilakukan kembali pada tanggal 10 Juni 2015';
                              //} else {
                                $view_status_laporan [$jenis_laps ['id']] ['pesan'] = ($lap_status) ? $lap_status ['pesan'] : '';
                               // }
                                $view_status_laporan [$jenis_laps ['id']] ['notif'] = $notif;
                   	
				}
			}
        }
        return $view_status_laporan;
    }

    public function laporanBumnHasViewInputAoLaporan($laps_kategori = 'input_profil',$user_group,$pdf = true,$rest)
    {
		
        if($this->periode_id == 6){
		    if($this->is_tbk == 1) {
		      $LAPORAN_REQUIRED = array (290);
		    } else {
		      $LAPORAN_REQUIRED = array (290);
		    }
        } else {
            $LAPORAN_REQUIRED = array (290);
        }
        
        $laps = $this->laporanBumnHasKategoriLaporanAo($laps_kategori);
        
        //var_dump($laps);
        
        $view_status_laporan = array();
        
        foreach($laps as $jenis_laps){
            if (substr ( $this->bumn_id, 0, 2 ) != '01' and ($jenis_laps ['id'] == 305 or $jenis_laps['id'] == 492)) {
				//do nothing
			}else{
                if (($this->is_pso != 1) && ($jenis_laps['id'] == 498) ){
					//do nothing
				}/*elseif (($this->is_tbk != 1) && ($jenis_laps['id'] == 495) ){
					//do nothing
				}*/
				elseif (($this->bumn_id == 3301) && ($jenis_laps['id'] == 240) && ($jenis_laps['id'] == 140)){
				    //var_dump($jenis_laps['id']);
				}
				elseif (($this->is_tbk == 1) && ($jenis_laps['id'] == 240) && ($jenis_laps['id'] == 140)){
					//do nothing
                    //var_dump($jenis_laps['id']);
				}elseif (($jenis_laps['id'] == 602) && ($jenis_laps['id'] == 601) ){
					//do nothing
                    //var_dump($jenis_laps['id']);
				}else{
				    $lap_status = $this->laporanBumnHasInputLaporan ( $jenis_laps ['id'] );
                    //var_dump($lap_status);
                    
                    if ($user_group == 20000 || $user_group == 1) {
					   
                        
						if ($lap_status['status_pelaporan_id'] == 5) {
							$status = 'INVALID';
							$notif = 'Terjadi Kesalahan';

							if($jenis_laps['id'] == 901 || $jenis_laps['id'] == 902 || $jenis_laps['id'] == 903 || $jenis_laps['id'] == 904){
								$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">**</font>' : $jenis_laps ['nama'];
							} elseif ($jenis_laps['id'] == 905 || $jenis_laps['id'] == 906 || $jenis_laps['id'] == 907 || $jenis_laps['id'] == 908 || $jenis_laps['id'] == 909) {
								$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">***</font>' : $jenis_laps ['nama'];
							} else {
								$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							}

							//$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							/*$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED ) && $lap_status ['status_pelaporan_id'] == 10) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
                            //echo $jenis_lap_nama;
                            //$status = 'INPROGRESS';
                            if($lap_status['status_pelaporan_id'] == 5){
                            	$lap_status['nama'] = 'INVALID';
                            }
                            
							$status = ($pdf) ? $lap_status ['nama'] : 'INPROGRESS';
                            if($lap_status ['tanggal'] == ''){
                                $notif = '';
                            } else {
                                $notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
                            }*/
                            
                            //$status = 'VERIFIED';
                            //echo $status;
                            //var_dump($jenis_laps);
                            
						} elseif($lap_status['status_pelaporan_id'] == 10){
							$status = 'INPROGRESS';
							$notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif($lap_status['status_pelaporan_id'] == 20){
							$status = 'UNVERIFIED';
							$notif = '<font color="orange">Menunggu Verifikasi Kementerian BUMN</font>';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} elseif ($lap_status['status_pelaporan_id'] == 40){
							$status = 'VERIFIED';
							$notif = 'Verifikasi Selesai';
							$jenis_lap_nama = $jenis_laps ['nama'];
						} else {
							if($jenis_laps['id'] == 901 || $jenis_laps['id'] == 902 || $jenis_laps['id'] == 903 || $jenis_laps['id'] == 904){
								$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">**</font>' : $jenis_laps ['nama'];
							} elseif ($jenis_laps['id'] == 905 || $jenis_laps['id'] == 906 || $jenis_laps['id'] == 907 || $jenis_laps['id'] == 908 || $jenis_laps['id'] == 909) {
								$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">***</font>' : $jenis_laps ['nama'];
							} else {
								$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							}
							//$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							$status = 'UNFILLED';
                            $notifikasi = ' ';
						}
						//if ($user_group == 20000)
					}

					$view_status_laporan [$jenis_laps ['id']] ['nama'] = $jenis_lap_nama;
					
					                    
					$view_status_laporan [$jenis_laps ['id']] ['method'] = $this->laporanBumnInputAoMethod($rest,$laps_kategori, $jenis_laps ['id'], $jenis_laps ['freetext'], $user_group, ($lap_status) ? $lap_status ['status_pelaporan_id'] : 0 );
                   
				}
			}
        }
        return $view_status_laporan;
    }

	public function laporanBumnHasViewStatusLaporan($laps_kategori = 'input_profil', $user_group, $pdf = true) {

		if($_SESSION['USERS_HAS_FIS']['FIS_ACCOUNT']=='sys_eis' || $_SESSION['USERS_HAS_FIS']['FIS_ACCOUNT']=='zalfriej' || $_SESSION['USERS_HAS_FIS']['FIS_ACCOUNT']=='super_eis'){
			$LAPORAN_REQUIRED = array (210, 220, 250, 301, 302, 303, 410, 430, 455, 460, 495, 510 );
		} else {
			if($this->periode_id == 6){
			    if($this->is_tbk == 1) {
			      $LAPORAN_REQUIRED = array (210, 220, 250, 301, 302, 303, 410, 430, 455, 460, 495, 510 );
			    } else {
			      $LAPORAN_REQUIRED = array (210, 220, 240, 250, 301, 302, 303, 410, 430, 455, 460, 495, 510 );
			    }
	        } else {
	            $LAPORAN_REQUIRED = array (301, 302, 303);
	        }
		}

		$laps = $this->laporanBumnHasKategoriLaporan ( $laps_kategori );
		//echo $this->is_tbk; print_r($laps);die();
        //echo '<pre>';
//        echo print_r($laps);
//        echo '</pre>';
		$view_status_laporan = array ();
        
		foreach ( $laps as $jenis_laps ) {
			//if (substr ( $this->bumn_id, 0, 2 ) != '01' and $jenis_laps ['id'] == 305) {           
			// echo '<pre>';
//        echo print_r($jenis_laps);
//        echo '</pre>';
//var_dump($jenis_laps['id']);
			if (substr ( $this->bumn_id, 0, 2 ) != '01' and ($jenis_laps ['id'] == 305 or $jenis_laps['id'] == 492)) {
				//do nothing
			}
			else {
				if (($this->is_pso != 1) && ($jenis_laps['id'] == 498) ){
					//do nothing
				}/*elseif (($this->is_tbk != 1) && ($jenis_laps['id'] == 495) ){
					//do nothing
				}*/
				elseif (($this->bumn_id == 3301) && ($jenis_laps['id'] == 240)){
				    //var_dump($jenis_laps['id']);
				}
				elseif (($this->is_tbk == 1) && ($jenis_laps['id'] == 240) ){
					//do nothing
                    //var_dump($jenis_laps['id']);
				}elseif (($jenis_laps['id'] == 601) || ($jenis_laps['id'] == 601) ){
					//do nothing
                    //var_dump($jenis_laps['id']);
				}
                else{
				    //var_dump($jenis_laps['id']);
					$lap_status = $this->laporanBumnHasStatusLaporan ( $jenis_laps ['id'] );
                    
                    //var_dump($jenis_laps['id']);

					if ($user_group == 20000 || $user_group == 1) {
					   
                        
                        //var_dump($jenis_laps['id']);
                        //if($jenis_laps['id'] == 240){
//                            echo 'ada';
//                        } else {
//                            echo 'ga ada';
//                        }
                        
						if ($lap_status) {
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED ) && $lap_status ['status_pelaporan_id'] == 10) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							$status = ($pdf) ? $lap_status ['nama'] : 'INPROGRESS';
                            //$status = 'VERIFIED';
						} else {
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							$status = 'UNFILLED';
						}
						//if ($user_group == 20000)
					} else if (($user_group == 60000 || $user_group == 700)) {
						if ($lap_status) {
							if ($pdf) {
								$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED ) && $lap_status ['status_pelaporan_id'] <= 15) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
								$status = $lap_status ['nama'];
							} else {
								$jenis_lap_nama = $jenis_laps ['nama'];
								$status = 'INPOGRESS';
							}

						} else {
							$jenis_lap_nama = $jenis_laps ['nama'];
							$status = 'UNFILLED';
						}
					}
                    
					$view_status_laporan [$jenis_laps ['id']] ['nama']    = $jenis_lap_nama;
					$view_status_laporan [$jenis_laps ['id']] ['status']  = $status;
					$view_status_laporan [$jenis_laps ['id']] ['user']    = ($lap_status) ? $lap_status ['users_login'] : '';
					$view_status_laporan [$jenis_laps ['id']] ['tanggal'] = ($lap_status) ? $lap_status ['tanggal'] : '';
					
					$view_status_laporan [$jenis_laps ['id']] ['method']  = $this->laporanBumnHasInputMethod ( $laps_kategori, $jenis_laps ['id'], $jenis_laps ['freetext'], $user_group, ($lap_status) ? $lap_status ['status_pelaporan_id'] : 0 );
				}
			}
		}
        
		return $view_status_laporan;
	}

	public function laporanLkpnminInputMethod($laps_kategori, $jenis_lap_id, $freetext, $user_group, $status_laporan_id)
	{
		require_once 'akunBumnModel.php';
        
        $akunBumnModel = new akunBumnModel ( $this->bumn_id, $jenis_lap_id, $this->tahun, $this->periode_id );
        
        $method = '';
//buat nutup input LKPN
        if (($user_group == 700 || $user_group == 1) && $status_laporan_id <= 20)
		{
		   //echo 'test';
			if ($laps_kategori == 'input_profil')
			{
				$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'">web</a>';
			}
			else
			{
				if ($freetext == 't')
				{
					$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">Web</a>';
				}
				else
				{
					if ($jenis_lap_id > 400 && $jenis_lap_id < 500)
					{
						if ($akunBumnModel->akunBumnHasFreeText ())
						{
							$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">Web</a>';
						}
						else
						{

							if($jenis_lap_id == 496){
								$method .= '<a onclick="location.href=\'/admin/cetakcapex?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">download berkas</a> | <a onclick="location.href=\'/newftp/uploadcapex?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
							}
						    //echo 'test1';
							//$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
							
                            //$method .= '| <a onclick="location.href=\'/admin/cetakrestatement?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id . '&rest='.$rest.'\'">download berkas</a>';
                            //$method .= '| <a onclick="location.href=\'/newftp/newuploadexcelrestate?rest='.$rest.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
							
						}

					}
					else
					{
						if($jenis_lap_id == 601) {
							$method .= '<a onclick="location.href=\'/admin/cetakneracalkpn?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">download berkas</a> | <a onclick="location.href=\'/newftp/uploadneracalkpnmin?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
						} elseif ($jenis_lap_id == 602) {
							$method .= '<a onclick="location.href=\'/admin/cetaklrlkpn?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">download berkas</a> | <a onclick="location.href=\'/newftp/uploadlrlkpnmin?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
						} /*elseif ($jenis_lap_id == 701) {
							$method .= '<a onclick="location.href=\'/admin/cetakdataconf?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">download berkas</a> | <a onclick="location.href=\'/newftp/uploaddatconf?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
						}*/else{
							if($jenis_lap_id > 200 && $jenis_lap_id < 300){
                                $method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'">web</a>';
                            } else {
                                //$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
							    
                                 $method .= '<a onclick="location.href=\'/admin/cetakrestatement?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id . '&rest='.$rest.'\'">download berkas</a>';
                                 if($this->periode_id == 6){
                                    $method .= ' | <a onclick="location.href=\'/newftp/newuploadexcelrestate?rest='.$rest.'&periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
                                 } else {
                                    $method .= ' | <a onclick="location.href=\'/newftp/newuploadexcelnonaudited?rest='.$rest.'&periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
                                 }
                                
						
                            }
						}
					}
				}
			}

		//if ($user_group == 20000 || $user_group == 1)
		}
		else if (($user_group == 20000 || $user_group == 60000) && $status_laporan_id >= 20)
		{
			if ($status_laporan_id == 20)
			{
				if ($laps_kategori == 'input_profil')
				{
					$method = '<a href="/profil/j' . $jenis_lap_id . '">verifikasi</a>';
				}
				else
				{
					if ($freetext == 't')
					{
						$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">verifikasi</a>';
					}
					else
					{
						if ($jenis_lap_id > 400 && $jenis_lap_id < 500)
						{
							if ($akunBumnModel->akunBumnHasFreeText ())
							{
								//$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">verifikasi</a>';
                                $method = '<input type="button" class="inputsubmit" onclick="verifikasi();" value="Verifikasi">';
							}
							else
							{
								//$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">verifikasi</a> ';
                                $method = '<input type="button" class="inputsubmit" onclick="verifikasi();" value="Verifikasi">';
							}

						}
						else
						{
							if($jenis_lap_id == 520){
								$method = '<a href="/dividen/verifikasi/jid/' . $jenis_lap_id . '/type/verifikasi">verifikasi</a> ';
							}else {
							     
                                 if($jenis_lap_id > 200 && $jenis_lap_id < 300){
                                
                                $method = '<a href="/profil/j' . $jenis_lap_id . '">verifikasi</a>';
                            } else {
                                //$method = '<a href="/view/lkpn/">verifikasi</a> ';
                                $method = '<a href="/view/ceklkpn?tahun=' . $this->tahun . '&periode_id=' . $this->periode_id . '&bumn_id=' . $this->bumn_id . '&jenis_lap_id=' . $jenis_lap_id . '&lanjut=Lanjut">verifikasi</a> ';
                                //$method = '<input type="button" class="inputsubmit" onclick="verifikasiproses('.$jenis_lap_id.');" value="Verifikasi">';
                                
                            }
							}
						}
					}
				}
				//if ($status_laporan_id == 15)
			}
			else if($status_laporan_id == 40)
			{
				$page = ($laps_kategori == 'input_profil')?'/page/profil':'/page/laporan';
				//$method = '<a href="/laporan/cancelverifikasi/jid/'.$jenis_lap_id.$page.'">Batal</a>';
                $method = '<input type="button" style="margin-top:0px;" class="inputsubmit" onclick="verifikasibatal('.$jenis_lap_id.');" value="batal">';
                
			}


		}

		return $method;
	}

	public function laporanLkpnInputMethod($laps_kategori, $jenis_lap_id, $freetext, $user_group, $status_laporan_id)
	{
		require_once 'akunBumnModel.php';
        
        $akunBumnModel = new akunBumnModel ( $this->bumn_id, $jenis_lap_id, $this->tahun, $this->periode_id );
        
        $method = '';
//buat nutup input LKPN
        if (($user_group == 20000 || $user_group == 1) && $status_laporan_id <= 20)
		{
		   //echo 'test';
			if ($laps_kategori == 'input_profil')
			{
				$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'">web</a>';
			}
			else
			{
				if ($freetext == 't')
				{
					$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">Web</a>';
				}
				else
				{
					if ($jenis_lap_id > 400 && $jenis_lap_id < 500)
					{
						if ($akunBumnModel->akunBumnHasFreeText ())
						{
							$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">Web</a>';
						}
						else
						{

							if($jenis_lap_id == 496){
								$method .= '<a onclick="location.href=\'/admin/cetakcapex?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">download berkas</a> | <a onclick="location.href=\'/newftp/uploadcapex?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
							}
						    //echo 'test1';
							//$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
							
                            //$method .= '| <a onclick="location.href=\'/admin/cetakrestatement?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id . '&rest='.$rest.'\'">download berkas</a>';
                            //$method .= '| <a onclick="location.href=\'/newftp/newuploadexcelrestate?rest='.$rest.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
							
						}

					}
					else
					{
						if($jenis_lap_id == 601) {
							$method .= '<a onclick="location.href=\'/admin/cetakneracalkpn?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">download berkas</a> | <a onclick="location.href=\'/newftp/uploadneracalkpn?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
						} elseif ($jenis_lap_id == 602) {
							$method .= '<a onclick="location.href=\'/admin/cetaklrlkpn?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">download berkas</a> | <a onclick="location.href=\'/newftp/uploadlrlkpn?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
						} /*elseif ($jenis_lap_id == 701) {
							$method .= '<a onclick="location.href=\'/admin/cetakdataconf?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">download berkas</a> | <a onclick="location.href=\'/newftp/uploaddatconf?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
						}*/else{
							if($jenis_lap_id > 200 && $jenis_lap_id < 300){
                                $method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'">web</a>';
                            } else {
                                //$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
							    
                                 $method .= '<a onclick="location.href=\'/admin/cetakrestatement?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id . '&rest='.$rest.'\'">download berkas</a>';
                                 if($this->periode_id == 6){
                                    $method .= ' | <a onclick="location.href=\'/newftp/newuploadexcelrestate?rest='.$rest.'&periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
                                 } else {
                                    $method .= ' | <a onclick="location.href=\'/newftp/newuploadexcelnonaudited?rest='.$rest.'&periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
                                 }
                                
						
                            }
						}
					}
				}
			}

		//if ($user_group == 20000 || $user_group == 1)
		}
		else if (($user_group == 700 || $user_group == 60000) && $status_laporan_id >= 20)
		{
			if ($status_laporan_id == 20)
			{
				if ($laps_kategori == 'input_profil')
				{
					$method = '<a href="/profil/j' . $jenis_lap_id . '">verifikasi</a>';
				}
				else
				{
					if ($freetext == 't')
					{
						$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">verifikasi</a>';
					}
					else
					{
						if ($jenis_lap_id > 400 && $jenis_lap_id < 500)
						{
							if ($akunBumnModel->akunBumnHasFreeText ())
							{
								//$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">verifikasi</a>';
                                $method = '<input type="button" class="inputsubmit" onclick="verifikasi();" value="Verifikasi">';
							}
							else
							{
								//$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">verifikasi</a> ';
                                $method = '<input type="button" class="inputsubmit" onclick="verifikasi();" value="Verifikasi">';
							}

						}
						else
						{
							if($jenis_lap_id == 520){
								$method = '<a href="/dividen/verifikasi/jid/' . $jenis_lap_id . '/type/verifikasi">verifikasi</a> ';
							}else {
							     
                                 if($jenis_lap_id > 200 && $jenis_lap_id < 300){
                                
                                $method = '<a href="/profil/j' . $jenis_lap_id . '">verifikasi</a>';
                            } else {
                                //$method = '<a href="/view/lkpn/">verifikasi</a> ';
                                $method = '<a href="/view/ceklkpn?tahun=' . $this->tahun . '&periode_id=' . $this->periode_id . '&bumn_id=' . $this->bumn_id . '&jenis_lap_id=' . $jenis_lap_id . '&lanjut=Lanjut">verifikasi</a> ';
                                //$method = '<input type="button" class="inputsubmit" onclick="verifikasiproses('.$jenis_lap_id.');" value="Verifikasi">';
                                
                            }
							}
						}
					}
				}
				//if ($status_laporan_id == 15)
			}
			else if($status_laporan_id == 40)
			{
				$page = ($laps_kategori == 'input_profil')?'/page/profil':'/page/laporan';
				//$method = '<a href="/laporan/cancelverifikasi/jid/'.$jenis_lap_id.$page.'">Batal</a>';
                $method = '<input type="button" style="margin-top:0px;" class="inputsubmit" onclick="verifikasibatal('.$jenis_lap_id.');" value="batal">';
                
			}


		}

		return $method;
	}
    
    public function laporanBumnInputMethod($rest,$laps_kategori, $jenis_lap_id, $freetext, $user_group, $status_laporan_id)
    {
        require_once 'akunBumnModel.php';
         
        $akunBumnModel = new akunBumnModel ( $this->bumn_id, $jenis_lap_id, $this->tahun, $this->periode_id );
        
        $method = '';

        list($lengkap, $data) = $this->laporanBumnHasLaporanPdf();
        
        if($rest == 2){
              //kolom tahun awal 
              $tahun = ($this->tahun - 1);
    	 	  //kolom tahun akhir 
    	 	  
     	  } else {
     	        //kolom tahun awal 
              $tahun = ($this->tahun - 2);
    	 	  //kolom tahun akhir 
     	  }

     	  //var_dump($lengkap);die();

     	/*if(($user_group == 20000) && $status_laporan_id <= 20){
     		if($jenis_lap_id > 100 && $jenis_lap_id < 300){
                $method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'"><b>WEB</b></a>';
            }

            if($jenis_lap_id == 510) $method .= '<a onclick="location.href=\'/admin/cetakpajak?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'"><b>DOWNLOAD</b></a> <b>|</b> <a onclick="location.href=\'/newftp/uploadpajakfis?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'"><b>UPLOAD</b></a>';

            if( $jenis_lap_id == 520){
                $method .= '<a href="/dividen/penetapan/"><b>PENETAPAN</b></a> ';
                $method .= '| <a href="/dividen/setoran/"><b>PENYETORAN</b></a> ';
            }
     	}*/
       
        //admin bumn dan unfilled, invalid, inprogress
        if (($user_group == 20000 || $user_group == 1) && $status_laporan_id <= 20)
		{
		   //echo 'test';
			if ($laps_kategori == 'input_profil')
			{
                            $method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'"><b>WEB</b> </a>';
			}
			else
			{  
				if ($freetext == 't')
				{
					$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '"><b>WEB</b></a>';
				}
				else
				{
					if ($jenis_lap_id > 400 && $jenis_lap_id < 500)
					{
						if ($akunBumnModel->akunBumnHasFreeText ())
						{
							$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">Web </a>';
						}
						else
						{

							if($jenis_lap_id == 496){
								$method .= '<a onclick="location.href=\'/admin/cetakcapex?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">Download XLS</a> | <a onclick="location.href=\'/newftp/uploadcapex?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload XLS</a>';
							} elseif ($jenis_lap_id == 410 || $jenis_lap_id == 430 || $jenis_lap_id == 470) {


								$cekakun = $akunBumnModel->akunBumnHasIsi3($this->tahun, $this->periode_id,$jenis_lap_id,$this->bumn_id);

                            	if($cekakun != 0){
                            		$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
                            		$method .= '<b>|</b> <a href="/laporan/generatenonkeu/method/download/type/xls/jid/' . $jenis_lap_id . '"><b>DOWNLOAD</b></a> ';
								    $method .= '<b>|</b> <a href="/laporan/generatenonkeu/method/upload/type/xls/jid/' . $jenis_lap_id . '"><b>UPLOAD</b></a> ';
                            	} else {
                            		$method = '<a href="/admin/akunbumnnonkeu/bumn_id/'.$this->bumn_id.'/jenis_lap_id/'.$jenis_lap_id.'/periode_id/'.$this->periode_id.'/tahun/'.$this->tahun.'/lanjut/1"><b>Buat Template Akun</b></a> ';
								    
                            	}

								/*$method .= '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';*/
							} else {
								$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
							}
						    
							
						}

					}
					else
					{
						if($jenis_lap_id == 510) $method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'"><b>WEB</b> </a>';
						else if ($jenis_lap_id == 310){
							$method .= '<a onclick="location.href=\'/admin/cetakbpybds?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">Download XLS</a> | <a onclick="location.href=\'/newftp/uploadbpybdsfis?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload XLS</a>';
						} else if ($jenis_lap_id == 320){
							$method .= '<a onclick="location.href=\'/admin/cetakrdi?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id .'\'">Download XLS</a> <b>|</b> <a onclick="location.href=\'/newftp/uploadrdifis?periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload XLS</a>';
						} else if ($jenis_lap_id == 321){
							$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'"><b>WEB</b> </a>';
						} else{
							if($jenis_lap_id > 100 && $jenis_lap_id < 300){
                                $method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'"><b>WEB</b></a>';
                            } elseif( $jenis_lap_id == 520){
                            	$method .= '<a href="/dividen/penetapan/"><b>PENETAPAN</b></a> ';
                            	$method .= '| <a href="/dividen/setoran/"><b>PENYETORAN</b></a> ';
                                //$method = '';
                            	//$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
                            } else {


                            	if($jenis_lap_id == 301 || $jenis_lap_id == 302 || $jenis_lap_id == 303){
                            		$cekakun = $akunBumnModel->akunBumnHasIsi3($this->tahun, $this->periode_id,$jenis_lap_id,$this->bumn_id);
                            	}

                            	if($cekakun != 0){
                            		//$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
                            		$method = '<a href="/laporan/generate/method/download/type/xls/jid/' . $jenis_lap_id . '"><b>DOWNLOAD</b></a> ';
								    $method .= '<b>|</b> <a href="/laporan/generate/method/upload/type/xls/jid/' . $jenis_lap_id . '"><b>UPLOAD</b></a> ';
                            	} else {
                            		//$method = '<a href="/admin/akunbumn"><b>Buat Template Akun</b></a> ';
								    //$method .= '| <a href="/laporan/generate/method/upload/type/xls/jid/' . $jenis_lap_id . '">Upload XLS </a> ';
								    $method .= 'Template Belum Tersedia, Harap Hubungi Kementerian BUMN';
                            	}

                            	if($_SESSION['USERS_HAS_EIS']['EIS_ACCOUNT'] == 'admin_data_kbumn'){
                            		
                            		/*if($jenis_lap_id == 301 || $jenis_lap_id == 302 || $jenis_lap_id == 303){
                            			$cekakun = $akunBumnModel->akunBumnHasIsi3($this->tahun, $this->periode_id,$jenis_lap_id,$this->bumn_id);
                            		}
                            		
                            		if($cekakun != 0){
                            			
                            			$method = '<a href="/laporan/generate/method/download/type/xls/jid/' . $jenis_lap_id . '">Download XLS</a> ';
								    	$method .= '| <a href="/laporan/generate/method/upload/type/xls/jid/' . $jenis_lap_id . '">Upload XLS </a> ';
                            		} else {
                            			$method = '<a href="/admin/akunbumn">Buat Template Akun</a> ';
								    	
                            		}*/

                            		$method .= '<a onclick="location.href=\'/admin/cetakrestatement?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id . '&rest='.$rest.'\'">Download XLS</a>';
	                                if($this->periode_id == 6){
	                                    $method .= ' | <a onclick="location.href=\'/newftp/newuploadexcelrestate?rest='.$rest.'&periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload XLS</a>';
	                                } else {
	                                    $method .= ' | <a onclick="location.href=\'/newftp/newuploadexcelnonaudited?rest='.$rest.'&periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload XLS</a>';
	                                }
								    
                            	}


                            	/*$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
								    $method .= '| <a href="/laporan/generate/method/download/type/xls/jid/' . $jenis_lap_id . '">Download XLS</a> ';
								    $method .= '| <a href="/laporan/generate/method/upload/type/xls/jid/' . $jenis_lap_id . '">Upload XLS </a> ';*/
                                //$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
                                /*if($this->bumn_id == '3302' || $this->bumn_id == '0101' || $this->bumn_id == '0201' || $this->bumn_id == '0401'){
                                	$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
								    $method .= '| <a href="/laporan/generate/method/download/type/xls/jid/' . $jenis_lap_id . '">Download XLS</a> ';
								    $method .= '| <a href="/laporan/generate/method/upload/type/xls/jid/' . $jenis_lap_id . '">Upload XLS </a> ';
                                } else {
                                	$method .= '<a onclick="location.href=\'/admin/cetakrestatement?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id . '&rest='.$rest.'\'">download berkas</a>';
	                                 if($this->periode_id == 6){
	                                    $method .= ' | <a onclick="location.href=\'/newftp/newuploadexcelrestate?rest='.$rest.'&periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
	                                 } else {
	                                    $method .= ' | <a onclick="location.href=\'/newftp/newuploadexcelnonaudited?rest='.$rest.'&periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
	                                 }
                                }*/
							    /*if($jenis_lap_id < 500){
							    	$method .= '<a onclick="location.href=\'/admin/cetakrestatement?tahun='.$this->tahun.'&periode='.$this->periode_id.'&bumnid='.$this->bumn_id.'&laporanid=' . $jenis_lap_id . '&rest='.$rest.'\'">download berkas</a>';
	                                 if($this->periode_id == 6){
	                                    $method .= ' | <a onclick="location.href=\'/newftp/newuploadexcelrestate?rest='.$rest.'&periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
	                                 } else {
	                                    $method .= ' | <a onclick="location.href=\'/newftp/newuploadexcelnonaudited?rest='.$rest.'&periode='.$this->periode_id.'&laporanid=' . $jenis_lap_id . '\'">Upload Berkas</a>';
	                                 }	
							    }*/
                                
						
                            }
						}
					}
				}
			}

		//if ($user_group == 20000 || $user_group == 1)
		}
		else if ($status_laporan_id >= 20 && ($user_group == 700))
		{
			if ($status_laporan_id == 20)
			{
				if ($laps_kategori == 'input_profil')
				{
					$method = '<a href="/profil/j' . $jenis_lap_id . '">verifikasi</a>';
				}
				else
				{
					if ($freetext == 't')
					{
						$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">verifikasi</a>';
					}
					else
					{
						if ($jenis_lap_id > 400 && $jenis_lap_id < 500)
						{
							if ($akunBumnModel->akunBumnHasFreeText ())
							{
								//$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">verifikasi</a>';
                                $method = '<input type="button" class="inputsubmit" onclick="verifikasi();" value="Verifikasi">';
							}
							else
							{
								//$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">verifikasi</a> ';
                                $method = '<input type="button" class="inputsubmit" onclick="verifikasi();" value="Verifikasi">';
							}

						}
						else
						{
							if($jenis_lap_id == 520){
								//$method = '<a href="/dividen/verifikasi/jid/' . $jenis_lap_id . '/type/verifikasi">verifikasi</a> ';
								$method .= '<a href="/dividen/penetapan/"><b>PENETAPAN</b></a> ';
                            	$method .= '| <a href="/dividen/setoran/"><b>PENYETORAN</b></a> ';
							} else {
							     
                                 if($jenis_lap_id > 200 && $jenis_lap_id < 300){
                                
                                $method = '<a href="/profil/j' . $jenis_lap_id . '">verifikasi</a>';
                            } elseif ($jenis_lap_id > 100 && $jenis_lap_id < 200) {
                            	$method = '<a href="/profil/j' . $jenis_lap_id . '">verifikasi</a>';
                            } elseif ($jenis_lap_id == 510) {
                            	$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'"><b>verifikasi</b> </a>';
                            	//$method = '<a href="/laporan/generate/method/web/jid/' . $jenis_lap_id . '"><b>verifikasi</b></a> ';
                            	//$method = '<a href="/view/lapmulti/lanjut/1">verifikasi</a>';
                            } else if ($jenis_lap_id == 321){
							$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'"><b>verifikasi</b> </a>';
							} elseif ($jenis_lap_id == 901) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 1){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 902) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 2){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 903) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 4){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 904) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 6){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 905) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 10){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 906) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 15){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 907) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 18){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 908) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 19){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 909) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 20){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 910) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 11){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 911) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 12){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 912) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 13){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } elseif ($jenis_lap_id == 913) {


                            	for($i=0;$i < count($data); $i++){
                            		if($data[$i]['id'] == 14){
                            			$file =($data[$i]['file'])?'<a style="cursor:pointer" onclick="window.open(\'/generated/pdf/file/'.$data[$i]['file'].'\')" >Lihat berkas <img src="/images/pdf.png" alt="pdf"></a>':'<font color="red">pdf Tidak Ditemukan.</font> '; 
										$upload = ($data[$i]['file'])?'<a href="/upload/berkas/ext/PDF/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Ubah berkas</a>':'<a href="/upload/berkas/ext/pdf/id/'.$data[$i]['id'].'/laporan/'.$data[$i]['nama'].'">Upload Berkas</a>';
										$method .= $file.' - '.$upload;
                            		}
                            	}
								
                            } else {
                            	//$method .= '<a href="/laporan/verifikasipdf/jid/'.$jenis_lap_id.'/id/'.$data[$i]['id'].'/file/'.$data[$i]['file'].'/laporan/'.$data[$i]['nama'].'">verifikasi</a>';
                                //$method = '<a href="/view/refresh?tahunawal='.$tahun.'&tahunakhir=' . $this->tahun . '&periode_id=' . $this->periode_id . '&bumn_id=' . $this->bumn_id . '&jenis_lap_id=' . $jenis_lap_id . '&lanjut=Lanjut">verifikasi</a> ';
                                /*if($user_group == 7001 || $_SESSION['USERS_HAS_EIS']['EIS_ACCOUNT'] == 'admin_periksa_kbumnn'){
                                	$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">verifikasi</a> ';
                                } else {
                                	$method = '<a href="/view/refresh?tahunawal='.$tahun.'&tahunakhir=' . $this->tahun . '&periode_id=' . $this->periode_id . '&bumn_id=' . $this->bumn_id . '&jenis_lap_id=' . $jenis_lap_id . '&lanjut=Lanjut">verifikasi</a> ';
                                }*/
                                $method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">verifikasi</a> ';
                                //$method = '<input type="button" class="inputsubmit" onclick="verifikasiproses('.$jenis_lap_id.');" value="Verifikasi">';
                                
                            }
							}
						}
					}
				}
				//if ($status_laporan_id == 15)
			}
			else if($status_laporan_id == 40)
			{
				$page = ($laps_kategori == 'input_profil')?'/page/profil':'/page/laporan';
				//$method = '<a href="/laporan/cancelverifikasi/jid/'.$jenis_lap_id.$page.'">Batal</a>';
				$method = '<button class="btn btn-danger" type="button" onclick="verifikasicancel('.$jenis_lap_id.');">BATAL VERIFIKASI</button>';
                //method = '<input type="button" style="margin-top:0px;" class="inputsubmit" onclick="verifikasicancel('.$jenis_lap_id.');" value="batal">';
                
			}


		}

		return $method;
        
    }



    public function laporanBumnInputAoMethod($rest,$laps_kategori, $jenis_lap_id, $freetext, $user_group, $status_laporan_id)
    {
        require_once 'akunBumnModel.php';
        
        $akunBumnModel = new akunBumnModel ( $this->bumn_id, $jenis_lap_id, $this->tahun, $this->periode_id );
        
        $method = '';

        list($lengkap, $data) = $this->laporanBumnHasLaporanPdf();
        
    
        if($status_laporan_id <= 40)
		{
			if($jenis_lap_id > 100 && $jenis_lap_id < 300){
	        	$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'"><b>WEB</b></a>';
	    	}
		}

		//$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'"><b>WEB</b></a>';
     	
		return $method;
        
    }

	public function laporanBumnHasInputMethod($laps_kategori, $jenis_lap_id, $freetext, $user_group, $status_laporan_id) {
		require_once 'akunBumnModel.php';
        
		$akunBumnModel = new akunBumnModel ( $this->bumn_id, $jenis_lap_id, $this->tahun, $this->periode_id );
        
		$method = '';
		if (($user_group == 20000 || $user_group == 1) && $status_laporan_id <= 15)
		{
			if ($laps_kategori == 'input_profil')
			{
				$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'">web</a>';
			}
			else
			{
				if ($freetext == 't')
				{
					$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">Web</a>';
				}
				else
				{
					if ($jenis_lap_id > 400 && $jenis_lap_id < 500)
					{
						if ($akunBumnModel->akunBumnHasFreeText ())
						{
							$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">Web</a>';
						}
						else
						{
							$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
							$method .= '| <a href="/laporan/generate/method/download/type/xls/jid/' . $jenis_lap_id . '">Download XLS</a> ';
							$method .= '| <a href="/laporan/generate/method/upload/type/xls/jid/' . $jenis_lap_id . '">Upload XLS </a> ';
							//$method .= '| <a href="/laporan/generate/method/download/type/txt/jid/' . $jenis_lap_id . '">Download TXT</a> ';
							//$method .= '| <a href="/laporan/generate/method/upload/type/txt/jid/' . $jenis_lap_id . '">Upload TXT</a> ';
						}

					}
					else
					{
						if($jenis_lap_id == 520) $method = '<a href="/dividen/setoran/">Web</a> ';
						else{
							if($jenis_lap_id > 200 && $jenis_lap_id < 300){
                                $method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'">web</a>';
                            } else {
                                $method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">Web</a> ';
							    $method .= '| <a href="/laporan/generate/method/download/type/xls/jid/' . $jenis_lap_id . '">Download XLS</a> ';
							     $method .= '| <a href="/laporan/generate/method/upload/type/xls/jid/' . $jenis_lap_id . '">Upload XLS </a> ';
							//$method .= '| <a href="/laporan/generate/method/download/type/txt/jid/' . $jenis_lap_id . '">Download TXT</a> ';
							//$method .= '| <a href="/laporan/generate/method/upload/type/txt/jid/' . $jenis_lap_id . '">Upload TXT</a> ';
                            }
						}
					}
				}
			}

		//if ($user_group == 20000 || $user_group == 1)
		}
		else if (($user_group == 700) && ($user_group == 60000) && $status_laporan_id >= 15)
		{
			if ($status_laporan_id == 15)
			{
				if ($laps_kategori == 'input_profil')
				{
					$method = '<a href="/profil/j' . $jenis_lap_id . '">verifikasi</a>';
				}
				else
				{
					if ($freetext == 't')
					{
						$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">verifikasi</a>';
					}
					else
					{
						if ($jenis_lap_id > 400 && $jenis_lap_id < 500)
						{
							if ($akunBumnModel->akunBumnHasFreeText ())
							{
								$method = '<a href="/laporan/generate/method/web/type/freetext/jid/' . $jenis_lap_id . '">verifikasi</a>';
							}
							else
							{
								$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">verifikasi</a> ';
							}

						}
						else
						{
							if($jenis_lap_id == 520){
								$method = '<a href="/dividen/verifikasi/jid/' . $jenis_lap_id . '/type/verifikasi">verifikasi</a> ';
							}else {
							     //$method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">verifikasi</a> ';
                                 if($jenis_lap_id > 200 && $jenis_lap_id < 300){
                                //$method = '<a href="/profil/j' . $jenis_lap_id . '/jid/'.$jenis_lap_id.'">web</a>';
                                $method = '<a href="/profil/j' . $jenis_lap_id . '">verifikasi</a>';
                            } else {
                                $method = '<a href="/laporan/generate/method/web/type/tree/jid/' . $jenis_lap_id . '">verifikasi</a> ';
                                
                            }
							}
						}
					}
				}
				//if ($status_laporan_id == 15)
			}
			else if($status_laporan_id == 20)
			{
				$page = ($laps_kategori == 'input_profil')?'/page/profil':'/page/laporan';
				$method = '<a href="/laporan/verifikasibatal/jid/'.$jenis_lap_id.$page.'">Batal</a>';
			}


		}

		return $method;
	}

	public function laporanBumnHasRule($jenis_lap_id) {

	}

	public function laporanBumnHasLaporanFreetext($jenis_lap_id) {
		$sql = 'select freetext from jenis_lap where id =' . $jenis_lap_id . ' ';
		$freetext = $this->db2->GetOne ( $sql );

		return ($freetext == 't') ? true : false;
	}

	public function laporanBumnHasFreetext($jenis_lap_id) {
		$sql = 'select uraian from freetext where bumn_id =\'' . $this->bumn_id . '\' and jenis_lap_id = ' . $jenis_lap_id . ' and tahun = ' . $this->tahun . ' and periode_id = ' . $this->periode_id . ' ';
		$freetext = $this->db2->GetOne ( $sql );

		return ($freetext) ? $freetext : '';
	}

	public function saveLaporanBumnHasFreetext($jenis_lap_id, $uraian) {
		$sql = 'delete from freetext where bumn_id =\'' . $this->bumn_id . '\' and jenis_lap_id = ' . $jenis_lap_id . ' and tahun = ' . $this->tahun . ' and periode_id = ' . $this->periode_id . ' ';
		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );

		$sql .= 'insert into freetext(bumn_id, periode_id, jenis_lap_id, tahun, uraian)values(\'' . $this->bumn_id . '\', ' . $this->periode_id . ', ' . $jenis_lap_id . ', ' . $this->tahun . ', \'' . $uraian . '\')';
		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}

	public function laporanBumnHasPosted($jenis_lap_id, $tahun, $periode_id, $bumn_id) {
		$status_pelaporan = $this->laporanBumnHasStatusLaporan ( $jenis_lap_id, $tahun, $periode_id, $bumn_id );

		if ($status_pelaporan ['status_pelaporan_id'] == 40) {
			return true;
		} else {
			return false;
		}
	}

	public function saveLaporanBumnHasStatusLaporan($jenis_lap_id, $status, $account) {

		if($account == 'super_eis'){
			$account = 'asdep_infokom';
		}

		$sql = 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = 20;';

		$sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = 40;';

		$sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = 10;';

    	$sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = 5;';

    	$sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = '.$status.' and users_login = \''.$account.'\';';

		$sql .= 'insert into status_pemasukan_bumn(bumn_id, jenis_lap_id, status_pelaporan_id, tahun, periode_id, tanggal, users_login)
				values(\'' . $this->bumn_id . '\', ' . $jenis_lap_id . ', ' . $status . ', ' . $this->tahun . ', ' . $this->periode_id . ', now(), \'' . $account . '\')';
		//echo ($sql); die();
		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}

	public function saveLogPelaporanBumn($jenis_lap_id, $status, $account,$pesan){

		if($account == 'super_eis'){
			$account = 'asdep_infokom';
		}

		$sql = 'insert into log_status_pemasukan_bumn(bumn_id, jenis_lap_id, status_pelaporan_id, tahun, periode_id, tanggal, user_login, pesan)
				values(\'' . $this->bumn_id . '\', ' . $jenis_lap_id . ', ' . $status . ', ' . $this->tahun . ', ' . $this->periode_id . ', now(), \'' . $account . '\',\'' . $pesan . '\');';
		
		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}

	public function deletepdfloglaporan($jenis_lap_id){

		$sql = 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'';

		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}

	public function saveLaporanBumnHasStatusPemasukanNotes($jenis_lap_id, $status, $account,$pesan)
	{
		if($account == 'super_eis'){
			$account = 'asdep_infokom';
		}

		//$sql = 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = 20;';

		$sql = 'insert into status_pemasukan_bumn(bumn_id, jenis_lap_id, status_pelaporan_id, tahun, periode_id, tanggal, users_login, pesan)
				values(\'' . $this->bumn_id . '\', ' . $jenis_lap_id . ', ' . $status . ', ' . $this->tahun . ', ' . $this->periode_id . ', now(), \'' . $account . '\',\'' . $pesan . '\');';
		//echo ($sql); die();
		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}
    
    public function saveLaporanBumnHasStatusPemasukan($jenis_lap_id, $status, $account) {

    	if($account == 'super_eis'){
			$account = 'asdep_infokom';
		}

		$sql = 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = 20;';

    	$sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = 5;';

    	$sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = 10;';

    	$sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = 40;';

    	$sql .= 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = '.$status.' and users_login = \''.$account.'\';';

		$sql .= 'insert into status_pemasukan_bumn(bumn_id, jenis_lap_id, status_pelaporan_id, tahun, periode_id, tanggal, users_login)
				values(\'' . $this->bumn_id . '\', ' . $jenis_lap_id . ', ' . $status . ', ' . $this->tahun . ', ' . $this->periode_id . ', now(), \'' . $account . '\');';
		//echo ($sql); die();
		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}

	public function cancelLaporanBumnHasStatusLaporan($jenis_lap_id, $status) {

		if($account == 'super_eis'){
			$account = 'asdep_infokom';
		}

		$sql = 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = '.$status.' ';
		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}
    
    public function cancelLaporanBumnHasInputLaporan($jenis_lap_id, $status) {
		$sql = 'delete from status_pemasukan_bumn where bumn_id = \''.$this->bumn_id.'\' and jenis_lap_id = '.$jenis_lap_id.' and tahun = '.$this->tahun.' and periode_id = '.$this->periode_id.'  and status_pelaporan_id = '.$status.' ';
		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}

	public function laporanLkpnHasLaporanPdf() {
		require_once 'bumnModel.php';

		$bumnModel = new bumnModel ( $this->bumn_id, $this->tahun, $this->periode_id );
		//$bumns = $bumnModel->bumnHasProfiles ();
		$bumns = $bumnModel->bumnHasProfilesUpload();
		$bumn_id2 = $bumns ['id2'];
		$is_tbk = $bumns['tbk'] == 't'?1:0;

		$where = '';
		//if ($is_tbk == 1) {
//			$sql = 'select id, nama, required from attachment_pdf where id= 6 order by id ';
//		}else{
//			if ($this->periode_id != 6) {
//				$where = 'where id = 6 ';
//			} else
//				$where = 'where id <> 7';
//			$returnValue = array (1 );
//
//			$sql = 'select id, nama, required from attachment_pdf ' . $where . ' order by id ';
//		}
        
			$returnValue = array (1 );

			$sql = 'select id, nama, required from attachment_pdf where id in (8) order by id ';
		//echo $sql;die();
		$rs = $this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );

		while ( ! $rs->EOF ) {
			$file_name = $bumn_id2 . '-' . $this->tahun . '-' . $this->periode_id . '-' . $rs->fields ['id'] . '.pdf';
			$file = Globals::getConfig ()->dirs->upload . $file_name;

			if (! file_exists ( $file )) {
				$returnValue [] = 0;
				$file_name = false;
			}

			$a ['id'] = $rs->fields ['id'];
			$a ['nama'] = $rs->fields ['nama'];
			$a ['required'] = $rs->fields ['required'];
			$a ['file'] = $file_name;
			$data [] = $a;

			$rs->MoveNext ();
		}

		$return = (in_array ( 0, $returnValue )) ? false : true;

		return array ($return, $data );
	} 
        
	public function laporanBumnHasLaporanPdf() {
		require_once 'bumnModel.php';

		$bumnModel = new bumnModel ( $this->bumn_id, $this->tahun, $this->periode_id );
		$bumns = $bumnModel->bumnHasProfilesUpload();
		//$bumns = $bumnModel->bumnHasProfiles ();
		$bumn_id2 = $bumns ['id2'];
		$is_tbk = $bumns['tbk'] == 't'?1:0;
                
		$where = '';
		//if ($is_tbk == 1) {
//			$sql = 'select id, nama, required from attachment_pdf where id= 6 order by id ';
//		}else{
//			if ($this->periode_id != 6) {
//				$where = 'where id = 6 ';
//			} else
//				$where = 'where id <> 7';
//			$returnValue = array (1 );
//
//			$sql = 'select id, nama, required from attachment_pdf ' . $where . ' order by id ';
//		}
        if($this->periode_id == 7){
			$where = 'where id in (6)';
		}elseif ($this->periode_id == 6) {
			$where = 'where id in (1,2,4,6,25,26,27)';
		}elseif ($this->periode_id == 10) {
			$where = 'where id in (6,15)';
		}elseif ($this->periode_id == 12) {
			$where = 'where id in (28)';
		} elseif ($this->periode_id == 5) {
			$where = 'where id in (6)';
		} else {
			$where = 'where id in (6)';
		}
			$returnValue = array (1 );

			$sql = 'select id, nama, required from attachment_pdf ' . $where . ' order by id asc ';
		//echo $sql;
		$rs = $this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );

		while ( ! $rs->EOF ) {

			$file_name = $bumn_id2 . '-' . $this->tahun . '-' . $this->periode_id . '-' . $rs->fields ['id'] . '.pdf';
			$file = Globals::getConfig ()->dirs->upload . $file_name;

			if (! file_exists ( $file )) {
				$returnValue [] = 0;
				$file_name = false;
			}

			$a ['id'] = $rs->fields ['id'];
			$a ['nama'] = $rs->fields ['nama'];
			$a ['required'] = $rs->fields ['required'];
			$a ['file'] = $file_name;
			$data [] = $a;

			$rs->MoveNext ();
		}

		$return = (in_array ( 0, $returnValue )) ? false : true;

		//echo $return;

		return array ($return, $data );
	}

	public function deleteStatusLaporanBumn(){
		return $this->db->delete("status_pelaporan_bumn","bumn_id = '$this->bumn_id' and tahun = $this->tahun and periode_id = $this->periode_id");
	}
    
    public function laporanBumnHasLaporanPdf2() {
		require_once 'bumnModel.php';

		$bumnModel = new bumnModel ( $this->bumn_id, $this->tahun, $this->periode_id );
		//$bumns = $bumnModel->bumnHasProfiles ();
		$bumns = $bumnModel->bumnHasProfilesUpload();
		$bumn_id2 = $bumns ['id2'];
		$is_tbk = $bumns['tbk'] == 't'?1:0;

		$where = '';
		/*if ($is_tbk == 1) {
			$sql = 'select id, nama, required from attachment_pdf where id= 7 order by id ';
		}else{*/
			if ($this->periode_id != 6) {
				$where = 'where id = 6 ';
			} else
				$where = 'where id <> 7';
			$returnValue = array (1 );

			$sql = 'select id, nama, required from attachment_pdf ' . $where . ' order by id ';
		//}
		//echo $sql;die();
		$rs = $this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );

		while ( ! $rs->EOF ) {
			$file_name = $bumn_id2 . '-' . $this->tahun . '-' . $this->periode_id . '-' . $rs->fields ['id'] . '.pdf';
			$file = Globals::getConfig ()->dirs->upload . $file_name;

			if (! file_exists ( $file )) {
				$returnValue [] = 0;
				$file_name = false;
			}

			$a ['id'] = $rs->fields ['id'];
			$a ['nama'] = $rs->fields ['nama'];
			$a ['required'] = $rs->fields ['required'];
			$a ['file'] = $file_name;
			$data [] = $a;

			$rs->MoveNext ();
		}

		$return = (in_array ( 0, $returnValue )) ? false : true;

		return array ($return, $data );
	}
    
    public function laporanBumnHasValidTo2($status)
	{
		$LAPORAN_REQUIRED = array (210, 220, 240, 250, 301, 302, 303, 410, 430, 455, 460, 495, 510 );
		//$LAPORAN_REQUIRED = array (301, 302, 303, 510 );//test case u/ generate xml untuk laporan yang sudah final

		switch($status)
		{
			case 'finish':
				$status_id = 15;
				break;
			case 'final':
				$status_id = 20;
				break;
			case 'posted':
				$status_id = 40;
				break;
		}

		$valid = array(1);
		foreach($LAPORAN_REQUIRED as $jid)
		{
			$status = $this->laporanBumnHasStatusLaporan($jid);
			//echo $status['status_pelaporan_id'];
			if($status)
			{
				if($status['status_pelaporan_id'] < $status_id){
					$valid[] = 0;
				}
			}
			else
				$valid[] = 0;


		}
		//print_r($valid);die("masuk");exit;
		return (in_array(0,$valid))?false:true;
	}
    
    public function laporanBumnHasViewStatusLaporan2($laps_kategori = 'input_profil', $user_group, $pdf = true) {
		$LAPORAN_REQUIRED = array (210, 220, 240, 250, 301, 302, 303, 410, 430, 455, 460, 495, 510 );
		
		$bumnModel = new bumnModel ( $this->bumn_id, $this->tahun, $this->periode_id );
		//$bumns = $bumnModel->bumnHasProfiles ();
		$bumns = $bumnModel->bumnHasProfilesUpload();
		$bumn_id2 = $bumns ['id2'];
		$is_tbk = $bumns['tbk'] == 't'?1:0;

		$laps = $this->laporanBumnHasKategoriLaporan ( $laps_kategori );
		//echo $is_tbk; print_r($laps);die();
		$view_status_laporan = array ();

		foreach ( $laps as $jenis_laps ) {
			//if (substr ( $this->bumn_id, 0, 2 ) != '01' and $jenis_laps ['id'] == 305) {
			if (substr ( $this->bumn_id, 0, 2 ) != '01' and ($jenis_laps ['id'] == 305 or $jenis_laps['id'] == 492)) {
				//do nothing
			}
			else {
				if (($this->is_pso != 1) && ($jenis_laps['id'] == 498) ){
					//do nothing
				}elseif (($this->is_tbk == 1) && ($jenis_laps['id'] == 495) ){
					//do nothing
				}
				elseif (($is_tbk == 1) && ($jenis_laps['id'] == 240) && ($this->bumn_id != '0406') ){ //kasus khusus untuk tbk wika dimunculin tingkat kesehatannya
					//do nothing
				}
				else{
					$lap_status = $this->laporanBumnHasStatusLaporan ( $jenis_laps ['id'] );

					if ($user_group == 20000 || $user_group == 1) {
						if ($lap_status) {
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED ) && $lap_status ['status_pelaporan_id'] == 10) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							$status = ($pdf) ? $lap_status ['nama'] : 'INPROGRESS';
						} else {
							$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED )) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
							$status = 'UNFILLED';
						}
						//if ($user_group == 20000)
					} else if (($user_group == 60000)) {
						if ($lap_status) {
							if ($pdf) {
								$jenis_lap_nama = (in_array ( $jenis_laps ['id'], $LAPORAN_REQUIRED ) && $lap_status ['status_pelaporan_id'] <= 15) ? $jenis_laps ['nama'] . '<font color="red">*</font>' : $jenis_laps ['nama'];
								$status = $lap_status ['nama'];
							} else {
								$jenis_lap_nama = $jenis_laps ['nama'];
								$status = 'INPOGRESS';
							}

						} else {
							$jenis_lap_nama = $jenis_laps ['nama'];
							$status = 'UNFILLED';
						}
					}

					$view_status_laporan [$jenis_laps ['id']] ['nama'] = $jenis_lap_nama;
					$view_status_laporan [$jenis_laps ['id']] ['status'] = $status;
					$view_status_laporan [$jenis_laps ['id']] ['user'] = ($lap_status) ? $lap_status ['users_login'] : '';
					$view_status_laporan [$jenis_laps ['id']] ['tanggal'] = ($lap_status) ? $lap_status ['tanggal'] : '';
					$view_status_laporan [$jenis_laps ['id']] ['method'] = $this->laporanBumnHasInputMethod ( $laps_kategori, $jenis_laps ['id'], $jenis_laps ['freetext'], $user_group, ($lap_status) ? $lap_status ['status_pelaporan_id'] : 0 );
				}
			}
		}

		return $view_status_laporan;
	}


	public function pengantarbumn() {
        $sql = 'SELECT
        			id,
                    bumn_id,
                    perihal,
                    ttd_surat,
                    tahun,
                    periode_id,
                    qr_code,
                    no_surat,
                    tgl_surat,
                    kepada,
                    file_dirkom,
                    waktu,
                    no_direksi,
                    no_deputi,
                    upload
                FROM
                    srt_pengantar
                WHERE
                    bumn_id = \'' . $this->bumn_id . '\'
                    AND periode_id = ' . $this->periode_id . '
                    AND tahun = ' . $this->tahun . '';
        //echo $sql;die();

        $rows = $this->db2->GetAll ( $sql );
		return $rows;
    }

    public function tandaterimabumn($bumn_id,$bulan,$tahun) {

    	if($bulan == 99){
    		$where = '';
    	} else {
    		$where = 'AND EXTRACT (\'month\' FROM tgl_surat) = \'' . $bulan . '\'';
    	}
        /*$sql = 'SELECT
        			id,
                    bumn_id,
                    perihal,
                    ttd_surat,
                    tahun,
                    periode_id,
                    qr_code,
                    no_surat,
                    tgl_surat,
                    kepada,
                    file_dirkom,
                    waktu,
                    no_direksi,
                    no_deputi,
                    upload
                FROM
                    srt_pengantar
                WHERE
                    bumn_id = \'' . $bumn_id . '\'
                    AND periode_id = ' . $periode_id . '
                    AND tahun = ' . $tahun . ';';*/

        $sql = 'SELECT
					ID,
					bumn_id,
					perihal,
					ttd_surat,
					tahun,
					periode_id,
					qr_code,
					no_surat,
					tgl_surat,
					kepada,
					file_dirkom,
					waktu,
					no_direksi,
					no_deputi,
					upload
				FROM
					srt_pengantar
				WHERE
					bumn_id = \'' . $bumn_id . '\'
				'.$where.'
				AND tahun = ' . $tahun . '
				ORDER BY
					tgl_surat DESC;';
        //echo $sql;die();

        $rows = $this->db2->GetAll ( $sql );
		return $rows;
    }


    public function rkappokokbumn($bumn_ids) {


    	/*$sql = 'SELECT
					A . ID,
					C .nama_lengkap AS bumn,
					b.nama AS periode,
					A .tahun,
					A .aset,
					A .liabilitas,
					A .ekuitas,
					A .pu,
					A .ebitda,
					A .bo,
					A .lbtb,
					A .lbep,
					A .capex,
					A .pajak,
					A .sdm,
					A .kurs,
					A .matauang
				FROM
					keu_rkap_prog A,
					a_bumn_master C,
					periode_baru b
				WHERE
					A .bumn_id = C . ID
				AND A .periode_id = b. ID
				AND a.periode_id = ' . $periodeid . '
				AND a.tahun = ' . $tahun . '
				AND a.bumn_id = \'' . $bumn_id . '\'';*/

		$sql = 'SELECT
					A . ID,
					A .bumn_id,
					C .nama_lengkap AS bumn,
					b.nama AS periode,
					A .tahun,
					A .aset,
					A .liabilitas,
					A .ekuitas,
					A .pu,
					A .ebitda,
					A .bo,
					A .lbtb,
					A .lbep,
					A .capex,
					A .pajak,
					A .sdm,
					A .kurs,
					A .matauang
				FROM
					keu_rkap_prog A,
					a_bumn_master C,
					periode_baru b
				WHERE
					A .bumn_id = C . ID
				AND A .periode_id = b. ID
				AND A .periode_id in (7,8)
				AND A .bumn_id in(\''.implode("','", $bumn_ids).'\')
				AND A .tahun in (2015,2016) ORDER BY a.bumn_id, a.periode_id ASC';
        //echo $sql;die();

        $rows = $this->db2->GetAll ( $sql );
		return $rows;
    }

    public function opiniauditorbumn($bumn_id,$tahun) {
        /*$sql = 'SELECT
        			bumn_id,
                    catatan,
                    kpa
                FROM
                    bumn_has_tingkat_oa
                WHERE
                    bumn_id = \'' . $bumn_id . '\'
                    AND tahun = ' . $tahun . ';';*/

        $sql = 'SELECT
					a.bumn_id as bumn_id,
					a.catatan as catatan,
					a.kpa as kpa,
					b.nama as opini
				FROM
					bumn_has_tingkat_oa a,
				  tingkat_kesehatan b
				WHERE
					a.bumn_id = \'' . $bumn_id . '\'
				                    AND a.tahun = ' . $tahun . '
				  and a.tingkat_oa_id = b.id;';
        //echo $sql;die();

        $rows = $this->db2->GetAll ( $sql );
		return $rows;
    }

    public function savePengantar($perihal,$ttd_surat,$qr_code,$no_surat,$tgl_surat,$kepada,$file_dirkom,$no_direksi) {
		$sql = 'delete from srt_pengantar where bumn_id =\'' . $this->bumn_id . '\' and tahun = ' . $this->tahun . ' and periode_id = ' . $this->periode_id . '; ';
		//$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );

		$nosrt = 'TPE-'.$no_surat;

		$sql .= 'insert into srt_pengantar(bumn_id, perihal, ttd_surat, qr_code, no_surat, tgl_surat, kepada,file_dirkom,periode_id,tahun,waktu,no_direksi)values(\'' . $this->bumn_id . '\',\'' . $perihal . '\',\'' . $ttd_surat . '\',\'' . $qr_code . '\',\'' . $nosrt . '\',\'' . $tgl_surat . '\',\'' . $kepada . '\',\'' . $file_dirkom . '\', ' . $this->periode_id . ', ' . $this->tahun . ',\'' . date("Y-m-d H:i:s") . '\',\'' . $no_direksi . '\')';
		//echo $sql;die();
		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}



	public function ambilrjppbumn() {
        $sql = 'SELECT
                    bumn_id,
                    periode_id,
                    thn_awal,
                    thn_akhir,
                    pdf
                FROM
                    pdf_rjpp
                WHERE
                    bumn_id = \'' . $this->bumn_id . '\'
                    AND periode_id = ' . $this->periode_id . ';';
        //echo $sql;die();

        $rows = $this->db2->GetAll ( $sql );
		return $rows;
    }


    public function saveRjppBumn($bumn_id,$periode_id,$thn_awal,$thn_akhir,$pdf) {
		$sql = 'delete from pdf_rjpp where bumn_id =\'' . $this->bumn_id . '\' and thn_awal = ' . $this->tahun . ' and periode_id = ' . $this->periode_id . '; ';
		//$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );



		$sql .= 'insert into pdf_rjpp(bumn_id,periode_id,thn_awal,thn_akhir,pdf)values(\'' . $this->bumn_id . '\', ' . $this->periode_id . ', ' . $thn_awal . ', ' . $thn_akhir . ',\'' . $pdf . '\')';
		//echo $sql;die();
		$this->db2->execute ( $sql ) or die ( $sql . '<br>' . $this->db2->ErrorMsg () );
	}


	public function emailAdminBumn(){

		$sql = 'SELECT
					A . LOGIN,
					A .email
				FROM
					users A,
					users_groups_fis b
				WHERE
					A .aktif = \'t\'
				AND A . LOGIN = b.users_login
				AND A .bumn_id = \'' . $this->bumn_id . '\' and b.groups_id = \'2' . $this->bumn_id . '\'';

		$rows = $this->db2->GetAll ( $sql );
		return $rows;
	}

	public function getstatusanakbumn(){
	         return array(
	                  array(
	                      'key' => 1,
	                      'title' => 'Anak Perusahaan'
	                  ),
	                  array(
	                      'key' => 2,
	                      'title' => 'Cucu Perusahaan'
	                  ),
	                  array(
	                      'key' => 3,
	                      'title' => 'Afiliasi'
	                  )                   
	         );
	  }

	  public function getperiodepokokrkap(){
	         return array(
	                  array(
	                      'key' => 7,
	                      'title' => 'RKAP Usulan'
	                  ),
	                  array(
	                      'key' => 8,
	                      'title' => 'Prognosa Tahunan'
	                  )                  
	         );
	  }

	public function getjsontablelogpelaporanbumn($bumn_ids){

    	$row = array();
    	$sLimit = "";
	    if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
		$sLimit = " LIMIT " . $_POST['iDisplayLength'] . " OFFSET " . $_POST['iDisplayStart'];
	    }

    	$sWhere = "";
                

        if(isset($_REQUEST['bumnsearch']) && $_REQUEST['bumnsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.bumn_id = '".$_REQUEST['bumnsearch']."'";  
           }else{
              $sWhere .= " AND A.bumn_id = '".$_REQUEST['bumnsearch']."'";  
           }
        }

        if(isset($_REQUEST['periodesearch']) && $_REQUEST['periodesearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.periode_id = ".$_REQUEST['periodesearch']." ";  
           }else{
              $sWhere .= " AND A.periode_id = ".$_REQUEST['periodesearch']." ";  
           }
        }

        if(isset($_REQUEST['statussearch']) && $_REQUEST['statussearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.status_pelaporan_id = ".$_REQUEST['statussearch']." ";  
           }else{
              $sWhere .= " AND A.status_pelaporan_id = ".$_REQUEST['statussearch']." ";  
           }
        }

    	
    	$sql = 'SELECT
					A . ID,
					b.nama_lengkap as bumn,
					C .nama as laporan,
					d.nama as status,
					a.tahun as tahun,
					e.nama as periode,
					a.tanggal as tanggal,
					a.user_login as user,
					a.pesan as pesan
				FROM
					log_status_pemasukan_bumn A,
					a_bumn_master b,
					jenis_lap C,
					status_pemasukan d,
					periode e
				WHERE
					A .bumn_id = b. ID
				AND C . ID = A .jenis_lap_id
				and d.id = a.status_pelaporan_id
				and e.id = a.periode_id
				and A.bumn_id in(\''.implode("','", $bumn_ids).'\')';

    	//echo $sql.$sWhere.$sLimit;die();

    	$datalogbumn = $this->db->fetchAll($sql.$sWhere.$sLimit);

    	
    	foreach ($datalogbumn as $isi) {

    		$row[] = array($isi['id'],$isi['bumn'],$isi['laporan'],$isi['status'],$isi['tahun'],$isi['periode'],$isi['tanggal'],$isi['user'],$isi['pesan']);
    	}

    	$iTotal = count($this->db->fetchall($sql));

    	/*if ( $filter != "" ){
            $sQueryTotal = count($this->db->fetchall($sql));
            
            $iFilteredTotal	= $sQueryTotal;
        }else{
            $iFilteredTotal = $iTotal;
        }*/
        $iFilteredTotal = $iTotal;

        $json = json_encode(array("sEcho" =>intval($_POST['sEcho']),
                                            "iTotalRecords" => $iTotal,
                                            "iTotalDisplayRecords" => $iFilteredTotal,
                                            "aaData" => $row));

    	return $json;
    }


    public function cekdatamasukrkapusulan(){

    	$sql = 'SELECT
					id,
					bumn_id,
					periode_id,
					tahun,
					aset,
					liabilitas,
					ekuitas,
					pu,
					ebitda,
					bo,
					lbtb,
					lbep,
					capex,
					pajak,
					sdm,
					kurs,
					matauang
				FROM
					keu_rkap_prog
				WHERE
					periode_id = 7
				AND tahun = ' . $this->tahun . '
				AND bumn_id = \'' . $this->bumn_id . '\'';

    	//echo $sql.$sWhere.$sLimit;die();

    	$datakeurkap = count($this->db->fetchAll($sql));


    	return $datakeurkap;
    }


    public function cekdatamasukprogtahunan(){

    	$sql = 'SELECT
					id,
					bumn_id,
					periode_id,
					tahun,
					aset,
					liabilitas,
					ekuitas,
					pu,
					ebitda,
					bo,
					lbtb,
					lbep,
					capex,
					pajak,
					sdm,
					kurs,
					matauang
				FROM
					keu_rkap_prog
				WHERE
					periode_id = 8
				AND tahun = ' . ($this->tahun-1) . '
				AND bumn_id = \'' . $this->bumn_id . '\'';

    	//echo $sql.$sWhere.$sLimit;die();

    	$datakeuprog = count($this->db->fetchAll($sql));


    	return $datakeuprog;
    }



    public function getjsontablerkapusulan(){

    	$row = array();
    	$sLimit = "";
	    if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
		$sLimit = " LIMIT " . $_POST['iDisplayLength'] . " OFFSET " . $_POST['iDisplayStart'];
	    }

    	$sWhere = "";
                

        /*if(isset($_REQUEST['bumnsearch']) && $_REQUEST['bumnsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.bumn_id = '".$_REQUEST['bumnsearch']."'";  
           }else{
              $sWhere .= " AND A.bumn_id = '".$_REQUEST['bumnsearch']."'";  
           }
        }

        if(isset($_REQUEST['periodesearch']) && $_REQUEST['periodesearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.periode_id = ".$_REQUEST['periodesearch']." ";  
           }else{
              $sWhere .= " AND A.periode_id = ".$_REQUEST['periodesearch']." ";  
           }
        }

        if(isset($_REQUEST['statussearch']) && $_REQUEST['statussearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.status_pelaporan_id = ".$_REQUEST['statussearch']." ";  
           }else{
              $sWhere .= " AND A.status_pelaporan_id = ".$_REQUEST['statussearch']." ";  
           }
        }*/

    	
    	$sql = 'SELECT
					id,
					bumn_id,
					periode_id,
					tahun,
					aset,
					liabilitas,
					ekuitas,
					pu,
					ebitda,
					bo,
					lbtb,
					lbep,
					capex,
					pajak,
					sdm,
					kurs,
					matauang
				FROM
					keu_rkap_prog
				WHERE
					periode_id = 7
				AND tahun = ' . $this->tahun . '
				AND bumn_id = \'' . $this->bumn_id . '\'';

    	//echo $sql.$sWhere.$sLimit;die();

    	$datakeurkap = $this->db->fetchAll($sql.$sWhere.$sLimit);

    	
    	foreach ($datakeurkap as $isi) {

    		$delete = '<a onclick=\'ondeletekeurksap('.$isi['id'].');\'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';

    		$edit = '<a onclick=\'oneditrkap('.$isi['id'].');\'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';

    		$aksi = $delete.' &nbsp;'.$edit;

    		$matauang = ($isi['matauang'] == 1)? 'IDR' : 'USD';

    		//$nilaiproyek = "<b>".$matauang." ".number_format($val['nilaiproyek'],0,',',',')."</b>";

    		$row[] = array($matauang." ".number_format($isi['aset'],0,',',','),$matauang." ".number_format($isi['liabilitas'],0,',',','),$matauang." ".number_format($isi['ekuitas'],0,',',','),$matauang." ".number_format($isi['pu'],0,',',','),$matauang." ".number_format($isi['ebitda'],0,',',','),$matauang." ".number_format($isi['bo'],0,',',','),$matauang." ".number_format($isi['lbtb'],0,',',','),$matauang." ".number_format($isi['lbep'],0,',',','),$matauang." ".number_format($isi['capex'],0,',',','),$matauang." ".number_format($isi['pajak'],0,',',','),$isi['sdm'],'<div align="center">'.$aksi.'</div>');
    	}

    	$iTotal = count($this->db->fetchall($sql));

    	/*if ( $filter != "" ){
            $sQueryTotal = count($this->db->fetchall($sql));
            
            $iFilteredTotal	= $sQueryTotal;
        }else{
            $iFilteredTotal = $iTotal;
        }*/
        $iFilteredTotal = $iTotal;

        $json = json_encode(array("sEcho" =>intval($_POST['sEcho']),
                                            "iTotalRecords" => $iTotal,
                                            "iTotalDisplayRecords" => $iFilteredTotal,
                                            "aaData" => $row));

    	return $json;
    }


    public function getjsontableprognosa(){

    	$row = array();
    	$tahunprog = ($this->tahun)-1;
    	$sLimit = "";
	    if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
		$sLimit = " LIMIT " . $_POST['iDisplayLength'] . " OFFSET " . $_POST['iDisplayStart'];
	    }

    	$sWhere = "";
                

        /*if(isset($_REQUEST['bumnsearch']) && $_REQUEST['bumnsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.bumn_id = '".$_REQUEST['bumnsearch']."'";  
           }else{
              $sWhere .= " AND A.bumn_id = '".$_REQUEST['bumnsearch']."'";  
           }
        }

        if(isset($_REQUEST['periodesearch']) && $_REQUEST['periodesearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.periode_id = ".$_REQUEST['periodesearch']." ";  
           }else{
              $sWhere .= " AND A.periode_id = ".$_REQUEST['periodesearch']." ";  
           }
        }

        if(isset($_REQUEST['statussearch']) && $_REQUEST['statussearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.status_pelaporan_id = ".$_REQUEST['statussearch']." ";  
           }else{
              $sWhere .= " AND A.status_pelaporan_id = ".$_REQUEST['statussearch']." ";  
           }
        }*/

    	
    	$sql = 'SELECT
					id,
					bumn_id,
					periode_id,
					tahun,
					aset,
					liabilitas,
					ekuitas,
					pu,
					ebitda,
					bo,
					lbtb,
					lbep,
					capex,
					pajak,
					sdm,
					kurs,
					matauang
				FROM
					keu_rkap_prog
				WHERE
					periode_id = 8
				AND tahun = ' . $tahunprog . '
				AND bumn_id = \'' . $this->bumn_id . '\'';

    	//echo $sql.$sWhere.$sLimit;die();

    	$datakeuprog = $this->db->fetchAll($sql.$sWhere.$sLimit);

    	
    	foreach ($datakeuprog as $isi) {

    		$delete = '<a onclick=\'ondeletekeuprog('.$isi['id'].');\'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';

    		$edit = '<a onclick=\'oneditprog('.$isi['id'].');\'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';

    		$aksi = $delete.' &nbsp;'.$edit;

    		$matauang = ($isi['matauang'] == 1)? 'IDR' : 'USD';

    		/*$row[] = array($isi['aset'],$isi['liabilitas'],$isi['ekuitas'],$isi['pu'],$isi['ebitda'],$isi['bo'],$isi['lbtb'],$isi['lbep'],$isi['capex'],$isi['pajak'],$isi['sdm'],'<div align="center">'.$delete.'</div>');*/

    		$row[] = array($matauang." ".number_format($isi['aset'],0,',',','),$matauang." ".number_format($isi['liabilitas'],0,',',','),$matauang." ".number_format($isi['ekuitas'],0,',',','),$matauang." ".number_format($isi['pu'],0,',',','),$matauang." ".number_format($isi['ebitda'],0,',',','),$matauang." ".number_format($isi['bo'],0,',',','),$matauang." ".number_format($isi['lbtb'],0,',',','),$matauang." ".number_format($isi['lbep'],0,',',','),$matauang." ".number_format($isi['capex'],0,',',','),$matauang." ".number_format($isi['pajak'],0,',',','),$isi['sdm'],'<div align="center">'.$aksi.'</div>');
    	}

    	$iTotal = count($this->db->fetchall($sql));

    	/*if ( $filter != "" ){
            $sQueryTotal = count($this->db->fetchall($sql));
            
            $iFilteredTotal	= $sQueryTotal;
        }else{
            $iFilteredTotal = $iTotal;
        }*/
        $iFilteredTotal = $iTotal;

        $json = json_encode(array("sEcho" =>intval($_POST['sEcho']),
                                            "iTotalRecords" => $iTotal,
                                            "iTotalDisplayRecords" => $iFilteredTotal,
                                            "aaData" => $row));

    	return $json;
    }


    public function insertKeuRkap($fields){
		//var_dump($fields); die();
		return $this->db->insert('keu_rkap_prog', $fields);
	}

	public function insertKeuanganCapex($fields){
		//var_dump($fields); die();
		return $this->db->insert('keuangan_capex', $fields);
	}

	public function insertKeuanganPajak($fields){
		//var_dump($fields); die();
		return $this->db->insert('keu_pajak', $fields);
	}

	public function insertKinerjaKpku($fields){
		//var_dump($fields); die();
		return $this->db->insert('kinerja_kpku', $fields);
	}

	public function insertLkpn($fields){
		// var_dump($fields); die();
		return $this->db->insert('lkpn_test', $fields);
	}

	public function deleteKeuRkapById($id){
		
		return $this->db->delete("keu_rkap_prog", " id = '$id' ");	
	}

	public function deleteKeuanganCapex($id){
		
		return $this->db->delete("keuangan_capex", " id = '$id' ");	
	}

	public function deleteKeuanganPajak($id){
		
		return $this->db->delete("keu_pajak", " id = '$id' ");	
	}

	public function deleteKinerjaKpku($id){
		
		return $this->db->delete("kinerja_kpku", " id = '$id' ");	
	}

	public function updateKinerjaKpku($fields, $id){
		return $this->db->update('kinerja_kpku', $fields, '"id" = \''.$id.'\' ');
	}

	public function updateKeuRkap($fields, $id){
		return $this->db->update('keu_rkap_prog', $fields, '"id" = \''.$id.'\' ');
	}

	public function updateKeuProg($fields, $id){
		return $this->db->update('keu_rkap_prog', $fields, '"id" = \''.$id.'\' ');
	}


	public function updateKeuanganCapex($fields, $id){
		return $this->db->update('keuangan_capex', $fields, '"id" = \''.$id.'\' ');
	}

	public function updateKeuanganPajak($fields, $id){
		return $this->db->update('keu_pajak', $fields, '"id" = \''.$id.'\' ');
	}


	public function getjsontablekpku($bumn_ids){

    	$row = array();
    	$sLimit = "";
	    if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
		$sLimit = " LIMIT " . $_POST['iDisplayLength'] . " OFFSET " . $_POST['iDisplayStart'];
	    }

    	$sWhere = "";
                

        if(isset($_REQUEST['kpkubumnsearch']) && $_REQUEST['kpkubumnsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['kpkubumnsearch']."'";  
           }else{
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['kpkubumnsearch']."'";  
           }
        }

        if(isset($_REQUEST['kpkutahunsearch']) && $_REQUEST['kpkutahunsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.tahun = ".$_REQUEST['kpkutahunsearch']." ";  
           }else{
              $sWhere .= " AND A.tahun = ".$_REQUEST['kpkutahunsearch']." ";  
           }
        }

    	
    	$sql = 'SELECT
    				a.id,
					b.nama_lengkap,
					a.status,
					a.tahun,
					a.kpku_1,
					a.kpku_2,
					a.kpku_3,
					a.kpku_4,
					a.kpku_5,
					a.kpku_6,
					a.kpku_7,
					a.total,
					a.tingkat_kpku,
					a.berkas_pdf,
					a.pesan
				FROM
					kinerja_kpku a, a_bumn_master b
				WHERE
					periode_id = 6
				AND a.bumn_id = b.id
				and a.bumn_id in(\''.implode("','", $bumn_ids).'\')';

    	//echo $sql.$sWhere.$sLimit;die();

    	$datakpku = $this->db->fetchAll($sql.$sWhere.$sLimit);

    	
    	foreach ($datakpku as $isi) {

    		$path = $isi['berkas_pdf'];

    		$delete = '<a onclick=\'ondeletekpku('.$isi['id'].');\'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
    		$edit = '<a onclick=\'oneditkpku('.$isi['id'].');\'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
    		$attachfile = '<a href="#" onclick="location.href=\'/generated/pdf/file/' . $path . '\'"><img src="/images/attachment_fis.png"></a>&nbsp;';
    		// $check = '<input type="checkbox" name=check />';

    		$verifikasi = '<a onclick=\'onsukseskpku('.$isi['id'].');\'><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a> <a onclick=\'onbatalkpku('.$isi['id'].');\'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';

    		if($_SESSION['USERS_HAS_FIS']['EIS_GROUPS']['induk'] == 700){
    			$aksi = $verifikasi;
    		} else {
    			$aksi = $delete.' &nbsp;'.$edit;
    		}

    		//$nilaiproyek = "<b>".$matauang." ".number_format($val['nilaiproyek'],0,',',',')."</b>";
    		// '<div align="center">'.$check.'</div>',
    		$row[] = array($isi['nama_lengkap'],$isi['status'],$isi['tahun'],$isi['kpku_1'],$isi['kpku_2'],$isi['kpku_3'],$isi['kpku_4'],$isi['kpku_5'],$isi['kpku_6'],$isi['kpku_7'],$isi['total'],$isi['tingkat_kpku'],$isi['pesan'],'<div align="center">'.$attachfile.'</div>','<div align="center">'.$aksi.'</div>');
    	}

    	$iTotal = count($this->db->fetchall($sql));

    	/*if ( $filter != "" ){
            $sQueryTotal = count($this->db->fetchall($sql));
            
            $iFilteredTotal	= $sQueryTotal;
        }else{
            $iFilteredTotal = $iTotal;
        }*/
        $iFilteredTotal = $iTotal;

        $json = json_encode(array("sEcho" =>intval($_POST['sEcho']),
                                            "iTotalRecords" => $iTotal,
                                            "iTotalDisplayRecords" => $iFilteredTotal,
                                            "aaData" => $row));

    	return $json;
    }

    public function getjsontablelkpn($bumn_ids){

    	$row = array();
    	$sLimit = "";
	    if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
		$sLimit = " LIMIT " . $_POST['iDisplayLength'] . " OFFSET " . $_POST['iDisplayStart'];
	    }

    	$sWhere = "";
                

        if(isset($_REQUEST['bumnsearch']) && $_REQUEST['bumnsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['bumnsearch']."'";  
           }else{
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['bumnsearch']."'";  
           }
        }

        if(isset($_REQUEST['tahunsearch']) && $_REQUEST['tahunsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.tahun = ".$_REQUEST['tahunsearch']." ";  
           }else{
              $sWhere .= " AND A.tahun = ".$_REQUEST['tahunsearch']." ";  
           }
        }

        if(isset($_REQUEST['periodesearch']) && $_REQUEST['periodesearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND a.periode_id = ".$_REQUEST['periodesearch']." ";  
           }else{
              $sWhere .= " AND a.periode_id = ".$_REQUEST['periodesearch']." ";  
           }
        }

    	
    	$sql = 'SELECT
    				a.id,
					b.nama_lengkap,
					c.nama,
					a.tahun,
					a.saham,
					a.aset,
					a.liabilitas,
					a.ekuitas,
					a.pend_usaha,
					a.laba,
					a.laba_atribusi,
					a.modal,
					a.sdm,
					a.pajak,
					a.dividen,
					a.ebitda,
					a.kas_operasi
				FROM
					lkpn_test a, a_bumn_master b, periode c
				WHERE
					a.periode_id = c.id
				AND a.bumn_id = b.id
				and a.bumn_id in(\''.implode("','", $bumn_ids).'\')';

    	echo $sql.$sWhere.$sLimit;die();

    	$datalkpn = $this->db->fetchAll($sql.$sWhere.$sLimit);

    	
    	foreach ($datalkpn as $isi) {

    		$path = $isi['berkas_pdf'];

    		$delete = '<a onclick=\'ondeletekpku('.$isi['id'].');\'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
    		$edit = '<a onclick=\'oneditkpku('.$isi['id'].');\'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
    		$attachfile = '<a href="#" onclick="location.href=\'/generated/pdf/file/' . $path . '\'"><img src="/images/attachment_fis.png"></a>&nbsp;';
    		$check = '<input type="checkbox" name=check />';

    		$verifikasi = '<a onclick=\'onsukseskpku('.$isi['id'].');\'><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></a> <a onclick=\'onbatalkpku('.$isi['id'].');\'><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';

    		if($_SESSION['USERS_HAS_FIS']['EIS_GROUPS']['induk'] == 700){
    			$aksi = $verifikasi;
    		} else {
    			$aksi = $delete.' &nbsp;'.$edit;
    		}

    		//$nilaiproyek = "<b>".$matauang." ".number_format($val['nilaiproyek'],0,',',',')."</b>";
    		// '<div align="center">'.$check.'</div>',
    		$row[] = array('<div align="center">'.$check.'</div>',$isi['nama_lengkap'],$isi['nama'],$isi['tahun'],$isi['saham'],$isi['aset'],$isi['liabilitas'],$isi['ekuitas'],$isi['pend_usaha'],$isi['laba'],$isi['laba_atribusi'],$isi['modal'],$isi['pajak'],$isi['dividen'],$isi['ebitda'],$isi['kas_koperasi'],'<div align="center">'.$aksi.'</div>');
    	}

    	$iTotal = count($this->db->fetchall($sql));

    	/*if ( $filter != "" ){
            $sQueryTotal = count($this->db->fetchall($sql));
            
            $iFilteredTotal	= $sQueryTotal;
        }else{
            $iFilteredTotal = $iTotal;
        }*/
        $iFilteredTotal = $iTotal;

        $json = json_encode(array("sEcho" =>intval($_POST['sEcho']),
                                            "iTotalRecords" => $iTotal,
                                            "iTotalDisplayRecords" => $iFilteredTotal,
                                            "aaData" => $row));

    	return $json;
    }

    public function getjsontablecapex(){

    	$row = array();
    	$sLimit = "";
	    if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
		$sLimit = " LIMIT " . $_POST['iDisplayLength'] . " OFFSET " . $_POST['iDisplayStart'];
	    }

    	$sWhere = "";
                

        /*if(isset($_REQUEST['kpkubumnsearch']) && $_REQUEST['kpkubumnsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['kpkubumnsearch']."'";  
           }else{
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['kpkubumnsearch']."'";  
           }
        }

        if(isset($_REQUEST['kpkutahunsearch']) && $_REQUEST['kpkutahunsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.tahun = ".$_REQUEST['kpkutahunsearch']." ";  
           }else{
              $sWhere .= " AND A.tahun = ".$_REQUEST['kpkutahunsearch']." ";  
           }
        }*/


		$sql = 'SELECT
					id,
					bumn_id,
					periode_id,
					tahun,
					nilai_01,
					nilai_02,
					nilai_04,
					satuan_capex
				FROM
					keuangan_capex
				WHERE
					periode_id = ' . $this->periode_id . '
				AND tahun = ' . $this->tahun . '
				AND bumn_id = \'' . $this->bumn_id . '\'';

    	//echo $sql.$sWhere.$sLimit;die();

    	$datacapex = $this->db->fetchAll($sql.$sWhere.$sLimit);

    	
    	foreach ($datacapex as $isi) {

    		if ($isi['satuan_capex'] == 1) {
    			$matauang = 'IDR';
    		} elseif ($isi['satuan_capex'] == 2) {
    			$matauang = 'USD';
    		} elseif ($isi['satuan_capex'] == 3) {
    			$matauang = 'IDR';
    		} else {
    			$matauang = 'USD';
    		}

    		$delete = '<a onclick=\'ondeletecapex('.$isi['id'].');\'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
    		$edit = '<a onclick=\'oneditcapex('.$isi['id'].');\'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
    		

    		$aksi = $delete.' &nbsp;'.$edit;


    		$row[] = array($matauang." ".number_format($isi['nilai_01'],0,',',','),$matauang." ".number_format($isi['nilai_02'],0,',',','),$matauang." ".number_format($isi['nilai_04'],0,',',','),'<div align="center">'.$aksi.'</div>');
    	}

    	$iTotal = count($this->db->fetchall($sql));

    	/*if ( $filter != "" ){
            $sQueryTotal = count($this->db->fetchall($sql));
            
            $iFilteredTotal	= $sQueryTotal;
        }else{
            $iFilteredTotal = $iTotal;
        }*/
        $iFilteredTotal = $iTotal;

        $json = json_encode(array("sEcho" =>intval($_POST['sEcho']),
                                            "iTotalRecords" => $iTotal,
                                            "iTotalDisplayRecords" => $iFilteredTotal,
                                            "aaData" => $row));

    	return $json;
    }

    public function getjsontablepajak(){

    	$row = array();
    	$sLimit = "";
	    if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
		$sLimit = " LIMIT " . $_POST['iDisplayLength'] . " OFFSET " . $_POST['iDisplayStart'];
	    }

    	$sWhere = "";
                

        /*if(isset($_REQUEST['kpkubumnsearch']) && $_REQUEST['kpkubumnsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['kpkubumnsearch']."'";  
           }else{
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['kpkubumnsearch']."'";  
           }
        }

        if(isset($_REQUEST['kpkutahunsearch']) && $_REQUEST['kpkutahunsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND A.tahun = ".$_REQUEST['kpkutahunsearch']." ";  
           }else{
              $sWhere .= " AND A.tahun = ".$_REQUEST['kpkutahunsearch']." ";  
           }
        }*/


		$sql = 'SELECT
					id,
					bumn_id,
					periode_id,
					tahun,
					pph,
					pph_orang,
					ppn,
					ppnbm,
					bphtb,
					pajak_ekport,
					pajak_lain,
					pbb,
					total_pajak,
					satuan_pajak
				FROM
					keu_pajak
				WHERE
					periode_id = ' . $this->periode_id . '
				AND tahun = ' . $this->tahun . '
				AND bumn_id = \'' . $this->bumn_id . '\'';

    	//echo $sql.$sWhere.$sLimit;die();

    	$datapajak = $this->db->fetchAll($sql.$sWhere.$sLimit);

    	
    	foreach ($datapajak as $isi) {

    		if ($isi['satuan_pajak'] == 1) {
    			$matauang = 'IDR';
    		} elseif ($isi['satuan_pajak'] == 2) {
    			$matauang = 'IDR';
    		} elseif ($isi['satuan_pajak'] == 3) {
    			$matauang = 'IDR';
    		} else {
    			$matauang = 'IDR';
    		}

    		$delete = '<a onclick=\'ondeletepajak('.$isi['id'].');\'><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
    		$edit = '<a onclick=\'oneditpajak('.$isi['id'].');\'><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
    		

    		$aksi = $delete.' &nbsp;'.$edit;


    		$row[] = array($matauang." ".number_format($isi['pph'],0,',',','),$matauang." ".number_format($isi['pph_orang'],0,',',','),$matauang." ".number_format($isi['ppn'],0,',',','),$matauang." ".number_format($isi['ppnbm'],0,',',','),$matauang." ".number_format($isi['bphtb'],0,',',','),$matauang." ".number_format($isi['pajak_ekport'],0,',',','),$matauang." ".number_format($isi['pajak_lain'],0,',',','),$matauang." ".number_format($isi['pbb'],0,',',','),$matauang." ".number_format($isi['total_pajak'],0,',',','),'<div align="center">'.$aksi.'</div>');
    	}

    	$iTotal = count($this->db->fetchall($sql));

    	/*if ( $filter != "" ){
            $sQueryTotal = count($this->db->fetchall($sql));
            
            $iFilteredTotal	= $sQueryTotal;
        }else{
            $iFilteredTotal = $iTotal;
        }*/
        $iFilteredTotal = $iTotal;

        $json = json_encode(array("sEcho" =>intval($_POST['sEcho']),
                                            "iTotalRecords" => $iTotal,
                                            "iTotalDisplayRecords" => $iFilteredTotal,
                                            "aaData" => $row));

    	return $json;
    }



    public function getjsontableanakperush($bumn_ids){

    	$row = array();
    	$sLimit = "";
	    if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
		$sLimit = " LIMIT " . $_POST['iDisplayLength'] . " OFFSET " . $_POST['iDisplayStart'];
	    }

    	$sWhere = "";
                

        if(isset($_REQUEST['anakbumnsearch']) && $_REQUEST['anakbumnsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['anakbumnsearch']."'";  
           }else{
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['anakbumnsearch']."'";  
           }
        }

        if(isset($_REQUEST['jenisanakbumnsearch']) && $_REQUEST['jenisanakbumnsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND a.status_anak_id = '".$_REQUEST['jenisanakbumnsearch']."'";  
           }else{
              $sWhere .= " AND a.status_anak_id = '".$_REQUEST['jenisanakbumnsearch']."'";  
           }
        }

		$sql = 'SELECT
					A . ID,
					c.nama_lengkap as bumn,
					A .nama,
					A .alamat,
					A .sektor_usaha,
					b.nama AS status,
					a.induk_id,
					(select f.nama from anak f where f.id = a.induk_id) as anak_induk,
					a.persentasi
				FROM
					anak A,
					status_anak b,
					a_bumn_master c
				WHERE
				a.bumn_id = c.id
				AND A .status_anak_id = b. ID
				and a.bumn_id in(\''.implode("','", $bumn_ids).'\')';

    	//echo $sql.$sWhere.$sLimit;die();

    	$dataanakperush = $this->db->fetchAll($sql.$sWhere.$sLimit);

    	
    	foreach ($dataanakperush as $isi) {
    		

    		$row[] = array($isi['bumn'],$isi['nama'],$isi['alamat'],$isi['sektor_usaha'],$isi['status'],$isi['anak_induk'],$isi['persentasi']);
    	}

    	$iTotal = count($this->db->fetchall($sql));

    	
        /*if ( $sWhere != "" ){
            $sQueryTotal = count($this->db->fetchall($sql));
            
            $iFilteredTotal	= $sQueryTotal;
        }else{
            $iFilteredTotal = $iTotal;
        }*/

        if($sWhere != "" ){
           $sQueryTotal = "SELECT count(*) AS counttotal FROM (".$sql.$sWhere.") B";
           $rResultTotal = $this->db->fetchRow($sQueryTotal);
           $iFilteredTotal = $rResultTotal['counttotal'];
        }else{
           $iFilteredTotal = $iTotal;
        }

        $json = json_encode(array("sEcho" =>intval($_POST['sEcho']),
                                            "iTotalRecords" => $iTotal,
                                            "iTotalDisplayRecords" => $iFilteredTotal,
                                            "aaData" => $row));

    	return $json;
    }


    public function getjsontablepokokrkap($bumn_ids){

    	$row = array();
    	$sLimit = "";
	    if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
		$sLimit = " LIMIT " . $_POST['iDisplayLength'] . " OFFSET " . $_POST['iDisplayStart'];
	    }

    	$sWhere = "";
                

        if(isset($_REQUEST['pokokrkapsearch']) && $_REQUEST['pokokrkapsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['pokokrkapsearch']."'";  
           }else{
              $sWhere .= " AND a.bumn_id = '".$_REQUEST['pokokrkapsearch']."'";  
           }
        }

        if(isset($_REQUEST['periodepokokrkapsearch']) && $_REQUEST['periodepokokrkapsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND a.periode_id = '".$_REQUEST['periodepokokrkapsearch']."'";  
           }else{
              $sWhere .= " AND a.periode_id = '".$_REQUEST['periodepokokrkapsearch']."'";  
           }
        }

        if(isset($_REQUEST['pokokrkaptahunsearch']) && $_REQUEST['pokokrkaptahunsearch'] != ""){
           if($sWhere != ''){
              $sWhere .= " AND a.tahun = ".$_REQUEST['pokokrkaptahunsearch']." ";  
           }else{
              $sWhere .= " AND a.tahun = ".$_REQUEST['pokokrkaptahunsearch']." ";  
           }
        }

		$sql = 'SELECT
					A . ID,
					C .nama_lengkap AS bumn,
					b.nama AS periode,
					A .tahun,
					A .aset,
					A .liabilitas,
					A .ekuitas,
					A .pu,
					A .ebitda,
					A .bo,
					A .lbtb,
					A .lbep,
					A .capex,
					A .pajak,
					A .sdm,
					A .kurs,
					A .matauang
				FROM
					keu_rkap_prog A,
					a_bumn_master C,
					periode_baru b
				WHERE
					A .bumn_id = C . ID
				AND A .periode_id = b. ID
				AND a.bumn_id in(\''.implode("','", $bumn_ids).'\')';

    	//echo $sql.$sWhere.$sLimit;die();

    	$pokokrkap = $this->db->fetchAll($sql.$sWhere.$sLimit);

    	
    	foreach ($pokokrkap as $isi) {

    		if ($isi['matauang'] == 1) {
    			$matauang = 'IDR';
    		} else {
    			$matauang = 'USD';
    		}
    		

    		$row[] = array($isi['bumn'],$isi['periode'],$isi['tahun'],$matauang." ".number_format($isi['aset'],0,',',','),$matauang." ".number_format($isi['liabilitas'],0,',',','),$matauang." ".number_format($isi['ekuitas'],0,',',','),$matauang." ".number_format($isi['pu'],0,',',','),$matauang." ".number_format($isi['ebitda'],0,',',','),$matauang." ".number_format($isi['bo'],0,',',','),$matauang." ".number_format($isi['lbtb'],0,',',','),$matauang." ".number_format($isi['lbep'],2,',',','),$matauang." ".number_format($isi['capex'],0,',',','),$matauang." ".number_format($isi['pajak'],0,',',','),$isi['sdm']);
    	}

    	$iTotal = count($this->db->fetchall($sql));

    	
        /*if ( $sWhere != "" ){
            $sQueryTotal = count($this->db->fetchall($sql));
            
            $iFilteredTotal	= $sQueryTotal;
        }else{
            $iFilteredTotal = $iTotal;
        }*/

        if($sWhere != "" ){
           $sQueryTotal = "SELECT count(*) AS counttotal FROM (".$sql.$sWhere.") B";
           $rResultTotal = $this->db->fetchRow($sQueryTotal);
           $iFilteredTotal = $rResultTotal['counttotal'];
        }else{
           $iFilteredTotal = $iTotal;
        }

        $json = json_encode(array("sEcho" =>intval($_POST['sEcho']),
                                            "iTotalRecords" => $iTotal,
                                            "iTotalDisplayRecords" => $iFilteredTotal,
                                            "aaData" => $row));

    	return $json;
    }


    public function getlapkpkubyid($id_kpku){

    	$sql = 'SELECT
    				a.id,
    				a.bumn_id,
					b.nama_lengkap,
					a.status,
					a.tahun,
					a.kpku_1,
					a.kpku_2,
					a.kpku_3,
					a.kpku_4,
					a.kpku_5,
					a.kpku_6,
					a.kpku_7,
					a.total,
					a.tingkat_kpku,
					a.berkas_pdf,
					a.pesan
				FROM
					kinerja_kpku a, a_bumn_master b
				WHERE
					a.id = '.$id_kpku.'';
		//echo $sql;die();

    	$data = $this->db->fetchAll($sql);

    	return $data;
    }

    public function getlaplkpnbyid($id_lkpn){

    	$sql = 'SELECT
    				a.id,
					b.nama_lengkap,
					c.nama,
					a.tahun,
					a.saham,
					a.aset,
					a.liabilitas,
					a.ekuitas,
					a.pend_usaha,
					a.laba,
					a.laba_atribusi,
					a.modal,
					a.sdm,
					a.pajak,
					a.dividen,
					a.ebitda,
					a.kas_koperasi
				FROM
					lkpn_test a, a_bumn_master b, periode c
				WHERE
					a.id = '.$id_lkpn.''; 
		//echo $sql;die();

    	$data = $this->db->fetchAll($sql);

    	return $data;
    }

    public function getlapkeurkapbyid($id_rkap){

    	$sql = 'SELECT
					id,
					bumn_id,
					periode_id,
					tahun,
					aset,
					liabilitas,
					ekuitas,
					pu,
					ebitda,
					bo,
					lbtb,
					lbep,
					capex,
					pajak,
					sdm,
					kurs,
					matauang
				FROM
					keu_rkap_prog
				WHERE
					id = '.$id_rkap.'';
		//echo $sql;die();

    	$data = $this->db->fetchAll($sql);

    	return $data;
    }


    public function getlapkeuprogbyid($id_prog){

    	$sql = 'SELECT
					id,
					bumn_id,
					periode_id,
					tahun,
					aset,
					liabilitas,
					ekuitas,
					pu,
					ebitda,
					bo,
					lbtb,
					lbep,
					capex,
					pajak,
					sdm,
					kurs,
					matauang
				FROM
					keu_rkap_prog
				WHERE
					id = '.$id_prog.'';
		//echo $sql;die();

    	$data = $this->db->fetchAll($sql);

    	return $data;
    }

    public function getcapexbyid($id_capex){

    	$sql = 'SELECT
					id,
					bumn_id,
					periode_id,
					tahun,
					nilai_01,
					nilai_02,
					nilai_04,
					satuan_capex
				FROM
					keuangan_capex
				WHERE
					id = '.$id_capex.'';
		//echo $sql;die();

    	$data = $this->db->fetchAll($sql);

    	return $data;
    }

    public function getpajakbyid($id_pajak){

    	$sql = 'SELECT
					id,
					bumn_id,
					periode_id,
					tahun,
					pph,
					pph_orang,
					ppn,
					ppnbm,
					bphtb,
					pajak_ekport,
					pajak_lain,
					pbb,
					satuan_pajak
				FROM
					keu_pajak
				WHERE
					id = '.$id_pajak.'';
		//echo $sql;die();

    	$data = $this->db->fetchAll($sql);

    	return $data;
    }
}


