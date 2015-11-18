/**
 * Created by Developer1 on 18/11/2015.
 */



$("#search-btn").on('click',function(){

	$('#message').fadeIn(600);
	var searchString = $("#searchbox").val();

    $('#errorbox').hide();
    var order = $('input:radio[name=optionsRadios]:checked').val();


    $.get( "fetchScraper.php", {searchString:searchString,order:order})
		.done(function( data ) {
			$('#message').delay(1000).fadeOut(600);

           // var items = [];
            var htmlStr = '';

           var obj = jQuery.parseJSON(data);
            if(obj.length > 0)
            {
            for (var i = 0, len = obj.length; i < len; i++) {

                htmlStr = htmlStr.concat("<div id=\"callout-navbar-breakpoint\" class=\"jumbotron\">");
                htmlStr =  htmlStr.concat("<h4>");
                htmlStr =  htmlStr.concat(obj[i].title);
                htmlStr =  htmlStr.concat("</h4>");
                htmlStr =  htmlStr.concat('<img width="160" height="160" src="');
                htmlStr =  htmlStr.concat(obj[i].img);
                htmlStr =  htmlStr.concat('" alt="Product Details">');
                htmlStr =  htmlStr.concat('<p>');
                htmlStr =  htmlStr.concat(obj[i].title);
                htmlStr =  htmlStr.concat('<code> Price ');
                htmlStr =  htmlStr.concat(obj[i].currency);
                htmlStr =  htmlStr.concat(obj[i].price);
                htmlStr =  htmlStr.concat('</code>');
                htmlStr =  htmlStr.concat('</p>');
                htmlStr =  htmlStr.concat('</div>');




            }
            }
            else
            {
                $('#errorbox').show();


            }



                $('.resultbox').html(htmlStr);

		});

});
