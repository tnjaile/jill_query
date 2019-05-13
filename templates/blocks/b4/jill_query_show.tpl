<{assign var=all_col value=$block.content}>
<{assign var=qsn value=$block.qsn}>
<{assign var=query_arr value=$block.query_arr}>
<a href="<{$xoops_url}>/modules/jill_query/index.php?qsn=<{$qsn}>"><h3><{$query_arr.title}></h3></a>
<div class="alert alert-info">
  <form action="<{$xoops_url}>/modules/jill_query/index.php#result" method="post" id="myForm"   role="form">
  	<{includeq file="$xoops_rootpath/modules/jill_query/templates/b4/jill_query_form.tpl"}>
  </form>
</div>