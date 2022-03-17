<{foreach from=$all_col item=data}>
  <!--欄位名稱-->
  <div class="form-group">
    <label class="col-sm-4 control-label">
      <{$data.qc_title}>
    </label>
    <div class="col-sm-8">
      <{if $query_arr.ispublic==2 && $data.qc_title=='email'}>
        <input class="form-control" type="text" value="<{$email}>" aria-label="email" disabled readonly>
        <input type='hidden' name="fillValue[<{$data.qcsn}>]" value="<{$email}>">
      <{else}>
        <input type="text" class="form-control" name="fillValue[<{$data.qcsn}>]" <{if $data.search_operator=="and"}> class="validate[required]" placeholder="<{$smarty.const._MD_REQUIRED}>" <{else}> placeholder="<{$smarty.const._MD_OPTIONAL}>" <{/if}> title='optional'>
        <input type='hidden' name="search_operator[<{$data.qcsn}>]" value="<{$data.search_operator}>">
      <{/if}>
    </div>
  </div>

<{/foreach}>
<{if $query_arr.passwd}>
  <!--欄位名稱-->
  <div class="form-group">
    <label class="col-md-4 control-label" for="passwd"><{$smarty.const._MD_JILLQUERY_PASSWD}></label>
    <div class="col-md-8">
      <input type="password" name="passwd" id="passwd" placeholder="<{$smarty.const._MD_REQUIRED}>" class="form-control validate[required]">
    </div>
  </div>
<{/if}>
 <!--欄位編號-->
<div class="text-center">
  <input type='hidden' name="qsn" value="<{$qsn}>">
  <input type='hidden' name="op" value="show_result">
  <button type="submit" class="btn btn-primary" ><{$smarty.const._MD_JILLQUERY_SEARCH}></button>
</div>
