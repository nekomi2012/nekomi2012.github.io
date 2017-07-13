<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <!--[if lt IE 9]><script src="/assets/js/html5.js"></script><![endif]-->
    <title>epicdrop</title>
    <meta name="description" content="Modern and comfortable content management system." />
    <meta name="keywords" content="" />
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/fonts.min.css" />
    <link rel="stylesheet" href="/assets/css/core.min.css?v=599cbe98d23c2d44718a1efb46e4bd94" />
    <script src="https://unpkg.com/vue/dist/vue.min.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css?v=599cbe98d23c2d44718a1efb46e4bd94" />
    <script type="text/javascript" src="/assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/assets/js/core.min.js"></script>
    <script type="text/javascript" src="/assets/js/socket.io.js?v=777777"></script>
    <script type="text/javascript" src="/assets/js/functions.min.js?v=599cbe98d23c2d44718a1efb46e4bd94"></script>
    	<script src="/assets/js/jquery.arcticmodal-0.3.min.js"></script>
      <link rel="stylesheet" href="/assets/js/jquery.arcticmodal-0.3.css">
    <script>
    <?php if(Auth::guest()): ?>

    <?php else: ?>
    var login = <?php echo e(Auth::user()->id); ?>;
    <?php endif; ?>

    </script>
</head>

