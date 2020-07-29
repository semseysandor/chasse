<?php

use CRM_Chasse_ExtensionUtil as E;

class CRM_Chasse_Page_Report extends CRM_Core_Page
{

  public function run()
  {
    $total=[];
    // Example: Set the page-title dynamically; alternatively, declare a static title in xml/Menu/*.xml
    CRM_Utils_System::setTitle(E::ts('Journey Report'));

    $msg_template_id = CRM_Utils_Request::retrieve('msg_template_id', 'Positive');
    $result = civicrm_api3(
      'Mailing',
      'get',
      [
        'sequential' => 1,
        'return' => ["id"],
        'msg_template_id' => $msg_template_id,
      ]
    );

    if ($result['count'] <= 0) {
      $this->assign('mailing',false);
      parent::run();
      return;
    }

    $mailing_ids=$result['values'];

    $report_fields_sum=['queue','delivered','url','forward','reply','unsubscribe','optout','opened','total_opened','bounce'];
    $report_fields_ave=['delivered_rate','bounce_rate','unsubscribe_rate','optout_rate','clickthrough_rate'];


    foreach ($report_fields_sum as $item) {
      $total[$item]=0;
    }
    foreach ($report_fields_ave as $item) {
      $total[$item]=0;
    }
    $total['clicks']=0;

    foreach ($mailing_ids as $mailing) {
      $report = CRM_Mailing_BAO_Mailing::report($mailing['id']);

      foreach ($report['event_totals'] as $param => $value) {
        if (in_array($param,$report_fields_sum)) {

          $total[$param] += $value;

        }


      }

      $clicks=(int)$report['event_totals']['clickthrough_rate']*$report['event_totals']['delivered'];
      $total['clicks']+=$clicks;
    }

    if ($total['queue'] == 0) {
      foreach ($report_fields_ave as $item) {
        $total[$item]=0;
      }
    } else {
      $total['delivered_rate']=$total['delivered']/$total['queue'];
      $total['bounce_rate']=$total['bounce']/$total['queue'];
      $total['unsubscribe_rate']=$total['unsubscribe']/$total['queue'];
      $total['optout_rate']=$total['optout']/$total['queue'];
      $total['clickthrough_rate']=$total['clicks']/$total['queue'];
    }


    $this->assign('report_total',$total);
   parent::run();
  }

}
