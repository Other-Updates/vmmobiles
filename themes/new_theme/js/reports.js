// JavaScript Document
edit_count = 0;
var attendance_threshold;
var to_clone;

$(document).ready(function(){
	
	attendance_threshold = parseFloat($("#attendance_threshold").val());
	month_starting_date = $("#month_starting_date").val();
	week_starting_day = $("#week_starting_day").val();
		
		var d = new Date();
		$(".close").click(function(){
				
				$('.modal').modal('hide');
				//$(".modal-backdrop").hide();
		});
		$("#count_change").change(function(){
		/*var users = GetParameterValues('users');
		
		if(users!=undefined)	*/   
		$.ajax({
		   	url : BASE_URL + "api/set_show_count/",
			type : "POST",
			data : {show_count:$(this).val(),class:ct_class,method:ct_method},
			success:function(res)
			{
				var pathArray = window.location.pathname.split( '/' );
				var newPathname = "";
				for ( i = 0; i < pathArray.length; i++ ) {
				  	if(i==0)
					{
						
						newPathname += pathArray[i];
					}
					else if( i != pathArray.length-1)
					{
						
						newPathname += "/";
				  		newPathname += pathArray[i];
						
					}
				}
				new_path = window.location.protocol+"//" + window.location.host +newPathname+"/";
				window.location = new_path;
			//window.location = window.location.pathname;
			}
		   });
		});
		$("#print").unbind("click").click(function(){
				window.print();
		});
		$(".reset").click(function(){
		$.ajax({
		   	url : BASE_URL + "api/reset_session/",
			type : "POST",
			data : {class:ct_class,method:ct_method},
			success:function(res)
			{
				
				window.location = window.location.pathname;
			}
		   });
		
	});
		$("#department_select").change(function(){
			$.ajax({
				url:BASE_URL+"api/get_designations/",
				type:'POST',
				data:{
					department:$(this).val()
				},
				success:function(res){
					$("#designation").html(res);
					$("#designation_select").multiselect({
						includeSelectAllOption: true,
						 enableFiltering: true
					});
			}   
			});	   
		});
		$("#go").click(function(){
			
							
			if($("#year_select").val()!="" && $("#month_select").val()!="")
			{
				if($('select[name="user_type"]').val()==1)
				{					
					if($("#date_select").val()==null)
					{
						alert("You must select week for Daily / Weekly users");
						return false;
					}
				}
				
			}
			
			else
			{
				if(ct_class=='reports' && ct_method=='tds_reports')
					alert("Please select Year");
				else
					alert("Please select Year & Month");
				return false;
			}
		});
		$(".user_type").change(function(){										
		var txt ="<option value=''>Select Month</option>";
		$("#year_select").val("");
		$("#month_select").val("");
		$("#date_select").html("");
		$("#date_select").multiselect('rebuild');
		var month =new Array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");
		if($(this).val()==1)
		{
			$("#date_th").show();
			if($.trim($("#year_select").val())==d.getFullYear())
			{
				
				for(i=0;i<=d.getMonth();i++)
				{
					
					txt = txt + "<option value="+(i+1)+">"+month[i]+"</option>"	;
					
				}
				
			}
			else
			{
				for(i=0;i<=11;i++)
				{
					txt = txt +"<option value="+(i+1)+">"+month[i]+"</option>"	;
					
				}
				
			}
			
		
		}
		else if($(this).val()==2)
		{
			$("#date_th").hide();
			if($.trim($("#year_select").val())==d.getFullYear())
			{
				
				for(i=0;i<=d.getMonth()-1;i++)
				{
					if(i==d.getMonth())
					{
						if(d.getDate()>month_starting_date)
							txt = txt + "<option value="+(i+1)+">"+month[i]+"</option>"	;
					}
					else
						txt = txt + "<option value="+(i+1)+">"+month[i]+"</option>"	;
				}
				
			}
			else
			{
				for(i=0;i<=11;i++)
				{
					txt = txt +"<option value="+(i+1)+">"+month[i]+"</option>"	;
					
				}
				
			}
			
		}
		$("#month_select").html(txt);
	});
		
	$("#month_select").change(function(){
		//$("#date_select").multiselect('destroy')
		
		if($(this).val()!=0){
			list = "";
			var getTot = daysInMonth($(this).val(),$("#year_select").val()); //Get total days in a month
			
			month_st_date = $("#year_select").val()+"-"+$(this).val()+"-1";
			month_et_date = $("#year_select").val()+"-"+$(this).val()+"-"+getTot;
			$("#month_start_date").val(month_st_date);
			$("#month_end_date").val(month_et_date);
			
			var sat = new Array();   //Declaring array for inserting Saturdays
		
			for(var i=1;i<=getTot;i++){    //looping through days in month
				var newDate = new Date($("#year_select").val(),$(this).val()-1,i);
				if(newDate.getDay()==week_starting_day){   //if Saturday
					sat.push(i);
				}
			
			}
			
			 list ="";
			if($("#year_select").val()== d.getFullYear())
			{
				
				if(d.getMonth()+1 == $(this).val())
				{
					
					for(k=0;k<sat.length;k++)
					{
						if(parseInt(sat[k]+6)<d.getDate())
						{
							current = sat[k]+"-"+ $(this).val()+"-"+$("#year_select").val();
							list += "<option value='"+sat[k]+"'>"+sat[k]+"-"+$("#month_select option:selected").text()+"</option>";
							
						}
					}
				}
				else
				{
					for(k=0;k<sat.length;k++)
					{
						
						current = sat[k]+"-"+ $(this).val()+"-"+$("#year_select").val();
						list += "<option value='"+sat[k]+"'>"+sat[k]+"-"+$("#month_select option:selected").text()+"</option>";
						
						
					}
				
				}
			}
			else
			{
				for(k=0;k<sat.length;k++)
				{
					
					current = sat[k]+"-"+ $(this).val()+"-"+$("#year_select").val();
					list += "<option value='"+sat[k]+"'>"+sat[k]+"-"+$("#month_select option:selected").text()+"</option>";
						
					
				}
			
			}
			
			$("#date_select").html(list);
			
			$("#date_select").multiselect('rebuild');
			if($(".user_type").val()==1)
			{
				if(list=="")
				{
					alert("Week not yet started for current month");
					$(this).val('');
				}
			}
			if(month_starting_date!=1)
			{
				end_date = parseInt(month_starting_date)-1;
				end_month = parseInt($(this).val())+1;
				end_year = parseInt($("#year_select").val())+1;
				if($(this).val()!=12)
				{
					$("#start_date").val($("#year_select").val()+"-"+$(this).val()+"-"+month_starting_date);
					$("#end_date").val($("#year_select").val()+"-"+end_month+"-"+end_date);
				}
				else
				{
					
					$("#start_date").val($("#year_select").val()+"-"+$(this).val()+"-"+month_starting_date);
					$("#end_date").val(end_year+"-1-"+end_date);
				
				}
			}
			else
			{
				end_date = daysInMonth($(this).val(),$("#year_select").val());
				end_year = parseInt($("#year_select").val())+1;
				
				$("#start_date").val($("#year_select").val()+"-"+$(this).val()+"-"+month_starting_date);
				$("#end_date").val($("#year_select").val()+"-"+$(this).val()+"-"+end_date);
				
			
			}
		}
		
	});
	$("#date_select").change(function(){
		
		week_selected = $(this).val().toString().split(",");
		var index = week_selected.indexOf("multiselect-all");
		if (index > -1) {
			week_selected.splice(index, 1);
		}	
		diff = 0;
		for(j=0;j<week_selected.length-1;j++)
		{
			if(week_selected[j+1] - week_selected[j] > 7)
			 	diff = 1;
				
		}
		
		if(diff==0)
		{
			//new_value = $(this).val().split("-");
			if(week_selected.length==1)
			{
				$("#start_date").val(week_selected[0]+"-"+$("#month_select").val()+"-"+$("#year_select").val());
				start =$("#start_date").val().split("-");
				date = start[1]+"/"+start[0]+"/"+start[2];
				var startDate = new Date(date);
				var endDate = new Date(date);
				endDate.setDate( endDate.getDate() + parseInt(6) ); 
				$("#start_date").val($.trim(start[2])+"-"+start[1]+"-"+start[0]);
				$("#end_date").val(endDate.getFullYear()+"-"+(endDate.getMonth()+1)+"-"+endDate.getDate());
			}
			else
			{
			
				
				max_week = Math.max.apply(Math,week_selected); 
				min_week = Math.min.apply(Math,week_selected); 
				$("#start_date").val(min_week+"-"+$("#month_select").val()+"-"+$("#year_select").val());
				max_day = max_week+"-"+$("#month_select").val()+"-"+$("#year_select").val();
				start = max_day.split("-");
				date = start[1]+"/"+start[0]+"/"+start[2];
				var startDate = new Date(date);
				var endDate = new Date(date);
				endDate.setDate( endDate.getDate() + parseInt(6) ); 
				$("#start_date").val($("#year_select").val()+"-"+$("#month_select").val()+"-"+min_week);
				$("#end_date").val(endDate.getFullYear()+"-"+(endDate.getMonth()+1)+"-"+endDate.getDate());
			}
		}
		else
		{
			alert("you must select sequential weeks" );
			for(j=0;j<week_selected.length;j++)
			{
				$("#date_select").multiselect('deselect', week_selected[j]);
			}
			if(month_starting_date!=1)
			{
				end_date = parseInt(month_starting_date)-1;
				end_month = parseInt($("#month_select").val())+1;
				if($(this).val()!=12)
				{
					$("#start_date").val($("#year_select").val()+"-"+$("#month_select").val()+"-"+month_starting_date);
					$("#end_date").val($("#year_select").val()+"-"+end_month+"-"+end_date);
				}
				else
				{
					$("#start_date").val($("#year_select").val()+"-"+$("#month_select").val()+"-"+month_starting_date);
					$("#end_date").val($("#year_select").val()+1+"-1-"+end_date);
				
				}
			}
			else
			{
				end_date = daysInMonth($("#month_select").val(),$("#year_select").val());
				end_year = parseInt($("#year_select").val())+1;
				
				$("#start_date").val($("#year_select").val()+"-"+$("#month_select").val()+"-"+month_starting_date);
				$("#end_date").val($("#year_select").val()+"-"+$("#month_select").val()+"-"+end_date);
				
			
			}
		}
	});
	function daysInMonth(month,year) {
    	return new Date(year, month, 0).getDate();
	}
		
	
		$(".multiselect").multiselect({
				includeSelectAllOption: true,
				 enableFiltering: true
			});
		
		
		$("#year_select").change(function(){
			var month =new Array("Jan","Feb","Mar","Apr","May","June","July","Aug","Sep","Oct","Nov","Dec");
			$("#month_select").val("");
			$("#date_select").html("");
			$("#date_select").multiselect('rebuild');
			var txt ="<option value=''>Select Month</option>";
			if($(this).val()!=0)
			{
				if($(".user_type").val()==1)
				{
					if($.trim($(this).val())==d.getFullYear())
					{
						for(i=0;i<=d.getMonth();i++)
						{
							txt = txt + "<option value="+(i+1)+">"+month[i]+"</option>"	;
							
						}						
					}
					
					else
					{
						for(i=0;i<=11;i++)
						{
							txt = txt +"<option value="+(i+1)+">"+month[i]+"</option>"	;
							
						}
						
					}
				}
				else
				{
					if($.trim($(this).val())==d.getFullYear())
					{
						for(i=0;i<d.getMonth();i++)
						{
							//console.log(month[i]);
							if(i==parseInt(d.getMonth()))
							{
								if(d.getDate()>month_starting_date)
									txt = txt + "<option value="+(i+1)+">"+month[i]+"</option>"	;
							}
							else
								txt = txt + "<option value="+(i+1)+">"+month[i]+"</option>"	;
							
							
						}
						
					}
					
					else
					{
						for(i=0;i<=11;i++)
						{
							txt = txt +"<option value="+(i+1)+">"+month[i]+"</option>"	;
							
						}
						
					}	
					
				}
				
			}
			$("#month_select").html(txt);
		});
	
	
});

