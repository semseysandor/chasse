<?php
use CRM_Chasse_ExtensionUtil as E;

class CRM_Chasse_Page_Summary extends CRM_Core_Page {

  public function run() {

    if (!CRM_Core_Permission::check('access CiviMail')) {
      CRM_Core_Error::statusBounce(ts('You do not have permission to view this page.'));
    }
    CRM_Utils_System::setTitle(E::ts('Journey Summary'));

    $journeys_all=Civi::settings()->get('chasse_config');

    if (is_null($journeys_all)) {
      $this->assign('no_journeys',true);
      parent::run();
      return;
    }


    foreach ($journeys_all['journeys'] as $journey)
    {
      $name=$journey['name'];
      $id=$journey['id'];
      $steps=$journey['steps'];
      foreach ($steps as $step) {
        $journeys[]=[
          'id' => $id,
          'name' => $name,
          'code' => $step['code'],
          'msg_template_id' => $step['send_mailing'],
        ];
      }
    }



    $this->assign('journeys',$journeys);
    parent::run();
  }

}
