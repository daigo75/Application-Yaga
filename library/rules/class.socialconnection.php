<?php if(!defined('APPLICATION')) exit();

/**
 * This rule awards badges when the user connects social accounts
 *
 * @author Zachary Doll
 * @since 1.0
 * @package Yaga
 */
class SocialConnection implements YagaRule{

  public function Award($Sender, $User, $Criteria) {
    $Network = $Sender->EventArguments['Provider'];

    if($Network == $Criteria->SocialNetwork) {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  public function Form($Form) {
    $SocialNetworks = array(
        'Twitter' => 'Twitter',
        'Facebook' => 'Facebook'
    );

    $String = $Form->Label('Social Networks', 'SocialConnection');
    $String .= T('User has connected to: ');
    $String .= $Form->DropDown('SocialNetwork', $SocialNetworks);

    return $String;
  }

  public function Validate($Criteria, $Form) {
    $Validation = new Gdn_Validation();
    $Validation->ApplyRules(array(
        array(
          'Name' => 'SocialNetwork', 'Validation' => array('Required')
        )
    ));
    $Validation->Validate($Criteria);
    $Form->SetValidationResults($Validation->Results());
  }

  public function Hooks() {
    return array('Base_AfterConnection');
  }

  public function Description() {
    $Description = T('Yaga.Rules.SocialConnection.Desc');
    return Wrap($Description, 'div', array('class' => 'InfoMessage'));
  }

  public function Name() {
    return T('Yaga.Rules.SocialConnection');
  }
}
