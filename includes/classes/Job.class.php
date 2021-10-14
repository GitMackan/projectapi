<?php

class Job {
    // Variabler
    private $db;
    private $job;
    private $title;
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
     * Add job
     * @param string $job
     * @param string $title
     * @param string $start
     * @param string $end
     */

    public function addJob(string $job, string $title, string $start, string $end) : bool {
        $this->job = $job;
        $this->title = $title;
        $this->start = $start;
        $this->end = $end;
        
        // Check for empty values
        
            // Prepare statement 
            $stmt = $this->db->prepare("INSERT INTO jobs (job, title, start, end) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $this->job, $this->title, $this->start, $this->end);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }

            $stmt->close();
    }

        
    
    /**
     * Get jobs
     * @return array
     */

     public function getJobs () : array {
         $sql = "SELECT * FROM jobs ORDER BY job;";
         $result = $this->db->query($sql);

         return $result->fetch_all(MYSQLI_ASSOC);
     }




     /**
      * Delete job by id
      * @param int $id
      * @return boolean
      */

      public function deleteJob(int $id) : bool {
          $id = intval($id);

          $sql = "DELETE FROM jobs WHERE id=$id;";
          $result = $this->db->query($sql);

          return $result;
      }


      /**
       * Get specific job by id
       * @param int $id
       * @return array
       */

       public function getJobById(int $id) : array {
           $id = intval($id);
           
           $sql = "SELECT * FROM jobs WHERE id=$id;";
           $result = $this->db->query($sql);

           return $result->fetch_all(MYSQLI_ASSOC);
       }

       /**
        * Update job
        * @param int $id
        * @param string $job
        * @param string $title
        * @param string $start
        * @param string $end
        * @return boolean
        */
       public function updateJob(int $id, string $job, string $title, string $start, string $end) : bool {
           $this->id = $id;
           $this->job = $job;
           $this->title = $title;
           $this->start = $start;
           $this->end = $end;
           $id = intval($id);

           // Prepare statement 
           $stmt = $this->db->prepare("UPDATE jobs SET job=?, title=?, start=?, end=?  WHERE id=$id;");
           $stmt->bind_param("ssss", $this->job, $this->title, $this->start, $this->end);

           if ($stmt->execute()) {
               return true;
           } else {
               return false;
           }

           $stmt->close();
       }
}

