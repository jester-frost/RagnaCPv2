jQuery(function(){
	$('.show-info').on('click',function(){
		if( !$('.mask').hasClass('active') ){
			$('.mask').addClass('active');
		}else{
			$('.mask').addClass('active');
		}
		var element = $( this ).parents('li').find('.item_info');
		if( element.hasClass('hide') ){
			element.removeClass('hide');
		}
		return false;
	})
	$('.mask').on('click',function(){
		$( this ).removeClass( 'active' );
		$('.lojinha_list .item_info').map(function(){
			if( !$( this ).hasClass('hide') ){
				$( this ).addClass('hide');
			} 	
		})
	})
})