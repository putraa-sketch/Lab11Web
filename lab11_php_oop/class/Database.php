<?php
/**
 * Class Database
 * Deskripsi: Class untuk koneksi dan operasi database
 * Author: Lab10 PHP OOP
 */

class Database {
    protected $host;
    protected $user;
    protected $password;
    protected $db_name;
    protected $conn;

    /**
     * Constructor - Inisialisasi koneksi database
     */
    public function __construct() {
        $this->getConfig();
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->db_name);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
        // Set charset
        $this->conn->set_charset("utf8");
    }

    /**
     * Mengambil konfigurasi database
     */
    private function getConfig() {
        $this->host = 'localhost';
        $this->user = 'root';
        $this->password = '';
        $this->db_name = 'latihan1';
    }

    /**
     * Menjalankan query SQL
     * @param string $sql Query SQL
     * @return mysqli_result|bool
     */
    public function query($sql) {
        return $this->conn->query($sql);
    }

    /**
     * Mengambil satu baris data
     * @param string $table Nama tabel
     * @param string $where Kondisi WHERE (optional)
     * @return array|null
     */
    public function get($table, $where = null) {
        if ($where) {
            $where = " WHERE " . $where;
        }
        $sql = "SELECT * FROM " . $table . $where;
        $result = $this->conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    /**
     * Mengambil semua data
     * @param string $table Nama tabel
     * @param string $where Kondisi WHERE (optional)
     * @param string $order Order by (optional)
     * @return array
     */
    public function getAll($table, $where = null, $order = null) {
        $sql = "SELECT * FROM " . $table;
        
        if ($where) {
            $sql .= " WHERE " . $where;
        }
        
        if ($order) {
            $sql .= " ORDER BY " . $order;
        }
        
        $result = $this->conn->query($sql);
        $data = [];
        
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        
        return $data;
    }

    /**
     * Insert data ke database
     * @param string $table Nama tabel
     * @param array $data Data yang akan diinsert (key => value)
     * @return bool
     */
    public function insert($table, $data) {
        if (is_array($data)) {
            $columns = [];
            $values = [];
            
            foreach($data as $key => $val) {
                $columns[] = $key;
                $values[] = "'" . $this->conn->real_escape_string($val) . "'";
            }
            
            $columns_str = implode(",", $columns);
            $values_str = implode(",", $values);
            
            $sql = "INSERT INTO " . $table . " (" . $columns_str . ") VALUES (" . $values_str . ")";
            
            if ($this->conn->query($sql)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Update data di database
     * @param string $table Nama tabel
     * @param array $data Data yang akan diupdate (key => value)
     * @param string $where Kondisi WHERE
     * @return bool
     */
    public function update($table, $data, $where) {
        $update_value = [];
        
        if (is_array($data)) {
            foreach($data as $key => $val) {
                $update_value[] = "$key='" . $this->conn->real_escape_string($val) . "'";
            }
            $update_value_str = implode(",", $update_value);
            
            $sql = "UPDATE " . $table . " SET " . $update_value_str . " WHERE " . $where;
            
            if ($this->conn->query($sql)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Delete data dari database
     * @param string $table Nama tabel
     * @param string $where Kondisi WHERE
     * @return bool
     */
    public function delete($table, $where) {
        $sql = "DELETE FROM " . $table . " WHERE " . $where;
        
        if ($this->conn->query($sql)) {
            return true;
        }
        return false;
    }

    /**
     * Menghitung jumlah baris
     * @param string $table Nama tabel
     * @param string $where Kondisi WHERE (optional)
     * @return int
     */
    public function count($table, $where = null) {
        $sql = "SELECT COUNT(*) as total FROM " . $table;
        
        if ($where) {
            $sql .= " WHERE " . $where;
        }
        
        $result = $this->conn->query($sql);
        
        if ($result) {
            $row = $result->fetch_assoc();
            return (int)$row['total'];
        }
        return 0;
    }

    /**
     * Escape string untuk mencegah SQL injection
     * @param string $string String yang akan di-escape
     * @return string
     */
    public function escape($string) {
        return $this->conn->real_escape_string(trim($string));
    }

    /**
     * Mendapatkan ID terakhir yang diinsert
     * @return int
     */
    public function getLastId() {
        return $this->conn->insert_id;
    }

    /**
     * Destructor - Menutup koneksi
     */
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>