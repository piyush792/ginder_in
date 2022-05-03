/*///// /////*/

function thumbCarousel()
{
	f=0;
	c=$('.controlList');
	tn=$('.thumbNext')
	tp=$('.thumbPrev')
	c.ready(function(){
		tn.click(function(){
			if(f==0)
			{
				c.animate({marginLeft:'-306px'},500);	
				f=1;
			}							
		});
		tp.click(function(){
			if(f==1)
			{
				c.animate({marginLeft:'0px'},500);	
				f=0;
			}							
		});
	});
}


function terminPop()
{
	var f=0;	
	console.log(f)
	$('.ocSwitch').click(function(){
		if(f==0)
		{
			$('.onlineTermin').animate({right:'0px'},300);
			f=1;
			console.log(f)
		}
		else
		{
			$('.onlineTermin').animate({right:'-306px'},300);
			f=0;
			console.log(f)
		}		
	});
}