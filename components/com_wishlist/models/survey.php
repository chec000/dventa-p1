<?php
defined('_JEXEC') or die;

class WishlistModelSurvey extends JModelLegacy
{
    protected $surveyTable = '#__core_survey_questions';

    public function saveSurvey($data){
        $db = JFactory::getDbo();
        $user = JFactory::getUser()->id;
        $surveys = $this->getSurvey();
        if ($user > 0 && is_null($surveys)) {
            $i=1;
            foreach ($data as $item) {
                if ($item != '') {
                    $survey = new stdClass();
                    $survey->user_id = $user;
                    $survey->question = 'q'.$i;
                    $survey->answer = $item;
                    $db->insertObject($this->surveyTable, $survey);
                }
                $i++;
            }
        }
    }

    public function getSurvey(){
        $results = array();
        $user = JFactory::getUser()->id;
        if ($user > 0) {
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query
            ->select(array('s.id'))
            ->from($db->quoteName($this->surveyTable, 's'))
            ->where('s.user_id = ' . $db->Quote($user));

            $db->setQuery($query);

            $results = $db->loadObject();
        }
        return $results;
    }
}