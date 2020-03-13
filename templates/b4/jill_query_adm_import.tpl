<link href="<{$xoops_url}>/modules/tadtools/css/font-awesome/css/font-awesome.css" rel="stylesheet">
<div class="container-fluid">

  <h2><{$smarty.const._MA_JILLQUERY_IMPORT_TITLE}></h2>

  <div class="alert alert-info">
    <ol>
      <li><{$smarty.const._MA_JILLQUERY_IMPORT_NOTE1}></li>
      <li><{$smarty.const._MA_JILLQUERY_IMPORT_NOTE2}></li>
      <li><{$smarty.const._MA_JILLQUERY_IMPORT_NOTE3}></li>
      <li><{$smarty.const._MA_JILLQUERY_IMPORT_NOTE4}></li>
      <li><{$smarty.const._MA_JILLQUERY_IMPORT_NOTE5}></li>
      <li><{$smarty.const._MA_JILLQUERY_IMPORT_NOTE6}></li>
      <li><{$smarty.const._MA_JILLQUERY_IMPORT_NOTE7}></li>
    </ol>
  </div>

    <form action="<{$action}>" method="post" id="myForm"  role="form" enctype="multipart/form-data">
      <div class="form-group row">
        <label class="col-sm-6">
          <input type='file' name="excel" id="excel" style="width: 100%;" placeholder="<{$smarty.const._MD_JILLQUERY_DATAMANAGEMENT}>">
        </label>
        <div class="col-sm-6">
          <input type="hidden" name="op" value="import_excel">
          <button type="submit" class="btn btn-primary"><{$smarty.const._MD_JILLQUERY_DATAMANAGEMENT}></button>
        </div>
      </div>
    </form>
</div>