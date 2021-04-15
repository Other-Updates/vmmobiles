<?php 
		
		//sleep(20);
		
		$now = date('Y-m-d H:i:s');
		
		if(isset($messages) && !empty($messages))
		{
			
			for($i=0; $i <count($messages);$i++)
			{
				//echo strlen($messages[$i]["message"]);
				
				if(strlen($messages[$i]["message"])!=0)
				{
		   			
					//echo $messages[$i]["created_time"];
					
					$date_diff = date('Y-m-d H:i:s', strtotime('+20 seconds', strtotime($messages[$i]["created_time"])));
					
					if($date_diff <= $now)
					{
						$this->session_messages->delete_session_message($i);
					}
					else
					{
			   		echo "<div class='alert alert-".$messages[$i]["type"]." message'><input class='time' type='hidden' value='".$messages[$i]["created_time"]."'><button type='button' class='close' data-dismiss='alert' id=".$i.">&times;</button>".$messages[$i]["message"]."</div>";
					}
				}	
			}
		  
		
		}
?>
<script type="text/javascript">	
	$(document).ready(function(){

	$(".close").click(function(){

				var id = $(this).attr("id");
				$.ajax({url : BASE_URL+"api/delete_session_message/"+id,
				global:false,
						success : function (result)
						{
							
						
						}
				});
			});
			setInterval(function(){
	
		//	$("#session_msg").reload();
		var currentdate = new Date(); 
		year =  currentdate.getFullYear();
		month =	currentdate.getMonth()+1;
		day = currentdate.getDate();
		hours = currentdate.getHours();
		mins = currentdate.getMinutes();
		secs = currentdate.getSeconds();
		if(month < 10)
			month = "0" + month;
		if(day<10) 
			day = "0" + day;
		if(hours<10) 
			hours = "0" + hours;
		if(mins<10) 
			mins = "0" + mins;
		if(secs<10) 
			secs = "0" + secs;
		var datetime =  year + "-"
                + month + "-" 
                + day + " "  
                + hours + ":"  
                + mins + ":" 
                + secs;
		//alert(datetime);
		$(".message").each(function(){
				value  = $(this).find(".time").val();
				if(datetime >= value)
				{
					//alert("time over");
					$(this).fadeOut(2000);
				
				}
				
				
		
		});
			},20000);
			
			
	});
			
</script>