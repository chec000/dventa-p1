<?php
/**
 * @package     Joomla.Plugin
 * @subpackage  User.profile
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Utilities\ArrayHelper;

/**
 * An example custom profile plugin.
 *
 * @since  1.6
 */
class PlgUserProfile extends JPlugin
{
	/**
	 * Date of birth.
	 *
	 * @var    string
	 * @since  3.1
	 */
	private $date = '';

	/**
	 * Load the language file on instantiation.
	 *
	 * @var    boolean
	 * @since  3.1
	 */
	protected $autoloadLanguage = true;

	/**
	 * Constructor
	 *
	 * @param   object  &$subject  The object to observe
	 * @param   array   $config    An array that holds the plugin configuration
	 *
	 * @since   1.5
	 */
	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		JFormHelper::addFieldPath(__DIR__ . '/field');
	}

	/**
	 * Runs on content preparation
	 *
	 * @param   string  $context  The context for the data
	 * @param   object  $data     An object containing the data for the form.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	public function onContentPrepareData($context, $data)
	{
		
		// Check we are manipulating a valid form.
		if (!in_array($context, array('com_users.profile', 'com_users.user', 'com_users.registration', 'com_admin.profile')))
		{
			return true;
		}

		if (is_object($data))
		{
			$userId = isset($data->id) ? $data->id : 0;

			if (!isset($data->profile) && $userId > 0)
			{
				// Load the profile data from the database.
				$db = JFactory::getDbo();
				$db->setQuery(
					'SELECT profile_key, profile_value FROM #__user_profiles'
						. ' WHERE user_id = ' . (int) $userId . " AND profile_key LIKE 'profile.%'"
						. ' ORDER BY ordering'
				);

				try
				{
					$results = $db->loadRowList();
				}
				catch (RuntimeException $e)
				{
					$this->_subject->setError($e->getMessage());

					return false;
				}

				// Merge the profile data.
				$data->profile = array();

				foreach ($results as $v)
				{
					$k = str_replace('profile.', '', $v[0]);
					$data->profile[$k] = json_decode($v[1], true);

					if ($data->profile[$k] === null)
					{
						$data->profile[$k] = $v[1];
					}
					
				}
			}			
			
			///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

			if (!JHtml::isRegistered('users.url'))
			{
				JHtml::register('users.url', array(__CLASS__, 'url'));
			}

			if (!JHtml::isRegistered('users.calendar'))
			{
				JHtml::register('users.calendar', array(__CLASS__, 'calendar'));
			}

			if (!JHtml::isRegistered('users.tos'))
			{
				JHtml::register('users.tos', array(__CLASS__, 'tos'));
			}

			if (!JHtml::isRegistered('users.dob'))
			{
				JHtml::register('users.dob', array(__CLASS__, 'dob'));
			}
		}

		if(is_object($data)){
			//Cuando $data sea objeto va a eliminar el campo (Code) y a llenar los campos de cedis
			if(isset($data->profile->names_cedis) && $data->profile->names_cedis != "" ){
				$db = JFactory::getDbo();
				$db->setQuery(
					'SELECT names_cedis, street, ext_number, int_number, location, reference, estate, city, zip_code, telephone FROM #__core_cedis'
						. ' WHERE cedis_id = ' . $data->profile->names_cedis
						. ' ORDER BY ordering'
				);
				$cedis = $db->loadRowList();
				if($cedis!= null){
					$data->cedis_fields['cedis_names']=$cedis[0][0];
					$data->cedis_fields['cedis_street']=$cedis[0][1];		
					$data->cedis_fields['cedis_ext_number']=$cedis[0][2];		
					$data->cedis_fields['cedis_int_number']=$cedis[0][3];		
					$data->cedis_fields['cedis_location']=$cedis[0][4];		
					$data->cedis_fields['cedis_reference']=$cedis[0][5];		
					$data->cedis_fields['cedis_estate']=$cedis[0][6];		
					$data->cedis_fields['cedis_city']=$cedis[0][7];		
					$data->cedis_fields['cedis_zip_code']=$cedis[0][8];		
					$data->cedis_fields['cedis_telephone']=$cedis[0][9];
				}else{
					$data->cedis_fields['cedis_names']="";
					$data->cedis_fields['cedis_street']="";		
					$data->cedis_fields['cedis_ext_number']="";		
					$data->cedis_fields['cedis_int_number']="";		
					$data->cedis_fields['cedis_location']="";		
					$data->cedis_fields['cedis_reference']="";		
					$data->cedis_fields['cedis_estate']="";		
					$data->cedis_fields['cedis_city']="";		
					$data->cedis_fields['cedis_zip_code']="";		
					$data->cedis_fields['cedis_telephone']="";
				}		
			}
		}

		return true;
	}

	/**
	 * Returns an anchor tag generated from a given value
	 *
	 * @param   string  $value  URL to use
	 *
	 * @return mixed|string
	 */
	public static function url($value)
	{
		if (empty($value))
		{
			return JHtml::_('users.value', $value);
		}
		else
		{
			// Convert website URL to utf8 for display
			$value = JStringPunycode::urlToUTF8(htmlspecialchars($value));

			if (strpos($value, 'http') === 0)
			{
				return '<a href="' . $value . '">' . $value . '</a>';
			}
			else
			{
				return '<a href="http://' . $value . '">' . $value . '</a>';
			}
		}
	}

	/**
	 * Returns html markup showing a date picker
	 *
	 * @param   string  $value  valid date string
	 *
	 * @return  mixed
	 */
	public static function calendar($value)
	{
		if (empty($value))
		{
			return JHtml::_('users.value', $value);
		}
		else
		{
			return JHtml::_('date', $value, null, null);
		}
	}

	/**
	 * Returns the date of birth formatted and calculated using server timezone.
	 *
	 * @param   string  $value  valid date string
	 *
	 * @return  mixed
	 */
	public static function dob($value)
	{
		if (!$value)
		{
			return '';
		}

		return JHtml::_('date', $value, JText::_('DATE_FORMAT_LC1'), false);
	}

	/**
	 * Return the translated strings yes or no depending on the value
	 *
	 * @param   boolean  $value  input value
	 *
	 * @return string
	 */
	public static function tos($value)
	{
		if ($value)
		{
			return JText::_('JYES');
		}
		else
		{
			return JText::_('JNO');
		}
	}

	/**
	 * Adds additional fields to the user editing form
	 *
	 * @param   JForm  $form  The form to be altered.
	 * @param   mixed  $data  The associated data for the form.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	public function onContentPrepareForm($form, $data)
	{
		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');

			return false;
		}

		// Check we are manipulating a valid form.
		$name = $form->getName();

		if (!in_array($name, array('com_admin.profile', 'com_users.user', 'com_users.profile', 'com_users.registration')))
		{
			return true;
		}

		// Add the registration fields to the form.
		JForm::addFormPath(__DIR__ . '/profiles');
		$form->loadFile('profile', false);

		$fields = array(
			'code',
			'last_name1',
			'last_name2',
			'num_cel',
			'num_tel',
			'street',
			'num_ext',
			'num_int',
			'reference',
			'neighborhood',
			'pc',
			'town',
			'estate',
			'genre',
			'dob',
			'names_cedis',
		);

		// Change fields description when displayed in frontend or backend profile editing
		$app = JFactory::getApplication();

		if ($app->isClient('site') || $name === 'com_users.user' || $name === 'com_admin.profile')
		{
			$form->setFieldAttribute('code', 'description', 'PLG_USER_PROFILE_FIELD_CODE_DESC', 'profile');
			$form->setFieldAttribute('last_name1', 'description', 'PLG_USER_PROFILE_FIELD_CODE_DESC', 'profile');
			$form->setFieldAttribute('last_name2', 'description', 'PLG_USER_PROFILE_FIELD_CODE_DESC', 'profile');
			$form->setFieldAttribute('num_cel', 'description', 'PLG_USER_PROFILE_FIELD_NUMCEL_DESC', 'profile');
			$form->setFieldAttribute('num_tel', 'description', 'PLG_USER_PROFILE_FIELD_NUMTEL_DESC', 'profile');
			$form->setFieldAttribute('street', 'description', 'PLG_USER_PROFILE_FIELD_STREET_DESC', 'profile');
			$form->setFieldAttribute('num_ext', 'description', 'PLG_USER_PROFILE_FIELD_NUMEXT_DESC', 'profile');
			$form->setFieldAttribute('num_int', 'description', 'PLG_USER_PROFILE_FIELD_NUMINT_DESC', 'profile');
			$form->setFieldAttribute('reference', 'description', 'PLG_USER_PROFILE_FIELD_REFERENCE_DESC', 'profile');
			$form->setFieldAttribute('neighborhood', 'description', 'PLG_USER_PROFILE_FIELD_NEIGHBORHOOD_DESC', 'profile');
			$form->setFieldAttribute('pc', 'description', 'PLG_USER_PROFILE_FIELD_PC_DESC', 'profile');
			$form->setFieldAttribute('town', 'description', 'PLG_USER_PROFILE_FIELD_TOWN_DESC', 'profile');
			$form->setFieldAttribute('estate', 'description', 'PLG_USER_PROFILE_FIELD_ESTATE_DESC', 'profile');
			$form->setFieldAttribute('genre', 'description', 'PLG_USER_PROFILE_FIELD_GENRE_DESC', 'profile');			
			$form->setFieldAttribute('dob', 'description', 'PLG_USER_PROFILE_FIELD_DOB_DESC', 'profile');
			$form->setFieldAttribute('names_cedis', 'description', 'PLG_USER_PROFILE_FIELD_SAC_DESC', 'profile');
			
		}

		$tosarticle = $this->params->get('register_tos_article');
		$tosenabled = $this->params->get('register-require_tos', 0);



		foreach ($fields as $field)
		{
			// Case using the users manager in admin
			if ($name === 'com_users.user')
			{
				// Remove the field if it is disabled in registration and profile
				if ($this->params->get('register-require_' . $field, 1) == 0
					&& $this->params->get('profile-require_' . $field, 1) == 0)
				{
					$form->removeField($field, 'profile');
				}
				
			}
			// Case registration
			elseif ($name === 'com_users.registration')
			{
				// Toggle whether the field is required.
				if ($this->params->get('register-require_' . $field, 1) > 0)
				{
					$form->setFieldAttribute($field, 'required', ($this->params->get('register-require_' . $field) == 2) ? 'required' : '', 'profile');
				}
				else
				{
					$form->removeField($field, 'profile');
				}
			}
			// Case profile in site or admin
			elseif ($name === 'com_users.profile' || $name === 'com_admin.profile')
			{
				// Toggle whether the field is required.
				if ($this->params->get('profile-require_' . $field, 1) > 0)
				{
					$form->setFieldAttribute($field, 'required', ($this->params->get('profile-require_' . $field) == 2) ? 'required' : '', 'profile');
				}
				else
				{
					$form->removeField($field, 'profile');
				}
			}
		}
		/////// Comprueba las configuraciones de Cedis - Datos de envío
		$cedisfields = array(
			'cedis_names',
			'cedis_street',
			'cedis_ext_number',
			'cedis_int_number',
			'cedis_location',
			'cedis_reference',
			'cedis_estate',
			'cedis_city',
			'cedis_zip_code',
			'cedis_telephone'
		);

		//Elimina campos si se encuentra en formulario de registro
		if(is_array($data)){
			foreach($cedisfields as $cf){
				$form->removeField($cf, 'cedis_fields');
			}
		}

		if(is_object($data)){
			$form->removeField('code', 'profile');
		}
		//Elimina los campos cedis y selector de cedis si cedis_fields está deshabilitado en admin
		if($this->params->get('cedis_fields')==0){
			foreach($cedisfields as $cf){
				$form->removeField($cf, 'cedis_fields');
			}
			$form->removeField('names_cedis', 'profile');
		}

		$shipping = array(
			'street',
			'num_ext',
			'num_int',
			'reference',
			'neighborhood',
			'pc',
			'town',
			'estate',
		);

		if($this->params->get('shipping_information')==0){
			foreach($shipping as $sinfo){
				$form->removeField($sinfo, 'profile');
			}
		}
		
		// Drop the profile form entirely if there aren't any fields to display.
		$remainingfields = $form->getGroup('profile');

		if (!count($remainingfields))
		{
			$form->removeGroup('profile');
		}

		return true;
	}

	/**
	 * Method is called before user data is stored in the database
	 *
	 * @param   array    $user   Holds the old user data.
	 * @param   boolean  $isnew  True if a new user is stored.
	 * @param   array    $data   Holds the new user data.
	 *
	 * @return    boolean
	 *
	 * @since   3.1
	 * @throws    InvalidArgumentException on invalid date.
	 */
	public function onUserBeforeSave($user, $isnew, $data)
	{
		// Check that the date is valid.
		if (!empty($data['profile']['dob']))
		{
			try
			{
				$date = new JDate($data['profile']['dob']);
				$this->date = $date->format('Y-m-d H:i:s');
			}
			catch (Exception $e)
			{
				// Throw an exception if date is not valid.
				throw new InvalidArgumentException(JText::_('PLG_USER_PROFILE_ERROR_INVALID_DOB'));
			}
			if (JDate::getInstance('now') < $date)
			{
				// Throw an exception if dob is greather than now.
				throw new InvalidArgumentException(JText::_('PLG_USER_PROFILE_ERROR_INVALID_DOB_FUTURE_DATE'));
			}
		}
		// Check that the tos is checked if required ie only in registration from frontend.
		$task       = JFactory::getApplication()->input->getCmd('task');
		$option     = JFactory::getApplication()->input->getCmd('option');
		$tosarticle = $this->params->get('register_tos_article');
		$tosenabled = ($this->params->get('register-require_tos', 0) == 2);

		// Check that the tos is checked.
		if ($task === 'register' && $tosenabled && $tosarticle && $option === 'com_users' && !$data['profile']['tos'])
		{
			throw new InvalidArgumentException(JText::_('PLG_USER_PROFILE_FIELD_TOS_DESC_SITE'));
		}

		return true;
	}

	/**
	 * Saves user profile data
	 *
	 * @param   array    $data    entered user data
	 * @param   boolean  $isNew   true if this is a new user
	 * @param   boolean  $result  true if saving the user worked
	 * @param   string   $error   error message
	 *
	 * @return bool
	 */
	public function onUserAfterSave($data, $isNew, $result, $error)
	{
		$userId = ArrayHelper::getValue($data, 'id', 0, 'int');

		if ($userId && $result && isset($data['profile']) && count($data['profile']))
		{
			try
			{
				$db = JFactory::getDbo();

				// Sanitize the date
				$data['profile']['dob'] = $this->date;

				$keys = array_keys($data['profile']);

				foreach ($keys as &$key)
				{
					$key = 'profile.' . $key;
					$key = $db->quote($key);
				}

				$query = $db->getQuery(true)
					->delete($db->quoteName('#__user_profiles'))
					->where($db->quoteName('user_id') . ' = ' . (int) $userId)
					->where($db->quoteName('profile_key') . ' IN (' . implode(',', $keys) . ')');
				$db->setQuery($query);
				$db->execute();

				$query = $db->getQuery(true)
					->select($db->quoteName('ordering'))
					->from($db->quoteName('#__user_profiles'))
					->where($db->quoteName('user_id') . ' = ' . (int) $userId);
				$db->setQuery($query);
				$usedOrdering = $db->loadColumn();

				$tuples = array();
				$order = 1;
				
				foreach ($data['profile'] as $k => $v)
				{
					while (in_array($order, $usedOrdering))
					{
						$order++;
					}

					$tuples[] = '(' . $userId . ', ' . $db->quote('profile.' . $k) . ', ' . $db->quote(json_encode($v)) . ', ' . ($order++) . ')';
				}

				$db->setQuery('INSERT INTO #__user_profiles VALUES ' . implode(', ', $tuples));
				$db->execute();
			}
			catch (RuntimeException $e)
			{
				$this->_subject->setError($e->getMessage());

				return false;
			}
		}

		return true;
	}


	/**
	 * Remove all user profile information for the given user ID
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param   array    $user     Holds the user data
	 * @param   boolean  $success  True if user was succesfully stored in the database
	 * @param   string   $msg      Message
	 *
	 * @return  boolean
	 */
	public function onUserAfterDelete($user, $success, $msg)
	{
		if (!$success)
		{
			return false;
		}

		$userId = ArrayHelper::getValue($user, 'id', 0, 'int');

		if ($userId)
		{
			try
			{
				$db = JFactory::getDbo();
				$db->setQuery(
					'DELETE FROM #__user_profiles WHERE user_id = ' . $userId
						. " AND profile_key LIKE 'profile.%'"
				);

				$db->execute();
			}
			catch (Exception $e)
			{
				$this->_subject->setError($e->getMessage());

				return false;
			}
		}

		return true;
	}	
}
