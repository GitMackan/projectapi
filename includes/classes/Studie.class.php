<?php

class Studie {
    // Variabler
    private $db;
    private $uni;
    private $edu;
    private $start;
    private $end;

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
     * Add studie
     * @param string $uni
     * @param string $edu
     * @param string $start
     * @param string $end
     */

    public function addStudie(string $uni, string $edu, string $start, string $end) : bool {
        $this->uni = $uni;
        $this->edu = $edu;
        $this->start = $start;
        $this->end = $end;
        
        // Check for empty values
        
            // Prepare statement 
            $stmt = $this->db->prepare("INSERT INTO studies (uni, edu, start, end) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $this->uni, $this->edu, $this->start, $this->end);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }

            $stmt->close();
    }

        
    
    /**
     * Get studies
     * @return array
     */

     public function getStudies () : array {
         $sql = "SELECT * FROM studies ORDER BY uni;";
         $result = $this->db->query($sql);

         return $result->fetch_all(MYSQLI_ASSOC);
     }




     /**
      * Delete studie by id
      * @param int $id
      * @return boolean
      */

      public function deleteStudie(int $id) : bool {
          $id = intval($id);

          $sql = "DELETE FROM studies WHERE id=$id;";
          $result = $this->db->query($sql);

          return $result;
      }


      /**
       * Get specific course by id
       * @param int $id
       * @return array
       */

       public function getStudieById(int $id) : array {
           $id = intval($id);
           
           $sql = "SELECT * FROM studies WHERE id=$id;";
           $result = $this->db->query($sql);

           return $result->fetch_all(MYSQLI_ASSOC);
       }

       /**
        * Update course
        * @param int $id
        * @param string $uni
        * @param string $edu
        * @param string $start
        * @param string $end
        * @return boolean
        */
       public function updateStudie(int $id, string $uni, string $edu, string $start, string $end) : bool {
           $this->id = $id;
           $this->uni = $uni;
           $this->edu = $edu;
           $this->start = $start;
           $this->end = $end;
           $id = intval($id);

           // Prepare statement 
           $stmt = $this->db->prepare("UPDATE studies SET uni=?, edu=?, start=?, end=?  WHERE id=$id;");
           $stmt->bind_param("ssss", $this->uni, $this->edu, $this->start, $this->end);

           if ($stmt->execute()) {
               return true;
           } else {
               return false;
           }

           $stmt->close();
       }
}

