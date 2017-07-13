<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <!--[if lt IE 9]><script src="/assets/js/html5.js"></script><![endif]-->
    <title>FOXBET.SU</title>
    <meta name="description" content="Modern and comfortable content management system." />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/fonts.min.css" />
    <link rel="stylesheet" href="/assets/css/core.min.css?v=12222212122322" />
    <script src="https://unpkg.com/vue/dist/vue.min.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css?v=1222222222222222222222222222222222222222222222222222222331222222222" />
    <script type="text/javascript" src="/assets/js/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/assets/js/core.min.js"></script>
    <script type="text/javascript" src="/assets/js/socket.io.js"></script>
    	<script src="/assets/js/jquery.arcticmodal-0.3.min.js">
      </script><link rel="stylesheet" href="/assets/js/jquery.arcticmodal-0.3.css">
    <script src="https://use.fontawesome.com/2a0e9a11cb.js"></script>
    <script language="javascript" type="text/javascript">

window.onload = function() {
  <?php if(Auth::guest()): ?>
    var time = 0;
    var login = Math.random(1213123231123, 4213321321132312);
  <?php else: ?>
  var login = <?php echo e(Auth::user()->id); ?>;
  var time = <?php echo e(Auth::user()->timer); ?>;
  <?php endif; ?>
}

