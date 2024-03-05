<?php
error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

// require('fpdf185/fpdf.php');
// $pdf = new FPDF('P','mm','A4');
// $pdf->AddPage();
// $pdf->SetFont('Arial','B',14);

// $pdf->Cell(130 ,5,'MODERN PUBLIC SCHOOL',0,0);
// $pdfdoc = $pdf->Output("", "S");
// mail_attachment("mpsvns1995@gmail.com","hemant.singh@mpsvns.in", "test email","test message",$pdfdoc,"test.pdf");

function mail_attachment ($from , $to, $subject, $message, $pdfdoc,$filename){
            
            
            // a random hash will be necessary to send mixed content
            $separator = md5(time());
            
            // carriage return type (we use a PHP end of line constant)
            $eol = PHP_EOL;
            
            // attachment name
            // $filename = "test.pdf";
            
            // encode data (puts attachment in proper format)
            // $pdfdoc = $pdf->Output("", "S");
            $attachment = chunk_split(base64_encode($pdfdoc));
            
            // main header
            $headers  = "From: ".$from.$eol;
            $headers .= "MIME-Version: 1.0".$eol; 
            $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";
            
            // no more headers after this, we start the body! //
            
            $body = "--".$separator.$eol;
            $body .= "Content-Transfer-Encoding: 7bit".$eol.$eol;
            $body .= "This is a MIME encoded message.".$eol;
            
            // message
            $body .= "--".$separator.$eol;
            $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
            $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
            $body .= $message.$eol;
            
            // attachment
            $body .= "--".$separator.$eol;
            $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
            $body .= "Content-Transfer-Encoding: base64".$eol;
            $body .= "Content-Disposition: attachment".$eol.$eol;
            $body .= $attachment.$eol;
            $body .= "--".$separator."--";
            
            // send message
            $ok=mail($to, $subject, $body, $headers);
            
        //  $ok = mail($email_to, $email_subject, $email_message, $headers);
         
         if($ok) {
            echo "<center>";
            echo "Mail Sent Successfully ".$to." File name: ".$filename;
            unlink($attachment); // delete a file after attachment sent.
             echo "</br>";echo "</br>";
             echo "</center>";
         }else {
            die("Sorry but the email could not be sent. Please go back and try again!");
             echo "</br>";echo "</br>";
         }
      }

   ?>