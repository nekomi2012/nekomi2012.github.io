

<?php $__env->startSection('content'); ?>

<div class="content">
	<?php if($u->ban_ticket != 1): ?>

	<?php $__empty_1 = true; foreach($loots as $ticket): $__empty_1 = false; ?>

	<?php if($ticket->username == $u->username || $u->is_admin == 1 || $u->is_moderator == 1): ?>
	<div class="middle">
	   <div class="support_ui">
	      <div class="ticket-open">
	         <div class="title"><span>Тикет #<?php echo e($ticket->id); ?>:</span>&nbsp; <?php echo e($ticket->messages); ?></div>
					 <?php if($ticket->ask == 1 || $ticket->ask == 2): ?>
					 <ul class="list">
							<li>
								 <div class="avatar"><img src="<?php echo e($ticket->avatarka); ?>" class="img-circle"></div>
								 <div class="info">
										<div class="name support"><?php echo e($ticket->username); ?></div>
										<div class="date"><?php echo e($ticket->date); ?></div>
										<div class="text">
											<?php echo e($ticket->messages); ?>

										</div>
								 </div>
								 <div class="clear"></div>
							</li>
						</ul>
						 <?php foreach($mess as $ticketm): ?>
								<?php if($ticketm->admin_id == 1): ?>
								<ul class="list">
									<li>
										 <div class="avatar"><img src="/assets/images/support.jpg" class="img-circle"></div>
										 <div class="info">
												<div class="name support">ADMIN</div>
												<div class="date"><?php echo e($ticket->date); ?></div>
												<div class="text">
													<?php echo e($ticketm->messages); ?>

												</div>
										 </div>
										 <div class="clear"></div>
									</li>
								</ul>
								<?php else: ?>
								<ul class="list">
							 		<li>
							 			 <div class="avatar"><img src="<?php echo e($ticket->avatarka); ?>" class="img-circle"></div>
							 			 <div class="info">
							 					<div class="name support"><?php echo e($ticket->username); ?></div>
							 					<div class="date"><?php echo e($ticket->date); ?></div>
							 					<div class="text">
							 						<?php echo e($ticketm->messages); ?>

							 					</div>
							 			 </div>
							 			 <div class="clear"></div>
							 		</li>
							  </ul>
								<?php endif; ?>
						 <?php endforeach; ?>
					<?php endif; ?>
					<?php if($ticket->ask == 1 && $ticket->status == 0): ?>

					<form action="/support/<?php echo e($ticket->id); ?>" method="POST">
						<div class="textarea">
						<textarea type="text" name="mess" placeholder="Введите ваше сообщение..." maxlength="64" autocomplete="off"></textarea>
						</div>
						<div class="send-btn">
							   <a href="/support/" class="back">« назад</a>
							<input type="submit" name="submit" class="btn" value="Отправить">
						</div>
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"/>
					</form>
					<?php endif; ?>
					<?php if($ticket->ask == 2 && $ticket->status == 0): ?>
					<form action="/support/<?php echo e($ticket->id); ?>" method="POST">
						<div class="textarea">
						<textarea type="text" name="mess" placeholder="Введите ваше сообщение..." maxlength="64" autocomplete="off"></textarea>
					</div>
					<div class="send-btn">
							 <a href="/support/" class="back">« назад</a>
						<input type="submit" name="submit" class="btn" value="Отправить">
					</div>
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"/>
					</form>
					<?php endif; ?>
					<?php if($ticket->status == 0): ?>
					<form action="/support/<?php echo e($ticket->id); ?>" method="POST">
						<br><br>
						<div class="send-btn">
						<input type="submit" name="close" class="btn" value="Закрыть тикет">
					</div>
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"/>
					</form>
					<?php endif; ?>
					<?php if($u->is_admin == 1 && $ticket->status == 0): ?>
					<form action="/support/<?php echo e($ticket->id); ?>" method="POST">
						<div class="send-btn">
							<input type="submit" name="ban" class="btn" value="Заблокировать">
						</div>
						<br><br>
						<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>"/>
					</form>
					<?php endif; ?>
	      </div>
	   </div>
	</div>

	<?php else: ?>
	<center><h1 style="color: #fff;">Такого запроса не существует!</h1></center>
	<?php endif; ?>
	<?php endforeach; if ($__empty_1): ?>
	<center><h1 style="color: #fff;">Такого запроса не существует!</h1></center>
	<?php endif; ?>
	<?php else: ?>
	<div class="other-title">Ошибка! Вы были заблокированы за флуд.</div>
	<?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>