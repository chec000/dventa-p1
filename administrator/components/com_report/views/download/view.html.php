<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Report
 * @author     Othon Parra Alcantar <othon.parra@adventa.mx>
 * @copyright  
 * @license    Licencia Pública General GNU versión 2 o posterior. Consulte LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Report.
 *
 * @since  1.6
 */
class ReportViewDownload extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		require_once JPATH_COMPONENT . '/helpers/report.php';
		$this->result = ReportHelper::getFieldsOrder();
		$this->state = $this->get('State');
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
        $this->filterForm = $this->get('FilterForm');
        $this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		ReportHelper::addSubmenu('reportfields');

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function addToolbar()
	{
		$state = $this->get('State');
		$canDo = ReportHelper::getActions();

		JToolBarHelper::title(JText::_('COM_REPORT_TITLE_USERFIELDS'), 'userfields.png');
		JToolBarHelper::custom('reportfields.download', 'arrow-down-4', 'arrow-down-4', JText::_('COM_REPORT_CONFIRM_DOWNLOAD_CSV_BUTTON'), false);
		// Check if the form exists before showing the add/edit buttons
		//$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/reportfield';


		

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_report');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_report&view=reportfields');
	}

	/**
	 * Method to order fields 
	 *
	 * @return void 
	 */
	protected function getSortFields()
	{
		return array(
			'a.`id`' => JText::_('JGRID_HEADING_ID'),
			'a.`field_name`' => JText::_('COM_REPORT_USERFIELDS_FIELD_NAME'),
			'a.`ordering`' => JText::_('JGRID_HEADING_ORDERING'),
			'a.`state`' => JText::_('JSTATUS'),
		);
	}

    /**
     * Check if state is set
     *
     * @param   mixed  $state  State
     *
     * @return bool
     */
    public function getState($state)
    {
        return isset($this->state->{$state}) ? $this->state->{$state} : false;
	}

}
