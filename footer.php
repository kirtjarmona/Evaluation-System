<hr>
<pre><?php echo "SESSION" . var_dump($_SESSION); ?></pre>
<hr>
<pre><?php echo "POST" . var_dump($_POST); ?></pre>
<hr>
<pre><?php echo "GET" . var_dump($_GET); ?></pre>

</body>
<?php #echo $complete_evaluateID; ?>
<hr>
<pre>
	<?php echo $query2; ?>
	<?php #echo $insert_ratings_info; ?>
</pre>
<?php pg_close($conn);  ?>
</html>