<?php 

require'db.php';

use voku\helper\AntiXSS;
require_once 'anti-xss/autoload.php';
$antiXss = new AntiXSS();

function getAllQna()
{
    global $conn;
    $result = mysqli_query($conn,"SELECT * FROM qna ORDER BY id DESC");
    $rows = [];
	while( $row = mysqli_fetch_assoc($result) ) {
		$rows[] = $row;
    }
    
    return $rows;
}

function sendAnswer($data)
{
    global $conn,$antiXss;
    
    $idask = $antiXss->xss_clean($data["idask"]); //id quest
	$ids = $antiXss->xss_clean($data["ids"]); // id answer
    $answer = $antiXss->xss_clean($data["answer"]); //answer

	// tambahkan userbaru ke database
	mysqli_query($conn, "UPDATE `qna` SET 
	`answer` = '$answer',
    `answer_id` = '$ids' 
	WHERE `id` = '$idask'");
    
	return mysqli_affected_rows($conn);
}