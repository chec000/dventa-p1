<?php

defined('_JEXEC') or die('Restricted access');
?>
<?php $userId = isset($this->userId)?$this->userId:null;?>
<?php if($userId===0):?>
	<div id="system-message-container">
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<h4 class="alert-heading"><?php echo JText::_('COM_CHECKOUT_LOGIN_TITLE');?></h4>
			<div class="alert-message"><?php echo JText::_('COM_CHECKOUT_LOGIN_MSG');?></div>
		</div>
	</div>
<?php else:?>
	<div class="container">
		<h1 class="checkout-survey__title"><?php echo JText::_('COM_CHECKOUT_SURVEY_TITLE');?></h1>
		<p class="checkout-survey__help-text"><?php echo JText::_('COM_CHECKOUT_SURVEY_MSG');?></p>
		<form action="<?php echo JRoute::_('index.php?option=com_checkout&task=delivery'); ?>"
			method="post" name="adminForm" id="adminForm">
			<div class="form-group">
				<label class="question-text required"><?php echo JText::_('COM_CHECKOUT_SURVEY_Q1');?></label>
				<label class="answer-text">
					<input type="radio" name="q1" value="Excelente" required>
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS1');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q1" value="Buena">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS2');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q1" value="Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS3');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q1" value="Muy Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS4');?></span>
				</label>
			</div>
			<div class="form-group">
				<label class="question-text required"><?php echo JText::_('COM_CHECKOUT_SURVEY_Q2');?></label>
				<label class="answer-text">
					<input type="radio" name="q2" value="Excelente" required>
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS1');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q2" value="Buena">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS2');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q2" value="Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS3');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q2" value="Muy Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS4');?></span>
				</label>
			</div>
			<div class="form-group">
				<label class="question-text required"><?php echo JText::_('COM_CHECKOUT_SURVEY_Q3');?></label>
				<label class="answer-text">
					<input type="radio" name="q3" value="Excelente" required>
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS1');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q3" value="Buena">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS2');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q3" value="Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS3');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q3" value="Muy Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS4');?></span>
				</label>
			</div>
			<div class="form-group">
				<label class="question-text required"><?php echo JText::_('COM_CHECKOUT_SURVEY_Q4');?></label>
				<label class="answer-text">
					<input type="radio" name="q4" value="Excelente" required>
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS1');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q4" value="Buena">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS2');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q4" value="Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS3');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q4" value="Muy Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS4');?></span>
				</label>
			</div>
			<div class="form-group">
				<label class="question-text required"><?php echo JText::_('COM_CHECKOUT_SURVEY_Q5');?></label>
				<label class="answer-text">
					<input type="radio" name="q5" value="Excelente" required>
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS1');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q5" value="Buena">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS2');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q5" value="Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS3');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q5" value="Muy Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS4');?></span>
				</label>
			</div>
			<div class="form-group">
				<label class="question-text required"><?php echo JText::_('COM_CHECKOUT_SURVEY_Q6').$this->pmr_name.'?';?></label>
				<label class="answer-text">
					<input type="radio" name="q6" value="Excelente" required>
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS1');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q6" value="Buena">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS2');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q6" value="Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS3');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q6" value="Muy Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS4');?></span>
				</label>
			</div>
			<div class="form-group">
				<label class="question-text required"><?php echo JText::_('COM_CHECKOUT_SURVEY_Q7');?></label>
				<label class="answer-text">
					<input type="radio" name="q7" value="Excelente" required>
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS1');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q7" value="Buena">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS2');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q7" value="Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS3');?></span>
				</label>
				<label class="answer-text">
					<input type="radio" name="q7" value="Muy Mala">
					<span><?php echo JText::_('COM_CHECKOUT_SURVEY_ANS4');?></span>
				</label>
			</div>
			<div>
				<label class="question-text"><?php echo JText::_('COM_CHECKOUT_SURVEY_Q8');?></label>
				<textarea id="comments-text" name="q8"></textarea>
			</div>
			<div class="submit">
				<input type="submit" class="next-btn" value="<?php echo JText::_('COM_CHECKOUT_CONTINUE');?>">
			</div>
		</form>
	</div>
<?php endif;?>