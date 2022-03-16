<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet">
<div class="container-fluid">
  <{if $now_op=="list_searchcol"}>
    <{$jill_query_col_jquery_ui}>
    <{$jeditable_set}>

    <div class="row" style="display: flex;">
      <div class="col-sm-6 bg-danger">
        <h3><{$smarty.const._MA_JILLQUERY_SETCOL_STEP1}></h3>
        <form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data" role="form">
          <div class="radio">
            <label>
              <input type="radio" name="search_operator" id="search_operator_1" value="and" <{if $def_search_operator == "and"}>checked="checked"<{/if}>><{$smarty.const._MA_JILLQUERY__OPERATOR_AND}><strong class="text-danger">(<{$smarty.const._FILL_ALL_FIELDS}>)</strong>
            </label>
          </div>
          <{if $ispublic!=2}>
            <div class="radio">
              <label class="radio-inline">
                <input type="radio" name="search_operator" id="search_operator_2" value="or" <{if $def_search_operator == "or"}>checked="checked"<{/if}>><{$smarty.const._MA_JILLQUERY__OPERATOR_OR}><strong class="text-danger">(<{$smarty.const._FILL_ANY_FIELDS}>)</strong>
              </label>
            </div>
          <{/if}>
          <div class="row" style="text-align: center;">
            <button type="submit" class="btn btn-primary"><{$smarty.const._MA_JILLQUERY_SETSEARCH}></button>
            <input type='hidden' name="qsn" value="<{$qsn}>">
            <input type='hidden' name="ispublic" value="<{$ispublic}>">
            <input type="hidden" name="op" value="update_searchcol">
          </div>
        </form>
      </div>
      <div class="col-sm-6">
        <h3><{$title}><{$smarty.const._MA_JILLQUERY_SETCOL_STEP2}></h3>
        <div class="alert alert-info">
          <{includeq file="$xoops_rootpath/modules/jill_query/templates/jill_query_form.tpl"}>
        </div>
      </div>

    </div>
  <{/if}>
  <div class="row" style="text-align:right;">
    <div class="col-sm-12">
      <a href="<{$xoops_url}>/modules/jill_query/admin/setcol.php?qsn=<{$qsn}>" class="btn btn-success" ><{$smarty.const._MA_JILLQUERY_SETCOL}></a>
      <a href="<{$xoops_url}>/modules/jill_query/admin/main.php" class="btn btn-info" ><{$smarty.const._MA_JILLQUERY__MAIN}></a>
      <a href="<{$xoops_url}>/modules/jill_query/index.php" class="btn btn-info" ><{$smarty.const._MA_JILLQUERY_SMNAME1}></a>
    </div>
  </div>
</div>
