@extends('layout')

@section('content')

	<script type="text/javascript">
    $(document).ready(function() {
		$(".tickets .new").click(function () {
			$(".support_ui .table").hide();
			$(".support_ui .ticket-open").show();
      	$(".support_ui .nticket").show();
		});

		$(".tickets .my").click(function () {
			$(".support_ui .table").show();
			$(".support_ui .ticket-open").hide();
      	$(".support_ui .nticket").hide();
		});


	});
	</script>
<div class="middle">


	<!-- <middle> -->
	@if($u->ban_ticket != 1)

	<div class="support_ui" style="    padding-right: 20px;
    padding-left: 20px;">

	<div class="tickets">
		<div class="new" id="newticket">
      <i class="flaticon-tickets-new"></i> Новый тикет
		</div>
		<div class="my" id="listticket">
      <i class="flaticon-tickets-my"></i> Мои тикеты
    </div>

		<div class="table" style="margin-top: 55px;">

			@forelse($tickets as $ticket)

      <div class="list">
            <table>
              <tbody>
                <tr onclick="TicketPage({{$ticket->id}});">
            <td class="id">#{{$ticket->id}}</td>
            <td class="text">{{$ticket->title}}</td>
            <td class="date">
            </td>
                	@if($ticket->status == 0)
                <td class="status open">
                  <i class="flaticon-tickets-new"></i> Открыто
                </td>
                @else
                <td class="status closed">
                  <i class="flaticon-tickets-new"></i> Закрытый
                </td>
                @endif
            </tr>
            </tbody>
            </table>
            </div>

			@empty
			<br><center><h1 style="color: #FFF; font-weight: 300;">Запросы в техническую поддержку отсутствуют!</h1></center>
			@endforelse
    </div>
		</div>
    <div class="ticket-open" style="display: none;">
		<form action="/support" method="POST">
			<div class="nticket">
        <div class="title">
          				<input type="text" name="title" value="" placeholder="Тема обращения" maxlength="32" autocomplete="off">
        </div>
        <div class="textarea">
          				<textarea type="text" name="mess" value="" placeholder="Опишите вашу проблему" maxlength="128" autocomplete="off"></textarea>
        </div>
        <div class="send-btn">
          				<input type="submit" name="submit"  class="btn" value="Создать заявку">
        </div>
			</div>
			<input type="hidden" name="_token" value="{{csrf_token()}}"/>
		</form>
  </div>
	</div>
	@else
	<div class="other-title">Ошибка! Вы были заблокированы за флуд.</div>
	@endif

</div>

@endsection