</script>
    <script>
    <?php if(Auth::guest()): ?>
      var time = 0;
      var login = 1;
    <?php else: ?>
    var login = <?php echo e(Auth::user()->id); ?>;
    var time = <?php echo e(Auth::user()->timer); ?>;
    <?php endif; ?>

    </script>
        <script type="text/javascript" src="/assets/js/functions.min.js?v=122223221122222222222222122231213"></script>
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
              <?php if(!Auth::check()): ?>
              <div class="mob_menu">
              	<div class="logo">
              		<div class="logo-img"><span><strong>Fox</strong>Bet</span></div>
              		<div class="clearfix"></div>
              	</div>
              	<div class="auth2">
              					<a class="come-in" style="text-decoration: none; color: white; " href="/login">Войти</a>
              			</div>
              </div>
              <div class="balance-unite">
              <div class="deposit">
                  <button>ДЕПОЗИТ</button>
              </div>
              <div class="withdrawal">
                  <button>ВЫВОД</button>
              </div>
              <div class="cls"></div>
            </div>
              <?php else: ?>
              <div class="mob_menu">
              	<div class="logo">
              		<div class="logo-img"><span><strong>Fox</strong>bet</span></div>
              		<div class="clearfix"></div>
              	</div>
              	<div class="auth2">
              					<span class="user"><small>Добро пожаловать, </small><br><a href="#" class="nickname" id="asas"><?php echo e(Auth::user()->nick); ?></a></span>
              			<form style="display:none;" class="nickname_form">
              				<input type="text" class="nickname" value="<?php echo e(Auth::user()->nick); ?>">
              				<a href="#" class="save"><i class="fa fa-check" aria-hidden="true"></i></a>
              				<a href="#" class="close"><i class="fa fa-times" aria-hidden="true"></i></a>
              			</form>
              			<a class="logout" href="/logout">ВЫЙТИ</a>
              			</div>
            </div>
              <div class="balance-unite">
              <div class="balance">
                  <div class="v">
                    <?php echo e(Auth::user()->money); ?> <i class="flaticon-ruble"></i>
                  </div>
              </div>
              <div class="deposit">
                  <button>ДЕПОЗИТ</button>
              </div>
              <div class="withdrawal">
                  <button>ВЫВОД</button>
              </div>
              <div class="cls"></div>
            </div>
              <?php endif; ?>
            <?php if(Auth::guest()): ?>
            <div class="auth" style="float:right">
									<a class="come-in" href="/login">Войти</a>
						</div>
            <?php else: ?>
            <div class="signin">
              <div class="welcome">
                <div class="name-show">Добро пожаловать,<br> <a href="#"><?php echo e(Auth::user()->nick); ?></a></div
                  ><div class="name-edit">
                    <input type="text" value="<?php echo e(Auth::user()->nick); ?>">
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
                        <div>ИГР СЫГРАНО</div>
                    </div>
                    <div class="sep"></div>
                    <div class="wag" ><i class="odometr ptotalamount_i" id="st-total">0</i>
                        <div>ПОСТАВЛЕНО РУБ. (<i class="flaticon-ruble"></i>)</div>
                    </div>
                    <div class="cls"></div>
                </div>
                <div class="tabs">
                    <ul>
                        <li class="active" data-id="h-recent">ВСЕ ИГРЫ</li>
                        <li data-id="h-plays">МОИ ИГРЫ</li>
                        <li data-id="h-wins">ВЫИГРЫШИ</li>
                    </ul>
                    <div class="cls"></div>
                    <div class="table-h" data-id="h-recent-top">
                        <div class="f1">ИГРОК</div>
                        <div class="f2">СТАВКА</div>
                        <div class="f3">ПРОФИТ</div>
                        <div class="f4">ШАГ</div>
                        <div class="cls"></div>
                    </div>
                    <div class="table-h hide" data-id="h-plays-top">
                        <div class="f1">ДАТА</div>
                        <div class="f2">СТАВКА</div>
                        <div class="f3">ПРОФИТ</div>
                        <div class="f4">ШАГ</div>
                        <div class="cls"></div>
                    </div>
                    <div class="table-h hide" data-id="h-wins-top">
                        <div class="f1">ИГРОК</div>
                        <div class="f2">СТАВКА</div>
                        <div class="f3">ПРОФИТ</div>
                        <div class="f4">ШАГ</div>
                        <div class="cls"></div>
                    </div>
                </div>
                <template id="big-template">
                  <div>
                    <div class="list"  v-for="histor in big">
                        <div class="player">{{histor.nick}}</div>
                        <div class="bet">{{ histor.bet }} <i class="flaticon-ruble"></i>
                        </div>
                        <div class="profit win">{{ histor.profit }} <i class="flaticon-ruble"></i>
                        </div>
                        <div class="step">{{ histor.level }}</div>
                        <div class="difficult"><img v-bind:src="'/assets/images/'+ histor.mode +'-mode.png'" />
                        </div>
                    </div>
                    <div class="cls"></div>
                  </div>
                </template>
                <template id="history-template">
                  <div>
                    <div class="list"  v-for="histor in history">
                        <div class="player">{{histor.nick}}</div>
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
                          <img v-bind:src="'/assets/images/' + histor.mode + '-mode.png'" />
                        </div>
                    </div>
                  </div>
                </template>

                <div class="table-list">
                    <div class="recent-l" id="afk" data-id="h-recent-t" style="width: 75%;
    background: red;
    background: rgba(51, 0, 51,0.5);
    float: left;
    padding: 10px;">
                      <history></history>
                    </div>
                    <div class="recent-l hide" id="afk2" data-id="h-plays-t" style="width: 75%;
    background: red;
    background: rgba(51, 0, 51,0.5);
    float: left;
    padding: 10px;">
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
                            <img src="/assets/images/<?php echo e($hista->mode); ?>-mode.png" />
                          </div>
                      </div>
                      <?php endforeach; ?>
                      <?php else: ?>

                      <?php endif; ?>
                    </div>
                    <div class="recent-l hide" id="big" data-id="h-wins-t" style="width: 75%;
    background: red;
    background: rgba(51, 0, 51,0.5);
    float: left;
    display: none;">
                      <?php foreach($big as $biga): ?>
                      <div class="list">
                          <div class="player"><?php echo e($biga->nick); ?></div>
                          <div class="bet"><?php echo e($biga->bet); ?> <i class="flaticon-ruble"></i>
                          </div>
                          <div class="profit win"><?php echo e($biga->profit); ?> <i class="flaticon-ruble"></i>
                          </div>
                          <div class="step"><?php echo e($biga->level); ?></div>
                          <div class="difficult"><img src="/assets/images/<?php echo e($biga->mode); ?>-mode.png" />
                          </div>
                      </div>

                      <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <!-- .history -->
            <div class="game">
              <div class="a" style="background: transparent;">
                <div class="obj1"></div>
                <div class="obj3"></div>
                <div class="obj4"></div>
                <div class="obj6"></div>
                <div class="obj7"></div>
              </div>
                <div class="users_online">Online: <span id="st-online">-</span>
                </div>
                <div class="loading game-pane-load" style="display: block;"></div>
                <div class="tooltip_demo eas">Демо</div>
                <div class="demo-play">
                    <div class="tooltip close eas">
                        <div class="x-icon eas"></div>
                    </div>
                    <div style="height:135px;"></div>
                    <div class="play-demo btn eas">Играть демо</div>
                    <div class="deposit-demo btn eas">Депозит</div>
                    <div class="or">или</div>
                    <div class="free-demo btn eas">Бесплатные рубли</div>
                </div>
                <div class="arrow-step-left"><i class="flaticon-arr-right"></i>
                </div>
                <div class="arrow-step-right"><i class="flaticon-arr-left"></i>
                </div>
                <ul class="list"></ul>
                <div class="cls"></div>
                <div class="g-bottom">
                  <div class="play-btn play-start">
                      <div class="loading"></div>Играть</div>
                    <div class="control en">
                        <div>Мин</div> <span class="minus-icon">-</span>
                        <input type="text" class="betInp" value="₽15" maxlength="11"> <span class="plus-icon">+</span>
                        <div>Max</div>
                    </div>
                    <div class="control-active">0.00₽</div>
                    <div class="play-btn game-end">Закончить</div>
                    <div class="cls"></div>
                </div>
                <div class="game-type bottom">
                    <ul>
                        <li data-url="easy" class="iteasy"><img src="/assets/images/easy-mode.png" />
                            <div>ЛЕГКАЯ</div>
                        </li>
                        <li data-url="medium" class="itmedium"><img src="/assets/images/medium-mode.png" />
                            <div>СРЕДНЯЯ</div>
                        </li>
                        <li data-url="hard" class="ithard"><img src="/assets/images/hard-mode.png" />
                            <div>СЛОЖНАЯ</div>
                        </li>
                    </ul>
                    <div class="cls"></div>
                    <div class="verify">
                      <span class="s"><i class="fa fa-ticket" aria-hidden="true"></i> Проверить билет</span>
                      <span class="h"><i class="fa fa-ticket" aria-hidden="true"></i> Проверить билет</span>
                    </div>
                </div>
            </div>
            <!-- .game -->
            <div class="wagered">
                <div class="table-h-block">
                    <div class="table-header">
                        <div class="title">
                            <i class="fa fa-star-half-o" aria-hidden="true"></i>  ЛУЧШИЕ ИЗ ЛУЧШИХ
                        </div>
                        <div class="cls"></div>
                    </div>
                    <div class="tabs">
                        <ul>
                            <li class="active" data-id="w-wagered">По сумме ставок </li>
                            <li data-id="w-played">По играм</li>
                        </ul>
                        <div class="cls"></div>
                    </div>
                    <div class="table-h" data-id="w-wagered-top">
                        <div class="f1">#</div>
                        <div class="f2">ИГРОК</div>
                        <div class="f3">СУММА СТАВОК</div>
                        <div class="cls"></div>
                    </div>
                    <div class="table-h hide" data-id="w-played-top">
                        <div class="f1">#</div>
                        <div class="f2">ИГРОК</div>
                        <div class="f3">Игры</div>
                        <div class="cls"></div>
                    </div>
                </div>
                <div class="table-list">
                    <div class="recent-l" data-id="w-wagered-t" style="    width: 75%;
    float: right;
    padding: 18px;
    background: rgba(51, 0, 51,0.5);">
                        <div class="tldate today" id="afk4">
                          <?php if(!Auth::guest()): ?>
                            <?php foreach($top2 as $top): ?>
                            <div class="list">
                              <div class="number">
                                  <div><?php echo e($top->iddd); ?></div>
                              </div>
                                <div class="player"><?php echo e($top->nick); ?> </div>
                                <div class="win"><?php echo e($top->profit); ?> <i class="flaticon-ruble"></i>
                                </div>
                            </div>
                            <?php endforeach; ?>
                          <?php else: ?>

                          <?php endif; ?>
                        </div>
                    </div>
                    <div class="recent-l hide" data-id="w-played-t">
                        <div class="tldate today" id="afk3" style="    width: 75%;
    float: right;
    padding: 18px;
    background: rgba(51, 0, 51,0.5);">
                          <?php foreach($topf as $top1): ?>
                          <div class="list">
                            <div class="number">
                              <div><?php echo e($top1->iddd); ?></div>
                            </div>
                              <div class="player"><?php echo e($top1->nick); ?> </div>
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
                            <textarea readonly>Скоро</textarea>
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
                            <textarea readonly>Скоро</textarea>
                        </div>
                    </div>
                    <div class="cls"></div>
                    <div class="client-seed">Client Seed
                        <div class="textarea">
                            <textarea readonly>Скоро</textarea>
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
    <footer class="footer" >
