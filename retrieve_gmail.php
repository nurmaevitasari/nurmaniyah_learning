

<?php
/*connect to database */

$server = "localhost";
$username_database = "root";
$password_database= "";
$database = "myiios_nurma";

// Koneksi dan memilih database di server
$conn = mysqli_connect($server,$username_database,$password_database,$database) or die("Koneksi gagal");

/* connect to gmail */
$hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}';
$username = 'prog.indotara@gmail.com';
$password = 'NURMA9483';

/* try to connect */
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

/* grab emails */
$emails = imap_search($inbox,'ALL');

if($emails) {


	
	/* begin output var */
	$output = '';
	
	/* put the newest emails on top */
	rsort($emails);
	
	/* for every email... */
	foreach($emails as $email_number) 
	{

		
		/* get information specific to this email */
		$overview = imap_fetch_overview($inbox,$email_number,0);
		$message = imap_fetchbody($inbox,$email_number,2);


		
		/* output the email header information */

		$seen 	 = $overview[0]->seen;
		$subject = $overview[0]->subject;
		$from 	 = $overview[0]->from;
		$date 	 = $overview[0]->date;




		$output.= '<div class="toggler '.($seen ? 'read' : 'unread').'">';
		$output.= '<span class="subject">'.$subject.'</span> ';
		$output.= '<span class="from">'.$from.'</span>';
		$output.= '<span class="date">on '.$date.'</span>';
		$output.= '</div>';
		
		/* output the email body */
		$output.= '<div class="body">'.$message.'</div>';

		$datetime = date('Y-m-d H:i:s');

		$a = $conn->query(
		"INSERT INTO tbl_data_email
			(
			penerima,
			pengirim,
			subject,
			send_date,
			pesan,
			date_created
			) 
		VALUES (
		'$username',
		'$from',
		'$subject',
		'$date',
		'$message',
		'$datetime'	
		)"
	);


	
	}
	
	echo $output;

	

} 

/* close the connection */
imap_close($inbox);