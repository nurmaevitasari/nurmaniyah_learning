<?php


// http://cariprogram.blogspot.com
    // nuramijaya@gmail.com
    // sumber : http://www.codediesel.com/php/downloading-gmail-attachments-using-php/

/**
 * Downloads attachments dari Gmail dan menyimpan dalam bentuk file.
 * Menggunakan PHP IMAP extension, jadi pastikan php_imap dienable pada php.ini, yaitu :
 * extension=php_imap.dll
 */

set_time_limit(3000);

/* koneksi ke gmail */


$hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}';
$username = 'prog.indotara@gmail.com';
$password = 'NURMA9483';


/* koneksi */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());


/* mengambil semua email dengan 'ALL' 
 * jika ingin yang terbaru (unread) gunakan 'NEW'
 * kemudian bisa dibatasi dengan mengeset variabel
 * $max_emails
 */
$emails = imap_search($inbox,'ALL');

/* untuk membatasi email yang diterima jika menggunakan 'ALL' */
$max_emails = 5;


/* jika email ditemukan */
if($emails) {

    $count = 1;

    /* urutkan sehingga hasilnya email terbaru di atas */
    rsort($emails);

    /* looping semua email yang dibaca... */
    foreach($emails as $email_number)
    {


        /* mengambil informasi spesifik email */
        $overview = imap_fetch_overview($inbox,$email_number,0);

        /* isi pesan */
        $message = imap_fetchbody($inbox,$email_number,2);

        /* struktur email */
        $structure = imap_fetchstructure($inbox, $email_number);

        $attachments = array();



        /* jika ditemukan attachment proses ... */
        if(isset($structure->parts) && count($structure->parts))
        {
            for($i = 0; $i < count($structure->parts); $i++)
            {


                $attachments[$i] = array(
                    'is_attachment' => false,
                    'filename' => '',
                    'name' => '',
                    'attachment' => ''
                );



                if($structure->parts[$i]->ifdparameters)
                {
                    foreach($structure->parts[$i]->dparameters as $object)
                    {

                        if(strtolower($object->attribute) == 'filename')
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['filename'] = $object->value;
                        }
                    }
                }

                if($structure->parts[$i]->ifparameters)
                {
                    foreach($structure->parts[$i]->parameters as $object)
                    {
                        if(strtolower($object->attribute) == 'name')
                        {
                            $attachments[$i]['is_attachment'] = true;
                            $attachments[$i]['name'] = $object->value;
                        }
                    }
                }

                if($attachments[$i]['is_attachment'])
                {
                    $attachments[$i]['attachment'] = imap_fetchbody($inbox, $email_number, $i+1);

                    /* 4 = QUOTED-PRINTABLE encoding */
                    if($structure->parts[$i]->encoding == 3)
                    {
                        $attachments[$i]['attachment'] = base64_decode($attachments[$i]['attachment']);
                    }
                    /* 3 = BASE64 encoding */
                    elseif($structure->parts[$i]->encoding == 4)
                    {
                        $attachments[$i]['attachment'] = quoted_printable_decode($attachments[$i]['attachment']);
                    }
                }
            }
        }

        /* looping semua attachment dalam email ini dan simpan ke file */
        foreach($attachments as $attachment)
        {

            
            if($attachment['is_attachment'] == 1)
            {
                $filename = $attachment['name'];
                if(empty($filename)) $filename = $attachment['filename'];

                if(empty($filename)) $filename = time() . ".dat";

                /* prefix agar nama attachment tidak tabrakan
                 * jika ada yang bernama file sama
                 */
                $fp = fopen($email_number . "-" . $filename, "w+");

                fwrite($fp, $attachment['attachment']);
                fclose($fp);
            }

        }

        if($count++ >= $max_emails) break;
    }

}

/* close the connection */
imap_close($inbox);

echo "Selesai";

?>