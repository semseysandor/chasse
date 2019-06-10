<?php
use CRM_Chasse_ExtensionUtil as E;

/**
 * Chasse.Processjourneyschedules API specification (optional)
 * This is used for documentation and validation.
 *
 * @param array $spec description of fields supported by this API call
 * @return void
 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
 */
function _civicrm_api3_chasse_Processjourneyschedules_spec(&$spec) {
}

/**
 * Chasse.Processjourneyschedules API
 *
 * Process any journeys on automatic schedules.
 *
 * @param array $params
 * @return array API result descriptor
 * @see civicrm_api3_create_success
 * @see civicrm_api3_create_error
 * @throws API_Exception
 */
function civicrm_api3_chasse_Processjourneyschedules($params) {

  $chasse_processor = new CRM_Chasse_Processor();
  $journeys_to_run = $chasse_processor->getScheduledJourneys();

  if (!$journeys_to_run) {
    // Nothing to do.
    return civicrm_api3_create_success(['message' => 'Nothing to do'], $params, 'Chasse', 'Processjourneyschedules');
  }

  if (!$chasse_processor->attemptToLock()) {
    // Failed to obtain lock, something is already running.
    // This is OK, not an error, we just try again next time.
    return civicrm_api3_create_success(['message' => 'Chasse already running; could not obtain lock.'], $params, 'Chasse', 'Processjourneyschedules');
  }

  // Lock obtained and journeys to run.

  // Process each journey now.
  $result = ['journeys' => []];
  foreach ($journeys_to_run as $journey_id) {
    $result['journeys'][$journey_id] = $chasse_processor->journey($journey_id);
  }

  // Release lock.
  $chasse_processor->releaseLock();

  return civicrm_api3_create_success($result, $params, 'Chasse', 'Processjourneyschedules');
}