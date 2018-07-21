$(document).ready(function(){
var dval = 0;
var a1 = -1, a2 = -1, b1 = -1, b2 = -1;
var turn = true;
var ano = 2, bno = 2;
var sqs = $(".sq");
function release()
{
	reRoll();
	if(turn)
	{
		ano--;
		$("#ano").text(ano);
		if(a1 === -1)
			a1 = 0;
		else 
			a2 = 0;
		sqs[0].style.backgroundImage = "url(red.png)";
		if((b1+14)%28 === 0)
		{
			b1 = -1;
			bno++;
			$("#bno").text(bno);
		}
		if((b2+14)%28 === 0)
		{
			b2 = -1;
			bno++;
			$("#bno").text(bno);
		}
	}
	else
	{
		bno--;
		$("#bno").text(bno);
		if(b1 === -1)
			b1 = 0;
		else
			b2 = 0;
		sqs[14].style.backgroundImage = "url(blue.png)";
		if(a1 === 14)
		{
			a1 = -1;
			ano++;
			$("#ano").text(ano);
		}
		if(a2 === 14)
		{
			a2 = -1;
			ano++;
			$("#ano").text(ano);
		}
	}	
}
function reRoll()
{
	var flag = 0;
	if(turn)
	{
		if((dval === 6)&&((a1 === -1)||(a2 === -1)))
			$("#lockA")[0].removeEventListener("click", release);
		if((a1 !== -1)&&(27-a1 >= dval))
			sqs[a1].removeEventListener("click", movea1);
		if((a2 !== -1)&&(27-a2 >= dval))
			sqs[a2].removeEventListener("click", movea2);
	}
	else
	{
		if((dval === 6)&&((b1 === -1)||(b2 === -1)))
			$("#lockB")[0].removeEventListener("click", release);
		if((b1 !== -1)&&(27-b1 >= dval))
			sqs[(b1+14)%28].removeEventListener("click", moveb1);
		if((b1 !== b2)&&(b2 !== -1)&&(27-b2 >= dval))
			sqs[(b2+14)%28].removeEventListener("click", moveb2);
	}
	if(dval !== 6)
	{
		turn = !turn;
		if(turn)
			$("#roll").css("background-color", "rgb(250,100,100)");
		else
			$("#roll").css("background-color", "rgb(100,100,250)");	
	}
	$("#roll")[0].addEventListener("click", roll) ;
}
function check()
{
	if(turn)
	{
		if(b1 === 27)
		{
			$(".sq")[13].style.backgroundImage = "none";
			b1++;
		}
		if(b2 === 27)
		{
			$(".sq")[13].style.backgroundImage = "none";
			b2++;
		}
		if((b1 === 28)&&(b2 === 28))
			$("#pbox").html("Player B Won!!");
	}
	else 
	{
		if(a1 === 27)
		{
			$(".sq")[27].style.backgroundImage = "none";
			a1++;
		}
		if(a2 === 27)
		{
			$(".sq")[27].style.backgroundImage = "none";
			a2++;
		}
		if((a1 === 28)&&(a2 === 28))
			$("#pbox").html("Player A Won!!");
	}
}	
function movea1()
{
	reRoll();
	if(a1 !== a2)
		$(".sq")[a1].style.backgroundImage = "none";
	a1 += dval;
	if((b1>0)&&(a1 === (b1+14)%28))
	{
		b1 = -1;
		bno++;
		$("#bno").text(bno);
	}
	if((b2>0)&&(a1 === (b2+14)%28))
	{
		b2 = -1;
		bno++;
		$("#bno").text(bno);
	}
	$(".sq")[a1].style.backgroundImage = "url(red.png)";
	check();
}
function movea2()
{
	reRoll();
	if(a1 !== a2)
		$(".sq")[a2].style.backgroundImage = "none";
	a2 += dval;
	if((b1>0)&&(a2 === (b1+14)%28))
	{
		b1 = -1;
		bno++;
		$("#bno").text(bno);
	}
	if((b2>0)&&(a2 === (b2+14)%28))
	{
		b2 = -1;
		bno++;
		$("#bno").text(bno);
	}
	$(".sq")[a2].style.backgroundImage = "url(red.png)";
	check();
}
function moveb1()
{
	reRoll();
	if(b1 !== b2)
		$(".sq")[(b1+14)%28].style.backgroundImage = "none";
	b1 += dval;
	if(a1 === (b1+14)%28)
	{
		a1 = -1;
		ano++;
		$("#ano").text(ano);
	}
	if(a2 === (b1+14)%28)
	{
		a2 = -1;
		ano++;
		$("#ano").text(ano);
	}
	$(".sq")[(b1+14)%28].style.backgroundImage = "url(blue.png)";
	check();
}
function moveb2()
{
	reRoll();
	if(b1 != b2)
		$(".sq")[(b2+14)%28].style.backgroundImage = "none";
	b2 += dval;
	if(a1 === (b2+14)%28)
	{
		a1 = -1;
		ano++;
		$("#ano").text(ano);
	}
	if(a2 === (b2+14)%28)
	{
		a2 = -1;
		ano++;
		$("#ano").text(ano);
	}
	$(".sq")[(b2+14)%28].style.backgroundImage = "url(blue.png)";
	check();
}
function roll()
{
	var flag = 0;
	dval = Number($("#rtest").val());
	if(dval === 0)
		dval = Math.floor(Math.random()*6+1);
	$("#die")[0].src = dval+".png";
	if(turn)
	{
		if((dval === 6)&&((a1 === -1)||(a2 === -1)))
		{
			$("#lockA")[0].addEventListener("click", release);
			flag++;
		}
		if((a1 !== -1)&&(27-a1 >= dval))
		{
			sqs[a1].addEventListener("click", movea1);
			flag++;
		}
		if((a2 !== a1)&&(a2 !== -1)&&(27-a2 >= dval))
		{
			sqs[a2].addEventListener("click", movea2);
			flag++;
		}
		if(flag === 1)
		{
			if((dval === 6)&&((a1 === -1)||(a2 === -1)))
				release();
			else if((a1 !== -1)&&(27-a1 >= dval))
				movea1();
			else
				movea2();
		}		
	}
	else
	{
		if((dval === 6)&&((b1 === -1)||(b2 === -1)))
		{
			$("#lockB")[0].addEventListener("click", release);
			flag++;
		}
		if((b1 !== -1)&&(27-b1 >= dval))
		{
			sqs[(b1+14)%28].addEventListener("click", moveb1);
			flag++;
		}
		if((b1 !== b2)&&(b2 !== -1)&&(27-b2 >= dval))
		{
			sqs[(b2+14)%28].addEventListener("click", moveb2);
			flag++;
		}
		if(flag === 1)
		{
			if((dval === 6)&&((b1 === -1)||(b2 === -1)))
				release();
			else if((b1 !== -1)&&(27-b1 >= dval))
				moveb1();
			else
				moveb2();
		}
	}
	if(flag === 0)
	{
		turn = !turn;
		if(turn)
			$("#roll").css("background-color", "rgb(250,100,100)");
		else
			$("#roll").css("background-color", "rgb(100,100,250)");	
	}
	else if(flag > 1)
		$("#roll")[0].removeEventListener("click", roll) ;
}
$("#roll")[0].addEventListener("click", roll);
});