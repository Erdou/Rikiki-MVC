<?php
/**
 * User: Erdal Gunyar
 * Date: 28/01/2016
 * Time: 15:49
 */

/**
 * Dumps information into an on-screen visible bloc.
 * @param array $var The variable to dump.
 * @param boolean $exit If true script will be terminated just after.
 * @param string $label Label to show in the head of the bloc.
 */
function dump($var, $exit = true, $label = '') {
    echo ('<pre style="background: #e5e5e5; border:1px dashed #e51010; padding:7px; text-align:left;">');

    if (!empty($label)) {
        echo ('<strong>'.$label.'</strong><br/>');
    }

    if (is_string($var)) {
        $var = htmlentities($var);
    }
    elseif (is_array($var)) {
        $var = array_map('_map_html_entities', $var);
    }
    print_r($var);

    echo ('</pre>');
    flush();

    if ($exit) {
        exit(0);
    }

    function _map_html_entities($var) {
        if (is_string($var)) {
            return htmlentities($var, ENT_QUOTES | ENT_XHTML, 'UTF-8');
        }
        return $var;
    }
}


/**
 * Proper htmlspecialchar (xhtml & utf8)
 */
function xhtml($string) {
    return htmlspecialchars($string, ENT_COMPAT | ENT_XHTML, 'UTF-8');
}


/**
 * Authentication
 */
function verifyAuth() {
    // If not logged and not already in loggin page
    if ((!isset($_SESSION['user']) || empty($_SESSION['user'])) &&  $_REQUEST['page'] != 'login') {
        header('Location: '.ROOT_URL.'login/');
        exit;
    }
    // If logged but trying to access login page
    if (isset($_SESSION['user']) && !empty($_SESSION['user']) && $_REQUEST['page'] == 'login') {
        header('Location: '.ROOT_URL);
        exit;
    }
}

/**
 * Builds an image into disc
 * @param int $w Width
 * @param int $h Height
 * @param string $src_path Image local source path
 * @param string $dst_path Builed image's destination path
 * @param boolean $crop If true image will be cropped to fit size (default false)
 * @param boolean $moveOrig If true image source will be move to media's "upload" folder (default true). Set it to false for chain building.
 * @author Erdal Gunyar
 * @return string Destination path if image is succefully created. False otherwise.
 */
function buildImage($w, $h, $crop = false, $pref = 'media', $moveOrig = true) {
    if ($_FILES['picture']['type'] != 'image/jpeg') {
        logwriteln("Invalid image type '{$_FILES['picture']['type']}', image should be JPEG, build image will certainly fail");
    }

    // Temporary removing PHP's memory limit as imagecreatefromjpeg can require a lot of memory to uncompress the image
    ini_set('memory_limit', '-1');
    $im = @imagecreatefromjpeg($_FILES['picture']['tmp_name']);
    if ($moveOrig) {
        @move_uploaded_file($_FILES['picture']['tmp_name'], ROOT_DIR.'medias/upload/'.uniqid().'_'.$_FILES['picture']['name'].'.jpg');
    }
    if (!$im) {
        return false;
    }
    $old_x = imagesx($im);
    $old_y = imageSY($im);
    $ratio = $h / $w;

    // Finding dimensions
    if ($old_y / $old_x < $ratio) {
        $wider = true;
    }
    else {
        $wider = false;
    }
    if (!($wider XOR $crop)) { // if wider and crop OR taller and nocrop
        $new_y = $h;
        $mult = $new_y / $old_y;
        $new_x = $old_x * $mult;
    }
    else {
        $new_x = $w;
        $mult = $new_x / $old_x;
        $new_y = $old_y * $mult;
    }
    // Resizing
    $int_im = @imagecreatetruecolor($new_x, $new_y);
    if (!$int_im) {
        @imagedestroy($im);
        return false;
    }
    if (!imagecopyresampled($int_im, $im, 0, 0, 0, 0, $new_x, $new_y, $old_x, $old_y)) {
        @imagedestroy($im);
        @imagedestroy($int_im);
        return false;
    }
    @imagedestroy($im); // no longer needed

    if ($crop) {
        // Cropping
        $dst_im = @imagecreatetruecolor($w, $h);
        if (!$dst_im) {
            @imagedestroy($int_im);
            return false;
        }
        if (!imagecopy($dst_im, $int_im, 0, 0, 0, 0, $w, $h)) {
            @imagedestroy($int_im);
            @imagedestroy($dst_im);
            return false;
        }
        @imagedestroy($int_im); // no longer needed
    }
    else {
        $dst_im = $int_im;
    }
    // Saving
    $dst_file = $pref.'_'.md5(microtime()).'_'.uniqid(null, true).'.jpg';
    $dst_url = ROOT_URL.'medias/'.$dst_file;
    $dst_path = ROOT_DIR.'medias/'.$dst_file;
    if (!@imagejpeg($dst_im, $dst_path, 90)) {
        @imagedestroy($dst_im);
        return false;
    }
    @imagedestroy($dst_im);
    return $dst_url;
}

/**
 * Returns a password hash.
 * @param $pass string A password
 * @return string The hash of the password
 */
function passwordHash($pass) {
    if (!$pass) {
        return false;
    }
    $salt = 'Ердал Гуныар';
    return md5($salt.$pass);
}

