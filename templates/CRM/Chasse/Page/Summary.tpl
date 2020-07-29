{if !$no_journeys}
  <h3>Journey Summary</h3>
  <table class="selector row-highlight">
    <thead class="sticky">
    <th>Journey</th>
    <th>Step Code</th>
    <th>Mailing Name</th>
    <th>Subject</th>
    <th>From</th>
    <th>Reply To</th>
    <th>Action</th>
    </thead>
    <tbody>
    {foreach from=$journeys item="journey"}
      <tr class="{cycle values="odd-row,even-row"} crm-mailing">
        <td>{$journey.name}</td>
        <td>{$journey.code}</td>
        <td>{$journey.mailing_name}</td>
        <td>{$journey.mailing_subject}</td>
        <td>{$journey.mailing_from_name} &lt{$journey.mailing_from}&gt</td>
        <td>{$journey.mailing_replyto}</td>
        <td>
          <a href={crmURL p='civicrm/chasse/report' q="msg_template_id="}{$journey.msg_template_id} title="Show report">
          Report
          </a>
        </td>
      </tr>
    {/foreach}
    </tbody>
  </table>
{else}
  <div class="messages status no-popup">No journeys could be found</div>
{/if}
