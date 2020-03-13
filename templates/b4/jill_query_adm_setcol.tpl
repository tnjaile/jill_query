<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet">
<div class="container-fluid">
<a href="../index.php?qsn=<{$qsn}>"><h2><{$queryArr.title}></h2></a>
  <{if $now_op=="list_col"}>
    <{$jill_query_col_jquery_ui}>
    <{$formValidator_code}>
    <!-- <{$jeditable_set}> -->
    <{$delete_jill_query_col_func}>
    <script type='text/javascript'>
      $(document).ready(function(){
        $('#sort').sortable({ opacity: 0.6, cursor: 'move', update: function() {
            var order = $(this).sortable('serialize');
            $.post('save_sort.php', order, function(theResponse){
                $('#save_msg').html(theResponse);
            });
          }
        });
      });
      function change_enable(qcsn,name){
        $.post('change_enable.php',{qcsn:qcsn, name:name}, function(data) {
          console.log(data);
          $('#'+qcsn+'_'+name).attr('src',data);
        });
      }
    </script>

    <div id="save_msg"></div>
    <form action="<{$action}>" method="post" id="myForm" enctype="multipart/form-data"  role="form">
        <table class="table table-striped table-hover table-bordered">
          <thead>
            <tr>
              <th style="text-align: center; vertical-align: middle;">
                <!--標題-->
                <{$smarty.const._MA_JILLQUERY_QC_TITLE}>
              </th>
              <th  style="text-align: center;">
                <!--搜尋欄位-->
                <{$smarty.const._MA_JILLQUERY_QCSNSEARCH}>
              </th>
              <th  style="text-align: center;">
                <!--顯示欄位-->
                <{$smarty.const._MA_JILLQUERY_ISSHOW}>
              </th>
              <th  style="text-align: center;">
                <!--顯示欄位-->
                <{$smarty.const._MA_JILLQUERY_ISLIKE}>
              </th>
              <th  style="text-align: center; vertical-align: middle;">
                <{$smarty.const._TAD_FUNCTION}>
              </th>
            </tr>
          </thead>
          <tbody id="sort">
            <{if $all_content}>
              <{foreach from=$all_content item=data}>
                <tr id='tr_<{$data.qcsn}>'>
                  <td style="text-align: center;">
                    <!--標題-->
                    <div id="qc_title_<{$data.qcsn}>"><{$data.qc_title}></div>
                  </td>
                  <td style="text-align: center;">
                    <{$data.qcsnSearch}>
                  </td>
                  <td style="text-align: center;">
                    <{$data.isShow}>
                  </td>
                  <td style="text-align: center;">
                    <{$data.isLike}>
                  </td>
                  <td style="text-align: center;">
                    <img src='<{$xoops_url}>/modules/tadtools/treeTable/images/updown_s.png' style='cursor: s-resize;margin:0px 4px;' alt='<{$smarty.const._TAD_SORTABLE}>' title='<{$smarty.const._TAD_SORTABLE}>'>
                    <{if $data.qcinfo==""}>
                      <a href="javascript:delete_jill_query_col_func(<{$data.qcsn}>);" class="btn btn-xs btn-danger"><{$smarty.const._TAD_DEL}></a>
                    <{/if}>
                  </td>
                </tr>
              <{/foreach}>
            <{/if}>
          </tbody>
          <tr>
            <td>
              <input type="text" name="qc_title" id="qc_title" class="form-control validate[required] " value="<{$qc_title}>" placeholder="<{$smarty.const._MA_JILLQUERY_QC_TITLE}>">
            </td>
            <td style="text-align: center;">
              <input type="checkbox" name="qcsnSearch" class="form-control" value="1" >
            </td>
            <td style="text-align: center;">
              <input type="checkbox" name="isShow" class="form-control" value="1" >
            </td>
            <td>
              <input type="hidden" name="qsn" value="<{$qsn}>">
              <input type="hidden" name="op" value="insert_col">
              <button type="submit" class="btn btn-primary"><{$smarty.const._MA_JILLQUERY_ADDCOL}></button>
            </td>
          </tr>
        </table>
    </form>
  <{/if}>
  <div class="row" style="text-align:right;">
    <div class="col-sm-12">
      <a href="<{$xoops_url}>/modules/jill_query/admin/setsearch.php?qsn=<{$data.qsn}>" class="btn btn-info" ><{$smarty.const._MA_JILLQUERY_SETSEARCH}></a>
      <a href="<{$xoops_url}>/modules/jill_query/admin/main.php" class="btn btn-primary" ><{$smarty.const._MA_JILLQUERY__MAIN}></a>
    </div>
  </div>
</div>