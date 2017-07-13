<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <!--[if lt IE 9]><script src="/assets/js/html5.js"></script><![endif]-->
    <title>epicdrop</title>
    <meta name="description" content="Modern and comfortable content management system." />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/fonts.min.css" />
    <link rel="stylesheet" href="/assets/css/core.min.css?v=122" />
    <script src="https://unpkg.com/vue/dist/vue.min.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css?v=222222222222222222222222222122222" />
    <script type="text/javascript" src="/assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/assets/js/core.min.js"></script>
    <script type="text/javascript" src="/assets/js/socket.io.js"></script>
    	<script src="/assets/js/jquery.arcticmodal-0.3.min.js">
      </script><link rel="stylesheet" href="/assets/js/jquery.arcticmodal-0.3.css">
    <script src="https://use.fontawesome.com/2a0e9a11cb.js"></script>
    <script>
    @if(Auth::guest())
      var time = 0;
      var login = 3;
    @else
    var login = {{Auth::user()->id}};
    var time = {{Auth::user()->timer}};
    @endif

    </script>
        <script type="text/javascript" src="/assets/js/functions.min.js?v=122223112231213"></script>
</head>

<body>
  <div class="owerlay"></div>

    <div class="wrapper" style="    margin-bottom: 200px;">
        <header>
            <div class="logo">
                <a href="/"><img src="/assets/images/logo.png" width="150">
                </a>
                <div class="sound"><i class="flaticon-sound-on on"></i>
                </div>
            </div>
            <div class="mob_menu_button"></div>
              @if(!Auth::check())
              <div class="mob_menu">
              	<div class="logo">
              		<div class="logo-img"><span><strong>Epic</strong>Drop</span></div>
              		<div class="clearfix"></div>
              	</div>
              	<div class="auth2">
              					<a class="come-in" href="/login">Войти</a>
              			</div>
              </div>
              @else
              <div class="mob_menu">
              	<div class="logo">
              		<div class="logo-img"><span><strong>Epic</strong>drop</span></div>
              		<div class="clearfix"></div>
              	</div>
              	<div class="auth2">
              					<span class="user"><small>Добро пожаловать, </small><br><a href="#" class="nickname" id="asas">{{Auth::user()->nick}}</a></span>
              			<form style="display:none;" class="nickname_form">
              				<input type="text" class="nickname" value="{{Auth::user()->nick}}">
              				<a href="#" class="save"><i class="fa fa-check" aria-hidden="true"></i></a>
              				<a href="#" class="close"><i class="fa fa-times" aria-hidden="true"></i></a>
              			</form>
              			<a class="logout" href="/logout">ВЫЙТИ</a>
              			</div>
            </div>
              <div class="balance-unite">
              <div class="balance">
                  <div class="v">
                    {{Auth::user()->money}} <i class="flaticon-ruble"></i>
                  </div>
              </div>
              <div class="deposit">
                  <button>Deposit</button>
              </div>
              <div class="withdrawal">
                  <button>Withdraw</button>
              </div>
              <div class="cls"></div>
            </div>
              @endif
            @if(Auth::guest())
            <div class="signin">
                <div class="social">
                    <div class="fb"><a  style ="text-decoration: none; color: white; "href="/login">Login through
                        <div class="vk-icon"></div></a>
                    </div>
                </div>
                <div class="cls"></div>
            </div>
            @else
            <div class="signin">
              <div class="welcome">
                <div class="name-show">Welcome,<br> <a href="#">{{Auth::user()->nick}}</a></div
                  ><div class="name-edit">
                    <input type="text" value="{{Auth::user()->nick}}">
                    <div class="x-icon eas">
                    </div>
                    <div class="save-username flaticon-check eas"></div>
                  </div>
                  <div class="error"></div>
                </div>
                <div class="settings">
                  <i class="flaticon-settings"></i>
                </div><div class="cls">
                </div>
            </div>
            @endif
        </header>
        <!-- .wrapper -->
        <div class="middle">
            <div class="history">
                <div class="stats">
                    <div class="played"><i class="odometr ptotalcount_i" id="st-games">0</i>
                        <div>Games Played</div>
                    </div>
                    <div class="sep"></div>
                    <div class="wag" ><i class="odometr ptotalamount_i" id="st-total">0</i>
                        <div>Wagered (<i class="flaticon-ruble"></i>)</div>
                    </div>
                    <div class="cls"></div>
                </div>
                <div class="tabs">
                    <ul>
                        <li class="active" data-id="h-recent">Recent</li>
                        <li data-id="h-plays">My Plays</li>
                        <li data-id="h-wins">Big Wins</li>
                    </ul>
                    <div class="cls"></div>
                    <div class="table-h" data-id="h-recent-top">
                        <div class="f1">Players</div>
                        <div class="f2">Bet</div>
                        <div class="f3">Profit</div>
                        <div class="f4">Step</div>
                        <div class="cls"></div>
                    </div>
                    <div class="table-h hide" data-id="h-plays-top">
                        <div class="f1">Date</div>
                        <div class="f2">Bet</div>
                        <div class="f3">Profit</div>
                        <div class="f4">Step</div>
                        <div class="cls"></div>
                    </div>
                    <div class="table-h hide" data-id="h-wins-top">
                        <div class="f1">Players</div>
                        <div class="f2">Bet</div>
                        <div class="f3">Winning</div>
                        <div class="f4">Step</div>
                        <div class="cls"></div>
                    </div>
                </div>
                <template id="big-template">
                  <div>
                    <div class="list"  v-for="histor in big">
                        <div class="player">@{{histor.nick}}</div>
                        <div class="bet">@{{ histor.bet }} <i class="flaticon-ruble"></i>
                        </div>
                        <div class="profit win">@{{ histor.profit }} <i class="flaticon-ruble"></i>
                        </div>
                        <div class="step">@{{ histor.level }}</div>
                        <div class="difficult"><img v-bind:src="'/assets/images/'+ histor.mode +'-mode.svg'" />
                        </div>
                    </div>
                    <div class="cls"></div>
                  </div>
                </template>
                <template id="history-template">
                  <div>
                    <div class="list"  v-for="histor in history">
                        <div class="player">@{{histor.nick}}</div>
                        <div class="bet">@{{histor.bet}} <i class="flaticon-ruble"></i>
                        </div>
                        <div class="profit" v-if="histor.profit > 0" style="font-weight: bold;color: #eff464;">
                          @{{histor.profit}}
                          <i class="flaticon-ruble"></i>
                        </div>
                        <div class="profit" v-if="histor.profit <= 0">
                          @{{histor.profit}}
                          <i class="flaticon-ruble"></i>
                        </div>
                        <div class="step">@{{histor.level}}</div>
                        <div class="difficult">
                          <img v-bind:src="'/assets/images/' + histor.mode + '-mode.svg'" />
                        </div>
                    </div>
                  </div>
                </template>

                <div class="table-list">
                    <div class="recent-l" id="afk" data-id="h-recent-t" style="    width: 75%;
    float: left;">
                      <history></history>
                    </div>
                    <div class="recent-l hide" id="afk2" data-id="h-plays-t" style="    float: left;
    width: 75%;">
                      @if(!Auth::guest())
                      @foreach($h as $hista)
                      <div class="list" >
                          <div class="player">{{$hista->created_at}}</div>
                          <div class="bet">{{$hista->bet}} <i class="flaticon-ruble"></i>
                          </div>
                          <div class="profit">
                            @if($hista->profit <= 0)
                            {{$hista->profit}}
                            <i class="flaticon-ruble"></i>
                            @else
                            <span style="font-weight: bold; color: #eff464;">{{$hista->profit}}
                            <i class="flaticon-ruble"></i></span>
                            @endif
                          </div>
                          <div class="step">{{$hista->level}}</div>
                          <div class="difficult">
                            <img src="/assets/images/{{$hista->mode}}-mode.svg" />
                          </div>
                      </div>
                      @endforeach
                      @else

                      @endif
                    </div>
                    <div class="recent-l hide" id="big" data-id="h-wins-t" style="    float: left;
    width: 75%;">
                      @foreach($big as $biga)
                      <div class="list">
                          <div class="player">{{$biga->nick}}</div>
                          <div class="bet">{{$biga->bet}} <i class="flaticon-ruble"></i>
                          </div>
                          <div class="profit win">{{$biga->profit}} <i class="flaticon-ruble"></i>
                          </div>
                          <div class="step">{{$biga->level}}</div>
                          <div class="difficult"><img src="/assets/images/{{$biga->mode}}-mode.svg" />
                          </div>
                      </div>

                      @endforeach
                    </div>
                </div>
            </div>
            <!-- .history -->
            <div class="game">
              <div class="a" style="background: transparent;">
                <div class="obj1"></div>
                <div class="obj3"></div>
                <div class="obj4"></div>
                <div class="obj6" style="transform: rotate(21deg);"></div>
                <div class="obj7"style="transform: rotate(-21deg);"></div>
              </div>
                <div class="users_online">Online: <span id="st-online">-</span>
                </div>
                <div class="loading game-pane-load" style="display: block;"></div>
                <div class="tooltip_demo eas">Demo</div>
                <div class="demo-play">
                    <div class="tooltip close eas">
                        <div class="x-icon eas"></div>
                    </div>
                    <div style="height:135px;"></div>
                    <div class="play-demo btn eas">Demo play</div>
                    <div class="deposit-demo btn eas">Deposit</div>
                    <div class="or">OR</div>
                    <div class="free-demo btn eas">Get free money</div>
                </div>
                <div class="arrow-step-left"><i class="flaticon-arr-right"></i>
                </div>
                <div class="arrow-step-right"><i class="flaticon-arr-left"></i>
                </div>
                <ul class="list"></ul>
                <div class="cls"></div>
                <div class="g-bottom">
                    <div class="control en">
                        <div>Min</div> <span class="minus-icon">-</span>
                        <input type="text" class="betInp" value="₽15" maxlength="11"> <span class="plus-icon">+</span>
                        <div>Max</div>
                    </div>
                    <div class="play-btn play-start">
                        <div class="loading"></div>Play</div>
                    <div class="control-active">₽0.00</div>
                    <div class="play-btn game-end">End</div>
                    <div class="cls"></div>
                </div>
                <div class="game-type bottom">
                    <ul>
                        <li data-url="easy" class="iteasy"><img src="/assets/images/easy-mode.svg" />
                            <div>Easy</div>
                        </li>
                        <li data-url="medium" class="itmedium"><img src="/assets/images/medium-mode.svg" />
                            <div>Medium</div>
                        </li>
                        <li data-url="hard" class="ithard"><img src="/assets/images/hard-mode.svg" />
                            <div>Hard</div>
                        </li>
                    </ul>
                    <div class="cls"></div>
                    <div class="verify">
                      <span class="s">Show Verification <i class="flaticon-arr-down"></i></span>
                      <span class="h">Hide Verification <i class="flaticon-arr-top"></i></span>
                    </div>
                </div>
            </div>
            <!-- .game -->
            <div class="wagered">
                <div class="table-h-block">
                    <div class="table-header">
                        <div class="title">
                            <i class="flaticon-winner"></i> Hall of Heroes
                        </div>
                        <div class="cls"></div>
                    </div>
                    <div class="tabs">
                        <ul>
                            <li class="active" data-id="w-wagered">Wagered</li>
                            <li data-id="w-played">Games Played</li>
                        </ul>
                        <div class="cls"></div>
                    </div>
                    <div class="table-h" data-id="w-wagered-top">
                        <div class="f1">Rank</div>
                        <div class="f2">Player</div>
                        <div class="f3">Wagered</div>
                        <div class="cls"></div>
                    </div>
                    <div class="table-h hide" data-id="w-played-top">
                        <div class="f1">Rank</div>
                        <div class="f2">Player</div>
                        <div class="f3">Games Played</div>
                        <div class="cls"></div>
                    </div>
                </div>
                <div class="table-list">
                    <div class="recent-l" data-id="w-wagered-t" style="    width: 75%;
    float: right;">
                        <div class="tldate today" id="afk4">
                          @if(!Auth::guest())
                            @foreach($top2 as $top)
                            <div class="list">
                              <div class="number">
                                  <div>{{$top->iddd}}</div>
                              </div>
                                <div class="player">{{$top->nick}} </div>
                                <div class="win">{{$top->profit}} <i class="flaticon-ruble"></i>
                                </div>
                            </div>
                            @endforeach
                          @else

                          @endif
                        </div>
                    </div>
                    <div class="recent-l hide" data-id="w-played-t">
                        <div class="tldate today" id="afk3" style="    width: 75%;
    float: right;">
                          @foreach($topf as $top1)
                          <div class="list">
                            <div class="number">
                              <div>{{$top1->iddd}}</div>
                            </div>
                              <div class="player">{{$top1->nick}} </div>
                              <div class="win">{{$top1->open_box}}
                              </div>
                          </div>
                          @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="cls"></div>
            <!-- .wagered -->
            <div class="verify-b">
                <div class="current">
                    <div class="title">Current Ticket</div>
                    <div class="hash">Hash
                        <div class="textarea">
                            <textarea readonly>Game not started!</textarea>
                        </div>
                    </div>
                    <div class="number">Number
                        <div class="textarea">
                            <textarea></textarea>
                        </div>
                    </div>
                    <div class="cls"></div>
                    <div class="server-seed">Server Seed
                        <div class="textarea">
                            <textarea readonly></textarea>
                        </div>
                    </div>
                    <div class="client-seed">Client Seed
                        <div class="textarea">
                            <textarea readonly>Soon</textarea>
                        </div>
                    </div>
                    <div class="result">Result
                        <div class="textarea">
                            <textarea readonly>Verified</textarea>
                        </div>
                    </div>
                    <div class="submit">
                        <button class="verify-result">Verify</button>
                    </div>
                    <div class="cls"></div>
                </div>
                <div class="next">
                    <div class="title">Next Ticket</div>
                    <div class="hash">Hash
                        <div class="textarea">
                            <textarea readonly>Soon</textarea>
                        </div>
                    </div>
                    <div class="cls"></div>
                    <div class="client-seed">Client Seed
                        <div class="textarea">
                            <textarea readonly>Soon</textarea>
                        </div>
                    </div>
                    <div class="cls"></div>
                </div>
                <div class="cls"></div>
            </div>
            <!-- .verify -->
        </div>
        <!-- .middle -->
    </div>
    <div class="footer">
        <div class="inner">
            <div class="block1">
                <div class="logo"><img src="/assets/images/logo.png" width="150">
                </div>
                <div class="text">It's a cosmos out there...
                    <br>Are you brave enough to bet your luck and Cash
                    <br>against the abominable epicdrop? This is your chance to win.</div>
            </div>
            <div class="block2">
                <div class="title">Menu</div>
                <ul class="staticUIa">
                    <li><a class="about" href="javascript:aboutUI();">About</a>
                    </li>
                    <li><a class="affilate" href="javascript:affilateUI();">Affilate</a>
                    </li>
                    <li><a href="/support">Support</a>
                    </li>
                </ul>
            </div>
            <div class="block3 lang-ui">
                <div class="title">Languages</div>
                <div class="lang-active"><span>English</span> <i class="flaticon-arr-down"></i>
                </div>
                <div class="langs">
                    <ul>
                        <li data-url="en">English</li>
                        <li data-url="ru">Русский</li>
                    </ul>
                </div>
            </div>
            <div class="block4">
                <div class="free-money">
                    <div class="icon"><i class="flaticon-money"></i>
                    </div>
                    <div class="title">Get Free Money
                        <div class="desc">You can get free 1.00 ₽ every day</div>
                    </div>
                    <div class="cls"></div>
                </div>
                <div class="invite-friend en">
                    <div class="icon"><i class="flaticon-users"></i>
                    </div>
                    <div class="title">INVITE FRIEND & <i>EARN MORE</i>
                        <div class="desc">You can get 5% of each deposit for your friendsy</div>
                    </div>
                    <div class="cls"></div>
                </div>
            </div>
            <div class="cls"></div>
            <div class="copyright">
                <div style="position:absolute;">
                    <a href="//www.free-kassa.ru/" target="_blank"><img src="//www.free-kassa.ru/img/fk_btn/6.png" width="95">
                    </a>
                </div>
                <div class="terms"><a href="javascript:terms_show();">terms</a>
                </div>
                <div class="powered" style="margin-left:105px;">© 2017 epicdrop.ru

                </div>
                <div class="agree-18"><i>18+</i> Gambling may be addictive please play responsibly.</div>
            </div>
            <div class="cls"></div>
        </div>
    </div>
    <!-- .footer -->
    <!-- popupUI -->
    @if(Auth::guest())
    <div class="depositUI loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            For deposit amount, you need to <a href='/login'>log in</a>!
        </div>
    </div>
    @else
    <div class="depositUI sb sb-animation-flyInUp" style="display: none;">
    <a href="#close" class="sb-close-btn"><div class="close-icon eas"></div></a>
    <div class="title">Deposit</div>
    <div class="desc">Enter deposit amount, choose payment gate and click Deposit Now button.<br>The minimum deposit amount is <span>50.00 <i class="flaticon-ruble"></i></span>.</div>
    <div class="amount">
    <div class="fname">Amount (<i class="flaticon-ruble"></i>)</div>
    <div class="fvalue"><input type="text" class="numberInp depositInp_n" value="50.00" maxlength="7"></div>
    <div class="fdesc">Max amount: 10000.00 <i class="flaticon-ruble"></i><br>Min amount: 50.00 <i class="flaticon-ruble"></i></div>
    <div class="cls"></div>
    </div>
    <div class="payments">
    <div class="fname">Choose payment system</div>
    <ul>
    <li data-url="freekassa:qiwi" class=""><img src="/assets/images/payment-qiwi.svg">
      <div class="ico"><i class="flaticon-check"></i>
      </div></li>
      <li data-url="freekassa:yandex" class=""><img src="/assets/images/payment-yandex.svg"> <div class="ico"><i class="flaticon-check"></i></div></li>
      <li data-url="freekassa:megafon" class=""><img src="/assets/images/payment-megafon.svg"> <div class="ico"><i class="flaticon-check"></i></div></li>
      <li data-url="freekassa:mts" class=""><img src="/assets/images/payment-mts.svg"> <div class="ico"><i class="flaticon-check"></i></div></li>
      <li data-url="freekassa:tele2" class=""><img src="/assets/images/payment-tele2.svg"> <div class="ico"><i class="flaticon-check"></i></div></li>
      <li data-url="freekassa:master" class=""><img src="/assets/images/payment-master.svg"> <div class="ico"><i class="flaticon-check"></i></div></li>
      <li data-url="freekassa:visa" class=""><img src="/assets/images/payment-visa.svg"> <div class="ico"><i class="flaticon-check"></i></div></li>
      <li data-url="freekassa:freekassa" class="active selected"><img src="/assets/images/payment-freekassa.svg"> <div class="ico"><i class="flaticon-check"></i></div>
      </li>
    <div class="cls"></div>
    </ul>
    </div>
    <div class="pix"></div>
    <div class="submit"><div class="loading"></div><button class="DepositBtn">Deposit now</button></div>
    </div>
    @endif
    @if(Auth::guest())
    <div class="withdrawalUI loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            For withdrawal amount, you need to <a href="/login">log in</a>!
        </div>
    </div>
    @else
    <div class="withdrawalUI sb sb-animation-flyInUp" style="display: none;">
    <a href="#close" class="sb-close-btn"><div class="close-icon eas"></div></a>
    <div class="title">Withdrawal</div>
    <div class="desc">In case of larger withdrawals, your withdrawal may be marked for manual processing. This is very rare, and manual withdrawals are processed on business days from 10:00 to 18:00 GMT.</div>
    <div class="amount">
    <div class="fname">Amount (<i class="flaticon-ruble"></i>)</div>
    <div class="fvalue"><input type="text" class="numberInp withdrawalInp_n" value="100.00" maxlength="7"></div>
    <div class="cls"></div>
    </div>
    <div class="wallet">
    <div class="fname">Wallet</div>
    <div class="fvalue"><input type="text" class="withdrawalInp_w" placeholder="Wallet number" maxlength="20"></div>
    <div class="cls"></div>
    </div>
    <div class="cls"></div>
    <div class="payments">
    <div class="fname">Choose payment system</div>
    <ul>
    <li data-url="qiwi" class=""><img src="/assets/images/payment-qiwi.svg"> <div class="ico"><i class="flaticon-check"></i></div></li><li data-url="yandex" class="active selected"><img src="/assets/images/payment-yandex.svg"> <div class="ico"><i class="flaticon-check"></i></div></li><li data-url="webmoney" class=""><img src="/assets/images/payment-webmoney.svg"> <div class="ico"><i class="flaticon-check"></i></div></li>
    <div class="cls"></div>
    </ul>
    </div>
    <div class="pix"></div>
    <div class="submit"><div class="loading"></div><button class="WithdrawalBtn">Withdrawal Now</button></div>
    </div>
    @endif
      @if(Auth::guest())
    <div class="freemoneyUI loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            For free amount, you need to <a href="/login">log in</a>!
        </div>
    </div>
    @else
    <div class="freemoneyUI">
    <a href="#close" class="sb-close-btn"><div class="close-icon eas"></div></a>
    <div class="title">Get Free Money</div>
    <div class="desc">You can get free 1.00 ₽ every day</div>
    <div class="get-m">
      @if(!Auth::guest())
        @if(Auth::user()->timer > 0)
        <div class="fname">Get Your bonus in </div>
        <div class="fvalue" id="timer"></div>
        @else
        <div class="fname">Get Your</div>
        <div class="fvalue" id="timer">1.00 RUB</div>
        @endif
      @endif
    </div>
    <div class="pix"></div>
    @if(!Auth::guest())
      @if(Auth::user()->timer > 0)

      @else
      <div class="submit"><div class="loading"></div><button class="Freebtn">Claim now</button></div>
      @endif
    @endif
      </div>
    @endif
      @if(Auth::guest())
    <div class="loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            You need to <a href="/login">log in</a>!
        </div>
    </div>
    @else

    @endif
    @if(Auth::guest())
    <div class="settingsUI loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            You need to <a href="/login">log in</a>!
        </div>
    </div>
    @else
    <div class="settingsUI sb sb-animation-flyInUp" style="display: none;">
    <a href="#close" class="sb-close-btn"><div class="close-icon eas"></div></a>
    <div class="title">Settings</div>
    <div class="text">
    <ul class="tabs">
    <li class="active" data-url="profile">General</li>
    </ul>
    <div class="cls"></div>
    <div class="tab t-profile active">
    <div class="title">Welcome, {{Auth::user()->nick}}</div>
    <div class="list hash">
    <div class="name">Affiliate URL</div>
    <div class="value"><input type="text" readonly="" value="https://epicdrop.ru/?r={{Auth::user()->ref_code}}"></div>
    </div>
    <div class="list ">
    <div class="name">Alias</div>
    <div class="value"><input type="text" readonly="" value="{{Auth::user()->nick}}"></div>
    </div>
    <div class="list ">
    <div class="name">Refferal</div>
    <div class="value"><input type="text" readonly="" value="{{Auth::user()->ref_use}}"></div>
    </div>
    <div class="logout"><button onclick="location.href = '/logout';">Sign Out</button></div>
    <div class="stats">
    <div class="name">Stats</div>
    <div class="played">Games Played: <span style="color:#5671d8">{{Auth::user()->open_box}}</span></div>
    <div class="winns">Winnings (<i class="flaticon-ruble"></i>): <span style="color:#5671d8">{{Auth::user()->profit2}}</span></div>
    </div>
    </div>
    <div class="tab t-transactions"><div class="loading" style="display: block;"></div></div>
    </div>
    </div>
    @endif

    <div class="aboutUI">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">About</div>
        <div class="text">epicdrop многоступенчетая мини игра в которой вы можете испытать свою удачу и подняться по лестницам славы. С помощью детально проработанной системы epicdrop, мы разработали доказуемо честную игру, которая натянет ваши нервы в струну, но которая даст вам шанс неслыханно разбогатеть.
            <br />
            <br /> И будьте спокойны &ndash; генератор случайных чисел использует хэш напрямую из сторонних сервисов! Выигрыш предопределен, когда вы только нажимаете старт, и ваша удача - это единственное, что имеет значение. Это означает, что epicdrop на 100% доказуемо честная игра. Проверьте сами!
            <br />
            <br /> Честная система epicdrop использует формулу Hash = SHA256(SHA256(Number + '-' + Server Seed)). Под самой игрой находится форма для сверки хешев. Проверь и убедить, что все честно и зависит только от твоей удачи!
            <br />
            <br /> Играй в epicdrop, стань богатым и говори девчонкам, что ты один из первопроходцев этой игры. Они будут впечатлены. Или проиграй все и уж постарайся объяснить это своей жене! Предпочтительно выбрать что-то среднее. Получай удовольствие!
            <br />
            <br /> Не забудь попробовать DEMO версию, она БЕСПЛАТНАЯ.
            <br />
            <h3>Контакты</h3> Остались вопросы? Свяжитесь с нами
            <br /> Email: <a href="mailto:epicdropinfo@mail.ru">epicdropinfo@mail.ru</a>
        </div>
    </div>
    <div class="termsUI">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">terms</div>
        <div class="text">
            <h3>1. ОБЩИЕ ПОЛОЖЕНИЯ И ТЕРМИНЫ</h3> 1.1. Данный документ является договором на использование epicdrop.ru. Ниже приведены правила и условия использования Сервиса. Пожалуйста, внимательно ознакомьтесь с ними.
            <br /> 1.2. Сервисом могут пользоваться пользователи достигшие 18-ти летия.
            <br /> 1.3. Игра "epicdrop.ru" - беспроигрышная онлайн игра принадлежащяя организатору и находящиейся по адресу в сети интерет http://epicdrop.ru. Организатором предоставляются услуги пользователю по организацию его развлечения, досуга и отдыха.
            <br /> 1.4 Организаторы беспроигрышной онлайн игры epicdrop.ru никого насильно не заставляют проводить свой досуг на этом проекте.
            <br />
            <h3>2. УЧЕТНАЯ ЗАПИСЬ, ПАРОЛЬ, БЕЗОПАСНОСТЬ</h3> Для открытия Учетной Записи пользователь должен авторизоваться через Вконтакте.
            <br /> Пользователь несет полную ответственность за хранение конфиденциальной информации, за потерю доступа к своей Учетной Записи.
            <br /> Кроме того, пользователь несет полную ответственность за любые совершенные им действия.
            <br /> Сервис не несет ответственности за поступки, совершенные Пользователем в отношении третьих лиц.
            <br /> Пользователь обязуется сообщить Сервису о любом несанкционированном использовании его Учетной записи.
            <br />
            <h3>3. КОНФИДЕНЦИАЛЬНОСТЬ</h3> Сервис обязуется не редактировать и не раскрывать любую конфиденциальную информацию, предоставленную Пользователем Сервису.
            <br /> Сервис также обязуется хранить личный пароль пользователя в зашифрованном виде.
            <br /> Личные данные могут быть предоставлены третьим лицам лишь в связи с нарушением законодательства, а также оскорблением или клеветой в отношении брендов или торговых марок третьих лиц.
            <br />
            <h3>4. ПОЛЬЗОВАТЕЛЬ</h3> Сервис оставляет за собой право в любой момент блокировать Пользователя в связи с нарушением правил использования Сервиса или законодательства.
            <br /> Неприемлемы попытки несанкционированного доступа, попытки нанесения вреда Сервису.
            <br /> При добавлении на сайт любой информации, запрещены оскорбления, вымогательства, клевета, блеф, сообщения, содержащие вредоносную информацию (в т.ч. вирусы, трояны, черви и т.п.), а также информация, способная нанести вред третьим лицам.
            <br />
            <h3>5. ЗАПРЕЩЕНО</h3> 5.1 Запрещается публиковать фальсифицированные данные
            <br /> 5.2 Запрещается передача любых материалов, которые могут нарушить интеллектуальную собственность третьих лиц
            <br /> 5.3 Запрещаются фальшивые публикации информации с целью получения несанкционированных доступов к информации или данным третьих лиц
            <br /> 5.4 Запрещается публикация информации религиозного и политического характера
            <br /> 5.5 Запрещается регистрировать более одной Учетной Записи
            <br /> 5.6 Запрещается передавать данные для доступа к Учетной записи третьим лицам
            <br /> 5.7 Запрещается оскорблять, обзывать, ставить под сомнение профессиональную квалификацию и добросовестность физических и юридических лиц, в том числе Пользователей Сервиса и Администрации Сервиса.
            <br /> 5.8 Запрещается выбирать себе аватары, содержащие сцены насилия, угрозы, сквернословия, разврат (порнография), дискриминация в любых проявлениях, коммерческая реклама и рекламные тексты
            <br />
            <h3>6. ОТВЕТСТВЕННОСТЬ СТОРОН</h3> 6.1 Пополняя баланс на сайте любыми платежными системами, вы берете на себя полную ответственность за ваши действия. Сервис никак не принуждает и не настаивает делать какие либо действия.
            <br /> 6.2 Открывая кейс или тратя средства с вашего баланса любым другим способом, вы принимаете полную ответственность за ваши действия.
            <br /> 6.3 Сервис не призывает и не мотивирует увеличить ваши средства.
            <br /> 6.3 Сервис не дает 100% гарантии, что открытие кейсов даст возможность увеличить ваши средства на балансе.
            <br /> 6.4 Сервис ни в коем случае не обязывает и не заставляет совершать тех или иных действий. Все действия, совершенные вами в Сервисе, осуществляются исключительно под вашу ответственность.
            <br /> 6.5 Данное пользовательское соглашение размещено на сайте опкеш точка вип. Если же это не так, значит мы украли тупо текст и даже не удосужились прочитать его. Вот такие мы идиоты.
            <br />
            <h3>7. ПРИНЯТИЕ УСЛОВИЙ СОГЛАШЕНИЯ (АКЦЕНТ ОФЕРТЫ)</h3> 7.1 Используя и/или посещая любые разделы Сервисом, Вы соглашаетесь принять и соблюдать условия настоящего Соглашения и Вы соответственно a) соглашаетесь использовать средства электронной коммуникации для заключения договоров; b) Вы также отказываетесь от любых применимых в данном случае прав или требований, для которых необходима собственноручная подпись, в той степени, в которой это допускается любым применимым законодательным.
            <br /> 7.2 Если Вы не согласны принять и далее следовать условия настоящего Соглашения, пожалуйста, не регистрируйте аккаунт и/или прекратите использовать Ваш аккаунт. Дальнейшее использование Сервиса будет рассматриваться как Ваше согласие с условиями настоящего Соглашение, которые, как мы Вас уведомили, могут периодически применяться положением.
            <h3>8. ПРАВА</h3> 8.1. Исключительное право на Сервис принадлежит Сервису
            <br /> 8.2. Все права на материалы, представленные на нашем сайте, принадлежат Правообладателям</div>
    </div>


    <div class="verifyUI">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Verify Ticket</div>
        <div class="desc big">Hash = sha256(sha256(number-server_seed-return_seed))</div>
        <div class="text">
            <div class="list hash">
                <div class="name">Hash</div>
                <div class="value">
                    <input type="text" readonly>
                </div>
            </div>
            <div class="list number">
                <div class="name">Number</div>
                <div class="value">
                    <input type="text" readonly>
                </div>
            </div>
            <div class="list server">
                <div class="name">Server Seed</div>
                <div class="value">
                    <input type="text" readonly>
                </div>
            </div>
            <div class="list return">
                <div class="name">Return Seed</div>
                <div class="value">
                    <input type="text" readonly>
                </div>
            </div>
        </div>
        <div class="desc">Return Seed the winning column (right position)</div>
    </div>
    <div class="messageUI">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning</div>
        <div class="text"></div>
        <div class="submit">
            <button onclick="$('.sb-close-btn').trigger('click');">Close</button>
        </div>
    </div>
    <!-- .popupUI --><a class="vk-button" href="https://vk.com/" rel="nofollow" target="_blank"><span class="flaticon-soc-vk"></span> Мы Вконтакте</a>

    <script>
        var conf_vars = {
            'deposit-min': 50.00,
            'free-money': 1.00,
            'deposit-max': 10000.00,
            'real-balance': 0.,
            'logged-id': '1192104',
            'user-token': 'qsom3o5ga8oo69vcu0tr99t4l2',
            'game-open': 0,
            'min-bet': 5.00
        };
        var lang_conf = {
            'free-denied': 'Faucet available only if your balance less than <span>1.00 ₽.</span>',
            'deposit-min-err': 'You specified less than the minimum Deposit',
            'deposit-max-err': 'You specified more than the minimum Deposit',
            'deposit-method-err': 'Your chosen payment method is not working',
            'enough-money': 'Enough money on balance!',
            'wallet-empty': 'Please input wallet number',
            'withdrawal-success': 'Withdrawal successfully completed, wait money income',
            'free_denied2': 'Today You are already use free faucet!',
            'free_ok': 'Money credited to your balance!',
            'game_not_found': 'Bets not found',
            'with-min': 'Withdraw minimum is 50 rub!',
            'game-take':'Take #amount# <i class="flaticon-ruble"></i>',
            'game-end': 'End'
        };
        var game_passed = '-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1';
        var game_bet_amount = 0.00;
        var game_bet_take = 0.00;
        var click_sound = ss_soundbits('/assets/audio/click.ogg', "/assets/audio/click.mp3");
        var lost_sound = ss_soundbits('/assets/audio/lost.ogg', "/assets/audio/lost.mp3");
        var win_sound = ss_soundbits('/assets/audio/win.ogg', "/assets/audio/win.mp3");
        $(document).ready(function() {
            $('.game-pane-load').hide();
        });
    </script>
    <script src="//ulogin.ru/js/ulogin.js"></script>
