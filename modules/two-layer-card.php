<?php

	//Card title for threads
	if(!isset($data['card_content'])){
		$data["card_content"] = array(
			array(
				"title" => "Demo title",
				"date" => "1970-01-01 10:00",
				
			),
		);
	}

?>

<!-- Should be integrated into head --->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<div class="card-title row no-gutters">
	<div class="col-lg-4">
		<?php echo $data["card_content"]["title"]?>
	</div>
	
</div>


<script>
/*
var titleapp = function(e){
	var title = <?php json_encode($data["card_content"]["title"])?>;
	var date = <?php json_encode($data["card_content"]["date"])?>;



};
*/
</script>