<div class="row1" style="    height: 100%;
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;">
			<div class="container">
				<div class="text">
					<div class="logo-img"><span><strong>Fox</strong>bet</span></div>
					<p>Здесь сплошные сети...<br> Достаточно ли вы смелы, чтобы поставить <br>свою удачу и рубли против злого РобоЧика?<br>Это ваш шанс, чтобы выиграть.</p>
				</div>
				<div class="nav">
					<div class="left">

					</div>
					<div class="right">

					</div>
					<div class="clearfix"></div>
				</div>
				<div class="buttons" style="float:right">
					<a href="https://vk.com/im?media=&sel=-139629944" target="_blank">Техническая поддержка</a>
					<a href="#" class="free-money" data-modal=".modal4"><i class="fa fa-rub" aria-hidden="true"></i> бесплатные рубли всем!</a>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="row3">
			<ul>
				<li><a class="about" id="asas2">О нас</a></li>
				<li><a class="affilate" id="asas1">Рефералы</a></li>
				<li><a href="#" class="affilate" id="asas3">Бонусы</a></li>
			</ul>
		</div>
		<div class="row2">
			<div class="container" style="    width: 100%;
    height: 40px;
    max-width: 1400px;
    margin: 0 auto;">
				<div class="create">© 2016 FOXBET</div>
				<div class="copy"></div>
				<div class="age"><strong>18+</strong> Пожалуйста, играйте ответственно!</div>
				<div class="clearfix"></div>
			</div>
		</div>
    </footer>
    <!-- .footer -->
    <!-- popupUI -->

      <?php if(Auth::guest()): ?>
    <div class="freemoneyUI loginUI-size">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">Warning!</div>
        <div class="text">
            Для бесплатного БОНУСA, вам нужно <a href="/login">LOGIN</a>!
        </div>
    </div>
    <?php else: ?>
    <div class="freemoneyUI">
    <a href="#close" class="sb-close-btn"><div class="close-icon eas"></div></a>
    <div class="title">ПОЛУЧИТЬ БОНУС</div>
    <div class="desc">Вы можете получить бесплатно 10,00 ₽ каждые 8 часов</div>
    <div class="get-m">
      <?php if(!Auth::guest()): ?>
        <?php if(Auth::user()->timer > 0): ?>
        <div class="fname">ПОЛУЧИТЬ БОНУС </div>
        <div class="fvalue" id="timer"></div>
        <?php else: ?>
        <div class="fname">ПОЛУЧИТЬ БОНУС</div>
        <div class="fvalue" id="timer">10.00 RUB</div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
    <div class="pix"></div>
    <?php if(!Auth::guest()): ?>
      <?php if(Auth::user()->timer > 0): ?>

      <?php else: ?>
      <div class="submit"><div class="loading"></div><button class="Freebtn">Получить бонус</button></div>
      <?php endif; ?>
    <?php endif; ?>
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


    <div class="aboutUI">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">About</div>
        <div class="text">Foxbet многоступенчетая мини игра в которой вы можете испытать свою удачу и подняться по лестницам славы. С помощью детально проработанной системы Foxbet, мы разработали доказуемо честную игру, которая натянет ваши нервы в струну, но которая даст вам шанс неслыханно разбогатеть.
            <br />
            <br /> И будьте спокойны &ndash; генератор случайных чисел использует хэш напрямую из сторонних сервисов! Выигрыш предопределен, когда вы только нажимаете старт, и ваша удача - это единственное, что имеет значение. Это означает, что Foxbet на 100% доказуемо честная игра. Проверьте сами!
            <br />
            <br /> Честная система Foxbet использует формулу Hash = SHA256(SHA256(Number + '-' + Server Seed)). Под самой игрой находится форма для сверки хешев. Проверь и убедить, что все честно и зависит только от твоей удачи!
            <br />
            <br /> Играй в Foxbet, стань богатым и говори девчонкам, что ты один из первопроходцев этой игры. Они будут впечатлены. Или проиграй все и уж постарайся объяснить это своей жене! Предпочтительно выбрать что-то среднее. Получай удовольствие!
            <br />
            <br /> Не забудь попробовать DEMO версию, она БЕСПЛАТНАЯ.
            <br />
            <h3>Контакты</h3> Остались вопросы? Свяжитесь с нами
            <br /> Email: <a href="mailto:foxbet@mail.ru">Foxbet@mail.ru</a>
        </div>
    </div>
    <div class="termsUI">
        <a href="#close" class="sb-close-btn">
            <div class="close-icon eas"></div>
        </a>
        <div class="title">terms</div>
        <div class="text">
            <h3>1. ОБЩИЕ ПОЛОЖЕНИЯ И ТЕРМИНЫ</h3> 1.1. Данный документ является договором на использование Foxbet.su. Ниже приведены правила и условия использования Сервиса. Пожалуйста, внимательно ознакомьтесь с ними.
            <br /> 1.2. Сервисом могут пользоваться пользователи достигшие 18-ти летия.
            <br /> 1.3. Игра "Foxbet.su" - беспроигрышная онлайн игра принадлежащяя организатору и находящиейся по адресу в сети интерет http://Foxbet.su. Организатором предоставляются услуги пользователю по организацию его развлечения, досуга и отдыха.
            <br /> 1.4 Организаторы беспроигрышной онлайн игры Foxbet.su никого насильно не заставляют проводить свой досуг на этом проекте.
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
                'free-denied':'Кран доступен, только если ваш баланс менее <span>1.00 ₽.</span>',
                'deposit-min-err':'Вы указали меньше чем минимальный депозит',
                'deposit-max-err':'Вы указали больше чем минимальный депозит',
                'deposit-method-err':'Выбранная Вами платежная система не действует',
                'enough-money':'Недостаточна средств на счету',
                'wallet-empty':'Необходимо вписать номер кошелька',
                'withdrawal-success':'Деньги успешно списаны со счета, дождитесь пополнение кошелька',
                'free_denied2':'Сегодня вы уже воспользовались один раз!',
                'free_ok':'Деньги начислены на Ваш баланс!',
                'game_not_found':'Ставок нет',
              'game-take':'Взять #amount# <i class="flaticon-ruble"></i>',
                'with-min': 'Withdraw minimum is 50 rub!',
                'game-end':'Завершить'
              };
              var game_passed = '-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1,-1:-1:-1';
              var game_bet_amount = 0.00;
              var game_bet_take = 0.00;
              var click_sound = ss_soundbits("/assets/audio/click.mp3");
              var lost_sound = ss_soundbits("/assets/audio/lost.mp3");
              var win_sound = ss_soundbits("/assets/audio/win.mp3");

              $(document).ready(function() {
                  $('.game-pane-load').hide();
              });
    </script>
    <script src="//ulogin.ru/js/ulogin.js"></script>
