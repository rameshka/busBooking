
$(function(){
$(".search").keyup(function() 
{ 
var searchid = $(this).val();
var dataString = 'search='+ searchid;
var token = $('meta[name="_token"]').attr('content');
var url1='{{route("cityfinder")}}';
if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: url1 ,
    data: { _token:token , 'datafile':dataString },
    cache: false,
    success: function(html)
    {
    $("#result").html(html).show();
    }
    });
}return false;    
});

jQuery("#result").on("click",function(e){ 
    var $clicked = $(e.target);
    var $name = $clicked.find('.name').html();
    var decoded = $("<div/>").html($name).text();
    $('#searchid').val(decoded);
});
jQuery(document).on('click',  function(e) { 
    var $clicked = $(e.target);
    if (! $clicked.hasClass("search")){
    jQuery("#result").fadeOut(); 
    }
});

});

$(function(){
$(".search1").keyup(function() 
{ 
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: "result.php",
    data: dataString,
    cache: false,
    success: function(html)
    {
		$("#result1").show();
    $("#result1").html(html).show();
    }
    });
}
else {$("#result1").hide();
	}return false;    
});

jQuery("#result1").on("click",function(e){ 
    var $clicked = $(e.target);
    var $name = $clicked.find('.name').html();
    var decoded = $("<div/>").html($name).text();
    $('#searchid1').val(decoded);
});
jQuery(document).on('click',  function(e) { 
    var $clicked = $(e.target);
    if (! $clicked.hasClass("search1")){
    jQuery("#result1").fadeOut(); 
    }
});

});
