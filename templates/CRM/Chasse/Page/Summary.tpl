<h3>Journey Summary</h3>

{if $no_journeys}
  no journeys madafaka!

{else}

<table class="selector row-highlight">
  <thead class="sticky">
    <th>id</th>
    <th>Journey</th>
    <th>Steps</th>
    <th>mailing_id</th>
    <th></th>
  </thead>

  {foreach from=$journeys item="journey"}
    <tr class="{cycle values="odd-row,even-row"} crm-mailing">
      <td class="crm-mailing-status">{$journey.id}</td>
      <td class="crm-mailing-status">{$journey.name}</td>
      <td class="crm-mailing-status">{$journey.code}</td>
      <td class="crm-mailing-status">{$journey.msg_template_id}</td>
      <td>
        <a href ={crmURL p='civicrm/chasse/report' q="msg_template_id="}{$journey.msg_template_id} title="Show report">
        Report
        </a>
      </td>
    </tr>
  {/foreach}
</table>
{/if}
