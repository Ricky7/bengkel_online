<?php

class User {

	private $db; 
    private $error; 

    function __construct($db_conn)
    {
        $this->db = $db_conn;

        session_start();
    }

    public function register($nama_depan, $nama_belakang, $username, $password)
    {
        try
        {
            // buat hash dari password yang dimasukkan
            $hashPasswd = password_hash($password, PASSWORD_DEFAULT);
            //$tgl_reg = date('Y-m-d H:i:s');

            //Masukkan user baru ke database
            $query = $this->db->prepare("INSERT INTO tbl_user(nama, no_hp, username, password, tgl_daftar) VALUES(:nama, :no_hp, :username, :pass, NOW())");
            $query->bindParam(":nama", $nama_depan);
            $query->bindParam(":no_hp", $nama_belakang);
            $query->bindParam(":username", $username);
            $query->bindParam(":pass", $hashPasswd);
            //$query->bindParam(":tgl", $tgl_reg);
            $query->execute();

            return true;
        }catch(PDOException $e){
            // Jika terjadi error
            if($e->errorInfo[0] == 23000){
                //errorInfor[0] berisi informasi error tentang query sql yg baru dijalankan
                //23000 adalah kode error ketika ada data yg sama pada kolom yg di set unique
                $this->error = "Username sudah digunakan!";
                return false;
            }else{
                echo $e->getMessage();
                return false;
            }
        }
    }

    public function login($username, $password)
    {
        try
        {
            // Ambil data dari database
            $query = $this->db->prepare("SELECT * FROM tbl_user WHERE username = :username");
            $query->bindParam(":username", $username);
            $query->execute();
            $data = $query->fetch();

            // Jika jumlah baris > 0
            if($query->rowCount() > 0){
                // jika password yang dimasukkan sesuai dengan yg ada di database
                if(password_verify($password, $data['password'])){
                    $_SESSION['user_session'] = $data['id_user'];
                    return true;
                }else{
                    $this->error = "<i><small>Username atau Password Salah</small></i>";
                    return false;
                }
            }else{
                $this->error = "Akun tidak ada";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function isUserLoggedIn(){
	    // Apakah user_session sudah ada di session
	    if(isset($_SESSION['user_session']))
	    {
	        return true;
	    }
	}

	// Ambil data user yang sudah login
	public function getUser(){
	    // Cek apakah sudah login
	    if(!$this->isUserLoggedIn()){
	        return false;
	    }

	    try {
	        // Ambil data user dari database
	        $query = $this->db->prepare("SELECT * FROM tbl_user WHERE id_user = :id_user");
	        $query->bindParam(":id_user", $_SESSION['user_session']);
	        $query->execute();
	        return $query->fetch();
	    } catch (PDOException $e) {
	        echo $e->getMessage();
	        return false;
	    }
	}

    public function logout(){
        // Hapus session
        session_destroy();
        // Hapus user_session
        unset($_SESSION['user_session']);
        return true;
    }

    public function getLastError(){
        return $this->error;
    }

}

?>