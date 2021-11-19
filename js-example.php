// EXAMPLE
//
// Use it in browser console

$ = jQuery;

var events = []; 

$('.panel.panel-default').each(function(i,k){ 
	var item = this;
	var title = $(item).find('.extb-1 a').text();
	var url = $(item).find('.extb-1 a').attr('href');
	var dates = $(item).find('.extb-1 .d-block span').text();

	var description = $(item).find('.d-block.show_opening_times').text()+". "+$(item).find('a.snippet-text').text();
	//var parent = $(this).parent().parent().prev();
	var venue = $(item).find('.panel-heading a').text();
	var address = $(item).find('.space_address').text();
	var city = $(item).find('.panel-heading span.citynameRow').text();
	aux = dates.split("-");

	var start_date = aux[0];
	var end_date = aux[1];
	if (start_date && end_date){
		var post = { 
			source:"galleriesnow", 
			city:city.trim(), 
			tags:"art-exhibitions", 
			submit:1, 
			time: "09:30:00", 
			url: url.trim(),  
			area: 'london', 
			title: title.trim(), 
			start_date: start_date.trim(), 
			end_date:end_date.trim(), 
			description: description.trim() , 
			venue: venue.trim(), 
			address: address.trim() 
		};
		events.push(post); 
	}

});



JSON.stringify(events);

