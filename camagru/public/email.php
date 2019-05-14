<?php
    function confirm_email($username, $token, $email)
    {
        $boundary = "-----=" . md5(rand());
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $email))
            $endOfLine = "\r\n";
        else
            $endOfLine = "\n";

        $message_text = "Pour confirmer votre inscription cliquez sur ce lien: http://localhost:8080/camagru_ok/public/activation.php?username=".
            $username . "&token=" . $token;
        $message_html = "<html><head></head><body><h2>Bonjour ". $username ."</h2> Pour confirmer votre inscription " .
            "<a href=\"http://localhost:8080/camagru_ok/public/activation.php?username=". urlencode($username) .
            "&token=" . $token ."\">cliquez ici</a>.</body></html>";
        $sujet = "Confirmation d'inscription";
        $header = "From: \"camagru\"<camagru@gmail.com>". $endOfLine;
        $header.= "MIME-Version: 1.0" . $endOfLine;
        $header.= "Content-Type: multipart/alternative;". $endOfLine ." boundary=\"$boundary\"" . $endOfLine;

        $message = $endOfLine . "--" . $boundary . $endOfLine;

        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$endOfLine;
        $message.= "Content-Transfer-Encoding: 8bit".$endOfLine;
        $message.= $endOfLine.$message_text.$endOfLine;

        $message.= $endOfLine."--".$boundary.$endOfLine;
        //=====Ajout du message au format html.
        $message .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $endOfLine;
        $message .= "Content-Transfer-Encoding: 8bit" . $endOfLine;
        $message.= $endOfLine.$message_html.$endOfLine;

        $message .= $endOfLine . "--" . $boundary . "--".$endOfLine;
        $message .= $endOfLine . "--" . $boundary . "--".$endOfLine;

        if(mail($email, $sujet, $message, $header))
            echo ">confirm email sent" . PHP_EOL;
    }

    function reset_passwd_email($email, $token)
    {
        $boundary = "-----=" . md5(rand());
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $email))
            $endOfLine = "\r\n";
        else
            $endOfLine = "\n";

        $message_text = "Somebody asked to reset your password on Camagrick\n\nIf it was not you, you can safely ignore this email.\n" .
            "Click the following link to choose a new password:cliquez ici. http://localhost:8080/camagru_ok/public/activation.php?token=". $token;
        $message_html = "<html><head></head><body><h2>HI ! </h2> Somebody asked to reset your password on " .
            "<a href='http://localhost:8080/camagru_ok/public/index.php'>Camagrick</a><br/><br/>" .
            "If it was not you, you can safely ignore this email.<br/>" .
            "Click the following link to choose a new password:" .
            "<a href=\"http://localhost:8080/camagru_ok/public/reset_passwd.php?token=". $token . "\">cliquez ici</a>.</body></html>";
        $sujet = "Reset your password";
        $header = "From: \"camagru\"<camagru@gmail.com>". $endOfLine;
        $header.= "MIME-Version: 1.0" . $endOfLine;
        $header.= "Content-Type: multipart/alternative;". $endOfLine ." boundary=\"$boundary\"" . $endOfLine;

        $message = $endOfLine . "--" . $boundary . $endOfLine;

        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$endOfLine;
        $message.= "Content-Transfer-Encoding: 8bit".$endOfLine;
        $message.= $endOfLine.$message_text.$endOfLine;

        $message.= $endOfLine."--".$boundary.$endOfLine;
        //=====Ajout du message au format html.
        $message .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $endOfLine;
        $message .= "Content-Transfer-Encoding: 8bit" . $endOfLine;
        $message.= $endOfLine.$message_html.$endOfLine;

        $message .= $endOfLine . "--" . $boundary . "--".$endOfLine;
        $message .= $endOfLine . "--" . $boundary . "--".$endOfLine;

        if(mail($email, $sujet, $message, $header))
            echo ">reset passwds email sent" . PHP_EOL;
    }
    function send_like_notif($email, $username, $post_id)
    {
        $boundary = "-----=" . md5(rand());
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $email))
            $endOfLine = "\r\n";
        else
            $endOfLine = "\n";

        $message_text =  $username . " liked your post on Camagrick\n\n " .
            "Click the following link to see the liked post: http://localhost:8080/camagru_ok/public/index.php#". $post_id;
        $message_html = "<html><head></head><body><h2>HI ! </h2> " . $username . " liked your post on " .
            "<a href='http://localhost:8080/camagru_ok/public/index.php'>Camagrick</a><br/><br/>" .
            "Click the following link to see the liked post.<br/>" .
            "<a href=\"http://localhost:8080/camagru_ok/public/index.php#". $post_id . "\">cliquez ici</a>.</body></html>";
        $sujet = $username . " liked your post";
        $header = "From: \"camagru\"<camagru@gmail.com>". $endOfLine;
        $header.= "MIME-Version: 1.0" . $endOfLine;
        $header.= "Content-Type: multipart/alternative;". $endOfLine ." boundary=\"$boundary\"" . $endOfLine;

        $message = $endOfLine . "--" . $boundary . $endOfLine;

        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$endOfLine;
        $message.= "Content-Transfer-Encoding: 8bit".$endOfLine;
        $message.= $endOfLine.$message_text.$endOfLine;

        $message.= $endOfLine."--".$boundary.$endOfLine;
        //=====Ajout du message au format html.
        $message .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $endOfLine;
        $message .= "Content-Transfer-Encoding: 8bit" . $endOfLine;
        $message.= $endOfLine.$message_html.$endOfLine;

        $message .= $endOfLine . "--" . $boundary . "--".$endOfLine;
        $message .= $endOfLine . "--" . $boundary . "--".$endOfLine;

        if(mail($email, $sujet, $message, $header))
            echo ">like notif email sent" . PHP_EOL;
    }
    function send_comment_notif($email, $username, $post_id)
    {
        $boundary = "-----=" . md5(rand());
        if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $email))
            $endOfLine = "\r\n";
        else
            $endOfLine = "\n";

        $message_text =  $username . " posted a comment on your post on Camagrick\n\n " .
            "Click the following link to see the commentary: http://localhost:8080/camagru_ok/public/index.php#". $post_id;
        $message_html = "<html><head></head><body><h2>HI ! </h2> " . $username . " posted a comment on your post on " .
            "<a href='http://localhost:8080/camagru_ok/public/index.php'>Camagrick</a><br/><br/>" .
            "Click the following link to see the commentary.<br/>" .
            "<a href=\"http://localhost:8080/camagru_ok/public/index.php#". $post_id . "\">cliquez ici</a>.</body></html>";
        $sujet = $username . "  commented your post";
        $header = "From: \"camagru\"<camagru@gmail.com>". $endOfLine;
        $header.= "MIME-Version: 1.0" . $endOfLine;
        $header.= "Content-Type: multipart/alternative;". $endOfLine ." boundary=\"$boundary\"" . $endOfLine;

        $message = $endOfLine . "--" . $boundary . $endOfLine;

        //=====Ajout du message au format texte.
        $message.= "Content-Type: text/plain; charset=\"ISO-8859-1\"".$endOfLine;
        $message.= "Content-Transfer-Encoding: 8bit".$endOfLine;
        $message.= $endOfLine.$message_text.$endOfLine;

        $message.= $endOfLine."--".$boundary.$endOfLine;
        //=====Ajout du message au format html.
        $message .= "Content-Type: text/html; charset=\"ISO-8859-1\"" . $endOfLine;
        $message .= "Content-Transfer-Encoding: 8bit" . $endOfLine;
        $message.= $endOfLine.$message_html.$endOfLine;

        $message .= $endOfLine . "--" . $boundary . "--".$endOfLine;
        $message .= $endOfLine . "--" . $boundary . "--".$endOfLine;

        if(mail($email, $sujet, $message, $header))
            echo ">comment notif email sent" . PHP_EOL;
    }
?>
