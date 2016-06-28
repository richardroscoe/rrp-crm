<?php
class CPhpMailerLogRoute extends CEmailLogRoute
{
    protected function sendEmail($email, $subject, $message)
    {
        $mail = new phpmailer();
        $mail->IsSMTP();
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->Username = "richard@richardroscoe.co.uk";
        $mail->Password = "9w8PJZODiVBf"; //best to keep this in your config file
        $mail->Subject = $subject;
		$mail->SetFrom('crm@richardroscoe.co.uk', 'CRM');
        $mail->Body = $message;
        $mail->addAddress($email);
        $mail->send();
    }
}
?>