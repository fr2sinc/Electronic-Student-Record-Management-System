<?php
require_once('utility.php');
session_start();
header('Location: mark_recording.php');
define("CLASS_SUBID_SSN", "class_sID_ssn");
define("FINAL_SCORE", "score");
define("SUBJECT_MARK", "subject");
define("STUDENT_MARK", "student");
define("MARK_DECIMAL", "decimalMarkValue");

$db_con = connect_to_db();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST[CLASS_SUBID_SSN]) && isset($_POST['date']) && isset($_POST['hour']) && isset($_POST[STUDENT_MARK]) 
        && isset($_POST[FINAL_SCORE]) && isset($_POST[MARK_DECIMAL]) && !empty($_POST[CLASS_SUBID_SSN]) && 
        !empty($_POST['date']) && !empty($_POST['hour']) && !empty($_POST[STUDENT_MARK]) && !empty($_POST[FINAL_SCORE])){

        $fields = explode("_", $_POST[CLASS_SUBID_SSN]);
        $class = $fields[0];
        $subjectID = $fields[1];

        $date =$_POST['date']; 
        $hour = $_POST['hour'];

        $student = $_POST[STUDENT_MARK];
        $score = $_POST[FINAL_SCORE];

        // Check if the student is present
        $queryCheck = "SELECT COUNT(*) FROM ATTENDANCE WHERE StudentSSN = ? AND DATE = CURRENT_DATE AND PRESENCE = 'ABSENT';";

        if(!$db_con){
            echo '{"state" : "error",
            "result" : "Error in connection to database." }';
        }
        
        $prep_query = mysqli_prepare($db_con, $queryCheck);
           
        if(!$prep_query){
            print('Error in preparing query: '.$prep_query);
            echo '{"state" : "error",
            "result" : "Database error." }';
        }
                 
        if(!mysqli_stmt_bind_param($prep_query, "s", $student)){
            echo '{"state" : "error",
            "result" : "Param binding error." }';
        }
        if(!mysqli_stmt_execute($prep_query)){
            echo '{"state" : "error",
            "result" : "Database error (Query execution)." }';
        }
           
        mysqli_stmt_bind_result($prep_query, $count);

        $rows = array();
    
        while (mysqli_stmt_fetch($prep_query)) {
           array_push($rows, $count);
        }
   
        
        if($rows[0] != 0){
            $_SESSION[MSG] = STUDENT_ABSENT;
            die();
        }
        // end check

        //add decimal value to score
        if(empty($_POST[MARK_DECIMAL])) {
            $decimalMark = "0";
        }
        $decimalMark = $_POST[MARK_DECIMAL];
        $score = $score.substr($decimalMark, 1); //remove '0' from '0.25' -> .25

        $retval = recordMark($student, $subjectID, $date, $class, $score);
        
        $_SESSION[MSG] = $retval;

    } else {
        $_SESSION[MSG] = MARK_RECORDING_FAILED;
    }
} else {
    $_SESSION[MSG] = MARK_RECORDING_FAILED;
}
?>