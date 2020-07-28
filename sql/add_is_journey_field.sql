ALTER TABLE `civicrm_mailing`
    ADD
        `is_journey` TINYINT NULL DEFAULT NULL COMMENT 'Is this a journey email?' AFTER `is_archived`;
