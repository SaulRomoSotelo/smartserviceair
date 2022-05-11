<?php


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['recaptcha_response'])) {

    // Build POST request:
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_secret = '6LfKFZUUAAAAAIMSf1Tnnma6BnWX5hbcwqkTyyE5';
    $recaptcha_response = $_POST['recaptcha_response'];

    // Make and decode POST request:
    $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    $recaptcha = json_decode($recaptcha);

    // Take action based on the score returned:
    if ($recaptcha->score >= 0.5) {
      $mail_to = 'servicio@smartserviceair.com'; // specify your email here

      // Assigning data from the $_POST array to variables
      $name = $_POST['sender_name'];
      $mail_from = $_POST['sender_email'];
      $phone = $_POST['sender_phone'];
      $message = $_POST['sender_message'];

      // Construct email subject
      $subject = 'Mensaje desde web : ' . $name;

      // Construct email body
      $body_message = 'De: ' . $name . "\r\n";
      $body_message .= 'E-mail: ' . $mail_from . "\r\n";
      $body_message .= 'Teléfono: ' . $phone . "\r\n";
      $body_message .= 'Mensaje: ' . $message . "\r\n";

      // Construct email headers
      $headers = 'From: ' . $mail_from . "\r\n";
      $headers .= 'Reply-To: ' . $mail_from . "\r\n";

      $mail_sent = mail($mail_to, $subject, $body_message, $headers);

      if ($mail_sent == true){ ?>
          <script language="javascript" type="text/javascript">
          alert('Gracias por tu mensaje, en breve responderemos tu solicitud de información.');
          window.location = '/';
          </script>
      <?php } else { ?>
      <script language="javascript" type="text/javascript">
          alert('Mensaje no enviado. Por favor contactanos por telefono');
          window.location = '/';
      </script>
      <?php
      }
    } else {
      ?>
      <script language="javascript" type="text/javascript">
          alert('Mensaje no enviado. Por favor contactanos por telefono');
          window.location = '/';
      </script>
      <?php
    }

}






?>
