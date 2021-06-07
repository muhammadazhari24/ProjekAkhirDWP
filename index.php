<?php
	//Koneksi Database
	$server = "localhost";
	$user = "root";
	$pass = "";
	$database = "projek1";

	$koneksi = mysqli_connect($server, $user, $pass, $database)or die (mysql_error($koneksi));

	//jika tombol simpan diklik
	if (isset($_POST['bsimpan'])) {

		//Pengujian apakah data akan diedit atau disimpan baru
		if ($_GET['hal'] == "edit") {
			//Data akan di edit
			$edit = mysqli_query($koneksi, " UPDATE data_covid set
											provinsi = '$_POST[tprovinsi]',
											positif = '$_POST[tpositif]',
											sembuh = '$_POST[tsembuh]',
											meninggal = '$_POST[tmeninggal]',
											tanggal = '$_POST[ttanggal]'
											WHERE id = '$_GET[id]' 
											");
			// Jika edit sukses
			if ($edit){
				echo "<script>
						alert('EDIT DATA SUKSES!!!');
						document.location = 'index.php';
					</script>";
			}else{
				echo "<script>
						alert('EDIT DATA GAGAL!!!');
						document.location = 'index.php';
					</script>";
			}
		}else{
			//Data akan disimpan baru
			$simpan = mysqli_query($koneksi, "INSERT INTO data_covid(provinsi, positif, sembuh, meninggal, tanggal)
										VALUES 	('$_POST[tprovinsi]',
												'$_POST[tpositif]', 
												'$_POST[tsembuh]', 
												'$_POST[tmeninggal]'),
												'$_POST[ttanggal]')
												");
			// Jika simpan sukses
			if ($simpan){
				echo "<script>
						alert('SIMPAN DATA SUKSES!!!');
						document.location = 'index.php';
					</script>";
			}else{
				echo "<script>
						alert('SIMPAN DATA GAGAL!!!');
						document.location = 'index.php';
					</script>";
			}
		}



	}

	//Pengujian jika tombol Edit / Hapus di klik
	if(isset($_GET['hal']))
	{
		//Pengujian jika edit Data
		if($_GET['hal'] == "edit")
		{
			//Tampilkan Data yang akan diedit
			$tampil = mysqli_query($koneksi, "SELECT * FROM data_covid WHERE id = '$_GET[id]' ");
			$data = mysqli_fetch_array($tampil);
			if($data)
			{
				//Jika data ditemukan, maka data ditampung ke dalam variabel
				$vprovinsi = $data['provinsi'];
				$vpositif = $data['positif'];
				$vsembuh = $data['sembuh'];
				$vmeninggal = $data['meninggal'];
				$vtanggal = $data['tanggal'];
			}
		}
		else if ($_GET['hal'] == "hapus")
		{
			//Persiapan hapus data
			$hapus = mysqli_query($koneksi, "DELETE FROM data_covid WHERE id = '$_GET[id]' ");
			if($hapus){
				echo "<script>
						alert('Hapus Data Suksess!!');
						document.location='index.php';
				     </script>";
			}
		}
	}

?>



<!DOCTYPE html>
<html>
<head>
	<title>CRUD 2021</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
	
	<h1 class="text-center"> CRUD </h1>

	<!-- Awal Card Form -->
	<div class="card mt-3">
	  <div class="card-header bg-primary text-white">
	    Form Data Covid
	  </div>
	  <div class="card-body">
	    <form method="post" action="">
	    	<div class="form-group">
	    		<label>Provinsi</label>
	    		<input type="text" name="tprovinsi" value="<?=@$vprovinsi?>" class="form-control" placeholder="Provinsi" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Positif</label>
	    		<input type="text" name="tpositif" value="<?=@$vpositif?>" class="form-control" placeholder="Jumlah Positif" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Sembuh</label>
	    		<input type="text" name="tsembuh" value="<?=@$vsembuh?>" class="form-control" placeholder="Jumlah Sembuh" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Meninggal</label>
	    		<input type="text" name="tmeninggal" value="<?=@$vmeninggal?>" class="form-control" placeholder="Jumlah Meninggal" required>
	    	</div>
	    	<div class="form-group">
	    		<label>Tanggal</label>
	    		<input type="text" name="ttanggal" value="<?=@$vtanggal?>" class="form-control" placeholder="Tanggal" required>
	    	</div>


	    	<button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
	    	<button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>

	    </form>
	  </div>
	</div>
	<!-- Akhir Card Form -->


	<!-- Awal Card Table -->
	<div class="card mt-3">
	  <div class="card-header bg-success text-white">
	    DATA COVID
	  </div>
	  <div class="card-body">
	   
	  	<table class="table table-bordered table-striped">
	  		<tr>
	  			<th>No.</th>
	  			<th>Provinsi</th>
	  			<th>Positif</th>
	  			<th>Sembuh</th>
	  			<th>Meninggal</th>
	  			<th>Tanggal</th>
	  		</tr>

	  		<?php
	  			$no = 1;
	  			$tampil = mysqli_query($koneksi, "SELECT * from data_covid order by id desc");
	  			while ($data = mysqli_fetch_array($tampil)) :
	  		?>


	  		<tr>
	  			<td><?=$no++?></td>
	  			<td><?=$data['provinsi']?></td>
	  			<td><?=$data['positif']?></td>
	  			<td><?=$data['sembuh']?></td>
	  			<td><?=$data['meninggal']?></td>
	  			<td><?=$data['tanggal']?></td>
	  			<td>
	  				<a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning">Edit</a>
	  				<a href="index.php?hal=hapus$id=<?=$data['id']?>" 
	  					onclick ="return confirm('Apakah yakin ingin menghapus data ini?')" class="btn btn-danger">Hapus</a>
	  			</td>
	  		</tr>
	  	<?php endwhile; //Penutup perulangan while?>
	  	</table>

	  </div>
	</div>
	<!-- Akhir Card Table -->

</div>
<script type="text/javascript" serc="js/bootstrap.min.js"></script>
</body>
</html>