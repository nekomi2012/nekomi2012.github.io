<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use App\Game;
use App\Stats;
use Carbon\Carbon;
use Redirect;

class PagesController extends Controller
{
  const ADD_BONUS_MONEY = 10; //kazhdije 8 chasa
  const merchant_id = '43709'; //free-kassa
  const merchant_secret_1 = 'qhrm5cdi'; //free-kassa
  const merchant_secret_2 = 'w4ivbo6r'; //free-kassa
  const MINIMUM_BET = 5; // Min bet jet
  const MAXIMUM_BET = 1000; // Max bet jet
  const JET_EASY_PROCENT = 10; //Uz sliktu drop 30-40
  const JET_MEDIUM_PROCENT = 20; //Uz sliktu dropu 30-70
  const JET_HARD_PROCENT = 30; // Uz sliktu dropu 60-90



  public function pay(Request $request){
    $amount = $request->sum;
    $type = $request->payment_system;
    if((int)$amount < 1){
        $amount = 99;
    }
    $int_id =  \DB::table('payments')->insertGetId([
        'amount' => (int)$amount,
        'user' => Auth::user()->id,
        'time' => time(),
        'status' => 0,
      ]);
    $orderID = $int_id;

    $sign = md5(self::merchant_id.':'.$amount.':'.self::merchant_secret_1.':'.$orderID);
    if($type == 'qiwi'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=63';
    }else if($type == 'master'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=94';
    }else if($type == 'visa'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=94';
    }else if($type == 'mts'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=84';
    }else if($type == 'bee'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=83';
    }else if($type == 'mega'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=82';
    }else if($type == 'tele2'){
      $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=132';
    }else if($type == 'free'){
            $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru';
    }else if($type == 'yandex'){
            $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru&i=45';
    }else{
        $url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru';
    }
    //$url = 'http://www.free-kassa.ru/merchant/cash.php?m='.self::merchant_id.'&oa='.$amount.'&o='.$orderID.'&s='.$sign.'&lang=ru';
      return redirect($url);
  }

