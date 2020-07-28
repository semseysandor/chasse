#!/bin/bash
#
# SCRIPT
#

# CiviCRM module path
CIVI_MODULE="../../modules/civicrm/"

# Core PHP class
git diff ${CIVI_MODULE}/CRM/Mailing/BAO/Mailing.php ./CRM/Mailing/BAO/Mailing.php
echo
echo
git diff ${CIVI_MODULE}/CRM/Mailing/DAO/Mailing.php ./CRM/Mailing/DAO/Mailing.php
echo
echo
git diff ${CIVI_MODULE}/CRM/Mailing/Form/Search.php ./CRM/Mailing/Form/Search.php
echo
echo
git diff ${CIVI_MODULE}/CRM/Mailing/Page/Browse.php ./CRM/Mailing/Page/Browse.php
echo
echo
git diff ${CIVI_MODULE}/CRM/Mailing/Selector/Browse.php./CRM/Mailing/Selector/Browse.php
echo
echo

# Template
git diff ${CIVI_MODULE}/templates/CRM/Mailing/Form/Search.tpl ./templates/CRM/Mailing/Form/Search.tpl
