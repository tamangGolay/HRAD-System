<?php 
/**
 * Sending greetings to people on their birthdays and also to the employees for their appointment anneversory
 *
 * This file users phpmailer for sending the mails.
 * 
 * Author: 	Rinchen Wangdi
 * Date: 	22/08/2022
 * Place: 	Begana
 * 
 **/
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
	include 'connect.php'; 
	header("content-type: application/json");
	require './PHPMailer/src/Exception.php';
	require './PHPMailer/src/PHPMailer.php';
	require './PHPMailer/src/SMTP.php';
	$mail=new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure='tls';
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);
	$mail->Host = 'mail.bpc.bt';
	$mail->Port = '587';
	$mail->isHTML();

/**
 * 
 * This section sends anniversary greetings to employees
 * 
 * The annivesary that are considered to be wished now are:
 * 	1) Five Years Anniversary
 * 	2) Ten Years Anniversary
 * 	3) Fiften Years Anniversary
 *	4) Twenty Years Jubilee 
 *	5) Twenty Five Years Anniversary
 * 	6) Thirty Years Anniversary
 *	7) Thirty Five Years Anniversary
 * 	8) Fourty Years Anniversary
 * 
 **/
	for ($years = 5; $years <= 45; $years=$years + 5) {
		$query4AG =	"select substring_index(empName,' ',1) as firstName, emailId as mailId " .
					"from users " .
					"WHERE DAY(appointmentDate) = DAY(SYSDATE()) " .
					"AND MONTH(appointmentDate) = MONTH(SYSDATE()) " .
					"AND YEAR(appointmentDate) = YEAR(sysdate()) - " . $years .
					" AND emailId is NOT NULL;";
		$result4AG = mysqli_query($conn, $query4AG);
		while ($row4AG = mysqli_fetch_row($result4AG)){
			$fgName = $row4AG[0];
			$togMail = $row4AG[1];
			$greetingsmessage = "Dear " . $fgName . ",  <br><br> " .
								"<strong>Congratulations</strong> on " . $years ." years of service to BPC! <br><br> " . 
								"We are so fortunate to have you on our team. " . 
								"Your humility, generosity, and kindness is a " . 
								"constant source of motivation and inspiration, " . 
								"and your dedication and work ethics are exemplary. " . 
								"We wish you many more years of success. <br><br>" .
								"<em>Happy Work Anniversary! </em><br><br><br> " . 
								"The Management of <strong>BPC.</strong>";
			$mail->ClearAddresses();
			sendmail($mail, $togMail, "Happy Anniversary", $greetingsmessage);
		}
	}
	
/**
 * 
 * This section sends birthday greetings to people on their birthdays
 * 
 **/	
	$query4BD = "select substring_index(empName,' ',1) as firstName, emailId as mailId " .
				"from users " .
				"WHERE DAY(dob) = DAY(SYSDATE()) " . 
				"AND MONTH(dob) = MONTH(SYSDATE()) " .
				"AND emailId is NOT NULL;";
	$result4BD = mysqli_query($conn, $query4BD);
	while ($row4BD = mysqli_fetch_row($result4BD)){
		$fName = $row4BD[0];
		$toMail = $row4BD[1];
		$query4MM = "SELECT count(*) as maxMessage from birthdaymessages;";
		$result4MM = mysqli_query($conn, $query4MM);
		$row4MM = mysqli_fetch_row($result4MM);
		$maxMessage = $row4MM[0];
		$messageId = rand(1, $maxMessage);
		$query4M = "SELECT message FROM birthdaymessages WHERE id = " . $messageId . ";";
		$result4M = mysqli_query($conn, $query4M);
		$row4M = mysqli_fetch_row($result4M);
		$bmessage = $row4M[0];
		$birthdaymessage = "Dear " . $fName . ",<br><br> " . $bmessage . "<br><br><br> (The Management of <Strong> BPC)</Strong>";
		$mail->ClearAddresses();
		sendmail($mail, $toMail, "Happy Birthday", $birthdaymessage);
	}

/**
 *
 * This is the function which sends the mail using PHPMailer
 * 
 * Parameters: 	$mail -- The details of mail server
 * 				$recipaint -- The email address of mail recipaint
 * 				$subject -- The Subject of the mail
 * 				$message -- The content of the mail
 * 
 **/
	function sendmail($mail, $recipaint, $subject, $message){
		$mail->Username = 'do-not-reply';
		$mail->Password = '9CHVQxW7';
		$mail->SetFrom('do-not-reply@bpc.bt');
		$mail->Subject = $subject;
		$mail->Body = $message;
		$mail->AddAddress($recipaint);
		$mail->Send();
	}
?> 