  function getIP() {
      if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
      return $_SERVER['REMOTE_ADDR'];
  }
  public function getPayment(Request $request){
    if (!in_array($this->getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98'))) {
    return "Ip nneatbilst";
    }

  $sign = md5(self::merchant_id.':'.$request->AMOUNT.':'.self::merchant_secret_2.':'.$request->MERCHANT_ORDER_ID);

    if($sign != $request->SIGN){
      return "Signi neatbilst";
    }
  $payment=   \DB::table('payments')
    ->where('id', $request->MERCHANT_ORDER_ID)->first();
    if(count($payment) == 0){
        return "Neatrada bd";
    }else{
        if($payment->status != 0){
            return "Status nav 0";
        }else{
            if($payment->amount != $request->AMOUNT){
                return "Summa neatbilst";
            }else{
              $user = User::where('id', $payment->user)->first();
              $user->money = $user->money + $payment->amount;
              $user->deposit = $user->deposit + $payment->amount;
              $user->save();

              //1 tas kas uzaicina
              $te = User::where('ref_code', $user->ref_use)->first();
              if(count($te) == null || count($te) == 0){

              }else{
                $bon = (5/100)*$payment->amount;
                $te->refferal_money =   $te->refferal_money + $bon;
                $te->save();
              }
              $stats = Stats::where('id', 1)->first();
              $stats->deposit = $stats->deposit + $payment->amount;
              $stats->save();
              \DB::table('payments')
              ->where('id', $payment->id)
              ->update(['status' => 1]);
                return 'success';
            }
        }
    }
  }
  public function last_drop_jet()
  {
      $last_drops = Game::orderBy('id', 'desc')->where('status', 2)->where('type',0)->where('level','>',0)->take(9)->get();
      return response()->json(['last_drop' => $last_drops]);
  }

  public function last_jet_get()
  {
      $last_drops = Game::orderBy('id', 'desc')->where('status', 2)->where('type',0)->take(1)->get();
      return $last_drops;
  }
  public function index(Request $r){
    if($r->r != null){
      if(!Auth::check()){

      }else{
        $this->refuseurl($r->r);
      }
    }
    if(!Auth::check()){
        $top2 = User::where('id','>', 0)->orderBy('profit', 'DESC')->take(10)->get();
        $topf = User::where('id','>', 0)->orderBy('open_box', 'DESC')->take(10)->get();
        $big = Game::where('status',2)->orderBy('id', 'DESC')->where('profit', '>', 100)->take(10)->get();
      return view('pages.index', compact('top2','topf','big'));
    }else{
        $user2 = User::where('login', Auth::user()->login)->first();
        $created = new Carbon($user2->bonus_time);
        $now = Carbon::now();
        if($created->diffInHours($now) >= 8){
          $user2->timer = 0;
          $user2->save();
          $h = Game::where('status',2)->where('level','>',0)->where('user', Auth::user()->id)->where('type',0)->orderBy('id', 'DESC')->take(10)->get();
          $top2 = User::where('id','>', 0)->orderBy('profit', 'DESC')->take(10)->get();
          $i = 1;
          foreach ($top2 as $c) {
            $c->iddd = $i;
            $i++;
          }

          $topf = User::where('id','>', 0)->orderBy('open_box', 'DESC')->take(10)->get();
          $a = 1;
          foreach ($topf as $c1) {
            $c1->iddd = $a;
            $a++;
          }
          $big = Game::where('status',2)->orderBy('id', 'DESC')->where('profit', '>', 100)->take(10)->get();
          $pay =  \DB::table('payments')->where('user', Auth::user()->id)->where('status',1)->get();
          $viv =  \DB::table('vivod')->where('user', Auth::user()->id)->get();
            $ref =  User::where('ref_use', Auth::user()->ref_code)->count();
          return view('pages.index', compact('h','top2','topf','big','pay','viv','ref'));
        }else{
          $s = $created->diffInSeconds($now);
          $t = 28800  - $s;
          $user2->timer = $t;
          $user2->save();
          $h = Game::where('status',2)->where('level','>',0)->where('user', Auth::user()->id)->where('type',0)->orderBy('id', 'DESC')->take(10)->get();
          $top2 = User::where('id','>', 0)->orderBy('profit', 'DESC')->take(10)->get();
          $i = 1;
          foreach ($top2 as $c) {
            $c->iddd = $i;
            $i++;
          }
          $topf = User::where('id','>', 0)->orderBy('open_box', 'DESC')->take(10)->get();
          $a = 1;
          foreach ($topf as $c1) {
            $c1->iddd = $a;
            $a++;
          }
          $big = Game::where('status',2)->orderBy('id', 'DESC')->where('profit', '>', 100)->take(10)->get();
          $pay =  \DB::table('payments')->where('user', Auth::user()->id)->where('status',1)->get();
          $viv =  \DB::table('vivod')->where('user', Auth::user()->id)->get();
          $ref =  User::where('ref_use', Auth::user()->ref_code)->count();
          return view('pages.index', compact('h','top2','topf','big','pay','viv','ref'));
        }
    }
  }
  public function vivod($price, $kosh)
  {
    $zayavka = \DB::table('vivod')->where('user', Auth::user()->id)->where('status', 0)->count();
    if($this->user->money < $price) {
      $data = [
        'status' => 0,
        'message' => 'Не достаточно денег на балансе'
      ];
    } else if(strlen($kosh) <= 5 || $kosh == '') {
      $data = [
        'status' => 0,
        'message' => 'Попробуйте другой кошелёк!'
      ];
    } else if($zayavka >= 1){
      $data = [
        'status' => 0,
        'message' => 'Дождитесь оформления другой заявки!'
      ];
    }else if($price < 100){
      $data = [
        'status' => 0,
        'message' => 'Минимальная сумма к выводу: 100 р!'
      ];
    }
     else {
      $user = User::find(Auth::user()->id);
      $user->money = $user->money - $price;
      $user->save();
        $stats = Stats::where('id', 1)->first();
        $stats->vivod = $stats->vivod + $price;
        $stats->save();
      $data = [
        'status' => 1,
        'message' => 'Ваша заявка оформлена!',
        'sum' => $user->money,
        'nomer' => $kosh,
      ];
        \DB::table('vivod')->insertGetId(['user' => Auth::user()->id, 'amount' => $price, 'nomer' => $kosh]);
    }

    return $data;
  }


  public function addbonus(Request $request){
    if(!Auth::check()){
      return Redirect::to('/login');
    }else{
          $user2 = User::where('login', Auth::user()->login)->first();
        if(Carbon::now()->gt(Carbon::yesterday())){
            $created = new Carbon($user2->bonus_time);
            $now = Carbon::now();
        if($created->diffInHours($now) >= 8){
          $user2->money =   $user2->money + self::ADD_BONUS_MONEY;
          $user2->bonus_time = Carbon::now();
          $user2->save();
          return response()->json(['status' => 'true']);
        }else{
        $av =  8 -  $created->diffInHours($now);
            return response()->json(['status' => 'false', 'hoursleft' => $av]);
        }
      }
  }
  }

public function success(){
    return redirect('/');
}
  public function refuseurl($code2)
  {
      $code = \DB::table('users')->where('ref_code', $code2)->first();
      if (Auth::user()->ref_use !== NULL) {
        return 'Code used';
      } else if ($code == NULL) {
        return 'Code null';
      } else if (Auth::user()->ref_code == $code2) {
          return 'Code user';
      } else {
          $user = User::find(Auth::user()->id);
          $user->money = $user->money + 5;
          $user->ref_use = $code2;
          $user->save();
            return redirect('/login');
      }
  }

  public function getTopUser(){
    $top = User::where('id','>', 0)->orderBy('open_box', 'DESC')->take(10)->get();
    return $top;
  }
  public function getTopUserWeg(){
      $top = User::where('id','>', 0)->orderBy('profit', 'DESC')->take(10)->get();
    return $top;
  }
  public function getHistoryUser(Request $r){
      $history = Game::where('status',2)->where('level','>',0)->where('user', $r->user)->where('type',0)->orderBy('id', 'DESC')->take(9)->get();
      return $history;
  }
  public function getHistory(){
      $history = Game::where('status',2)->where('type',0)->where('level','>',0)->orderBy('id', 'DESC')->take(9)->get();
      return $history;
  }
  public function getStats(){
    $stats = Stats::where('id', 1)->first();
      return response()->json(['total' => $stats->total, 'games' => $stats->games]);
  }
  public function takebet(Request $r){
    $user = User::where('id', $r->user)->first();
    $game = Game::where('user', $user->id)->orderBy('id','DESC')->first();
    $mode = $game->mode;
    $level = $game->level;
    $bet = $game->bet;
    if($game->type == 0){
    if($game->status == 0){
      $mo = 0;
      $bala = 0;
      if($mode == 'easy'){
        if($level == 0){
          $user->money = $user->money + $game->bet;
          $user->save();
          $game->status = 2;
          $game->save();
        }else if($level == 1){
            $bala = $game->bet * 1.4;
          $user->money = $user->money + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 2){
          $bala = $game->bet * 2.2;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 3){
          $bala = $game->bet * 3.2;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 4){
          $bala = $game->bet * 4.8;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 5){
          $bala = $game->bet * 7.2;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 6){
          $bala = $game->bet * 10.7;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 7){
          $bala = $game->bet * 15.9;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 8){
          $bala = $game->bet * 23.6;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 9){
          $bala = $game->bet * 35.1;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 10){
          $bala = $game->bet * 52.1;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }
      }else if($mode == 'medium'){
        if($level == 0){
          $user->money = $user->money + $game->bet;
          $user->save();
          $game->status = 2;
          $game->save();
        }else if($level == 1){
          $bala = $game->bet * 1.9;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 2){
          $bala = $game->bet * 3.9;
          $user->money = $user->money + $bala;
             $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 3){
          $bala = $game->bet * 7.7;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 4){
          $bala = $game->bet * 15.2;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 5){
          $bala = $game->bet * 30;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 6){
          $bala = $game->bet * 59.3;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 7){
          $bala = $game->bet * 117.2;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 8){
          $bala = $game->bet * 231.4;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 9){
          $bala = $game->bet * 457.1;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 10){
          $bala = $game->bet * 902.9;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }
      }else if($mode == 'hard'){
        if($level == 0){
          $user->money = $user->money + $game->bet;
          $user->save();
          $game->status = 2;
          $game->save();
        }else if($level == 1){
          $bala = $game->bet * 2.9;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 2){
          $bala = $game->bet * 8.8;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 3){
          $bala = $game->bet * 26.1;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 4){
          $bala = $game->bet * 77.8;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 5){
          $bala = $game->bet * 231.0;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 6){
          $bala = $game->bet * 686.3;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 7){
          $bala = $game->bet * 2038.4;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 8){
          $bala = $game->bet * 6054.1;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 9){
          $bala = $game->bet * 17980.7;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }else if($level == 10){
          $bala = $game->bet * 53402.8;
          $user->money = $user->money + $bala;
                  $user->profit2 = $user->profit2 + $bala;
          $user->save();
          $game->status = 2;
          $game->profit = $bala;
          $game->save();
        }
      }
      $path = $game->path;
      $a =  unserialize($path);
      $b = json_decode($a, true);
        return response()->json(['banka' => 1,'status' => 'true', 'error' => 'Game ended. Money added to balance!', 'mode' => $mode,'fields_seeds' => $b]);
    }else{
      $path = $game->path;
      $a =  unserialize($path);
      $b = json_decode($a, true);
      return response()->json(['banka' => 1,'status' => 'false', 'error' => 'Game ended. Money not given!', 'mode' => $mode,'fields_seeds' => $b]);
    }

    }else{
      $game->status = 2;
      $game->save();
      $path = $game->path;
      $a =  unserialize($path);
      $b = json_decode($a, true);
        return response()->json(['banka' => 0,'status' => 'true', 'error' => 'Demo game ended!', 'mode' => $mode,'fields_seeds' => $b]);
    }
  }
  public function checkGame(Request $r){
    $user = User::where('id',$r->pleyers)->first();
    $game = Game::where('user', $user->id)->where('status',0)->first();
    $level = $r->level;
    $place = $r->place;
    $path = $game->path;
    $a =  unserialize($path);
    $b = json_decode($a, true);
    if($b[$level - 1]['steps'][$place - 1] == 0){
      if($user->is_yt == 1){
        if($game->mode == 'hard'){
          $akas = mt_rand(0,3);
        }else if($game->mode == 'medium'){
            $akas = mt_rand(1,4);
        }else{
          $akas = mt_rand(3,7);
        }
      if($level <= $akas){
        if($game->mode == 'easy'){
          if($place == 1){
              $ra = mt_rand(1,2);
              $b[$level - 1]['steps'][$place - 1] = 1;
              if($ra == 1){
                $b[$level - 1]['steps'][1] = 0;
              }else{
                $b[$level - 1]['steps'][2] = 0;
              }
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }else if($place == 2){
                $ra = mt_rand(0,2);
              $b[$level - 1]['steps'][$place - 1] = 1;
              if($ra == 2){
                $b[$level - 1]['steps'][2] = 0;
              }else{
                $b[$level - 1]['steps'][0] = 0;
              }
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }else if($place == 3){
            $ra = mt_rand(0,1);
              $b[$level - 1]['steps'][$place - 1] = 1;
              if($ra == 1){
                $b[$level - 1]['steps'][1] = 0;
              }else{
                $b[$level - 1]['steps'][0] = 0;
              }
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }
          $game->save();
          $game->level = $game->level + 1;
          $game->save();
          if($game->type == 0){
              return response()->json(['banka' => 1 , 'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }else{
                          return response()->json(['banka' => 0 , 'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }
        }
        if($game->mode == 'hard'){
          if($place == 1){
              $ra = mt_rand(1,2);
              $b[$level - 1]['steps'][$place - 1] = 1;
              if($ra == 1){
                $b[$level - 1]['steps'][1] = 0;
                $b[$level - 1]['steps'][2] = 0;
              }else{
                  $b[$level - 1]['steps'][1] = 0;
                $b[$level - 1]['steps'][2] = 0;
              }
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }else if($place == 2){
                $ra = mt_rand(0,2);
              $b[$level - 1]['steps'][$place - 1] = 1;
              if($ra == 2){
                  $b[$level - 1]['steps'][0] = 0;
                $b[$level - 1]['steps'][2] = 0;
              }else{
                    $b[$level - 1]['steps'][2] = 0;
                $b[$level - 1]['steps'][0] = 0;
              }
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }else if($place == 3){
            $ra = mt_rand(0,1);
              $b[$level - 1]['steps'][$place - 1] = 1;
              if($ra == 1){
                $b[$level - 1]['steps'][1] = 0;
                  $b[$level - 1]['steps'][0] = 0;
              }else{
                  $b[$level - 1]['steps'][1] = 0;
                $b[$level - 1]['steps'][0] = 0;
              }
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }
          $game->save();
          $game->level = $game->level + 1;
          $game->save();
          if($game->type == 0){
            return response()->json(['banka' => 1 ,'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }else{
            return response()->json(['banka' => 0 ,'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }
        }
        if($game->mode == 'medium'){
          if($place == 2){
              $b[$level - 1]['steps'][1] = 1;
              $b[$level - 1]['steps'][0] = 0;
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }else{
              $b[$level - 1]['steps'][0] = 1;
              $b[$level - 1]['steps'][1] = 0;
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }
          $game->save();
          $game->level = $game->level + 1;
          $game->save();

          if($game->type == 0){
            return response()->json(['banka' => 1, 'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }else{
                return response()->json(['banka' => 0,'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }
        }
      }else{
        $game->status = 2;
          $game->level = $game->level + 1;
        $game->save();

        if($game->type == 0){
            return response()->json(['banka' => 1,'status' => 'false', 'error' => 'Game ended!' ,'mode' => $game->mode ,'fields_seeds' => $b, 'end' => 1, 'status' => 2]);
        }else{
                return response()->json(['banka' => 0,'status' => 'false', 'error' => 'Game ended!' ,'mode' => $game->mode ,'fields_seeds' => $b, 'end' => 1, 'status' => 2]);
        }
      }
      }else{
        $game->status = 2;
          $game->level = $game->level + 1;
        $game->save();
        if($game->type == 0){
            return response()->json(['banka' => 1,'status' => 'false', 'error' => 'Game ended!' ,'mode' => $game->mode ,'fields_seeds' => $b, 'end' => 1, 'status' => 2]);
        }else{
                return response()->json(['banka' => 0,'status' => 'false', 'error' => 'Game ended!' ,'mode' => $game->mode ,'fields_seeds' => $b, 'end' => 1, 'status' => 2]);
        }
      }
    }else if($b[$level - 1]['steps'][$place - 1] == 1){
      if($user->is_yt == 1){
        if($game->level == 9){
          $game->level = $game->level + 1;
          $game->save();
          if($game->type == 0){
              return response()->json(['banka' => 1,'status' => 'true', 'error' => 'End level!','mode' => $game->mode ,'fields_seeds' => $b,'level' => $game->level + 1, 'end' => 1, 'status' => 1]);
          }else{
                  return response()->json(['banka' => 0,'status' => 'true', 'error' => 'End level!','mode' => $game->mode ,'fields_seeds' => $b,'level' => $game->level + 1, 'end' => 1, 'status' => 1]);
          }
        }
        $game->level = $game->level + 1;
        $game->save();
        if($game->type == 0){
    return response()->json(['banka' => 1,'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
        }else{
          return response()->json(['banka' => 0,'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
        }
      }else{
        if($game->mode == 'easy'){
          $pro = mt_rand(1,100);
          if($pro <= self::JET_EASY_PROCENT){//70
          if($place == 1){
              $b[$level - 1]['steps'][$place - 1] = 0;
              $b[$level - 1]['steps'][2] = 1;
              $b[$level - 1]['steps'][1] = 1;
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }else if($place == 2){
              $b[$level - 1]['steps'][$place - 1] = 0;
              $b[$level - 1]['steps'][0] = 1;
              $b[$level - 1]['steps'][2] = 1;
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }else if($place == 3){
              $b[$level - 1]['steps'][$place - 1] = 0;
              $b[$level - 1]['steps'][0] = 1;
              $b[$level - 1]['steps'][1] = 1;
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }
          $game->status = 2;
          $game->level = $game->level + 1;
          $game->save();
          if($game->type == 0){
              return response()->json(['banka' => 1,'status' => 'false', 'error' => 'Game ended!' ,'mode' => $game->mode ,'fields_seeds' => $b, 'end' => 1, 'status' => 2]);
          }else{
                  return response()->json(['banka' => 0,'status' => 'false', 'error' => 'Game ended!' ,'mode' => $game->mode ,'fields_seeds' => $b, 'end' => 1, 'status' => 2]);
          }
        }else{
          $game->save();
          $game->level = $game->level + 1;
          $game->save();
          if($game->type == 0){
              return response()->json(['banka' => 1 , 'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }else{
                          return response()->json(['banka' => 0 , 'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }
        }
        }
        if($game->mode == 'hard'){
          $pro = mt_rand(1,100);
          if($pro <= self::JET_HARD_PROCENT){
          if($place == 1){
              $ra = mt_rand(1,2);
              $b[$level - 1]['steps'][$place - 1] = 0;
              if($ra == 1){
                $b[$level - 1]['steps'][1] = 1;
                $b[$level - 1]['steps'][2] = 0;
              }else{
                  $b[$level - 1]['steps'][1] = 0;
                $b[$level - 1]['steps'][2] = 1;
              }
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }else if($place == 2){
                $ra = mt_rand(0,2);
              $b[$level - 1]['steps'][$place - 1] = 0;
              if($ra == 2){
                  $b[$level - 1]['steps'][0] = 0;
                $b[$level - 1]['steps'][2] = 1;
              }else{
                    $b[$level - 1]['steps'][2] = 0;
                $b[$level - 1]['steps'][0] = 1;
              }
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }else if($place == 3){
            $ra = mt_rand(0,1);
              $b[$level - 1]['steps'][$place - 1] = 0;
              if($ra == 1){
                $b[$level - 1]['steps'][1] = 1;
                  $b[$level - 1]['steps'][0] = 0;
              }else{
                  $b[$level - 1]['steps'][1] = 0;
                $b[$level - 1]['steps'][0] = 1;
              }
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }
          $game->status = 2;
          $game->level = $game->level + 1;
          $game->save();
          if($game->type == 0){
              return response()->json(['banka' => 1,'status' => 'false', 'error' => 'Game ended!' ,'mode' => $game->mode ,'fields_seeds' => $b, 'end' => 1, 'status' => 2]);
          }else{
                  return response()->json(['banka' => 0,'status' => 'false', 'error' => 'Game ended!' ,'mode' => $game->mode ,'fields_seeds' => $b, 'end' => 1, 'status' => 2]);
          }
        }else{
          $game->save();
          $game->level = $game->level + 1;
          $game->save();
          if($game->type == 0){
              return response()->json(['banka' => 1 , 'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }else{
                          return response()->json(['banka' => 0 , 'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }
        }
        }
        if($game->mode == 'medium'){
          $pro = mt_rand(1,100);
          if($pro <= self::JET_MEDIUM_PROCENT){
          if($place == 2){
              $b[$level - 1]['steps'][1] = 0;
              $b[$level - 1]['steps'][0] = 1;
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }else{
              $b[$level - 1]['steps'][0] = 0;
              $b[$level - 1]['steps'][1] = 1;
              $ac = json_encode($b, true);
              $acc = serialize($ac);
              $game->path = $acc;
          }
          $game->status = 2;
          $game->level = $game->level + 1;
          $game->save();
          if($game->type == 0){
              return response()->json(['banka' => 1,'status' => 'false', 'error' => 'Game ended!' ,'mode' => $game->mode ,'fields_seeds' => $b, 'end' => 1, 'status' => 2]);
          }else{
                  return response()->json(['banka' => 0,'status' => 'false', 'error' => 'Game ended!' ,'mode' => $game->mode ,'fields_seeds' => $b, 'end' => 1, 'status' => 2]);
          }
        }else{
          $game->save();
          $game->level = $game->level + 1;
          $game->save();
          if($game->type == 0){
              return response()->json(['banka' => 1 , 'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }else{
                          return response()->json(['banka' => 0 , 'status' => 'true', 'error' => 'Next level!','mode' => $game->mode ,'level' => $game->level + 1, 'end' => 0, 'status' => 1]);
          }
        }
      }
      }
    }
  }
  public function ru(Request $r){
    if($r->r != null){
      if(!Auth::check()){

      }else{
        $this->refuseurl($r->r);
      }
    }
    if(!Auth::check()){
        $top2 = User::where('id','>', 0)->orderBy('profit', 'DESC')->take(10)->get();
        $topf = User::where('id','>', 0)->orderBy('open_box', 'DESC')->take(10)->get();
        $big = Game::where('status',2)->orderBy('id', 'DESC')->where('profit', '>', 100)->take(10)->get();
      return view('pages.ru', compact('top2','topf','big'));
    }else{
        $user2 = User::where('login', Auth::user()->login)->first();
        $created = new Carbon($user2->bonus_time);
        $now = Carbon::now();
        if($created->diffInHours($now) >= 8){
          $user2->timer = 0;
          $user2->save();
          $h = Game::where('status',2)->where('level','>',0)->where('user', Auth::user()->id)->where('type',0)->orderBy('id', 'DESC')->take(10)->get();
          $top2 = User::where('id','>', 0)->orderBy('profit', 'DESC')->take(10)->get();
          $i = 1;
          foreach ($top2 as $c) {
            $c->iddd = $i;
            $i++;
          }

          $topf = User::where('id','>', 0)->orderBy('open_box', 'DESC')->take(10)->get();
          $a = 1;
          foreach ($topf as $c1) {
            $c1->iddd = $a;
            $a++;
          }
          $big = Game::where('status',2)->orderBy('id', 'DESC')->where('profit', '>', 100)->take(10)->get();
          $pay =  \DB::table('payments')->where('user', Auth::user()->id)->where('status',1)->get();
          $viv =  \DB::table('vivod')->where('user', Auth::user()->id)->get();
            $ref =  User::where('ref_use', Auth::user()->ref_code)->count();
          return view('pages.ru', compact('h','top2','topf','big','pay','viv','ref'));
        }else{
          $s = $created->diffInSeconds($now);
          $t = 28800  - $s;
          $user2->timer = $t;
          $user2->save();
          $h = Game::where('status',2)->where('level','>',0)->where('user', Auth::user()->id)->where('type',0)->orderBy('id', 'DESC')->take(10)->get();
          $top2 = User::where('id','>', 0)->orderBy('profit', 'DESC')->take(10)->get();
          $i = 1;
          foreach ($top2 as $c) {
            $c->iddd = $i;
            $i++;
          }
          $topf = User::where('id','>', 0)->orderBy('open_box', 'DESC')->take(10)->get();
          $a = 1;
          foreach ($topf as $c1) {
            $c1->iddd = $a;
            $a++;
          }
          $big = Game::where('status',2)->orderBy('id', 'DESC')->where('profit', '>', 100)->take(10)->get();
          $pay =  \DB::table('payments')->where('user', Auth::user()->id)->where('status',1)->get();
          $viv =  \DB::table('vivod')->where('user', Auth::user()->id)->get();
          $ref =  User::where('ref_use', Auth::user()->ref_code)->count();
          return view('pages.ru', compact('h','top2','topf','big','pay','viv','ref'));
        }
    }
  }
  public function getBalance(Request $r){
    $user = User::where('id', $r->user)->first();
     return response()->json(['status' => 'true', 'balance' => $user->money]);
  }
  public function generateGame(Request $r){
      $user = User::where('id',$r->user)->first();
      $game = Game::where('user', $user->id)->where('status', 0)->first();
      $stats = Stats::where('id', 1)->first();
      if($game != null){
        if($game->level == 0 && $game->type == 0){
          $hash = md5($user->id.$r->bet.$r->mode);
          return response()->json(['status' => 'true', 'banka' => 1, 'hash' => $hash]);
        }else{
          $game->status = 2;
          $game->save();
        }
      }
      if($r->bet < self::MINIMUM_BET){   return response()->json(['status' => 'false', 'error' => 'Minimum bet '.self::MINIMUM_BET.'! ', 'user' => $user->id]);}
      if($r->bet > self::MAXIMUM_BET){ return response()->json(['status' => 'false', 'error' => 'Maximum bet '.self::MAXIMUM_BET.'! ', 'user' => $user->id]);}
      if($r->bet <= $user->money){ //TODO bet amount

        $user->money = $user->money - $r->bet;
        $user->open_box = $user->open_box + 1;
        $user->profit = $user->profit + $r->bet;
        $user->save();
        $stats->total = $stats->total + $r->bet;
        $stats->games = $stats->games + 1;
        $stats->save();
        if($r->mode == 'easy'){
          $a = [];
          for ($i=1; $i <= 10; $i++) {
            $r1 = mt_rand(0,1);
            $r2 = mt_rand(0,1);
            $r3 = mt_rand(0,1);
            while($r1 == 0 && $r2 == 0 && $r3 == 0 ||
             $r1 == 1 && $r2 == 1 && $r3 == 1 ||
              $r1 == 0 && $r2 == 0 && $r3 == 1 ||
             $r1 == 1 && $r2 == 0 && $r3 == 0 ||
              $r1 == 0 && $r2 == 1 && $r3 == 0){
                $r1 = mt_rand(0,1);
                $r2 = mt_rand(0,1);
                $r3 = mt_rand(0,1);
            }
            if($r1 == 0 && $r2 == 0 && $r3 == 0 ||
             $r1 == 1 && $r2 == 1 && $r3 == 1 ||
              $r1 == 0 && $r2 == 0 && $r3 == 1 ||
             $r1 == 1 && $r2 == 0 && $r3 == 0 ||
              $r1 == 0 && $r2 == 1 && $r3 == 0){

              }else{
                              $a[] = ['level' => $i, 'steps' => $r1.$r2.$r3] ;
              }
          }
          $b = json_encode($a);
          // $user->money = $user->money - 1;
          // $user->save();
          $hash = md5($user->id.$r->bet.$r->mode.$b);
          $hash2 = md5(md5($user->id.$r->bet.$r->mode.$b));
          $k = mt_rand(0,2);
          $k2 = mt_rand(0,2);
          $k3 = mt_rand(0,2);
          $k4 = mt_rand(0,2);
          $k5 = mt_rand(0,2);
          $k6 = mt_rand(0,2);
          $k7 = mt_rand(0,2);
          $k8 = mt_rand(0,2);
          $k9 = mt_rand(0,2);
          $k10 = mt_rand(0,2);

          $x = mt_rand(0,2);
          $x2 = mt_rand(0,2);
          $x3 = mt_rand(0,2);
          $x4 = mt_rand(0,2);
          $x5 = mt_rand(0,2);
          $x6 = mt_rand(0,2);
          $x7 = mt_rand(0,2);
          $x8 = mt_rand(0,2);
          $x9 = mt_rand(0,2);
          $x10 = mt_rand(0,2);

          $client = $k.$k2.$k3.$k4.$k5.$k6.$k7.$k8.$k9.$k10;
          $server = $x.$x2.$x3.$x4.$x5.$x6.$x7.$x8.$x9.$x10;

          Game::create([
              'user' => $user->id,
              'bet' => $r->bet,
              'mode' => $r->mode,
              'profit' => 0,
              'hash' => $hash,
              'level' => 0,
              'path' => serialize($b),
              'nick' => $user->username,
              'type' => '0',
              'number' => $hash2,
              'seed_u' => $client,
              'seed_c' => $server
          ]);
        }else if($r->mode == 'medium'){
          $a = [];
          for ($i=1; $i <= 10; $i++) {
            $r1 = mt_rand(0,1);
            $r2 = mt_rand(0,1);
            while($r1 == 0 && $r2 == 0 || $r1 == 1 && $r2 == 1){
              $r1 = mt_rand(0,1);
              $r2 = mt_rand(0,1);
            }
            if($r1 == 0 && $r2 == 0 || $r1 == 1 && $r2 == 1){

            }else{
                              $a[] = ['level' => $i, 'steps' => $r1.$r2] ;
            }
          }
          $b = json_encode($a);
          $hash = md5($user->id.$r->bet.$r->mode.$b);
          // $user->money = $user->money - 1;
          // $user->save();
          $hash2 = md5(md5($user->id.$r->bet.$r->mode.$b));
          $k = mt_rand(0,2);
          $k2 = mt_rand(0,2);
          $k3 = mt_rand(0,2);
          $k4 = mt_rand(0,2);
          $k5 = mt_rand(0,2);
          $k6 = mt_rand(0,2);
          $k7 = mt_rand(0,2);
          $k8 = mt_rand(0,2);
          $k9 = mt_rand(0,2);
          $k10 = mt_rand(0,2);

          $x = mt_rand(0,2);
          $x2 = mt_rand(0,2);
          $x3 = mt_rand(0,2);
          $x4 = mt_rand(0,2);
          $x5 = mt_rand(0,2);
          $x6 = mt_rand(0,2);
          $x7 = mt_rand(0,2);
          $x8 = mt_rand(0,2);
          $x9 = mt_rand(0,2);
          $x10 = mt_rand(0,2);

          $client = $k.$k2.$k3.$k4.$k5.$k6.$k7.$k8.$k9.$k10;
          $server = $x.$x2.$x3.$x4.$x5.$x6.$x7.$x8.$x9.$x10;

          Game::create([
            'user' => $user->id,
            'bet' => $r->bet,
            'mode' => $r->mode,
              'profit' => 0,
              'hash' => $hash,
              'level' => 0,
              'path' => serialize($b),
              'nick' => $user->username,
                'type' => '0',
                'number' => $hash2,
                'seed_u' => $client,
                'seed_c' => $server
          ]);
        }else if($r->mode == 'hard'){
          $a = [];
          for ($i=1; $i <= 10; $i++) {
            $r1 = mt_rand(0,1);
            $r2 = mt_rand(0,1);
            $r3 = mt_rand(0,1);
            while($r1 == 0 && $r2 == 0 && $r3 == 0 ||
             $r1 == 1 && $r2 == 1 && $r3 == 1 ||
              $r1 == 0 && $r2 == 1 && $r3 == 1 ||
             $r1 == 1 && $r2 == 1 && $r3 == 0 ||
              $r1 == 1 && $r2 == 0 && $r3 == 1){
                $r1 = mt_rand(0,1);
                $r2 = mt_rand(0,1);
                $r3 = mt_rand(0,1);
            }
            if($r1 == 0 && $r2 == 0 && $r3 == 0 ||
             $r1 == 1 && $r2 == 1 && $r3 == 1 ||
              $r1 == 0 && $r2 == 1 && $r3 == 1 ||
             $r1 == 1 && $r2 == 1 && $r3 == 0 ||
              $r1 == 1 && $r2 == 0 && $r3 == 1){

              }else{
                              $a[] = ['level' => $i, 'steps' => $r1.$r2.$r3] ;
              }
          }
          $b = json_encode($a);
          // $user->money = $user->money - 1;
          // $user->save();
          $hash = md5($user->id.$r->bet.$r->mode.$b);
          $hash2 = md5(md5($user->id.$r->bet.$r->mode.$b));
          $k = mt_rand(0,2);
          $k2 = mt_rand(0,2);
          $k3 = mt_rand(0,2);
          $k4 = mt_rand(0,2);
          $k5 = mt_rand(0,2);
          $k6 = mt_rand(0,2);
          $k7 = mt_rand(0,2);
          $k8 = mt_rand(0,2);
          $k9 = mt_rand(0,2);
          $k10 = mt_rand(0,2);

          $x = mt_rand(0,2);
          $x2 = mt_rand(0,2);
          $x3 = mt_rand(0,2);
          $x4 = mt_rand(0,2);
          $x5 = mt_rand(0,2);
          $x6 = mt_rand(0,2);
          $x7 = mt_rand(0,2);
          $x8 = mt_rand(0,2);
          $x9 = mt_rand(0,2);
          $x10 = mt_rand(0,2);

          $client = $k.$k2.$k3.$k4.$k5.$k6.$k7.$k8.$k9.$k10;
          $server = $x.$x2.$x3.$x4.$x5.$x6.$x7.$x8.$x9.$x10;

          Game::create([
            'user' => $user->id,
            'bet' => $r->bet,
            'mode' => $r->mode,
              'profit' => 0,
              'hash' => $hash,
              'level' => 0,
              'path' => serialize($b),
              'nick' => $user->username,
              'type' => '0',
              'number' => $hash2,
              'seed_u' => $client,
              'seed_c' => $server
          ]);
        }
               return response()->json(['status' => 'true', 'banka' => 1, 'hash' => $hash, 'number' => $hash2 , 'seed_u' => $client, 'seed_c' => $server]);
      }else{
        if($r->mode == 'easy'){
          $a = [];
          for ($i=1; $i <= 10; $i++) {
            $r1 = mt_rand(0,1);
            $r2 = mt_rand(0,1);
            $r3 = mt_rand(0,1);
            while($r1 == 0 && $r2 == 0 && $r3 == 0 ||
             $r1 == 1 && $r2 == 1 && $r3 == 1 ||
              $r1 == 0 && $r2 == 0 && $r3 == 1 ||
             $r1 == 1 && $r2 == 0 && $r3 == 0 ||
              $r1 == 0 && $r2 == 1 && $r3 == 0){
                $r1 = mt_rand(0,1);
                $r2 = mt_rand(0,1);
                $r3 = mt_rand(0,1);
            }
            if($r1 == 0 && $r2 == 0 && $r3 == 0 ||
             $r1 == 1 && $r2 == 1 && $r3 == 1 ||
              $r1 == 0 && $r2 == 0 && $r3 == 1 ||
             $r1 == 1 && $r2 == 0 && $r3 == 0 ||
              $r1 == 0 && $r2 == 1 && $r3 == 0){

              }else{
                              $a[] = ['level' => $i, 'steps' => $r1.$r2.$r3] ;
              }
          }
          $b = json_encode($a);
          // $user->money = $user->money - 1;
          // $user->save();
          $hash = md5($user->id.$r->bet.$r->mode.$b);
          $hash2 = md5(md5($user->id.$r->bet.$r->mode.$b));
          $k = mt_rand(0,2);
          $k2 = mt_rand(0,2);
          $k3 = mt_rand(0,2);
          $k4 = mt_rand(0,2);
          $k5 = mt_rand(0,2);
          $k6 = mt_rand(0,2);
          $k7 = mt_rand(0,2);
          $k8 = mt_rand(0,2);
          $k9 = mt_rand(0,2);
          $k10 = mt_rand(0,2);

          $x = mt_rand(0,2);
          $x2 = mt_rand(0,2);
          $x3 = mt_rand(0,2);
          $x4 = mt_rand(0,2);
          $x5 = mt_rand(0,2);
          $x6 = mt_rand(0,2);
          $x7 = mt_rand(0,2);
          $x8 = mt_rand(0,2);
          $x9 = mt_rand(0,2);
          $x10 = mt_rand(0,2);

          $client = $k.$k2.$k3.$k4.$k5.$k6.$k7.$k8.$k9.$k10;
          $server = $x.$x2.$x3.$x4.$x5.$x6.$x7.$x8.$x9.$x10;

          Game::create([
              'user' => $user->id,
              'bet' => $r->bet,
              'mode' => $r->mode,
              'profit' => 0,
              'hash' => $hash,
              'level' => 0,
              'path' => serialize($b),
              'nick' => $user->username,
              'type' => '111',
              'number' => $hash2,
              'seed_u' => $client,
              'seed_c' => $server
          ]);
        }else if($r->mode == 'medium'){
          $a = [];
          for ($i=1; $i <= 10; $i++) {
            $r1 = mt_rand(0,1);
            $r2 = mt_rand(0,1);
            while($r1 == 0 && $r2 == 0 || $r1 == 1 && $r2 == 1){
              $r1 = mt_rand(0,1);
              $r2 = mt_rand(0,1);
            }
            if($r1 == 0 && $r2 == 0 || $r1 == 1 && $r2 == 1){

            }else{
                              $a[] = ['level' => $i, 'steps' => $r1.$r2] ;
            }
          }
          $b = json_encode($a);
          $hash = md5($user->id.$r->bet.$r->mode.$b);
          // $user->money = $user->money - 1;
          // $user->save();
          $hash2 = md5(md5($user->id.$r->bet.$r->mode.$b));
          $k = mt_rand(0,2);
          $k2 = mt_rand(0,2);
          $k3 = mt_rand(0,2);
          $k4 = mt_rand(0,2);
          $k5 = mt_rand(0,2);
          $k6 = mt_rand(0,2);
          $k7 = mt_rand(0,2);
          $k8 = mt_rand(0,2);
          $k9 = mt_rand(0,2);
          $k10 = mt_rand(0,2);

          $x = mt_rand(0,2);
          $x2 = mt_rand(0,2);
          $x3 = mt_rand(0,2);
          $x4 = mt_rand(0,2);
          $x5 = mt_rand(0,2);
          $x6 = mt_rand(0,2);
          $x7 = mt_rand(0,2);
          $x8 = mt_rand(0,2);
          $x9 = mt_rand(0,2);
          $x10 = mt_rand(0,2);

          $client = $k.$k2.$k3.$k4.$k5.$k6.$k7.$k8.$k9.$k10;
          $server = $x.$x2.$x3.$x4.$x5.$x6.$x7.$x8.$x9.$x10;

          Game::create([
            'user' => $user->id,
            'bet' => $r->bet,
            'mode' => $r->mode,
              'profit' => 0,
              'hash' => $hash,
              'level' => 0,
              'path' => serialize($b),
              'nick' => $user->username,
              'type' => '111',
              'number' => $hash2,
              'seed_u' => $client,
              'seed_c' => $server
          ]);
        }else if($r->mode == 'hard'){
          $a = [];
          for ($i=1; $i <= 10; $i++) {
            $r1 = mt_rand(0,1);
            $r2 = mt_rand(0,1);
            $r3 = mt_rand(0,1);
            while($r1 == 0 && $r2 == 0 && $r3 == 0 ||
             $r1 == 1 && $r2 == 1 && $r3 == 1 ||
              $r1 == 0 && $r2 == 1 && $r3 == 1 ||
             $r1 == 1 && $r2 == 1 && $r3 == 0 ||
              $r1 == 1 && $r2 == 0 && $r3 == 1){
                $r1 = mt_rand(0,1);
                $r2 = mt_rand(0,1);
                $r3 = mt_rand(0,1);
            }
            if($r1 == 0 && $r2 == 0 && $r3 == 0 ||
             $r1 == 1 && $r2 == 1 && $r3 == 1 ||
              $r1 == 0 && $r2 == 1 && $r3 == 1 ||
             $r1 == 1 && $r2 == 1 && $r3 == 0 ||
              $r1 == 1 && $r2 == 0 && $r3 == 1){

              }else{
                              $a[] = ['level' => $i, 'steps' => $r1.$r2.$r3] ;
              }
          }
          $b = json_encode($a);
          // $user->money = $user->money - 1;
          // $user->save();
          $hash = md5($user->id.$r->bet.$r->mode.$b);
          $hash2 = md5(md5($user->id.$r->bet.$r->mode.$b));
          $k = mt_rand(0,2);
          $k2 = mt_rand(0,2);
          $k3 = mt_rand(0,2);
          $k4 = mt_rand(0,2);
          $k5 = mt_rand(0,2);
          $k6 = mt_rand(0,2);
          $k7 = mt_rand(0,2);
          $k8 = mt_rand(0,2);
          $k9 = mt_rand(0,2);
          $k10 = mt_rand(0,2);

          $x = mt_rand(0,2);
          $x2 = mt_rand(0,2);
          $x3 = mt_rand(0,2);
          $x4 = mt_rand(0,2);
          $x5 = mt_rand(0,2);
          $x6 = mt_rand(0,2);
          $x7 = mt_rand(0,2);
          $x8 = mt_rand(0,2);
          $x9 = mt_rand(0,2);
          $x10 = mt_rand(0,2);

          $client = $k.$k2.$k3.$k4.$k5.$k6.$k7.$k8.$k9.$k10;
          $server = $x.$x2.$x3.$x4.$x5.$x6.$x7.$x8.$x9.$x10;

          Game::create([
            'user' => $user->id,
            'bet' => $r->bet,
            'mode' => $r->mode,
              'profit' => 0,
              'hash' => $hash,
              'level' => 0,
              'path' => serialize($b),
              'nick' => $user->username,
              'type' => '111',
              'number' => $hash2,
              'seed_u' => $client,
              'seed_c' => $server
          ]);
        }
            return response()->json(['status' => 'true', 'banka' => 0, 'hash' => $hash, 'number' => $hash2 , 'seed_u' => $client, 'seed_c' => $server]);
      }
  }
  public function getBig(){
    $history = Game::where('status',2)->orderBy('id', 'DESC')->where('profit', '>', 100)->take(10)->get();
    return $history;
  }


}