@if(!Auth::guest())
    <div style="display: none;">
      <div class="modal modal1" id="paymentModal">
  		<div style="    background: #685086;
    height: 480px;">
  			<div class="header-modal"><h2>Депозит</h2><a href="#" class="close arcticmodal-close"><i class="fa fa-times" aria-hidden="true"></i></a></div>
  			<div class="body-modal">
  				<div class="sidebar-pay">
  					<ul>
  						<li class="active" data-value="yandex">Яндекс. Деньги</li>
  						<li data-value="qiwi">QIWI Wallet</li>
  						<li data-value="webmoney">WebMoney</li>
  						<li data-value="bee">Билайн</li>
  						<li data-value="mega">Мегафон</li>
  						<li data-value="mts">МТС</li>
  						<li data-value="tele2">ТЕЛЕ2</li>
  						<li data-value="visa">Visa, MasterCard</li>
  						<li data-value="skin" style="display:none">SkinPay</li>
  						<li data-value="free">FreeKassa</li>
  					</ul>
  				</div>
  				<div class="box-pay">
  					<form method="post" action="/pay">
  						<div class="top">
  							<h3>Яндекс. Деньги</h3>
  							<input type="number" name="sum" value="50"></input>
  							<input type="hidden" name="payment_system" value="45"/>
  							<div class="price">
  								<a href="#" data-value="50">50</a>  <a href="#" data-value="100">100</a>   <a href="#" data-value="500">500</a>   <a href="#" data-value="1000">1000</a>   <a href="#" data-value="2000">2000</a>   <a href="#" data-value="3000">3000</a>
  							</div>
  						</div>
  						<div class="center">
  							<div class="inform">
  								<h4>Информация</h4>
  								<p>Минимальная сумма к пополнению: <strong>50</strong></p>
  								<p>Максимальная сумма к пополнению: <strong>10000</strong></p>
  							</div>
  						</div>
  						<div class="bottom">
  							<button type="submit">Оплатить</button>
  						</div>
  					</form>
  				</div>
  			</div>
  			<div class="clearfix"></div>
  		</div>
  	</div>
  </div>
