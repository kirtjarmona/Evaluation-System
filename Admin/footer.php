<hr>
<pre>SESSION<?php var_dump($_SESSION); ?></pre>
<pre>POST<?php var_dump($_POST); ?></pre>
<pre>GET<?php var_dump($_GET); ?></pre>
<pre>
	
<?php  echo($query_ratings_result); ?>
</pre>
<?php #echo($query_count_faculties_voted); ?>
<?php #print_r($items); ?>
<?php pg_close($conn);  ?>
</html>