<body>
    <div class="wrapper">
        <header>
            <div class="logo">
                <a href="./"><img src="/assets/images/logo.png" width="150">
                </a>
                <div class="sound"><i class="flaticon-sound-on on"></i>
                </div>
            </div>
            <div class="balance-unite">
              <?php if(!Auth::check()): ?>
              <div class="balance">
                  <div class="v">
                    Login <i class="flaticon-ruble"></i>
                  </div>
              </div>
              <?php else: ?>
              <div class="balance">
                  <div class="v">
                    <?php echo e(Auth::user()->money); ?> <i class="flaticon-ruble"></i>
                  </div>
              </div>
              <?php endif; ?>
                <div class="deposit">
                    <button>Deposit</button>
                </div>
                <div class="withdrawal">
                    <button>Withdrawal</button>
                </div>
                <div class="cls"></div>
            </div>
            <?php if(Auth::guest()): ?>
            <div class="signin">
                <div class="social">
                    <div class="fb"><a href="/login">Login through
                        <div class="vk-icon"></div></a>
                    </div>
                </div>
                <div class="cls"></div>
            </div>
            <?php else: ?>
            <div class="signin">
              <div class="welcome">
                <div class="name-show">Welcome,<br> <a href="#"><?php echo e(Auth::user()->username); ?></a></div
                  ><div class="name-edit">
                    <input type="text" value="<?php echo e(Auth::user()->username); ?>">
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
            <?php endif; ?>
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
                        <div class="player">{{histor.username}}</div>
                        <div class="bet">{{ histor.bet }} <i class="flaticon-ruble"></i>
                        </div>
                        <div class="profit win">{{ histor.profit }} <i class="flaticon-ruble"></i>
                        </div>
                        <div class="step">{{ histor.level }}</div>
                        <div class="difficult"><img v-bind:src="'/assets/images/'+ histor.mode +'-mode.svg'" />
                        </div>
                    </div>
                    <div class="cls"></div>
                  </div>
                </template>
                <template id="history-template">
                  <div>
                    <div class="list"  v-for="histor in history">
                        <div class="player">{{histor.username}}</div>
                        <div class="bet">{{histor.bet}} <i class="flaticon-ruble"></i>
                        </div>
                        <div class="profit" v-if="histor.profit > 0" style="font-weight: bold;color: #eff464;">
                          {{histor.profit}}
                          <i class="flaticon-ruble"></i>
                        </div>
                        <div class="profit" v-if="histor.profit <= 0">
                          {{histor.profit}}
                          <i class="flaticon-ruble"></i>
                        </div>
                        <div class="step">{{histor.level}}</div>
                        <div class="difficult">
                          <img v-bind:src="'/assets/images/' + histor.mode + '-mode.svg'" />
                        </div>
                    </div>
                  </div>
                </template>
                <template id="top2-template">
                  <div>
                    <div class="list" v-for="histor in top2">
                      <div class="number">
                          <div></div>
                      </div>
                        <div class="player">{{histor.username}} </div>
                        <div class="win">{{histor.profit}} <i class="flaticon-ruble"></i>
                        </div>
                    </div>
                  </div>
                </template>
                <template id="top-template">
                  <div>
                    <div class="list" v-for="histor in top">
                      <div class="number">
                          <div></div>
                      </div>
                        <div class="player">{{histor.username}} </div>
                        <div class="win">{{histor.open_box}}
                        </div>
                    </div>
                  </div>
                </template>

                <template id="historyu-template">
                  <div>
                    <div class="list"  v-for="histor in historyu">
                        <div class="player">-</div>
                        <div class="bet">{{histor.bet}} <i class="flaticon-ruble"></i>
                        </div>
                        <div class="profit" v-if="histor.profit > 0" style="font-weight: bold;color: #eff464;">
                          {{histor.profit}}
                          <i class="flaticon-ruble"></i>
                        </div>
                        <div class="profit" v-if="histor.profit <= 0">
                          {{histor.profit}}
                          <i class="flaticon-ruble"></i>
                        </div>
                        <div class="step">{{histor.level}}</div>
                        <div class="difficult">
                          <img v-bind:src="'/assets/images/' + histor.mode + '-mode.svg'" />
                        </div>
                    </div>
                  </div>
                </template>
                <div class="table-list">
                    <div class="recent-l" id="afk" data-id="h-recent-t">
                      <history></history>
                    </div>
                    <div class="recent-l hide" id="afk2" data-id="h-plays-t">
                      <?php if(!Auth::guest()): ?>
                      <?php foreach($h as $hista): ?>
                      <div class="list" >
                          <div class="player"><?php echo e($hista->created_at); ?></div>
                          <div class="bet"><?php echo e($hista->bet); ?> <i class="flaticon-ruble"></i>
                          </div>
                          <div class="profit">
                            <?php if($hista->profit <= 0): ?>
                            <?php echo e($hista->profit); ?>

                            <i class="flaticon-ruble"></i>
                            <?php else: ?>
                            <span style="font-weight: bold; color: #eff464;"><?php echo e($hista->profit); ?>

                            <i class="flaticon-ruble"></i></span>
                            <?php endif; ?>
                          </div>
                          <div class="step"><?php echo e($hista->level); ?></div>
                          <div class="difficult">
                            <img src="/assets/images/<?php echo e($hista->mode); ?>-mode.svg" />
                          </div>
                      </div>
                      <?php endforeach; ?>
                      <?php else: ?>

                      <?php endif; ?>
                    </div>
                    <div class="recent-l hide" id="big" data-id="h-wins-t">
                      <?php foreach($big as $biga): ?>
                      <div class="list">
                          <div class="player"><?php echo e($biga->username); ?></div>
                          <div class="bet"><?php echo e($biga->bet); ?> <i class="flaticon-ruble"></i>
                          </div>
                          <div class="profit win"><?php echo e($biga->profit); ?> <i class="flaticon-ruble"></i>
                          </div>
                          <div class="step"><?php echo e($biga->level); ?></div>
                          <div class="difficult"><img src="/assets/images/<?php echo e($biga->mode); ?>-mode.svg" />
                          </div>
                      </div>

                      <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- .history -->
            <div class="game">
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
                    <div class="verify"><span class="s">Show Verification <i class="flaticon-arr-down"></i></span><span class="h">Hide Verification <i class="flaticon-arr-top"></i></span>
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
                        <div class="date">
                            <div class="active"><span>All time</span> <i class="flaticon-arr-down"></i>
                            </div>
                            <div class="date-list">
                                <ul>
                                    <li data-url="today">All time</li>
                                </ul>
                            </div>
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
                    <div class="recent-l" data-id="w-wagered-t">
                        <div class="tldate today" id="afk4">
                          <?php if(!Auth::guest()): ?>
                            <?php foreach($top2 as $top): ?>
                            <div class="list">
                              <div class="number">
                                  <div></div>
                              </div>
                                <div class="player"><?php echo e($top->username); ?> </div>
                                <div class="win"><?php echo e($top->profit); ?> <i class="flaticon-ruble"></i>
                                </div>
                            </div>
                            <?php endforeach; ?>
                          <?php else: ?>

                          <?php endif; ?>
                        </div>
                    </div>
                    <div class="recent-l hide" data-id="w-played-t">
                        <div class="tldate today" id="afk3">
                          <?php foreach($topf as $top1): ?>
                          <div class="list">
                            <div class="number">
                                <div></div>
                            </div>
                              <div class="player"><?php echo e($top1->username); ?> </div>
                              <div class="win"><?php echo e($top1->open_box); ?>

                              </div>
                          </div>
                          <?php endforeach; ?>
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
                            <textarea readonly></textarea>
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
                    <li><a href="/en/support">Support</a>
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
    <?php if(Auth::guest()): ?>
    <div class="depositUI loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            For deposit amount, you need to <a href='/login'>log in</a>!
        </div>
    </div>
    <?php else: ?>
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
    <?php endif; ?>
    <?php if(Auth::guest()): ?>
    <div class="withdrawalUI loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            For withdrawal amount, you need to <a href="/login">log in</a>!
        </div>
    </div>
    <?php else: ?>
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
    <?php endif; ?>
      <?php if(Auth::guest()): ?>
    <div class="freemoneyUI loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            For free amount, you need to <a href="/login">log in</a>!
        </div>
    </div>
    <?php else: ?>
    <div class="freemoneyUI">
    <a href="#close" class="sb-close-btn"><div class="close-icon eas"></div></a>
    <div class="title">Get Free Money</div>
    <div class="desc">You can get free 1.00 ₽ every day</div>
    <div class="get-m">
    <div class="fname">Get Your</div>
    <div class="fvalue">1.00 RUB</div>
    </div>
    <div class="pix"></div>
    <div class="submit"><div class="loading"></div><button class="Freebtn">Claim now</button></div>
    </div>
    <?php endif; ?>
      <?php if(Auth::guest()): ?>
    <div class="loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            You need to <a href="/login">log in</a>!
        </div>
    </div>
    <?php else: ?>

    <?php endif; ?>
    <?php if(Auth::guest()): ?>
    <div class="settingsUI loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            You need to <a href="/login">log in</a>!
        </div>
    </div>
    <?php else: ?>
    <div class="settingsUI sb sb-animation-flyInUp" style="display: none;">
    <a href="#close" class="sb-close-btn"><div class="close-icon eas"></div></a>
    <div class="title">Settings</div>
    <div class="text">
    <ul class="tabs">
    <li class="active" data-url="profile">General</li>
    </ul>
    <div class="cls"></div>
    <div class="tab t-profile active">
    <div class="title">Welcome, <?php echo e(Auth::user()->username); ?></div>
    <div class="list hash">
    <div class="name">Affiliate URL</div>
    <div class="value"><input type="text" readonly="" value="https://epicdrop.ru/?r=<?php echo e(Auth::user()->ref_code); ?>"></div>
    </div>
    <div class="list ">
    <div class="name">Alias</div>
    <div class="value"><input type="text" readonly="" value="<?php echo e(Auth::user()->username); ?>"></div>
    </div>
    <div class="list ">
    <div class="name">Refferal</div>
    <div class="value"><input type="text" readonly="" value="<?php echo e(Auth::user()->ref_use); ?>"></div>
    </div>
    <div class="logout"><button onclick="location.href = '/logout';">Sign Out</button></div>
    <div class="stats">
    <div class="name">Stats</div>
    <div class="played">Games Played: <span style="color:#5671d8"><?php echo e(Auth::user()->open_box); ?></span></div>
    <div class="winns">Winnings (<i class="flaticon-ruble"></i>): <span style="color:#5671d8"><?php echo e(Auth::user()->profit2); ?></span></div>
    </div>
    </div>
    <div class="tab t-transactions"><div class="loading" style="display: block;"></div></div>
    </div>
    </div>
    <?php endif; ?>

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
</body>

</html>
