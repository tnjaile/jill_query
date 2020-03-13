<{$toolbar}>
<!--列出所有資料-->
<{if $now_op=="list_jill_query"}>
  <{if $all_content}>
    <{foreach from=$all_content item=data}>
      <div class="row">
        <div class="col-sm-12" >
          <div style="margin: 10px 0px;">
            <h3>
              <a class="btn btn-info" href="<{$action}>?qsn=<{$data.qsn}>">
                <i class="fa fa-search fa-lg fa-flip-horizontal" aria-hidden="true"></i>
              </a>
              <a href="<{$action}>?qsn=<{$data.qsn}>"><{$data.title}></a>
            </h3>
          </div>
        </div>
        <hr>
      </div>
    <{/foreach}>

    <{else}>
      <div class="jumbotron">
        <h2><{$smarty.const._MD_NOFORM}></h2>
      </div>
  <{/if}>
<{elseif $now_op=="public_query"}>
  <a name="public_query" href="<{$xoops_url}>/modules/jill_query/index.php?qsn=<{$smarty.get.qsn}>" ><{$smarty.const._MD_JILLQUERY_PUBLICQUERY}><{$query_arr.title}></a>
  <div class="row">
    <div class="col-sm-12">
      <form action="index.php" method="post" id="myForm"  class="form-horizontal" role="form">
        <div class="form-group">
          <div class="col-sm-6">
            <select class="form-control" name="public_qsn">
              <{$option_menu}>
            </select>
          </div>
          <div class="col-sm-2">
            <button type="submit" class="btn btn-primary">
            <{$smarty.const._MD_JILLQUERY_SEARCH}></button>
            <input type="hidden" name="op" value="public_query">
          </div>
        </div>
      </form>
    </div>
  </div>
  <{if $all_content}>
    <{includeq file="$xoops_rootpath/modules/jill_query/templates/jill_query_list_data.tpl"}>
      <{$bar}>
  <{/if}>
<{else}>
  <{if $all_col}>
    <{$formValidator_code}>

    <h2>

      <a name="result" href="<{$xoops_url}>/modules/jill_query/index.php" ><i class="fa fa-reply" style="filter:alpha(opacity=30);-moz-opacity:0.3;opacity: 0.3;"></i> <{$query_arr.title}></a>

      <{if $query_arr.ispublic=="1" || $iseditAdm || $isAdmin}>
        <div class="text-right">
          <{if $iseditAdm}>
            <a href='excel.php?qsn=<{$qsn}>' class='btn btn-danger btn-sm'><{$smarty.const._MD_JILLQUERY_DATAMANAGEMENT }></a>
          <{/if}>

          <{if $query_arr.ispublic=="1"}>
            <a href="<{$xoops_url}>/modules/jill_query/index.php?op=public_query&qsn=<{$qsn}>" class="btn btn-primary btn-sm"><{$smarty.const._MD_JILLQUERY_PUBLIC}></a>
          <{/if}>

          <{if $isAdmin}>
            <a href="<{$xoops_url}>/modules/jill_query/admin/setcol.php?qsn=<{$qsn}>" class="btn btn-success btn-sm"><{$smarty.const._MD_JILLQUERY_SETCOL}></a>
            <a href="<{$xoops_url}>/modules/jill_query/admin/setsearch.php?qsn=<{$qsn}>" class="btn btn-info btn-sm"><{$smarty.const._MD_JILLQUERY_SETSEARCH}></a>
            <a href="<{$xoops_url}>/modules/jill_query/admin/main.php?op=jill_query_form&qsn=<{$qsn}>" class="btn btn-warning btn-sm"><{$smarty.const._TAD_EDIT}></a>
          <{/if}>
        </div>
      <{/if}>

    </h2>

    <{if $query_arr.directions}>
      <div class="alert alert-success">
        <{$query_arr.directions}>
      </div>
    <{/if}>
    <{if $all_col}>
      <div class="alert alert-info">
        <form action="index.php#result" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal"  role="form">
          <{includeq file="$xoops_rootpath/modules/jill_query/templates/jill_query_form.tpl"}>
        </form>
      </div>
    <{/if}>
  <{else}>
    <div class="jumbotron">
      <h2><{$smarty.const._MD_JILLQUERY_EMPTY_SEARCH}></h2>
    </div>
  <{/if}>

  <{if $now_op=="show_result"}>
    <{if $all_content}>
      <h3><{$smarty.const._MD_JILLQUERY_RESULT}><small><{$total}></small></h3>

      <table class="table table-striped table-hover table-condensed">
        <thead>
          <tr class="info">
            <th><{$smarty.const._MD_JILLQUERY_ROW}></th>
            <{foreach from=$title_show_arr key=qcsn item=t}>
              <th>
                <!--編號-->
                <{$t.qc_title}>
              </th>
             <{/foreach}>
          </tr>
        </thead>
        <tbody>
          <{foreach from=$all_content key=ssn item=data name=col}>
              <tr id="tr_<{$ssn}>">
                <td><{$smarty.foreach.col.index+1}></td>
            <{section name=value loop=$data}>
              <td><{$data[value]}></td>
            <{/section}>
              </tr>
          <{/foreach}>
        </tbody>
      </table>

    <{else}>
      <div class="jumbotron">
        <h2><{$smarty.const._MD_JILLQUERY_NODATA}></h2>
      </div>
    <{/if}>
  <{/if}>
<{/if}>