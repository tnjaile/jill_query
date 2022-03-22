<{$toolbar}>

<!--列出所有資料-->
<{if $now_op=="list_data"}>
    <h2><a href="<{$xoops_url}>/modules/jill_query/index.php"><i class="fa fa-reply"></i> <{$query_arr.title}></a></h2>
    <hr>
    <h2><{$smarty.const._MD_JILLQUERY_STEP}> 1<{$smarty.const._TAD_FOR}>
    <a href="excel_sample.php?qsn=<{$qsn}>">
      <{$smarty.const._MD_JILLQUERY_SAMPLE}></i>
    </a>
    </h2>

    <h2><{$smarty.const._MD_JILLQUERY_STEP}> 2<{$smarty.const._TAD_FOR}><{$smarty.const._MD_JILLQUERY_STEP2}></h2>
    <div class="row">
      <div class="col-sm-8">
        <div class="alert alert-info">
          <form action="<{$action}>" method="post" id="myForm" class="form-horizontal" role="form" enctype="multipart/form-data">
            <div class="form-group">
              <label class="col-sm-12 control-label">
                <input type='file' name="excel" id="excel" style="width: 100%;" placeholder="<{$smarty.const._MD_JILLQUERY_DATAMANAGEMENT}>">
              </label>
            </div>
            <div class="form-group">
              <div class="col-sm-9">
                <div >
                  <label class="radio-inline">
                    <input type="radio" name="continue_no" value="0" checked="checked"><{$smarty.const._MD_CONTINUE_NO}>
                  </label>

                  <label class="radio-inline">
                    <input type="radio" name="continue_no" value="on"><{$smarty.const._MD_CONTINUE}>
                  </label>
                </div>
              </div>
              <div class="col-sm-3">
                <input type="hidden" name="op" value="import_excel">
                <input type="hidden" name="qsn"  value="<{$qsn}>">
                <button type="submit" class="btn btn-primary btn-block"><{$smarty.const._MD_JILLQUERY_DATAMANAGEMENT}></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <{if $all_content}>
      <{$jill_query_col_value_jquery_ui}>
      <{$jeditable_set}>
      <{$delete_jill_query_col_value_func}>
      <{$formValidator_code}>
      <h3><{$total}></h3>
      <hr>

      <{if $isAdmin || $iseditAdm}>
        <div class="row"  style="margin-bottom:10px;">
          <div class="col-sm-6">
            <form action="<{$action}>" method="POST" id="searchform" class="form-inline"  role="form">
                <div class="form-group">
                  <div class="col-sm-4">
                    <select name="qcsn" id="qc_title" class="form-control validate[required]">
                      <option value=""><{$smarty.const._MD_JILLQUERY_QCTITLESEARCH}></option>
                      <{foreach from=$title_arr key=qcsn item=t}>
                        <option value="<{$qcsn}>"><{$t.qc_title}></option>
                      <{/foreach}>
                    </select>
                  </div>
                  <div class="col-sm-8">
                    <input type="text" id="keyword" name="keyword" class="form-control validate[condRequired[qc_title],required]"   placeholder="<{$smarty.const._MD_JILLQUERY_KEYWORD}>" value="">
                    <input type="submit" name="send" value="<{$smarty.const._MD_JILLQUERY_SEARCH}>" class="btn btn-primary" />
                    <input type="hidden" name="qsn"  value="<{$qsn}>">
                    <input type="hidden" name="next_op"  value="show_search">
                  </div>
                </div>
            </form>
          </div>
          <{if $next_op=="show_search"}>
            <div class="col-sm-2">
              <a href="<{$action}>?qsn=<{$qsn}>" class="btn btn-link"><i class="fa fa-search" aria-hidden="true"></i> <{$smarty.const._MD_JILLQUERY_BACKSEARCH}></a>
            </div>
          <{/if}>
          <{if $isAdmin}>
            <div class="text-right">
              <a href="<{$xoops_url}>/modules/jill_query/admin/setcol.php?qsn=<{$qsn}>" class="btn btn-success btn-sm"><{$smarty.const._MD_JILLQUERY_SETCOL}></a>
              <a href="<{$xoops_url}>/modules/jill_query/admin/setsearch.php?qsn=<{$qsn}>" class="btn btn-info btn-sm"><{$smarty.const._MD_JILLQUERY_SETSEARCH}></a>
              <a href="<{$xoops_url}>/modules/jill_query/admin/main.php?op=jill_query_form&qsn=<{$qsn}>" class="btn btn-warning btn-sm"><{$smarty.const._TAD_EDIT}></a>
            </div>
          <{/if}>
        </div>
      <{/if}>
      <{includeq file="$xoops_rootpath/modules/jill_query/templates/jill_query_list_data.tpl"}>
      <{$bar}>
    <{else}>
      <div class="jumbotron">
        <h2><a href="<{$action}>?qsn=<{$qsn}>"><{$smarty.const._MD_JILLQUERY_NODATA}><{$smarty.const._MD_JILLQUERY_BACKSEARCH}></a></h2>
      </div>
    <{/if}>

<{/if}>