@else

@endif
@if(!Auth::guest())
  <div style="display: none;">
	<div class="modal modal3" id="withdrawModal">
		<div style="height: 460px;">
			<div class="header-modal"><h2>Вывод средств</h2><a href="#" class="close arcticmodal-close"><i class="fa fa-times" aria-hidden="true"></i></a></div>
			<div class="body-modal">
				<div class="sidebar-pay">
					<ul>
						<li class="active" data-value="yandex">Яндекс. Деньги</li>
						<li data-value="qiwi">QIWI Wallet</li>
						<li data-value="webmoney">WebMoney</li>
					</ul>
				</div>
				<div class="box-pay">
					<div class="top">
						<h3>Яндекс. Деньги</h3>
						<input type="number" name="sum" value="100"></input>
						<input type="hidden" name="payment_system" value="45"/>
					</div>
					<div class="center">
						<div class="refill">
							<input type="text" placeholder="Введите свой кошелек" name="wallet"/>
							<p>Минимальная сумма к выводу: <strong>100 р.</strong></p>
							<p class="white"><strong>Внимание:</strong> вывод осуществляется в течении <strong>48 часов.</strong></p>
						</div>
					</div>
					<div class="bottom">
						<button class="withdraw">Подать заявку</button>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>
@else

@endif


