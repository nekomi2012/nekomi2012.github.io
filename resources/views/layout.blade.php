<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <!--[if lt IE 9]><script src="/assets/js/html5.js"></script><![endif]-->
    <title>Triplecash.ru</title>
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
    <script>
    @if(Auth::guest())

    @else
    var login = {{Auth::user()->id}};
    @endif

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
              @if(!Auth::check())
              <div class="balance">
                  <div class="v">
                    Login <i class="flaticon-ruble"></i>
                  </div>
              </div>
              @else
              <div class="balance">
                  <div class="v">
                    {{Auth::user()->money}} <i class="flaticon-ruble"></i>
                  </div>
              </div>
              @endif
                <div class="deposit">
                    <button>Deposit</button>
                </div>
                <div class="withdrawal">
                    <button>Withdrawal</button>
                </div>
                <div class="cls"></div>
            </div>
            @if(Auth::guest())
            <div class="signin">
                <div class="social">
                    <div class="fb"><a href="/login">Login through
                        <div class="vk-icon"></div></a>
                    </div>
                </div>
                <div class="cls"></div>
            </div>
            @else
            <div class="signin">
              <div class="welcome">
                <div class="name-show">Welcome,<br> <a href="#">{{Auth::user()->username}}</a></div
                  ><div class="name-edit">
                    <input type="text" value="{{Auth::user()->username}}">
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
            </div>
            @endif
        </header>
@yield('content')
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
                    <li><a href="/en/statistics/">Statistics</a>
                    </li>
                    <li><a href="
javascript:lgpAction();
">Support</a>
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
    <div class="fname">Get Your</div>
    <div class="fvalue">1.00 RUB</div>
    </div>
    <div class="pix"></div>
    <div class="submit"><div class="loading"></div><button class="Freebtn">Claim now</button></div>
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
    <div class="title">ДОБРО ПОЖАЛОВАТЬ, {{Auth::user()->username}}</div>
    <div class="list hash">
    <div class="name">Affiliate URL</div>
    <div class="value"><input type="text" readonly="" value="https://epicdrop.ru/?r={{Auth::user()->ref_code}}"></div>
    </div>
    <div class="list ">
    <div class="name">Alias</div>
    <div class="value"><input type="text" readonly="" value="{{Auth::user()->username}}"></div>
    </div>
    <div class="list ">
    <div class="name">Refferal</div>
    <div class="value"><input type="text" readonly="" value="{{Auth::user()->ref_use}}"></div>
    </div>
    <div class="logout"><button onclick="/logout'">Sign Out</button></div>
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
            'game-take': 'Take amount',
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
