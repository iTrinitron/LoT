<?php

//show message from add / edit page
if(isset($_GET['delpost'])){ 

	$stmt = $db->prepare('DELETE FROM blog_posts WHERE postID = :postID') ;
	$stmt->execute(array(':postID' => $_GET['delpost']));

	header("Location: {$page->pageURL}&admin=blog&action=deleted");
	exit;
} 

?>

<script language="JavaScript" type="text/javascript">
function delpost(id, title)
{
	if (confirm("Are you sure you want to delete '" + title + "'"))
	{
		window.location.href = '<?php echo $page->pageURL; ?>&admin=blog&delpost=' + id;
	}
}
</script>

<div class="box">


<?php 
//show message from add / edit page
if(isset($_GET['action'])){ 
	echo '<h3>Post '.$_GET['action'].'.</h3>'; 
} 
?>

<table>
<tr>
	<th>Title</th>
	<th>Date</th>
	<th>Action</th>
</tr>
<?php
	try {

		$stmt = $db->query('SELECT postID, postTitle, postDate FROM blog_posts ORDER BY postID DESC');
		while($row = $stmt->fetch()){

			echo '<tr>';
			echo '<td>'.$row['postTitle'].'</td>';
			echo '<td>'.date('jS M Y', strtotime($row['postDate'])).'</td>';
			?>

			<td>
				<a href="?page=admin&admin=edit-post&id=<?php echo $row['postID'];?>">Edit</a> | 
				<a href="javascript:delpost('<?php echo $row['postID'];?>','<?php echo $row['postTitle'];?>')">Delete</a>
			</td>

			<?php 
			echo '</tr>';

		}

	} catch(PDOException $e) {
			echo $e->getMessage();
	}
?>
</table>

<p><a href='?page=admin&admin=add-post'>Add Post</a></p>

</div>
