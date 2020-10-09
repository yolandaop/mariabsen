<?php 
//panggil file session-admin.php untuk menentukan apakah admin atau bukan
include('system/inc/session-gurumapel.php');
//panggil file conn.php untuk menghubung ke server
include('system/config/conn.php');
//panggil file header.php untuk menghubungkan konten bagian atas
include('system/inc/header.php');
//memberi judul halaman
echo '<title>Absen Siswa - MARI-ABSEN</title>';
//panggil file css.php untuk desain atau tema
include('system/inc/css.php');
//panggil file navi-gurumapel.php untuk menghubungkan gurumapel ke konten
include('system/inc/nav-gurumapel.php');
//mendapatkan informasi untuk mengabsen siswa
$nm_kelas = $_GET['kelas'];
$query = mysql_query("SELECT * FROM kelas WHERE nm_kelas='$nm_kelas' ORDER BY nm_kelas ASC") or die(mysql_error());
$data = mysql_fetch_array($query);
//merubah waktu kedalam format indonesia
$hari = array ("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$bln = array ("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
?>



	<div class="page-content">
		<div class="container-fluid">
			<section class="box-typical">
				<header class="box-typical-header">
					<div class="tbl-row">
						<div class="tbl-cell tbl-cell-title">
							<div align="center">
								<h3 align="center"> ABSEN SHOLAT KELAS : <?php echo $nm_kelas; ?></h3>
								<h7 align="center">( <?php echo "".$hari[date("w")].", ".date("j")." ".$bln[date("n")]." ".date("Y");""; ?> )</h7>
							</div>
						</div>
					</div>
				</header>
				
				<form action="page.php?process-insert-absensi-sholat" method="post" id="form-absen" name="postform">
					<div class="box-typical-body">
						<div class="table-responsive">
							<table id="table-sm" class="table table-bordered table-hover table-sm">
								<thead>
									<tr>
									<th><center>No</center></th>	
									<th><center>Nama</center></th>
									<th><center>Kehadiran</center></th>
									<th><center>NIS</center></th>
									<th><center>Keterangan</center></th>
									<th><center>Kelas</center></th>
									</tr>
								</thead>
								
								<tbody>
									<?php
									//penting nech buat kasih nilai awal cekbox
									$tanggal=date("d/m/Y");
									$no=0;
									$i=1;
									$query=mysql_query("SELECT s.nama, s.nis, s.nm_kelas, s.jns_kel, ass.ket FROM siswa s LEFT JOIN absensi_sholat ass ON s.nis = ass.nis WHERE s.nm_kelas='$nm_kelas' AND (ass.tanggal='$tanggal' OR ass.tanggal IS NULL) ORDER BY s.nis ASC");
									while($data=mysql_fetch_array($query)){
									?>
									<tr>	
									<input type="hidden" value="<?php echo $data['nm_kelas'];?>" name="nm_kelas"/>
									<input type="hidden" value="<?php echo $tanggal; ?>" name="tanggal"/>
									<td><?php echo $i;?></td>
									<td><?php echo $data['nama'];?></td>
									<td class="radio" align="center">
									<?php
									echo " <input type='radio' name='absen-$data[nis]' value='sholat' id='$no'"; if($data['ket'] == "S") echo 'checked'; echo "><label for='$no'>Sholat  </label>";
									$no++;
									echo " <input type='radio' name='absen-$data[nis]' value='tidaksholat' id='$no'"; if($data['ket'] == "TS") echo 'checked'; echo "><label for='$no'>Tidak Sholat  </label>";
									$no++;
									if($data[jns_kel] == 'Perempuan') {
									echo " <input type='radio' name='absen-$data[nis]' value='halangan' id='$no'"; if($data['ket'] == "HL") echo 'checked'; echo "><label for='$no'>Halangan  </label>";
									$no++;
									}
									?>
									</td>
									<td><?php echo $data['nis'];?></td>
									<td> <?php echo '<input id="table-sm" class="table table-bordered table-hover table-sm" name="keterangan-'.$data['nis'].'" placeholder="Keterangan" type="text">'; ?> </td>
									<td align="center"><?php echo $data['nm_kelas'];?></td>
									</tr>
									<?php
									$i++;
									}
									?>
								</tbody>
							</table>
						</div>
					</div><!--.box-typical-body-->
					
					<div class="card-block">
						<div class="form-group form-group-checkbox">
							<div class="checkbox float-left">
								<input 	id="absen-agree" type="checkbox" name="info" value="succes"
								data-validation="[NOTEMPTY]"
								data-validation-message="Klik ini jika benar telah terabsen!">
								<label for="absen-agree">Semua siswa telah terabsen?</label>
							</div>
						</div>
						<div class="row">  
							<div class="col-md-12">
								<div class="form-group" align="center">
									<div class="btn-group" role="group">
										<button id="form-absen" name="form-absen" type="submit" class="btn btn-default font-icon font-icon-event" data-toggle="tooltip" data-placement="top" title="Absen?" /></button>
										<a href="javascript:history.back()" class="btn btn-default font-icon font-icon-refresh-2" data-toggle="tooltip" data-placement="top" title="Kembali?"></a>
									</div>
								</div>
							</div><!--.col-md-12-->
						</div><!--.row-->
					</div><!--.card-block-->
				</form>
			</section>
			
		</div><!--.container-fluid-->
	</div><!--.page-content-->
	
<?php 
include('system/inc/footer.php');
?>