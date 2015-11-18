/**
 * Created by Developer1 on 18/11/2015.
 */



$("#search-btn").on('click',function(){

	$('#message').fadeIn(600);
	var searchString = $("#searchbox").val();

	$.get( "fetchScraper.php", {searchString:searchString})
		.done(function( data ) {
			$('#message').delay(1000).fadeOut(600);

			$('.resultbox').html(data);

		});

});