<?php if(!Auth::guest()): ?>
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
<?php else: ?>

<?php endif; ?>
<?php if(!Auth::guest()): ?>
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
<?php else: ?>

<?php endif; ?>


<?php if(!Auth::guest()): ?>
<div style="display: none;">
<div class="modal modal5" id="prof">
  <div style="
    height: 610px;
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
        <h4>Добро пожаловать, <a href="#"><?php echo e(Auth::user()->nick); ?></a></h4>
        <div class="left">
          <label>Никнейм:</label>
          <input type="text" placeholder="<?php echo e(Auth::user()->nick); ?>" readonly/>
          <div class="stat">
            <strong>ИГР СЫГРАНО</strong>
            <span><?php echo e(Auth::user()->open_box); ?></span>
          </div>
        </div>
        <div class="center">
          <?php if(Auth::user()->profit < 1000 && Auth::user()->profit >= 0): ?>
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Новичок</strong></span>
          <?php endif; ?>
          <?php if(Auth::user()->profit < 2500 && Auth::user()->profit >= 1000): ?>
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Неизвестный</strong></span>
          <?php endif; ?>
          <?php if(Auth::user()->profit < 5000 && Auth::user()->profit >= 2500): ?>
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Узнаваемый</strong></span>
          <?php endif; ?>
          <?php if(Auth::user()->profit < 10000 && Auth::user()->profit >= 5000): ?>
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Знаменитый</strong></span>
          <?php endif; ?>
          <?php if(Auth::user()->profit < 15000 && Auth::user()->profit >= 10000): ?>
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Выдающийся</strong></span>
          <?php endif; ?>
          <?php if(Auth::user()->profit < 20000 && Auth::user()->profit >= 15000): ?>
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Прославленный</strong></span>
          <?php endif; ?>
          <?php if(Auth::user()->profit < 30000 && Auth::user()->profit >= 20000): ?>
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Величайший</strong></span>
          <?php endif; ?>
          <?php if(Auth::user()->profit < 50000 && Auth::user()->profit >= 30000): ?>
          <div class="img"><img src="/assets/images/prof.png" alt="...."/></div>
          <span class="rang">Ваш ранг: <strong>Легендарный</strong></span>
          <?php endif; ?>
        </div>
        <div class="right">
          <label>Эл. адрес:</label>
          <input type="text" placeholder="" readonly/>
          <div class="stat">
            <strong>ПОСТАВЛЕНО руб</strong>
            <span><?php echo e(Auth::user()->profit); ?></span>
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
		  <?php if($pay == []): ?>
            <?php foreach($pay as $paym): ?>
              <tbody>
                 <tr>
                    <td><?php echo e($paym->id); ?></td>
                    <td>Freekassa</td>
                    <td class="yellow">+ <?php echo e($paym->amount); ?> р.</td>
                    <td><?php echo e($paym->created_at); ?></td>
                    <td class="check"><i class="fa fa-check-circle tooltip tooltipstered" aria-hidden="true"></i></td>
                 </tr>
              </tbody>
            <?php endforeach; ?>

            <?php else: ?>


			<?php endif; ?>
			<?php if($viv == []): ?>
            <?php foreach($viv as $vivod): ?>
              <tbody>
                 <tr>
                    <td><?php echo e($vivod->id); ?></td>
                    <td>Vivod</td>
                    <td class="red">- <?php echo e($vivod->amount); ?> р.</td>
                    <td><?php echo e($paym->created_at); ?></td>
                    <?php if($vivod->status == 0): ?>
                        <td class="check"><i class="fa fa-refresh tooltip tooltipstered" aria-hidden="true"></i></td>
                    <?php endif; ?>
                    <?php if($vivod->status == 2): ?>
                      <td class="check"><i class="fa fa-check-circle tooltip tooltipstered" aria-hidden="true"></i></td>
                    <?php endif; ?>
                 </tr>
              </tbody>
            <?php endforeach; ?>

            <?php else: ?>


			<?php endif; ?>
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
            <li><i class="fa fa-angle-right" aria-hidden="true"></i> Количество игроков, которых Вы привлекли: <span><?php echo e($ref); ?></span></li>
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
          <input type="text" value="http://foxbet.su?r=ptOvU1F" readonly />
          <p>До <strong>5%</strong> от каждого депозита, сделанного игроками, которых Вы привлекли, добавляется к вашему балансу и вы сразу же сможете его вывести.</p>
          <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter" data-url="http://foxbet.su?r=ptOvU1F"></div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
</div>
<?php else: ?>
<div style="display: none;">
<div class="modal modal5" id="prof">
  <div style="
    height: 610px;
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
<?php endif; ?>

</body>

</html>
