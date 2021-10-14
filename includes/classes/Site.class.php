<?php

class Site {
    // Variabler
    private $db;
    private $title;
    private $url;
    private $info;

    // Constructor 
    public function __construct() {
        // MySQLi connection
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
        // Check connection
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    /**
     * Add site
     * @param string $title
     * @param string $url
     * @param string $info
     */

    public function addSite(string $title, string $url, string $info) : bool {
        $this->title = $title;
        $this->url = $url;
        $this->info = $info;
        
        // Check for empty values
        
            // Prepare statement 
            $stmt = $this->db->prepare("INSERT INTO sites (title, url, info) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $this->title, $this->url, $this->info);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }

            $stmt->close();
    }

        
    
    /**
     * Get sites
     * @return array
     */

     public function getSites () : array {
         $sql = "SELECT * FROM sites ORDER BY title;";
         $result = $this->db->query($sql);

         return $result->fetch_all(MYSQLI_ASSOC);
     }




     /**
      * Delete site by id
      * @param int $id
      * @return boolean
      */

      public function deleteSite(int $id) : bool {
          $id = intval($id);

          $sql = "DELETE FROM sites WHERE id=$id;";
          $result = $this->db->query($sql);

          return $result;
      }


      /**
       * Get specific site by id
       * @param int $id
       * @return array
       */

       public function getSiteById(int $id) : array {
           $id = intval($id);
           
           $sql = "SELECT * FROM sites WHERE id=$id;";
           $result = $this->db->query($sql);

           return $result->fetch_all(MYSQLI_ASSOC);
       }

       /**
        * Update Site
        * @param int $id
        * @param string $title
        * @param string $url
        * @param string $info
        * @return boolean
        */
       public function updateSite(int $id, string $title, string $url, string $info) : bool {
           $this->id = $id;
           $this->title = $title;
           $this->url = $url;
           $this->info = $info;
           $id = intval($id);

           // Prepare statement 
           $stmt = $this->db->prepare("UPDATE sites SET title=?, url=?, info=?  WHERE id=$id;");
           $stmt->bind_param("sss", $this->title, $this->url, $this->info);

           if ($stmt->execute()) {
               return true;
           } else {
               return false;
           }

           $stmt->close();
       }
}

