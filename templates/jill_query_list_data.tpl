<table class="table table-striped table-hover table-bordered table-condensed">
  <thead>
    <tr class="info">
      <th><{$smarty.const._MD_JILLQUERY_ROW}></th>
      <{foreach from=$title_arr key=qcsn item=t}>
        <th style="text-align: center;">
          <!--編號-->
          <{$t.qc_title}>
        </th>
      <{/foreach}>
    </tr>
  </thead>
  <tbody id="jill_query_col_sort">
    <{foreach from=$all_content key=ssn item=data}>
      <tr id="tr_<{$ssn}>">
        <td><{$data.qrSort}></td>
      <{foreach from=$data.col_data key=qcsn item=val}>
        <td id="<{$ssn}>-<{$qcsn}>" class="jq_data"><{$val}></td>
      <{/foreach}>
      </tr>
    <{/foreach}>
  </tbody>
</table>
