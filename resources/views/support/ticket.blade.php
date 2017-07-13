@extends('layout')

@section('content')

<div class="content">
	@if($u->ban_ticket != 1)

	@forelse($loots as $ticket)

	@if($ticket->username == $u->username || $u->is_admin == 1 || $u->is_moderator == 1)
	<div class="middle">
	   <div class="support_ui">
	      <div class="ticket-open">
	         <div class="title"><span>Тикет #{{$ticket->id}}:</span>&nbsp; {{$ticket->messages}}</div>
					 @if($ticket->ask == 1 || $ticket->ask == 2)
					 <ul class="list">
							<li>
								 <div class="avatar"><img src="{{$ticket->avatarka}}" class="img-circle"></div>
								 <div class="info">
										<div class="name support">{{$ticket->username}}</div>
										<div class="date">{{$ticket->date}}</div>
										<div class="text">
											{{$ticket->messages}}
										</div>
								 </div>
								 <div class="clear"></div>
							</li>
						</ul>
						 @foreach($mess as $ticketm)
								@if($ticketm->admin_id == 1)
								<ul class="list">
									<li>
										 <div class="avatar"><img src="/assets/images/support.jpg" class="img-circle"></div>
										 <div class="info">
												<div class="name support">ADMIN</div>
												<div class="date">{{$ticket->date}}</div>
												<div class="text">
													{{$ticketm->messages}}
												</div>
										 </div>
										 <div class="clear"></div>
									</li>
								</ul>
								@else
								<ul class="list">
							 		<li>
							 			 <div class="avatar"><img src="{{$ticket->avatarka}}" class="img-circle"></div>
							 			 <div class="info">
							 					<div class="name support">{{$ticket->username}}</div>
							 					<div class="date">{{$ticket->date}}</div>
							 					<div class="text">
							 						{{$ticketm->messages}}
							 					</div>
							 			 </div>
							 			 <div class="clear"></div>
							 		</li>
							  </ul>
								@endif
						 @endforeach
					@endif
					@if($ticket->ask == 1 && $ticket->status == 0)

					<form action="/support/{{$ticket->id}}" method="POST">
						<div class="textarea">
						<textarea type="text" name="mess" placeholder="Введите ваше сообщение..." maxlength="64" autocomplete="off"></textarea>
						</div>
						<div class="send-btn">
							   <a href="/support/" class="back">« назад</a>
							<input type="submit" name="submit" class="btn" value="Отправить">
						</div>
						<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					</form>
					@endif
					@if($ticket->ask == 2 && $ticket->status == 0)
					<form action="/support/{{$ticket->id}}" method="POST">
						<div class="textarea">
						<textarea type="text" name="mess" placeholder="Введите ваше сообщение..." maxlength="64" autocomplete="off"></textarea>
					</div>
					<div class="send-btn">
							 <a href="/support/" class="back">« назад</a>
						<input type="submit" name="submit" class="btn" value="Отправить">
					</div>
						<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					</form>
					@endif
					@if($ticket->status == 0)
					<form action="/support/{{$ticket->id}}" method="POST">
						<br><br>
						<div class="send-btn">
						<input type="submit" name="close" class="btn" value="Закрыть тикет">
					</div>
						<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					</form>
					@endif
					@if($u->is_admin == 1 && $ticket->status == 0)
					<form action="/support/{{$ticket->id}}" method="POST">
						<div class="send-btn">
							<input type="submit" name="ban" class="btn" value="Заблокировать">
						</div>
						<br><br>
						<input type="hidden" name="_token" value="{{csrf_token()}}"/>
					</form>
					@endif
	      </div>
	   </div>
	</div>

	@else
	<center><h1 style="color: #fff;">Такого запроса не существует!</h1></center>
	@endif
	@empty
	<center><h1 style="color: #fff;">Такого запроса не существует!</h1></center>
	@endforelse
	@else
	<div class="other-title">Ошибка! Вы были заблокированы за флуд.</div>
	@endif
</div>

@endsection
