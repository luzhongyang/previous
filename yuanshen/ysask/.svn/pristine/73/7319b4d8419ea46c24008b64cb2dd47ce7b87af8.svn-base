<?php
namespace Common\Model;
use Think\Model;

class QuestioninvitationModel extends CommonModel{

	protected $pk = 'id';
    protected $tableName = 'question_invitation';

    public function invitations($question_id)
    {
    	if($question_id = (int)$question_id) {
	    	$sql = "SELECT * FROM `__QUESTION_INVITATION__` WHERE `__QUESTION_INVITATION__`.`question_id` = '$question_id' AND `__QUESTION_INVITATION__`.`question_id` IS NOT NULL AND `invitee_id` > '0' GROUP BY `invitee_id` ORDER BY `created_time` DESC LIMIT 3";
	    	return $this->query($sql);
    	}
    }


    public function items2($question_id)
    {
    	if($question_id = (int)$question_id) {
    		$sql = "SELECT * FROM `__TABLE__` WHERE `question_id`='$question_id'";
    		return $this->query($sql);
    	}
    }
}