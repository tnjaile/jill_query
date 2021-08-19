<{foreach from=$all_col item=data}>
  <!--欄位名稱-->
  <div class="form-group row">
    <label class="col-sm-4 col-form-label text-md-right">
      <{$data.qc_title}>
    </label>
    <div class="col-sm-8">
      <input type="text" class="form-control" name="fillValue[<{$data.qcsn}>]" <{if $data.search_operator=="and"}> class="validate[required]" placeholder="<{$smarty.const._MD_REQUIRED}>" <{else}> placeholder="<{$smarty.const._MD_OPTIONAL}>" <{/if}> title='optional'>
      <input type='hidden' name="search_operator[<{$data.qcsn}>]" value="<{$data.search_operator}>">
    </div>
  </div>

<{/foreach}>
<{if $query_arr.passwd}>
  <!--欄位名稱-->
  <div class="form-group row">
    <label class="col-md-4 col-form-label text-md-right" for="passwd"><{$smarty.const._MD_JILLQUERY_PASSWD}></label>
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
