<div class="centered">
	<div id="change_background_picture"><!--
		--><?=form_open_multipart('user/edit/picture/background', array('class' => 'ajax-upload'));?><!--
			--><?=form_input($change_picture['background']['upload']);?><!--
			--><?=form_input($change_picture['background']['submit']);?><!--
			--><?=form_input($change_picture['background']['delete']);?><!--
		--><?=form_close();?><!--
	--></div>
	<div id="profile_picture">
		<div class="picture" style="background-image:url(<?=avatar_image($user->id)?>);"></div>
	</div>
	<div id="change_profile_picture">
		<?=form_open_multipart('user/edit/picture/profile', array('class' => 'ajax-upload'));?>
			<?=form_input($change_picture['profile']['upload']);?>
			<?=form_input($change_picture['profile']['submit']);?>
			<?=form_input($change_picture['profile']['delete']);?>
		<?=form_close();?>
	</div>
	<div id="user-info">
		<h1 class="text-contrast"><?=showname($user)?></h1>
		<div class="message<?php if(!isset($form_validation['messages']) || count($form_validation['messages']) == 0) echo ' hidden'; ?>"><div class="container">
			<?php if(isset($form_validation['messages']) && count($form_validation['messages']) > 0) foreach($form_validation['messages'] as $m): ?>
				<p><?=$m?></p>
			<?php endforeach; ?>
		</div></div>
		<?=form_open('user/edit');?>
			<?php /* <div class="user-edit-item">
				<?=form_label('E-Mail', $edit_form['email']['id']);?>
				<?=p_r(form_input($edit_form['email']));?>
			</div> */ ?>
			<div class="user-edit-item">
				<?=form_label('Username', $edit_form['username']['id']);?>
				<?=p_r(form_input($edit_form['username']));?>
			</div>
			<div class="user-edit-item">
				<?=form_label('First name', $edit_form['first_name']['id']);?>
				<?=p_r(form_input($edit_form['first_name']));?>
			</div>
			<div class="user-edit-item">
				<?=form_label('Last name', $edit_form['last_name']['id']);?>
				<?=p_r(form_input($edit_form['last_name']));?>
			</div>
			<div class="user-edit-item">
				<?=form_label('New Password', $edit_form['password']['id']);?>
				<?=p_r(form_input($edit_form['password']));?>
				<?=p_r(form_input($edit_form['password_verification']));?>
			</div>
			<div class="about user-edit-item">
				<?=form_label('About', $edit_form['about']['id']);?>
				<?=p_r(form_textarea($edit_form['about']));?>
				<div class="clear"></div>
			</div>
			<div class="user-edit-item">
				<?=form_label('Old Password', $edit_form['old_password']['id']);?>
				<?=p_r(form_input($edit_form['old_password']));?>
			</div>
		<?=p_r(form_input($edit_form['submit']));?>
		<?=form_close();?>
	</div>
</div>