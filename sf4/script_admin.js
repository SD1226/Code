$(document).ready(function(){
	
	function activate()
	{
        $("#add").click(function(e){ 
		    e.stopPropagation();
		    add(); 
		    });
		$(".delete").click(function(e){
			e.stopPropagation();			
			del($(this).parent()); 
			});	
	}
	
	
	
	function deactivate()
	{
		$("#add").unbind("click");
		$(".delete").unbind("click");
	}
	
	
	
	function del(item)
	{
		var index = $('.book').index(item);	
		$.post("delete.php",{book_id: ids[index]},
		function(data, status)
		{
			if((status == 'success')&&data)
			{
				item.remove();
				ids.splice(index,1);
				state.splice(index,1);
			}
			else
			{
				alert("Error: Failed to save changes!");
			}
		});
	}
	
	
	
	function save(item)
	{
		var bname = item.find('input[name="bname"]').val();
		var author = item.find('input[name="author"]').val();
        var publisher = item.find('input[name="publisher"]').val();
		$.post("save.php",{bname: bname, author: author, publisher: publisher},
		function(data, status)
		{
			if((status == 'success')&&data)
			{
				data = JSON.parse(data);
				item.html(data.note);
				ids.push(data.id);
				state.push(1);
			}
			else
			{
				alert("Error: Failed to save changes!");
			}
		});
	}
	
	
	
	
	
	function add()
	{
	    deactivate();
		var prev = $("#content").html();
		$("#content").html(prev+'<div class="book"><form>'+
        '<input type="text" name="bname"  placeholder="Book name" maxlength="50" />'+
        '<input type="text" name="author"  placeholder="Author" maxlength="50" />'+
        '<input type="text" name="publisher" placeholder="Publisher" maxlength="50" />'+
        '<button type="submit" class="save">SAVE</button><button type="button" class="cancel">CANCEL</button>'+
        '</form></div>');
		var item = $(".book:last");
		item.find(".cancel").click(function(e){ 
		    e.stopPropagation();
		    item.remove();
            activate();
	        });			
		item.find("form").submit(function(e){ 
            e.stopPropagation();
		    save(item);
            activate();
			});		
	}	
	
	
	
	
	$("#dd").click(function(){ $("#dBar").toggle(); });
	activate();

});