$(document).ready(function(){
	
	
	
	function activate()
	{
		$(".issue").click(function(e){ 
		    e.stopPropagation();
		    issue($(this).parent()); 
			});
		$(".return").click(function(e){
			e.stopPropagation();			
		    ret($(this).parent()); 
	        });	
	}
	
	
	
	function deactivate()
	{
		$(".issue").unbind("click");
		$(".return").unbind("click");
	}
	
	
	
	function issue(item)
	{
		var index = $('.book').index(item);
		deactivate();
		$.post("is_ret.php",{book_id: ids[index], new_status: 0, uid: uid},
		function(data, status)
		{
			if((status == 'success')&&data)
			{
				state[index] = 0;
				item.find('.issue').remove();
				item.html(item.html()+'<button type="button" class="return">Return</button>');
			}
			else
			{
				alert("Error: Failed to save changes!");
			}
			activate();
		});
	}
	
	
	
	function ret(item)
	{
		var index = $('.book').index(item);
		deactivate();
		$.post("is_ret.php",{book_id: ids[index], new_status: 1, uid: 0},
		function(data, status)
		{
			if((status == 'success')&&data)
			{
				state[index] = 1;
				item.find('.return').remove();
				item.html(item.html()+'<button type="button" class="issue">Issue</button>');
			}
			else
			{
				alert("Error: Failed to save changes!");
			}
			activate();
		});
	}
	
	function mybooks()
	{
		$('#mybooks').unbind("click").text("All Books").click(function(){ allbooks(); });
		$('.issued, .issue').parent().hide();
	}

	
	function allbooks()
	{
		$('#mybooks').unbind("click").text("My Books").click(function(){ mybooks(); });
		$('.issued, .issue').parent().show();
	}
	
		
	$("#dd").click(function(){ $("#dBar").toggle(); });
	activate();
	$('#mybooks').click(function(){ mybooks(); });

});