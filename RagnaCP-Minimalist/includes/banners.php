<?php 
	$url = array(
		"img1" => array( 
			"link" => "https://picsum.photos/1200/255/?image=345",
		),
		"img2" => array( 
			"link" => "https://picsum.photos/1200/255/?image=535",
		),
		"img3" => array( 
			"link" => "https://picsum.photos/1200/255/?image=545",
		),
		"img4" => array( 
			"link" => "https://picsum.photos/1200/255/?image=525",
		),
	);

	$gallery = true;
	if( ( count( $url ) > 1 ) && ( $gallery == true ) ){
		$class = "gallery";
	}else{
		$class = "";
	}
?>
<section class="banner <?php echo $class; ?>">
	<ul>
		<?php foreach ($url as $img):?>
			<li>
				<img src="<?php echo $img['link']; ?>" alt="">
			</li>
		<?php endforeach; ?>
	</ul>
</section>