@if(!Auth::guest())
<div style="display: none;">
<div class="modal modal5" id="prof">
  <div style="
    height: 560px;
">
    <div class="header-modal"><h2>Профиль</h2></div>
    <div class="body-modal" style="background: #685086;">
      <div class="nav" style="    margin-top: 10px;">
        <ul>
          <li class="active"><a href="#">ИНФОРМАЦИЯ</a></li>
          <li><a href="#">БОНУСЫ</a></li>
          <li><a href="#">Операции</a></li>
          <li><a href="#">РЕФЕРАЛЫ</a></li>
          <li><a href="#">СКОРО</a></li>
        </ul>
      </div>
      <div class="profile tab tab1 active">
        <h4>Добро пожаловать, <a href="#">{{Auth::user()->nick}}</a></h4>
        <div class="left">
          <label>Никнейм:</label>
          <input type="text" placeholder="{{Auth::user()->nick}}" readonly/>
          <div class="stat">
            <strong>ИГР СЫГРАНО</strong>
            <span>{{Auth::user()->open_box}}</span>
          </div>
        </div>
        <div class="center">
          @if(Auth::user()->profit < 1000 && Auth::user()->profit >= 0)
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Новичок</strong></span>
          @endif
          @if(Auth::user()->profit < 2500 && Auth::user()->profit >= 1000)
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Неизвестный</strong></span>
          @endif
          @if(Auth::user()->profit < 5000 && Auth::user()->profit >= 2500)
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Узнаваемый</strong></span>
          @endif
          @if(Auth::user()->profit < 10000 && Auth::user()->profit >= 5000)
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Знаменитый</strong></span>
          @endif
          @if(Auth::user()->profit < 15000 && Auth::user()->profit >= 10000)
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Выдающийся</strong></span>
          @endif
          @if(Auth::user()->profit < 20000 && Auth::user()->profit >= 15000)
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Прославленный</strong></span>
          @endif
          @if(Auth::user()->profit < 30000 && Auth::user()->profit >= 20000)
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Величайший</strong></span>
          @endif
          @if(Auth::user()->profit < 50000 && Auth::user()->profit >= 30000)
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Легендарный</strong></span>
          @endif
        </div>
        <div class="right">
          <label>Эл. адрес:</label>
          <input type="text" placeholder="" readonly/>
          <div class="stat">
            <strong>ПОСТАВЛЕНО руб</strong>
            <span>{{Auth::user()->profit}}</span>
          </div>
        </div>
        <div class="clearfix"></div>
        <div class="footer-modal">
          <a href="/logout" style="
        margin-top: 20px;
        width: 35%;
        height: 50px;
        line-height: 50px;
        text-align: center;
    ">Выйти</a>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="bonuses tab tab2">
        <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
            <th></th>
            <th></th>
            <th style="text-align:center;">БОНУСЫ СКОРО ПОЯВЯТСЯ</th>
            <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
         </table>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="operations tab tab3">
        <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
            <th>№</th>
            <th>Транзикация</th>
            <th>Сумма</th>
            <th>Дата</th>
            <th>Статус</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pay as $paym)
              <tbody>
                 <tr>
                    <td>{{$paym->id}}</td>
                    <td>Freekassa</td>
                    <td class="yellow">+ {{$paym->amount}} р.</td>
                    <td>{{$paym->created_at}}</td>
                    <td class="check"><i class="fa fa-check-circle tooltip tooltipstered" aria-hidden="true"></i></td>
                 </tr>
              </tbody>
            @endforeach
            @foreach($viv as $vivod)
              <tbody>
                 <tr>
                    <td>{{$vivod->id}}</td>
                    <td>Vivod</td>
                    <td class="red">- {{$vivod->amount}} р.</td>
                    <td>{{$paym->created_at}}</td>
                    @if($vivod->status == 0)
                        <td class="check"><i class="fa fa-refresh tooltip tooltipstered" aria-hidden="true"></i></td>
                    @endif
                    @if($vivod->status == 2)
                      <td class="check"><i class="fa fa-check-circle tooltip tooltipstered" aria-hidden="true"></i></td>
                    @endif
                 </tr>
              </tbody>
            @endforeach
          </tbody>
         </table>
         </div>
        <div class="clearfix"></div>
      </div>
      <div class="operations tab tab4">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
            <th></th>
            <th></th>
            <th style="text-align:center;">СКОРО ПОЯВИТСЯ</th>
            <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
         </table>
         </div>
        <div class="clearfix"></div>
      </div>

      <div class="referrals tab tab5">
        <h4>ПРИГЛАСИТЕ ДРУЗЕЙ И ЗАРАБАТЫВАЙТЕ ДЕНЬГИ</h4>
        <div class="left">
          <h3>ПРОЦЕНТ ОТ ДЕПОЗИТА До: <span>5%</span></h3>
          <ul>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i> Количество игроков, которых Вы привлекли: <span>{{$ref}}</span></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i> Всего выплачено вам: <span>0 р.</span></li>
          </ul>
          <h3>ВЫПЛАТЫ ПО УРОВНЯМ</h3>
          <ul>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i> Уровень 1: <span>3%</span></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i> Уровень 2: <span>4%</span></li>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i> Уровень 3: <span>5%</span></li>
          </ul>
        </div>
        <div class="right">
          <label>Ваша реф. ссылка:</label>
          <input type="text" value="http://epicdrop.ru?r=ptOvU1F" readonly />
          <p>До <strong>5%</strong> от каждого депозита, сделанного игроками, которых Вы привлекли, добавляется к вашему балансу и вы сразу же сможете его вывести.</p>
          <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter" data-url="http://epicdrop.ru?r=ptOvU1F"></div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
</div>
@else
<div style="display: none;">
<div class="modal modal5" id="prof">
  <div style="
    height: 560px;
">
    <div class="header-modal"><h2>Профиль</h2></div>
    <div class="body-modal" style="background: #685086;">
      <div class="operations tab tab4 active">
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
            <th></th>
            <th></th>
            <th style="text-align:center;">СКОРО ПОЯВИТСЯ</th>
            <th></th>
            </tr>
          </thead>
          <tbody>
          </tbody>
         </table>
         </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
</div>
@endif

</body>

</html>
