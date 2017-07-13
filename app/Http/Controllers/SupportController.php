<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Support;
use Auth;


class SupportController extends Controller {

	 const SUPPORT_NAME = 'Support';  // Imja kotorie pokazivaetsa kogda admin otvechaet v tikete
	 const SUPPORT_TITLE = 'ТЕХНИЧЕСКАЯ ПОДДЕРЖКА'; // Nazvanie dlja stronici tiketa i supporta
	 const TITLE_UP = 'Support | '; // Etot title pakazivaetsa v verhu gde vkladka

	public function support(Request $request) {

		$admin = Auth::user()->is_admin;
		$moderator = Auth::user()->is_moderator;
		$limit = Auth::user()->request;
		$users = Auth::user()->id;
		$usersname = Auth::user()->username;
		$usersava = Auth::user()->avatar;
		$error = NULL;
		$error2 = NULL;


		if ($admin == 1 || $moderator == 1) {
			//$tickets = \DB::table('support')->paginate(15);
			$tickets = \DB::table('support')->orderBy('status')->get();
		}
		else {
			$tickets = \DB::table('support')->where('user_id',Auth::user()->id)->orderBy('status')->get();
		}

		if (isset($_POST['submit']) && $limit <= 3)
		{
			if (isset($_POST['mess'])) { $text = $_POST['mess']; if ($text == '') { unset($text); } }
			if (isset($_POST['title'])) { $title = $_POST['title']; if ($title =='') { unset($title); } }

			if (empty($text)) {
    $error = 'You forgot to write a message!';
}
			if (empty($title)) {
    $error2 = 'You forgot to write a title!';
}
if (!$error && !$error2) {
	$text = stripslashes($text); $text = htmlspecialchars($text);
			$title = stripslashes($title); $title = htmlspecialchars($title);
			$date_ticket = date("Y-m-d H:i:s");

			\DB::table('support')->insert([
					'user_id' => $users,
					'username' => $usersname,
					'avatarka' => $usersava,
					'messages' => $text,
					'date' => $date_ticket,
					'title' => $title,
					'status' => 0,
					'ask' => 1,
				]);

			\DB::table('users')->where('id', $users)->update(array('request' => $limit + 1));
	if ($admin == 1 || $moderator == 1) {
			$tickets = \DB::table('support')->orderBy('status')->get();
			}
			else {
				$tickets = \DB::table('support')->where('user_id',Auth::user()->id)->orderBy('status')->get();
			}

			header('refresh: 0.1');
}



		}
		elseif(isset($_POST['submit']) && $limit > 3) {}
		return view('support.index', compact('tickets'));
	}

	public function ticket($ticketId){

		$admin = Auth::user()->is_admin;
		$users = Auth::user()->id;
		$usersname = Auth::user()->username;
		$usersava = Auth::user()->avatarka;

		$loots = \DB::table('support')->where('id',$ticketId)->get();
		$mess = \DB::table('supmessages')->where('ticket_id',$ticketId)->get();

		if (isset($_POST['submit']))
		{
	$error = NULL;
			$tmess = \DB::table('users')->where('id',Auth::user()->id)->get();

			if ($admin == 1) { $messadmin = 1; $uticket = 0; }
			if ($admin == 0) { $messadmin = 0; $uticket = $users; }

			if (isset($_POST['mess'])) {
			$text = $_POST['mess'];
			if ($text == '') {
		unset($text);
		}
	}


if (empty($text)) {
    $error = 'You forgot to write a message!';


}
if (!$error) {

	if ($admin == 1) {
		$text = stripslashes($text); $text = htmlspecialchars($text);
			$date_ticket = date("Y-m-d H:i:s");
    \DB::table('supmessages')->insert([
					'ticket_id' => $ticketId,
					'user_id' => $uticket,
					'admin_id' => $messadmin,
					'messages' => $text,
					'date' => $date_ticket,
				]);
			$loots = \DB::table('support')->where('id',$ticketId)->get();
			$mess = \DB::table('supmessages')->where('ticket_id',$ticketId)->get();

			\DB::table('support')
            ->where('id', $ticketId)
            ->update(array('ask' => 2));


			header('refresh: 0.1');

	}else{

			$text = stripslashes($text); $text = htmlspecialchars($text);
			$date_ticket = date("Y-m-d H:i:s");
			\DB::table('supmessages')->insert([
					'ticket_id' => $ticketId,
					'user_id' => $uticket,
					'admin_id' => $messadmin,
					'messages' => $text,
					'date' => $date_ticket,
				]);
			$loots = \DB::table('support')->where('id',$ticketId)->get();
			$mess = \DB::table('supmessages')->where('ticket_id',$ticketId)->get();

			header('refresh: 0.1');

	}
}

		}
		if (isset($_POST['close']))
		{
			\DB::table('support')
            ->where('id', $ticketId)
            ->update(array('status' => 1));

			$loots = \DB::table('support')->where('id',$ticketId)->get();
			$mess = \DB::table('supmessages')->where('ticket_id',$ticketId)->get();

			header('refresh: 0.1');
		}
		if (isset($_POST['ban']))
		{
			$uid_ticket = \DB::table('support')->where('id', $ticketId)->pluck('user_id');

			\DB::table('users')
            ->where('id', $uid_ticket)
            ->update(array('ban_ticket' => 1));

			$loots = \DB::table('support')->where('id',$ticketId)->get();
			$mess = \DB::table('supmessages')->where('ticket_id',$ticketId)->get();

			header('refresh: 0.1');
		}

	return view('support.ticket', compact('loots','mess'));
	}
}
