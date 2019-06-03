<?php
/**
 * @copyright	Copyright (c) 2017 Adventa (http://www.adventa.com.mx/). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */
// no direct access
defined('_JEXEC') or die;
?>
<?php
	$points_type= array('','','');
	$points_value=array('','','');
	if ($params->get('ac_points_order') == 1){
		$points_type[0]='actual_points';
		$points_value[0]=$actual;
	}else if ($params->get('ac_points_order') == 2){
		$points_type[1]='actual_points';
		$points_value[1]=$actual;
	}else{
		$points_type[2]='actual_points';
		$points_value[2]=$actual;
	}

	if ($params->get('aq_points_order') == 1){
		$points_type[0]='adquired_points';
		$points_value[0]=$adquired;
	}else if ($params->get('aq_points_order') == 2){
		$points_type[1]='adquired_points';
		$points_value[1]=$adquired;
	}else{
		$points_type[2]='adquired_points';
		$points_value[2]=$adquired;
	}

	if ($params->get('re_points_order') == 1){
		$points_type[0]='reedemed_points';
		$points_value[0]=$exchanged;
	}else if ($params->get('re_points_order') == 2){
		$points_type[1]='reedemed_points';
		$points_value[1]=$exchanged;
	}else{
		$points_type[2]='reedemed_points';
		$points_value[2]=$exchanged;
	}
?>
<div id="<?php echo $params->get('wrapper'); ?>" >
	<h2><?php echo JText::_( 'MOD_ACCOUNT_STATUS_FRONT_TPL_NAME' ); ?></h2>
<!--USER_NAME-->
  <div class="account-status-header">

		<div class="account-status-avatar">
				<span class="fa fa-user-circle-o profile-user"></span>
		</div>

		<div class="account-status-userinfo">
			<?php if ($params->get('user_name')) : ?>
				<<?php echo $params->get('headers_tag'); ?>>
					<?php echo $params->get('user_name'); ?>
				</<?php echo $params->get('headers_tag'); ?>>
			<?php endif; ?>

		  <<?php echo $params->get('text_tag'); ?>>
		  	<?php if ($params->get('user_name')) : ?>
		  		<?php
		  			echo "{$user->name}";
		  		?>
		  	<?php endif; ?>
		  </<?php echo $params->get('text_tag'); ?>>

			<!--USER_USERNAME-->
			<?php if ($params->get('user_username')) : ?>
					<<?php echo $params->get('headers_tag'); ?>>
						<?php echo $params->get('user_username'); ?>
					</<?php echo $params->get('headers_tag'); ?>>
			<?php endif; ?>

			<<?php echo $params->get('text_tag'); ?>>
				<?php if ($params->get('user_username')) : ?>
					<?php	echo "{$user->username}";	?>
				<?php endif; ?>
			</<?php echo $params->get('text_tag'); ?>>
		</div>

	</div>

	<div class="main-points">
		<!--POINTS1-->
		<div class="points-item right-border">
				<?php if ($points_type[0]) : ?>
					<span class="points-number">
						<?php	echo number_format($points_value[0],0);?>
					</span>
				<?php endif; ?>

				<?php if ($points_type[0]) : ?>
						<span><?php echo $coin.' '.$params->get($points_type[0]); ?></span>
				<?php endif; ?>
		</div>

		<!--POINTS2-->
		<div class="points-item right-border">
				<?php if ($points_type[1]) : ?>
					<span class="points-number">
						<?php	echo number_format($points_value[1],0);?>
					</span>
				<?php endif; ?>

				<?php if ($points_type[1]) : ?>
						<span><?php echo $coin.' '.$params->get($points_type[1]); ?></span>
				<?php endif; ?>
		</div>

		<!--POINTS3-->
		<div class="points-item">
			<?php if ($points_type[2]) : ?>
				<span class="points-number">
					<?php	echo number_format($points_value[2],0);?>
			  </span>
			<?php endif; ?>

			<?php if ($points_type[2]) : ?>
					<span> <?php echo $coin.' '.$params->get($points_type[2]); ?> </span>
			<?php endif; ?>
		</div>

	</div>

	<div class="account-status-canjes">
		<a href="index.php/historial-de-canje" class="btn btn-info"> Historial de canjes</a>
	</div>

</div>
