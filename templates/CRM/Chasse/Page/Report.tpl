{if !$no_mailing}
<fieldset>
  <legend>{ts}Delivery Summary{/ts}</legend>
    <table class="crm-info-panel">
      <tr>
        <td class="label">{ts}Intended Recipients{/ts}</td>
        <td>{$report_total.queue}</td>
      </tr>
      <tr>
        <td class="label">{ts}Successful Deliveries{/ts}</td>
        <td>{$report_total.delivered} ({$report_total.delivered_rate|string_format:"%0.2f"}%)</td>
      </tr>
      <tr>
        <td class="label">{ts}Unique Opens{/ts}</td>
        <td>{$report_total.opened} ({$report_total.opened_rate|string_format:"%0.2f"}%)</td>
      </tr>
      <tr>
        <td class="label">{ts}Total Opens{/ts}</td>
        <td>{$report_total.total_opened}</td>
      </tr>
      <tr>
        <td class="label">{ts}Click-throughs{/ts}</td>
        <td>{$report_total.clicks} ({$report_total.clickthrough_rate|string_format:"%0.2f"}%)</td>
      </tr>
      <tr>
        <td class="label">{ts}Forwards{/ts}</td>
        <td>{$report_total.forward}</td>
      </tr>
      <tr>
        <td class="label">{ts}Replies{/ts}</td>
        <td>{$report_total.reply}</td>
      </tr>
      <tr>
        <td class="label">{ts}Bounces{/ts}</td>
        <td>{$report_total.bounce} ({$report_total.bounce_rate|string_format:"%0.2f"}%)</td>
      </tr>
      <tr>
        <td class="label">{ts}Unsubscribe Requests{/ts}</td>
        <td>{$report_total.unsubscribe} ({$report_total.unsubscribe_rate|string_format:"%0.2f"}%)</td>
      </tr>
      <tr>
        <td class="label">{ts}Opt-out Requests{/ts}</td>
        <td>{$report_total.optout} ({$report_total.optout_rate|string_format:"%0.2f"}%)</td>
      </tr>
    </table>
</fieldset>



{else}
  <div class="messages status no-popup">No mailing</div>


{/if}
