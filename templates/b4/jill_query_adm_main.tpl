<!-- <link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet"> -->
<div class="container-fluid">

  <!--顯示表單-->
  <{if $now_op=="jill_query_form"}>
    <script type="text/javascript" src="<{$xoops_url}>/modules/tadtools/My97DatePicker/WdatePicker.js"></script>
      <!--套用formValidator驗證機制-->
      <{$formValidator_code}>
      <form action="<{$action}>" method="post" id="myForm" role="form" style="margin-bottom: 30px;">
        <!--名稱-->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLQUERY_TITLE}>
          </label>
          <div class="col-sm-10">
            <input type="text" name="title" id="title" class="form-control validate[required]" value="<{$title}>" placeholder="<{$smarty.const._MA_JILLQUERY_TITLE}>">
          </div>
        </div>

        <!--說明-->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLQUERY_DIRECTIONS}>
          </label>
          <div class="col-sm-10">
            <{$directions_editor}>
          </div>
        </div>

        <!--承辦人Email-->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLQUERY_EDITOREMAIL}>
          </label>
          <div class="col-sm-10">
            <textarea name="editorEmail" id="editorEmail" class="form-control" placeholder="<{$smarty.const._MA_JILLQUERY_EDITOREMAIL_INFO}>" rows="3"><{$editorEmail}></textarea>
          </div>
        </div>

        <!--是否啟用-->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLQUERY_ISENABLE}>
          </label>
          <div class="col-sm-10">
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="isEnable" id="isEnable_1" value="1" <{if $isEnable == "1"}>checked="checked"<{/if}>>
              <label class="form-check-label" for="isEnable_1"><{$smarty.const._YES}></label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio"  name="isEnable" id="isEnable_0" value="0" <{if $isEnable == "0"}>checked="checked"<{/if}>>
              <label class="form-check-label" for="isEnable_0"><{$smarty.const._NO}></label>
            </div>
          </div>
        </div>
        <!--密碼-->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLQUERY_PASSWD}>
          </label>
          <div class="col-sm-10">
            <input type="text" name="passwd" id="passwd" class="form-control" value="<{$passwd}>" placeholder="<{$smarty.const._MA_JILLQUERY_PASSWD}>">
          </div>
        </div>
        <!--是否公開-->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLQUERY_ISPUBLIC_DESC}>
          </label>
          <div class="col-sm-10">
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="ispublic" id="ispublic_1" value="1" <{if $ispublic == "1"}>checked="checked"<{/if}>>
                <label class="form-check-label" for="ispublic_1"><{$smarty.const._YES}></label>
              </div>
              <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="ispublic" id="ispublic_0" value="0" <{if $ispublic == "0"  || $ispublic == ""}>checked="checked"<{/if}>>
                <label class="form-check-label" for="ispublic_0"><{$smarty.const._NO}></label>
              </div>
          </div>
        </div>

        <!--可讀取群組-->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLQUERY_READ_GROUP}>
          </label>
          <div class="col-sm-10">
            <select name="read_group[]" class="form-control" size='10' multiple>
              <{foreach from=$all_group key=r item=read}>
                <option value=<{$r}> <{if $r|in_array:$read_group}>selected<{/if}> >
                  <{$read}>
                </option>
              <{/foreach}>
            </select>
          </div>
        </div>

        <!--瀏覽人數-->
        <div class="form-group row">
          <label class="col-sm-2 col-form-label text-md-right">
            <{$smarty.const._MA_JILLQUERY_COUNTER}>
          </label>
          <label class="col-sm-10 col-form-label">
            <{$counter}>
          </label>
        </div>

        <div class="text-center">

          <!--開設者帳號-->
          <input type='hidden' name="uid" value="<{$uid}>">
          <input type='hidden' name="qsn" value="<{$qsn}>">
          <{$token_form}>

          <input type="hidden" name="op" value="<{$next_op}>">
          <button type="submit" class="btn btn-primary" ><{$smarty.const._TAD_SAVE}></button>
          <{if $next_op=="update_jill_query"}>
            <a href="<{$xoops_url}>/modules/jill_query/admin/setcol.php?qsn=<{$qsn}>" class="btn btn-success pull-right"><{$smarty.const._MA_JILLQUERY_SETCOL}></a>
            <a href="<{$xoops_url}>/modules/jill_query/admin/setsearch.php?qsn=<{$qsn}>" class="btn btn-info pull-right"><{$smarty.const._MA_JILLQUERY_SETSEARCH}></a>
          <{/if}>
        </div>
      </form>
  <{/if}>

  <!--顯示某一筆資料-->
  <{if $now_op=="show_one_jill_query"}>
    <{if $isAdmin}>
      <{$delete_jill_query_func}>
    <{/if}>
    <h2 class="text-center"><{$title}></h2>


    <!--說明-->
    <div class="row">
      <label class="col-sm-3 text-right">
        <{$smarty.const._MA_JILLQUERY_DIRECTIONS}>
      </label>
      <div class="col-sm-9">

        <div class="card card-body bg-light m-1">
          <{$directions}>
        </div>
      </div>
    </div>

    <!--承辦人Email-->
    <div class="row">
      <label class="col-sm-3 text-right">
        <{$smarty.const._MA_JILLQUERY_EDITOREMAIL}>
      </label>
      <div class="col-sm-9">
        <{$editorEmail}>
      </div>
    </div>

    <!--備註-->
    <div class="row">
      <label class="col-sm-3 text-right">
        <{$smarty.const._MA_JILLQUERY_COUNTER}>
      </label>
      <div class="col-sm-9">

        <div class="card card-body bg-light m-1">
          <{$counter}>
        </div>
      </div>
    </div>

    <!--開設者帳號-->
    <div class="row">
      <label class="col-sm-3 text-right">
        <{$smarty.const._MA_JILLQUERY_UID}>
      </label>
      <div class="col-sm-9">
        <{$uid_name}>
      </div>
    </div>

    <div class="text-right">
      <{if $isAdmin}>
        <a href="javascript:delete_jill_query_func(<{$qsn}>);" class="btn btn-danger"><{$smarty.const._TAD_DEL}></a>
        <a href="<{$xoops_url}>/modules/jill_query/admin/main.php?op=jill_query_form&qsn=<{$qsn}>" class="btn btn-warning"><{$smarty.const._TAD_EDIT}></a>
        <a href="<{$xoops_url}>/modules/jill_query/admin/main.php?op=jill_query_form" class="btn btn-primary"><{$smarty.const._MA_JILLQUERY_ADD}></a>
      <{/if}>
      <a href="<{$action}>" class="btn btn-success"><{$smarty.const._TAD_HOME}></a>
    </div>
  <{/if}>

  <!--列出所有資料-->

  <{if $now_op=="list_jill_query"}>
    <{if $all_content}>
      <{if $isAdmin}>
        <{$delete_jill_query_func}>

      <{/if}>

      <table class="table table-striped table-hover">
        <thead>
          <tr>

            <th>
              <!--名稱--><!--資料數-->
              <{$smarty.const._MA_JILLQUERY_TITLE}>(<{$smarty.const._MA_JILLQUERY_AMOUNT}>)
            </th>
            <th>
              <{$smarty.const._MA_JILLQUERY_READ_GROUP}>
            </th>
            <th>
              <!--密碼-->
              <{$smarty.const._MA_JILLQUERY_PASSWD}>
            </th>
            <th>
              <!--承辦人Email-->
              <{$smarty.const._MA_JILLQUERY_EDITOREMAIL}>
            </th>
            <th>
              <!--是否啟用-->
              <{$smarty.const._MA_JILLQUERY_ISENABLE}>
            </th>
            <th>
              <!--是否公開-->
              <{$smarty.const._MA_JILLQUERY_ISPUBLIC}>
            </th>
            <{if $isAdmin}>
              <th><{$smarty.const._TAD_FUNCTION}></th>
            <{/if}>
          </tr>
        </thead>

        <tbody id="jill_query_sort">
          <{foreach from=$all_content item=data}>
            <tr id="tr_<{$data.qsn}>">

              <td>
                <!--名稱--><!--資料數-->
                <a href="../index.php?qsn=<{$data.qsn}>"><{$data.title}></a>(<a href="../excel.php?qsn=<{$data.qsn}>"><{$data.total}></a>)
              </td>

              <td style="text-align: right;">
                <{$data.read_group_name}>
              </td>
              <td style="text-align: right;">
                <!--密碼-->
                <{$data.passwd}>
              </td>
              <td>
                <!--承辦人Email-->
                <{$data.editorEmail}>
              </td>

              <td>
                <!--是否啟用-->
                <{$data.isEnable}>
              </td>
              <td>
                <!--是否公開-->
                <{$data.ispublic}>
              </td>
              <{if $isAdmin}>
                <td>
                  <a href="javascript:delete_jill_query_func(<{$data.qsn}>);" class="btn btn-sm btn-danger"><{$smarty.const._TAD_DEL}></a>
                  <a href="<{$xoops_url}>/modules/jill_query/admin/main.php?op=jill_query_form&qsn=<{$data.qsn}>" class="btn btn-sm btn-warning"><{$smarty.const._TAD_EDIT}></a>
                  <a href="<{$xoops_url}>/modules/jill_query/admin/setcol.php?qsn=<{$data.qsn}>" class="btn btn-sm btn-success"><{$smarty.const._MA_JILLQUERY_SETCOL}></a>
                  <a href="<{$xoops_url}>/modules/jill_query/admin/setsearch.php?qsn=<{$data.qsn}>" class="btn btn-sm btn-info"><{$smarty.const._MA_JILLQUERY_SETSEARCH}></a>
                  <{ if $data.cols!=''}>
                    <a href="<{$xoops_url}>/modules/jill_query/admin/main.php?op=copy_cols&qsn=<{$data.qsn}>" class="btn btn-sm btn-primary"><{$smarty.const._MA_JILLQUERY_COPY}></a>
                    <a href="<{$xoops_url}>/modules/jill_query/admin/export.php?qsn=<{$data.qsn}>" class="btn btn-sm btn-secondary"><{$smarty.const._MA_JILLQUERY_EXPORT}></a>
                  <{/if}>
                </td>
              <{/if}>
            </tr>
          <{/foreach}>
        </tbody>
      </table>


      <{if $isAdmin}>
        <div class="text-right">
          <a href="<{$xoops_url}>/modules/jill_query/admin/main.php?op=jill_query_form" class="btn btn-primary"><{$smarty.const._MA_JILLQUERY_ADD}></a>
        </div>
      <{/if}>

      <{$bar}>
    <{else}>
      <{if $isAdmin}>
        <div class="jumbotron text-center">
          <a href="<{$xoops_url}>/modules/jill_query/admin/main.php?op=jill_query_form" class="btn btn-info"><{$smarty.const._MA_JILLQUERY_ADD}></a>
        </div>
      <{/if}>
    <{/if}>
  <{/if}>

</div>