<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
class email
{   
    public function sendmail($header,$body,$email){
        // Thiết lập các thông số và gửi email
        $mail = new PHPMailer(true);
        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'kidcher1416@gmail.com'; // Địa chỉ email của bạn
            $mail->Password   = 'akprtgeyhnanokqd'; // Mật khẩu email của bạn
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Thiết lập thông tin người gửi và người nhận
            $mail->setFrom('kidcher1416@gmail.com', 'Shop');
            $mail->addAddress($email, 'Gửi từ shop vip pro');

            // Thiết lập tiêu đề và nội dung email
            $mail->Subject = $header;
            $mail->Body    = $body;

            $mail->CharSet = 'UTF-8';
            // Gửi email
            $mail->send();
            echo 'Email đã được gửi đi thành công';
        } catch (Exception $e) {
            echo "Có lỗi xảy ra khi gửi email: {$mail->ErrorInfo}";
        }
    }
}
if(isset($_POST["action"])&&$_POST["action"]=="sendmain"){
    $classmail = new email();
    return $classmail->sendmail($_POST["header"],$_POST["body"],$_POST["email"]);
}
?>