/**
 * Generates a new password randomly.
 * @param $length int Size of the generated password
 * @return string The generated password
 */
function genPassword($length) {
    $chars = "234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $i = 0;
    $password = "";
    while ($i <= $length) {
        $password .= $chars{mt_rand(0,strlen($chars))};
        $i++;
    }
    return $password;
}

/**
 * 403 helper
 */
function exit403() {
    header('HTTP/1.1 403 Forbidden');
    exit('Refused.');
}


/**
 * Normalize
 */
function normalize($str) {
    $str = trim($str);
    $str = mb_strtolower($str);
    $remplace = array('à'=>'a',
        'á'=>'a',
        'â'=>'a',
        'ã'=>'a',
        'ä'=>'a',
        'å'=>'a',
        'ò'=>'o',
        'ó'=>'o',
        'ô'=>'o',
        'õ'=>'o',
        'ö'=>'o',
        'è'=>'e',
        'é'=>'e',
        'ê'=>'e',
        'ë'=>'e',
        'ì'=>'i',
        'í'=>'i',
        'î'=>'i',
        'ï'=>'i',
        'ù'=>'u',
        'ú'=>'u',
        'û'=>'u',
        'ü'=>'u',
        'ÿ'=>'y',
        'ñ'=>'n',
        'ç'=>'c',
        'ø'=>'0',
        'ı'=>'i',
        'ş'=>'s',
        'ğ'=>'g'
    );
    $str = strtr($str, $remplace);
    $str = preg_replace('/[^a-z0-9]/', ' ', $str);
    $str = trim($str);
    $str = preg_replace('/[\s]+/', ' ', $str);

    return $str;
}

function normalizeName($name) {
    $name = normalize($name);
    $name = ucwords($name);
    return $name;
}

/**
 * Tests a mail addresse
 * @param string $mail
 * @return boolean If it's a correct mail, function returns 'true', else it returns 'false'
 */
function testMail($mail) {
    $mail = strtoupper($mail);
    return (preg_match('/^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/', $mail) > 0);
}

/**
 * Log function
 */
function logWriteln($message) {
    $time = date(DATE_ATOM);
    $ip = $_SERVER['REMOTE_ADDR'];
    $user = $_SESSION['user'];
    $res = @file_put_contents(ROOT_DIR.'app/log/app.log', "[$time][$user@$ip] $message\n", FILE_APPEND | LOCK_EX);
    return $res;
}


/**
 * Sends an email, proper way.
 *
 * @param $to mixed A string for one receiver or an array of receivers
 * @param $from string Sender's mail address
 * @param $subject string The subject of the mail
 * @param $message string The message
 * @param $replyTo string (Optional) A reply-to address
 * @return bool True if the mail is successfully sent, false otherwise
 */
function sendMail($to, $from, $subject, $message, $replyTo = ""){
    $headers = 'MIME-Version: 1.0'."\r\n".
        'Content-type: text/html; charset=utf-8'."\r\n".
        "From: $from"."\r\n".
        ($replyTo?("Reply-To: $replyTo"."\r\n"):'').
        'X-Mailer: PHP/'.phpversion()."\r\n".
        'Message-ID: <'.uniqid(false, true).'@'.ROOT_URL.'>'."\r\n".
        'X-Priority: 3'."\r\n".
        'Content-Transfer-Encoding: quoted-printable';

    $message = quoted_printable_encode($message);
    $subject = '=?UTF-8?Q?'.quoted_printable_encode($subject).'?=';

    if (is_array($to)) {
        $dests = $to;
        $to = '';
        foreach ($dests as $dest) {
            $to .= $dest.', ';
        }
        $to = substr($to, 0, -2);
    }

    $res = mail($to, $subject, $message, $headers);
    return $res;
}


/**
 * Make money format
 */
function numberToEuro($number) {
    $res = number_format($number, 2, ',', ' ').' €';
    return $res;
}


/**
 * Generate keywords for a desc
 */
function genKeywords($desc, $maxlen = 0) {
    require 'libs/emptywords.php';

    $str = mb_strtolower($desc, 'UTF-8');
    $words = _wordsToArray($str);

    $len = 0;
    $res = '';
    foreach ($words as $k => $v) {
        $wordlen = mb_strlen($k, 'UTF-8');
        if ($maxlen && (mb_strlen($k, 'UTF-8')+mb_strlen($res, 'UTF-8')+1) > $maxlen) {
            break;
        }

        $res .= $k.',';
    }
    $res = mb_substr($res, 0, -1, 'UTF-8');

    return $res;

    function _wordsToArray($str) {
        $res = array();

        $str = preg_replace('/[^a-zA-Z0-9\-àâæçéèêëïîôœùüûÿ]+/', ' ', $str);
        $exploded = explode(' ', $str);

        $emptyWords = getEmptyWords();

        foreach ($exploded as $word) {
            $word = trim($word);

            if (!empty($word) && mb_strlen($word, 'UTF-8') > 1 &&  (false === array_search($word, $emptyWords))) {
                if (isset($res[$word])) {
                    $res[$word] += 1;
                }
                else {
                    $res[$word] = 0;
                }
            }
        }

        arsort($res);

        return $res;
    }
}
