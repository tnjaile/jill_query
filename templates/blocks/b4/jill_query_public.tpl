<{assign var=all_content value=$block.content}>
<{assign var=qsn value=$block.qsn}>
<{assign var=query_arr value=$block.query_arr}>
<{assign var=title_arr value=$block.title_arr}>
<h3><a href="<{$xoops_url}>/modules/jill_query/index.php?op=public_query&qsn=<{$qsn}>"><{$query_arr.title}></a></h3>
<{if $all_content}>
  <{includeq file="$xoops_rootpath/modules/jill_query/templates/b4/jill_query_list_data.tpl"}>
  <div class="text-right">
    [ <a href="<{$xoops_url}>/modules/jill_query/index.php?op=public_query&qsn=<{$qsn}>">more...</a> ]
  </div>
<{/if}>
