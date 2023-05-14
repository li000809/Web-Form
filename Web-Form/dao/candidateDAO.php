<?php
require_once('abstractDAO.php');
require_once('./model/candidate.php');

class candidateDAO extends abstractDAO
{
    function __construct()
    {
        try {
            parent::__construct();
        } catch (mysqli_sql_exception $e) {
            throw $e;
        }
    }

    public function getCandidate($candidateId)
    {
        $query = 'SELECT * FROM candidates WHERE id = ?';
        $stmt = $this->mysqli->prepare($query);
        $stmt->bind_param('i', $candidateId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $temp = $result->fetch_assoc();
            $candidate = new candidate($temp['id'], $temp['name'], $temp['piece'], $temp['duration'], $temp['birth'], $temp['image']);
            $result->free();
            return $candidate;
        }
        // $result->free();
        // return false;
    }

    // ** useful
    public function getCandidates()
    {
        //The query method returns a mysqli_result object
        $result = $this->mysqli->query('SELECT * FROM candidates');
        $candidates = array();

        if ($result->num_rows >= 1) {
            while ($row = $result->fetch_assoc()) {
                //Create a new employee object, and add it to the array.
                $candidate = new Candidate($row['id'], $row['name'], $row['piece'], $row['duration'], $row['birth'], $row['image']);
                $candidates[] = $candidate;
            }
            $result->free();
            return $candidates;
        }
        // $result->free();
        // return false;
    }

    public function addCandidate($candidate)
    {

        if (!$this->mysqli->connect_errno) {
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = 'INSERT INTO candidates (name, piece, duration, birth, image) VALUES (?,?,?,?,?)';
            $stmt = $this->mysqli->prepare($query);
            if ($stmt) {
                $name = $candidate->getName();
                $piece = $candidate->getPiece();
                $duration = $candidate->getDuration();
                $birth = $candidate->getBirth();
                $image = $candidate->getImage();

                $stmt->bind_param(
                    'ssiss',
                    $name,
                    $piece,
                    $duration,
                    $birth,
                    $image
                );
                //Execute the statement
                $stmt->execute();

                if ($stmt->error) {
                    return $stmt->error;
                } else {
                    return $candidate->getName() . ' added successfully!';
                }
            } else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error;
                return $error;
            }

        } else {
            return 'Could not connect to Database.';
        }
    }
    public function updateCandidate($candidate)
    {

        if (!$this->mysqli->connect_errno) {
            //The query uses the question mark (?) as a
            //placeholder for the parameters to be used
            //in the query.
            //The prepare method of the mysqli object returns
            //a mysqli_stmt object. It takes a parameterized 
            //query as a parameter.
            $query = "UPDATE candidates SET name=?, piece=?, duration=?, birth=?, image=? WHERE id=?";
            $stmt = $this->mysqli->prepare($query);
            if ($stmt) {
                $id = $candidate->getId();
                $name = $candidate->getName();
                $piece = $candidate->getPiece();
                $duration = $candidate->getDuration();
                $birth = $candidate->getBirth();
                $image = $candidate->getImage();
                echo 'Birth in updateCandidate method: ' . $birth . '<br>';
                $stmt->bind_param('ssissi',
                    $name,
                    $piece,
                    $duration,
                    $birth,
                    $image,
                    $id
                );
                //Execute the statement
                $stmt->execute();

                echo "Affected rows: " . $stmt->affected_rows . "<br>";

                if ($stmt->error) {
                    return $stmt->error;
                } else {
                    return $candidate->getName() . ' updated successfully!';
                }
            } else {
                $error = $this->mysqli->errno . ' ' . $this->mysqli->error;
                echo $error;
                return $error;
            }

        } else {
            return 'Could not connect to Database.';
        }
    }

    public function deleteCandidate($candidateId)
    {
        if (!$this->mysqli->connect_errno) {
            $query = 'DELETE FROM candidates WHERE id = ?';
            $stmt = $this->mysqli->prepare($query);
            $stmt->bind_param('i', $candidateId);
            $stmt->execute();
            if ($stmt->error) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
?>

<!-- // if ($image_updated) {
// $query = "UPDATE candidates SET name=?, piece=?, duration=?, birth=?, image=? WHERE id=?";
// } else {
// $query = "UPDATE candidates SET name=?, piece=?, duration=?, birth=? WHERE id=?";
// }

// if ($image_updated) {
// $stmt->bind_param('ssiisi', $name, $piece, $duration, $birth, $image, $id);
// } else {
// $stmt->bind_param('ssisi', $name, $piece, $duration, $birth, $id);
// } -->