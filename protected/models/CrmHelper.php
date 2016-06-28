<?php

/**
 * Helper functions
 */
class CrmHelper extends CActiveRecord
{
	public static function formatPhone($in)
	{
		$out = str_replace(' ', '', $in);
		
		if ($out[0] == '0') {
			$pre = substr($out, 0, 5);
			$post = substr($out, 5, 6);
			$out =$pre.' '.$post;
		}	
		return $out;
	}
	
	//
	// Prepare a date string for output
	//
	// Input format is yyyy-mm-dd hh:mm:ss
	// If the year is this year, don't display
	// Don't display seconds
	// If the day is today, output: Today, 10:00
	//
	// E.g. Output: 25 March, 10:00
	// E.g. Output: 2 January 2014, 10:00	
	//
	public static function dateTimeOutput( $datestr )
	{
		if (!$datestr || strlen($datestr) == 0)
			return ('Date not set');
			
		$format = 'Y-m-d H:i:s';
		$nowDate = new DateTime("now");	
		$inDate = DateTime::createFromFormat($format, $datestr);
			
		if ($nowDate->format('Y-m-d') == $inDate->format('Y-m-d')) {
			// It's today
			$out = "Today, ";
			$format = "g:ia"; 
		} elseif ($nowDate->format('Y') == $inDate->format('Y')) {
			// It's this year
			$out = '';
			$format = "l, j F, g:ia";
		} else {
			// Full date
			$out = '';
			$format = "l, j F Y, g:ia";
		}
		$out .= $inDate->format($format);
		
		return($out);
	}
	
	public static function dateOutput( $datestr, $notset = 'Date not set' )
	{
		if (!$datestr || strlen($datestr) == 0)
			return ($notset);
			
		$format = 'Y-m-d';
		$nowDate = new DateTime("now");	
		$inDate = DateTime::createFromFormat($format, $datestr);
			
		if ($nowDate->format('Y-m-d') == $inDate->format('Y-m-d')) {
			// It's today
			$out = "Today, ";
			$format = ""; 
		} elseif ($nowDate->format('Y') == $inDate->format('Y')) {
			// It's this year
			$out = '';
			$format = "l, j F";
		} else {
			// Full date
			$out = '';
			$format = "j F Y";
		}
		$out .= $inDate->format($format);
		
		return($out);
	}	
	
	public static function monthOutput( $datestr)
	{
		$format = 'Y-m-d';

		$inDate = DateTime::createFromFormat($format, $datestr);
		
		$format = "F Y";

		$out = $inDate->format($format);
		
		return($out);		
	}
	
	// Parss a reminder time specification
	//
	// Spec definition
	//
	// Spec = [+-][0-9]*[month | day | week | hour]
	// Which means, relative to the date/time $realtiveTo, return a datetime the specified number of days, minutes, weeks or hours, before (-) or after (+)
	//
	//
	public static function parseTimeSpec($spec, $relativeTo, $setHistorical = true)
	{
//echo "<p>spec $spec, rt $relativeTo , sh $setHistorical</p>";

		$format = 'Y-m-d H:i:s';
		$relDate = DateTime::createFromFormat($format, $relativeTo);
		if (!$relDate) {
			$format = 'Y-m-d H:i';
			$relDate = DateTime::createFromFormat($format, $relativeTo);
		}
		
		if (!$relDate)
			return NULL;
		
//echo "<p>relDate</p><pre>"; print_r($relDate); echo "</pre>";

		$format = 'Y-m-d H:i';
		
		$now = new DateTime("now");
//echo "<p>relDate = ".$relDate->format($format);
//echo ", now = ".$now->format($format)."</p>";
		
		if ($now > $relDate && !$setHistorical) {
//echo "<p>Not calculating historical date</p>";
			return NULL;
		}
		// Now add or subract the specified period.
		
		$relDate->modify($spec);
		$output = $relDate->format($format);
		return $output;
	}
	
	// Send a text message
	// 
	// We are using textlocal's email to sms gateway
	// nnnnnnn@txtlocal.co.uk
	//
	public static function sendTxt($msg, $mobile, $name)
	{		
		$len = strlen($msg->body);
		Yii::log("Send to $name ($mobile) $len characters:<br />$msg->body", "info", "application.crmhelper.sendTxt");
		
		Yii::import('application.extensions.phpmailer.JPhpMailer');
		$mail = new JPhpMailer;
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
		
		$mail->Username = 'richard@richardroscoe.co.uk';
		$mail->Password = '9w8PJZODiVBf';
//		$mail->SetFrom('crm@richardroscoe.co.uk', 'CRM');
$mail->SetFrom('richard@richardroscoe.co.uk', 'Richard Roscoe');

		$mail->Body = $msg->body;
		$mail->AddAddress(str_replace(' ', '', $mobile).'@txtlocal.co.uk');
		$mail->Send();	
	}
	
	// Send an email
	public static function sendEmail($msg, $email, $name)
	{
		Yii::log("Send to $name <$email>, subject: $msg->subject", "info", "application.crmhelper.sendEmail");
		
		Yii::import('application.extensions.phpmailer.JPhpMailer');
		$mail = new JPhpMailer;
		$mail->IsSMTP();
		$mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
		
		$mail->Username = 'richard@richardroscoe.co.uk';
		$mail->Password = '9w8PJZODiVBf';
		$mail->SetFrom('richard@richardroscoe.co.uk', 'Richard Roscoe');

		$mail->Subject = $msg->subject;
		$mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
		$mail->MsgHTML($msg->body, $name);
		$mail->AddAddress($email);
		$mail->Send();
//echo "<p>CrmHelper:: sendEmail() DIDNT SEND</P>";
	}
	
	public static function firstline($str)
	{
		$lines = preg_split( '/\r\n|\r|\n/', $str, 2);
		return ($lines[0]);
	}
}
?>