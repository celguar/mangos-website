<br>
<?php builddiv_start(0, $lang['commands']) ?>
<?php $MANG = new Mangos; ?>
<style media="screen, projection" type="text/css">
	@import "css/master.css";
	@import "css/<?php echo LANGUAGE ?>/language.css";
</style>
	
<?php write_metalborder_header(); ?>
	<div>
		<input type="text" id="commandSearch" onkeyup="myFunction()" placeholder="Search commands..">
	</div>
    <table id="commandTable" cellpadding="3" cellspacing="0" width='100%'>
    <tbody>
        <tr>
            <th class="rankingHeader" align="center" nowrap="nowrap">Command name&nbsp;</td> 
            <th class="rankingHeader" align="center" nowrap="nowrap">Security level&nbsp;</td>
        </tr>
<?php foreach($alltopics as $postanum => $topic){ ?>
        <tr>
            <td class="serverStatus">
				<b style="color: rgb(102, 13, 2);">
					<details>
						<summary>
							<b style="color: rgb(35, 67, 3);">
								<?php echo $topic['name'];?>
							</b>
						</summary>
						<p>
							<?php echo $topic['help'];?>
						</p>
					</details>
				</b>
			</td>
            <td class="serverStatus" align="center"><b style="color: rgb(35, 67, 3);"><?php echo $topic['security'];?></b></td>
        </tr>
		<script>
		function myFunction() {
		  // Declare variables
		  var input, filter, table, tr, td, i, txtValue;
		  input = document.getElementById("commandSearch");
		  filter = input.value.toUpperCase();
		  table = document.getElementById("commandTable");
		  tr = table.getElementsByTagName("tr");

		  // Loop through all table rows, and hide those who don't match the search query
		  for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[0];
			if (td) {
			  txtValue = td.textContent || td.innerText;
			  if (txtValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			  } else {
				tr[i].style.display = "none";
			  }
			}
		  }
		}
		</script>
<?php } unset($res_info, $res) ?>
    </tbody>
    </table>
<?php write_metalborder_footer(); ?>

<?php unset($MANG); ?>
<?php builddiv_end() ?>