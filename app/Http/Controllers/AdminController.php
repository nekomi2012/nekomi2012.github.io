<?php

namespace App\Http\Controllers;

use App\User;
use App\Cases;
use App\Ticket;
use App\Payments;
use Illuminate\Http\Request;
use App\Items;

class AdminController extends Controller
{
    public function index()
    {
        $drop = \DB::table('games')->orderBy('id', 'desc')->where('status', 2)->take(20)->get();
        foreach ($drop as $i) {
            $user = User::find($i->user);
            if($user != null){
              $i->username = $user->username;
              $i->user_id = $user->id;
              $i->price = $i->profit;
              $i->case_price = $i->bet;
            }
        }
        return view('admin.index', compact('drop'));
    }


    public function users()
    {
      $users = \DB::table('users')->orderBy('id', 'asc')->paginate(100);
        return view('admin.users', compact('users'));
    }
    public function search2(Request $request)
    {
        $users = User::select('users.id',
            'users.username',
            'users.avatar', 'users.money',
            'users.login',
             \DB::raw('COUNT(last_drops.user) as open_box'))->join('last_drops', 'last_drops.user', '=', 'users.id')->where('login', 'LIKE', '%' . $request->get('name') . '%')->orderby('id', 'desc')->paginate(20);
        return view('admin.users', compact('users'));

    }
    public function searchusersname(Request $request)
    {
        $users = User::select('users.id',
            'users.username',
            'users.avatar', 'users.money',
            'users.login',
             \DB::raw('COUNT(last_drops.user) as open_box'))->join('last_drops', 'last_drops.user', '=', 'users.id')->where('username', 'LIKE', '%' . $request->get('name') . '%')->orderby('id', 'desc')->paginate(20);
        return view('admin.users', compact('users'));
    }
    public function givemoney($id, Request $request)
    {
        $user = User::find($id);
        if ($request->get('money')) {
            $user->money += $request->get('money');
            $user->save();
            return redirect('/admin/users');
        }
        return view('admin.givemoney', compact('user'));
    }
    public function userid($id)
    {
        $user = User::find($id);
        return view('admin.user', compact('user'));
    }
    public function userdit(Request $request)
    {
        $user = User::find($request->get('id'));
        $user->money = $request->get('money');
        $user->username = $request->get('username');
        $user->is_admin = $request->get('is_admin');
        $user->is_yt = $request->get('is_yt');
        $user->save();
        return redirect('/admin/users');

    }



    public function lastvvod()
    {
      $a = \DB::table('payments')->orderBy('id', 'desc')->where('status', 1)->take(20)->get();
      foreach ($a as $b) {
        $u = User::find($b->user);
        $b->name = $u->username;
        $b->name_id = $u->id;
      }

      return view('admin.lastvvod', compact('a'));
    }

    public function vivod()
    {
      $a = \DB::table('vivod')->where('status', 0)->orderBy('id', 'desc')->get();
      foreach ($a as $b) {
        $u = User::find($b->user);
        $b->name = $u->username;
        $b->name_id = $u->id;
      }

      return view('admin.vivod', compact('a'));
    }

    public function close($id)
    {
      \DB::table('vivod')->where('id', $id)->update(['status' => 1]);
      return redirect('/admin/lastvivod');
    }
}
