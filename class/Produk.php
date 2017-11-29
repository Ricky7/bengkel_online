<?php

class Produk {

	private $db; 
    private $error; 

    function __construct($db_conn)
    {
        $this->db = $db_conn;

    }

    //Kategori
    public function tambahKategori($fields = array())
    {

        $keys = array_keys($fields);

        $values = "'" . implode( "','", $fields ) . "'";

        $sql = "INSERT INTO tbl_kategori (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

        if ($this->db->prepare($sql)) {
            if ($this->db->exec($sql)) {
                return true;
            }
        }

        return false;

    }

    public function updateKategori($fields = array(), $id) {

		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = '{$value}'";
			if($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}

		$sql = "UPDATE tbl_kategori SET {$set} WHERE id_kategori = {$id}";

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;

	}

	public function delKategori($id) {

        $stmt = $this->db->prepare("DELETE FROM tbl_kategori WHERE id_kategori=:id");
        $stmt->bindparam(":id",$id);
        $stmt->execute();
        return true;
    }

    public function daftarKategori($query) {

        $stmt = $this->db->prepare($query);
        $stmt->execute();
    
        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>

                <tr>
                	<td><?php print($row['id_kategori']); ?></td>
                    <td><?php print($row['nama_kategori']); ?></td>
                    <td><?php print($row['deskripsi_kat']); ?></td>
                    <td><a href="admin_edit_kat.php?id=<?php print($row['id_kategori']); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></td>
                    <td>
                    <a href="#" data-href="admin_del_kat.php?id=<?php print($row['id_kategori']); ?>" data-toggle="modal" data-target="#confirm-delete" class="hapus"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>
                <?php
            }
        }
        else
        {
            ?>
            <tr>
            <td>Data tidak ada...</td>
            </tr>
            <?php
        }

    }

    public function getKategoriID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM tbl_kategori WHERE id_kategori=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

    public function getUserID($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM tbl_user WHERE id_user=:id");
        $stmt->execute(array(":id"=>$id));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        return $editRow;
    }

	public function getKategori() {

    	try {
            // Ambil data Produk dari database
            $query = $this->db->prepare("SELECT * FROM tbl_kategori");
            $query->execute();
            return $query->fetchAll();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function Laporan($query) {

        $jumlah_desimal = "0";
        $pemisah_desimal = ",";
        $pemisah_ribuan = ".";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $total_harga = 0;

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                $total_harga += $row['harga'];
                ?>

                <tr>
                    <td><?php print($row['kode_produk']); ?></td>
                    <td><?php print($row['nama_produk']); ?></td>
                    <td><?php print($row['total']); ?></td>
                    <td align="left"><?php print('Rp.'.number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                </tr>
                <?php
            }
            ?>
                <tr>
                    <td colspan="3"><b>Sub Total<b></td>
                    <td align="left"><?php print('Rp.'.number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                </tr>
            <?php
        }
        else
        {
            ?>
            <tr>
            <td>Data tidak ada...</td>
            </tr>
            <?php
        }

    }

    public function getLastError(){
        return $this->error;
    }

    public function paging($query,$records_per_page)
    {
        $starting_position=0;
        if(isset($_GET["page_no"]))
        {
            $starting_position=($_GET["page_no"]-1)*$records_per_page;
        }
        $query2=$query." limit $starting_position,$records_per_page";
        return $query2;
    }

    public function paginglink($query,$records_per_page)
    {
        
        $self = $_SERVER['PHP_SELF'];
        
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        $total_no_of_records = $stmt->rowCount();
        
        if($total_no_of_records > 0)
        {
            ?><ul class="pagination"><?php
            $total_no_of_pages=ceil($total_no_of_records/$records_per_page);
            $current_page=1;
            if(isset($_GET["page_no"]))
            {
                $current_page=$_GET["page_no"];
            }
            if($current_page!=1)
            {
                $previous =$current_page-1;
                echo "<li><a href='".$self."?page_no=1'>First</a></li>";
                echo "<li><a href='".$self."?page_no=".$previous."'>Previous</a></li>";
            }
            for($i=1;$i<=$total_no_of_pages;$i++)
            {
                if($i==$current_page)
                {
                    echo "<li><a href='".$self."?page_no=".$i."' style='color:red;'>".$i."</a></li>";
                }
                else
                {
                    echo "<li><a href='".$self."?page_no=".$i."'>".$i."</a></li>";
                }
            }
            if($current_page!=$total_no_of_pages)
            {
                $next=$current_page+1;
                echo "<li><a href='".$self."?page_no=".$next."'>Next</a></li>";
                echo "<li><a href='".$self."?page_no=".$total_no_of_pages."'>Last</a></li>";
            }
            ?></ul><?php
        }
    }

    public function daftarProduk($query) {

    	$jumlah_desimal = "0";
		$pemisah_desimal = ",";
		$pemisah_ribuan = ".";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
    
        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>

                <tr>
                	<td><?php print($row['id_produk']); ?></td>
                	<td><img src="../assets/image_produk/<?php print($row['gambar']); ?>" width="60px" height="60px"></td>
                    <td><?php print($row['nama_produk']); ?></td>
                    <td><?php print($row['kode_produk']); ?></td>
                    <td><?php print(number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                    <td><?php print($row['stok']); ?></td>
                    <td><a href="admin_edit_produk.php?id=<?php print($row['id_produk']); ?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></td>
                    <td>
                    <a href="#" data-href="admin_del_produk.php?id=<?php print($row['id_produk']); ?>" data-toggle="modal" data-target="#confirm-delete" class="hapus"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                    </td>
                </tr>
                <?php
            }
        }
        else
        {
            ?>
            <tr>
            <td>Data tidak ada...</td>
            </tr>
            <?php
        }

    }

    public function insertProduk($fields = array()) {
		$keys = array_keys($fields);

		$values = "'" . implode( "','", $fields ) . "'";

		$sql = "INSERT INTO tbl_produk (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;
	}

	public function updateProduk($fields = array(), $id) {

		$set = '';
		$x = 1;

		foreach ($fields as $name => $value) {
			$set .= "{$name} = '{$value}'";
			if($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}

		$sql = "UPDATE tbl_produk SET {$set} WHERE id_produk = {$id}";

		if ($this->db->prepare($sql)) {
	        if ($this->db->exec($sql)) {
	            return true;
	        }
	    }

		return false;

	}

	public function getProdukID($id)
	{
		$stmt = $this->db->prepare("SELECT * FROM tbl_produk WHERE id_produk=:id");
		$stmt->execute(array(":id"=>$id));
		$editRow=$stmt->fetch(PDO::FETCH_ASSOC);
		return $editRow;
	}

	public function delProduk($id) {

        $stmt = $this->db->prepare("DELETE FROM tbl_produk WHERE id_produk=:id");
        $stmt->bindparam(":id",$id);
        $stmt->execute();
        return true;
    }


    //****Index****//
    public function indexProduk($query) {

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        // format mata uang
        $jumlah_desimal = "0";
        $pemisah_desimal = ",";
        $pemisah_ribuan = ".";

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>

                <div class="col-md-3 top_brand_left" style="padding-bottom:20px;">
					<div class="hover14 column">
						<div class="agile_top_brand_left_grid">
							<div class="agile_top_brand_left_grid1">
								<figure>
									<div class="snipcart-item block" >
										<div class="snipcart-thumb">
											<a href="single.php?item_id=<?php print($row['id_produk']); ?>"><img title=" " alt=" " src="assets/image_produk/<?php print($row['gambar']); ?>" width="90px" height="90px"/></a>		
											<p align="center"><?php print($row['nama_produk']); ?></p>
											<h4 align="center"><?php print("Rp. ".number_format($row['harga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></h4>
										</div>
										<div class="snipcart-details top_brand_home_details">
											<a href="single.php?item_id=<?php print($row['id_produk']); ?>">	
												<input type="submit" name="submit" value="Beli" class="button" />
											</a>
										</div>
									</div>
								</figure>
							</div>
						</div>
					</div>
				</div>

                <?php
            }
        }
        else
        {
            ?>
            <tr>
            <td>Stok Habis!!</td>
            </tr>
            <?php
        }
    }


    public function addCart($datas = array()) {

        $keys = array_keys($datas);

        $values = "'" . implode( "','", $datas ) . "'";

        $id_user = $datas['id_user'];
        $id_produk = $datas['id_produk'];

        // Cek Jika Produk tersebut sudah ada di table cart dengan id sesi yg sama
        $stmt = $this->db->prepare("SELECT * FROM tbl_cart WHERE id_user=:id_user AND id_produk=:id_produk");
        $stmt->execute(array(":id_user"=>$id_user, ":id_produk"=>$id_produk));
        $editRow=$stmt->fetch(PDO::FETCH_ASSOC);
        
        // jika ada
        if($stmt->rowCount()>0) {

            $harga = $editRow['harga'] + $datas['harga'];
            $jlh_produk = $editRow['jumlah'] + $datas['jumlah'];

            $sql = "UPDATE tbl_cart SET harga={$harga}, jumlah={$jlh_produk}  WHERE id_produk = {$id_produk} AND id_user = {$id_user}";


            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }
            
            return false;


        } else {

            $sql = "INSERT INTO tbl_cart (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

            if ($this->db->prepare($sql)) {
                if ($this->db->exec($sql)) {
                    return true;
                }
            }

            return false;
        }

        return true;

    }

    public function dataCart($query) {

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        // format mata uang
        $jumlah_desimal = "0";
        $pemisah_desimal = ",";
        $pemisah_ribuan = ".";
        $total = 0;

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                $total += $row['harga']*$row['jumlah'];
                ?>

                <tr class="rem1">
                    <td class="invert"><?php print($row['kode_produk']) ?></td>
                    <td class="invert-image"><a href="single.php?item_id=<?php print($row['id_produk']) ?>">
                        <img src="assets/image_produk/<?php print($row['gambar']) ?>" alt=" " class="img-responsive" width="70px" height="70px"></a></td>
                    <td class="invert"><?php print($row['nama_produk']) ?></td>
                    <td class="invert"><?php print($row['jumlah']) ?></td>
                    <td class="invert"><?php print("Rp. ".number_format($row['harga']*$row['jumlah'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                    <td class="invert">
                        <div class="rem">
                            <a href="delete_cart.php?del_id=<?php print($row['id_cart']) ?>"><div class="close1"></div></a>
                        </div>
                    </td>
                </tr>

                <?php
            }
            ?>
                <tr>
                    <td colspan="4">Subtotal</td>
                    <td colspan="2"><?php print("Rp. ".number_format($total,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                </tr>
            <?php
        }
        else
        {
            ?>
            <tr>
            <td colspan="6">Anda Belum Belanja!!</td>
            </tr>
            <?php
        }
    }

    public function myCart($id_user) {

        $total_harga = 0;
        $total_produk = 0;
        $query = "SELECT *, tbl_cart.harga as charga FROM tbl_cart INNER JOIN tbl_produk ON (tbl_cart.id_produk=tbl_produk.id_produk) WHERE tbl_cart.id_user=:id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(":id"=>$id_user));
        
        // format mata uang
        $jumlah_desimal = "0";
        $pemisah_desimal = ",";
        $pemisah_ribuan = ".";

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                $total_harga += $row['charga'];
                $total_produk += $row['jumlah'];
                ?>

                <li><?php print($row['nama_produk']) ?> <i>(<?php print($row['jumlah']) ?>)</i> <span><?php echo "Rp. ".number_format($row['charga'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></span></li>

                <?php
            }
                ?>

                <li><b>Total <i>(<?php print($total_produk) ?>)</i> <span><?php echo "Rp. ".number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></span></b></li>

                <?php
        }
    }

    public function delCart($id) {

        $stmt = $this->db->prepare("DELETE FROM tbl_cart WHERE id_cart=:id");
        $stmt->bindparam(":id",$id);
        $stmt->execute();
        return true;
    }

    public function totalBerat($id_user) {

        $total = 0;
        $stmt = $this->db->prepare("SELECT tbl_produk.berat as total_berat, tbl_cart.jumlah as total_jumlah FROM tbl_produk INNER JOIN tbl_cart ON(tbl_produk.id_produk=tbl_cart.id_produk) WHERE tbl_cart.id_user=:id");
        $stmt->execute(array(":id"=>$id_user));
        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                //Jumlahkan tiap2 perkalian total berat
                $total += $row['total_berat'] * $row['total_jumlah'];

            }
                ?>
                    <Input type="hidden" value="<?php echo $total ?>" id="berat" name="berat" required>
                <?php
        }
    }

    public function insertOrder($fields = array(), $id_user) {

        $keys = array_keys($fields);

        $values = "'" . implode( "','", $fields ) . "'";

        $sql = "INSERT INTO tbl_order (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

        if ($this->db->prepare($sql)) {

            if ($this->db->exec($sql)) {

                $lastId = $this->db->lastInsertId();

                $move_data = "INSERT INTO tbl_order_detail (id_order, id_produk, jumlah, harga)
SELECT {$lastId}, id_produk, jumlah, harga FROM tbl_cart WHERE id_user={$id_user}";

                if($this->db->exec($move_data)) {
                    $delCart = $this->db->prepare("DELETE FROM tbl_cart WHERE id_user=:id");
                    $delCart->bindparam(":id",$id_user);
                    $delCart->execute();
                    return true;
                }
                
                return true;
            }
        }

        return false;
    }

    public function myOrder($id_order) {

        $total_harga = 0;
        $total_produk = 0;
        $query = "SELECT * FROM tbl_order_detail INNER JOIN tbl_produk 
         ON (tbl_order_detail.id_produk=tbl_produk.id_produk) WHERE tbl_order_detail.id_order=:id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(":id"=>$id_order));
        
        // format mata uang
        $jumlah_desimal = "0";
        $pemisah_desimal = ",";
        $pemisah_ribuan = ".";

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                $total_harga += $row['harga'] * $row['jumlah'];
                $total_produk += $row['jumlah'];
                ?>

                <li><?php print($row['nama_produk']) ?> <i>(<?php print($row['jumlah']) ?>)</i> <span><?php echo "Rp. ".number_format($row['harga']*$row['jumlah'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></span></li>

                <?php
            }
                ?>

                <li><b>Total Belanja <i>(<?php print($total_produk) ?>)</i> <span><?php echo "Rp. ".number_format($total_harga,$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan) ?></span></b></li>

                <?php
        }
    }


    public function getOrderData($id_order){

        try {
            $query = $this->db->prepare("SELECT * FROM tbl_order WHERE id_order = :id_order");
            $query->bindParam(":id_order", $id_order);
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getTotalHarga($id_order){

        try {
            $query = $this->db->prepare("SELECT SUM(harga) as xtotal FROM tbl_order_detail WHERE id_order = :id_order");
            $query->bindParam(":id_order", $id_order);
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function insertBayar($fields = array(), $id_user, $id_order) {

        $set = '';
        $x = 1;

        foreach ($fields as $name => $value) {
            $set .= "{$name} = '{$value}'";
            if($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }

        //var_dump($set);
        $sql = "UPDATE tbl_order SET {$set} WHERE id_user={$id_user} AND id_order={$id_order}";

        if ($this->db->prepare($sql)) {
            if ($this->db->exec($sql)) {
                return true;
            }
        }

        return false;
    }

    public function waitOrder($query) {

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        // format mata uang
        $jumlah_desimal = "0";
        $pemisah_desimal = ",";
        $pemisah_ribuan = ".";

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>

                <tr class="rem1">
                    <td class="invert"><?php print($row['id_order']) ?></td>
                    <td class="invert"><?php print($row['tgl_order']) ?></td>
                    <td class="invert"><?php print("Rp. ".number_format($row['xharga']+$row['ongkir'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                    <td class="invert"><?php print($row['desk_order']) ?></td>
                    <?php
                        switch ($row['status_order']) {
                            case 'Tidak bayar':
                                ?>
                                    <td class="invert">
                                        <div class="rem">
                                            <a href="pembayaran.php?slug=<?php print($row['id_order']) ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                        </div>
                                    </td>
                                <?php
                                break;

                            case 'Tunggu':
                                ?>
                                    <td class="invert">
                                        <div class="rem">
                                            <a href="pembayaran.php?slug=<?php print($row['id_order']) ?>"><span class="glyphicon glyphicon-pencil"></span></a>
                                        </div>
                                    </td>
                                <?php
                                break;
                            
                            case 'Bayar':
                                ?>
                                    <td class="invert">
                                        <div class="rem">
                                            <span>Diterima</span>
                                        </div>
                                    </td>
                                <?php
                                break;

                            case 'Dikirim':
                                ?>
                                    <td class="invert">
                                        <div class="rem">
                                            <a href="konfirmasi.php?slug=<?php print($row['id_order']) ?>" onclick="return confirm('Apakah Pesanan telah sampai ?')"><span class="glyphicon glyphicon-pencil"></span></a>
                                        </div>
                                    </td>
                                <?php
                                break;

                            case 'Selesai':
                                ?>
                                    <td class="invert">
                                        <div class="rem">
                                            <span>Selesai</span>
                                        </div>
                                    </td>
                                <?php
                                break;
                        }

                    ?>
                </tr>

                <?php
            }
        }
        else
        {
            ?>
            <tr>
            <td colspan="6">Pesanan tidak tersedia...</td>
            </tr>
            <?php
        }
    }

    public function ubahStatusOrder($id, $status, $id_admin) {

        $sql = "UPDATE tbl_order SET id_admin={$id_admin}, status_order='{$status}' WHERE id_order = {$id}" ;

        if ($this->db->prepare($sql)) {
            if ($this->db->exec($sql)) {
                return true;
            }
        }

        return false;
    }

    public function ubahStatus($id, $status) {

        $sql = "UPDATE tbl_order SET status_order='{$status}' WHERE id_order = {$id}" ;

        if ($this->db->prepare($sql)) {
            if ($this->db->exec($sql)) {
                return true;
            }
        }

        return false;
    }

    public function listOrder($query) {

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        
        // format mata uang
        $jumlah_desimal = "0";
        $pemisah_desimal = ",";
        $pemisah_ribuan = ".";

        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>

                <tr>
                    <td><?php print($row['id_order']) ?></td>
                    <td><?php print($row['tgl_order']) ?></td>
                    <td><?php print($row['provinsi']) ?></td>
                    <td><?php print("Rp. ".number_format($row['nilai_transfer'],$jumlah_desimal, $pemisah_desimal, $pemisah_ribuan)); ?></td>
                    
                    <?php
                        switch ($row['status_order']) {

                            case 'Tunggu':
                                ?>
                                    <td>
                                        <div>
                                            <a href="admin_order_info.php?slug=<?php print($row['id_order']) ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                        </div>
                                    </td>
                                <?php
                                break;
                            
                            case 'Bayar':
                                ?>
                                    <td>
                                        <div>
                                            <a href="admin_order_info.php?slug=<?php print($row['id_order']) ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                        </div>
                                    </td>
                                <?php
                                break;

                            case 'Dikirim':
                                ?>
                                    <td>
                                        <div>
                                            <a href="admin_order_info.php?slug=<?php print($row['id_order']) ?>"><span class="glyphicon glyphicon-edit"></span></a>
                                        </div>
                                    </td>
                                <?php
                                break;

                            case 'Selesai':
                                ?>
                                    <td>
                                        <div>
                                            <span>Selesai</span>
                                        </div>
                                    </td>
                                <?php
                                break;
                        }

                    ?>
                </tr>

                <?php
            }
        }
        else
        {
            ?>
            <tr>
            <td colspan="6">Pesanan tidak tersedia...</td>
            </tr>
            <?php
        }
    }

    public function infoProdukOrder($id_order) {

        $query = "SELECT * FROM tbl_produk INNER JOIN tbl_order_detail ON (tbl_produk.id_produk=tbl_order_detail.id_produk) WHERE tbl_order_detail.id_order=:id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(array(":id"=>$id_order));
        
        if($stmt->rowCount()>0)
        {
            while($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
                ?>
                    <tr>
                        <td><img src="../assets/image_produk/<?php print($row['gambar']); ?>" width="60px" height="60px"></td>
                        <td><?php print($row['kode_produk']); ?></td>
                        <td><?php print($row['nama_produk']); ?></td>
                    </tr>
                <?php
            }
        }
    }

    public function kirimBarang($fields = array(), $id_order) {

        $keys = array_keys($fields);

        $values = "'" . implode( "','", $fields ) . "'";

        //var_dump($fields);

        $sql = "INSERT INTO tbl_kirim (`" . implode('`,`', $keys) . "`) VALUES ({$values})";

        if ($this->db->prepare($sql)) {
            if ($this->db->exec($sql)) {

                $lastId = $this->db->lastInsertId();

                $updatekirim = "UPDATE tbl_order SET status_order='Dikirim' WHERE id_order={$id_order}";

                //var_dump($updatekirim);
                if ($this->db->prepare($updatekirim)) {
                    if ($this->db->exec($updatekirim)) {

                        // ambil nilai id_produk & jumlah_produk pada tabel order_detail
                        $ambil = "SELECT id_produk, jumlah FROM tbl_order_detail WHERE id_order={$id_order}";

                        $stmt = $this->db->prepare($ambil);
                        $stmt->execute();

                        if($stmt->rowCount()>0)
                        {
                            while($ambil_row=$stmt->fetch(PDO::FETCH_ASSOC))
                            {
                                $ambil_stok = $ambil_row['jumlah'];
                                $ambil_id_produk = $ambil_row['id_produk'];

                                $updateStok = "UPDATE tbl_produk SET stok=stok-{$ambil_stok} WHERE id_produk={$ambil_id_produk}";

                                $this->db->prepare($updateStok);
                                $this->db->exec($updateStok);
                            }
                        }
                        else
                        {
                            echo "Error";
                        }


                        return true;
                    }
                }
                return true;
            }
        }

        return false;
    }

    public function getResi($id_order){

        try {
            $query = $this->db->prepare("SELECT * FROM tbl_kirim WHERE id_order = :id_order");
            $query->bindParam(":id_order", $id_order);
            $query->execute();
            return $query->fetch();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

}

?>