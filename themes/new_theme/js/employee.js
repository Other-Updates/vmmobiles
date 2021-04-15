// JavaScript Document
$(document).ready(function(){
						   
	$(".hide").hide();	
	
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
			//	alert(new_path);
				window.location = new_path;
			}
		   });
		
		/*else
			window.location = BASE_URL+"masters/employees?show="+$(this).val();
	*/
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
	// Micrate check box selection of users
	$(".migrate-user").click(function(){
		var n=$( "input:checked" ).length;
		//alert(n);
		if(n>0)
			$("#migrate").css("display","block");
		else if(n==0)
			$("#migrate").css("display","none");
		
	});
	// On micrate button click
	$("#migrate").click(function(){
			$(this).hide();
		user = new Array();
		k=0;
		$(".migrate-user").each(function(i){
			if($(this).is(":checked"))
			{
				user[k] = $(this).val();	
				k++;
			}
		});
		$
			
			$.ajax({
				
				url:BASE_URL + "api/migrate/",
				type:"POST",
				data:{user:user},
				
				success:function(res)
				{
					if(res == "true") {
						update_user(user);
					} else {
						window.location = window.location.pathname;
					}
				},
				error : function(msg) {
                 console.log(msg);
                 //window.location = window.location.pathname;
                }
			});

		

							 
	});

	function update_user(user)
	{
		$.ajax({
			url:BASE_URL + "api/update_user_moved_status/",
			type:"POST",
			data:{user:user},
			success:function(res)
			{
				window.location = window.location.pathname;
			},
			error : function(msg) {
                 console.log(msg);
            }
	   });

	}
	function astart(){
	   
	   	$("#fade_div").css("display","block");
		  $("#wait").css("display","block");
		   
		  
		}
		 function acomplete(){
		 
			 $("#wait").css("display","none");
			 $("#fade_div").css("display","none");
		}
	
	$( "#myModal" ).on('shown', function(){
		var revised_date = new Date($("#revised_date").next().val());
		$(".revised_date").datepicker({dateFormat:'d-m-yy',minDate:revised_date,onClose:function()
		{
			if($(this).val()=="")
				$(this).css('border','1px solid red');	
			else
				$(this).css('border','1px solid #CCCCCC');
		}
		});
		$(".revise").val('');
		$(".revise").each(function(){
			$(this).css('border','1px solid #CCCCCC');
		});
	});

	$("#revise_salary").click(function(){
		res = 0;
		$(".revise").each(function(){
				if($(this).val()=="")
				{
					$(this).css('border','1px solid red');	
					res = 1;	
				}
				else
				{
					$(this).css('border','1px solid #CCCCCC');
				}
		});
		if(res==1)
			return false;
		else
		{
			astart();
			$(this).attr("type","button");
			return true;
		}
	});
	$(".revise").blur(function(){
		if($(this).val()!="")
				$(this).css('border','1px solid #CCCCCC');
		else
			$(this).css('border','1px solid red');	
	});
	
	
	$( "#myModal2" ).on('shown', function(){
		var shift_date = new Date($("#shift_date").next().val());		
		$(".shift_date").datepicker({dateFormat:'d-m-yy',minDate:shift_date,onClose:function()
			{
				if($(this).val()=="")
					$(this).css('border','1px solid red');	
				else
					$(this).css('border','1px solid #CCCCCC');
			}
		});
		$(".shift").val('');
		$(".shift-radio").val('');
		$(".shift-radio").css('border','1px solid #CCCCCC');
		$(".shift").each(function(){
			$(this).css('border','1px solid #CCCCCC');
		});
	});
	$(".shift-radio").change(function(){
										
			if($.trim($(this).val())!="")
				$(".error").css("display","none");
	});
	$(".shift-radio").blur(function(){
		if($(this).val()!="")
				$(this).css('border','1px solid #CCCCCC');
		else
			$(this).css('border','1px solid red');	
	});
	$("#change_shift").click(function(){
		res = 0;
		$(".shift").each(function(){
				if($(this).val()=="")
				{
					$(this).css('border','1px solid red');	
					res = 1;	
				}
				else
				{
					$(this).css('border','1px solid #CCCCCC');
				}
		});
		
		$(".shift-radio").each(function(){
			if($.trim($(this).val())=="")
			{
				$(this).css('border','1px solid red');
				res =1		
			}
			else
			{
				$(this).css('border','1px solid #CCCCCC');
			}
		});
		
		if(res==1)
			return false;
		else
		{
			astart();
			$(this).attr("type","button");
			return true;
		}
	});
	$(".shift").blur(function(){
		if($(this).val()!="")
				$(this).css('border','1px solid #CCCCCC');
		else
			$(this).css('border','1px solid red');	
	});
	$(".multiselect").multiselect({
				includeSelectAllOption: true,
				 enableFiltering: true
			});
	/*function GetParameterValues(param)
	{
		var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		for (var i = 0; i < url.length; i++) 
		{
			var urlparam = url[i].split('=');
			if (urlparam[0] == param) 
			{
				return urlparam[1];
			}
		}
	}*/
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
		$("#all").click(function(){
							//	 alert($(this).val());
			if($(this).attr("checked")=="checked")
			{
				$.ajax({
					   url:BASE_URL+"api/add_all_ip",
					   type:'GET',
				
						success:function(res){
					   
						window.location =BASE_URL+"masters/white_list/";
						}
					});	
			}
			else
			{	
				$.ajax({
					   url:BASE_URL+"api/remove_all_ip",
					   type:'GET',
				
						success:function(res){
					   
						window.location =BASE_URL+"masters/white_list/";
						}
					});	
				
			}
		})
	$(".add_row").click(function(){

			var table = $(this).closest("table");
			var row = $(table).find("tbody tr:first").clone();
			var len = $(table).find("tbody tr").length + 1;
			row.find("td:first").html(len);
			row.find("input:text").each(function(i){
				if($(this).css("border-color")=="red")
				{
					$(this).css("border","1px solid #BBBBBB");
				}
				if($(this).hasClass("percentage"))
				{
					var prev,next,get_name ;
					prev = $(this).attr('name');
					next = prev.replace('0',len-1);
					$(this).attr('name',next);
				}
				$(this).val('');
			
			});
			row.find("input:checkbox").each(function(i){
				var prev,next,get_name ;
				prev = $(this).attr('name');
				next = prev.replace('0',len-1);
				$(this).attr('name',next);
				if($(this).is(':checked') )
				{
					
					 $(this).removeAttr('checked');
				}
			
			});
			row.find("input:radio").each(function(i){
				var prev,next,get_name ;
				prev = $(this).val();
				next = prev.replace('0',len-1);
				$(this).val(next);
				if($(this).is(':checked') )
				{
					
					 $(this).removeAttr('checked');
				}
			
			});
			row.find("td:last").children("a").css("visibility","visible");
			
			table.find("tbody").append(row);
			$('.date-dob').each(function(i) {
				this.id = 'date-dob' + i;
			
			}).removeClass('hasDatepicker').datepicker({dateFormat:'d-m-yy',changeYear: true,yearRange: '1945:'+(new Date).getFullYear()});
			
			$('.datepicker').each(function(i) {
				this.id = 'date-picker' + i;
			
			}).removeClass('hasDatepicker').datepicker({dateFormat:'d-m-yy',changeYear: true,yearRange: '1945:'+(new Date).getFullYear()});
			
		});
		$("#dol").datepicker({dateFormat:'d-m-yy',changeYear: true,minDate:$("#doj").val(),yearRange: '1945:'+(new Date).getFullYear()});
		$("#doj").datepicker({dateFormat:'d-m-yy',changeYear: true,yearRange: '1945:'+(new Date).getFullYear(),
		 onClose:function()
		{
			$("#dol").val("");
			var date2 = $(this).datepicker('getDate');
            date2.setDate(date2.getDate()+1);
			$("#dol").removeClass("hasDatepicker").datepicker({dateFormat:'d-m-yy',changeYear: true,minDate:date2,yearRange: '1945:'+(new Date).getFullYear()});	
		}
		});
		//datepicker widget
		$("#datepicker").datepicker({dateFormat:'d-m-yy',changeYear: true,yearRange: '1945:'+(new Date).getFullYear()
		,onClose:function()
		{
			dob = new Array();
			dob = $(this).val().split('-');
			var d = new Date();
			
			$("#age").val(d.getFullYear()-dob[2]);	
		}
		});
		$(".today-date").datepicker({dateFormat:'d-m-yy',maxDate:0});
		
		
		/*$(".datepicker").datepicker({dateFormat:'d-m-yy',changeYear: true,yearRange: '1945:'+(new Date).getFullYear(),
		onClose:function(){
				if($(this).hasClass("end_date"))
				{
					from_date = $(this).closest("tr").find("input.start_date").val();
					to_date = $(this).val();
					//alert(Date.parse(from_date));
					if (from_date >= to_date) 
					{
						alert("End date must be greater than start date");
						$(this).val('');
					}
				}
				
		}});*/
		
		
		$(".date-dob").datepicker({dateFormat:'d-m-yy',changeYear: true,yearRange: '1945:'+(new Date).getFullYear()});
		

	//Image instant preview
	$(".profile_pic").change(function(event){
									
	   var preview = $(".img-polaroid");
	   var input = $(event.currentTarget);
	   var file = input[0].files[0];
	   var reader = new FileReader();
	   reader.onload = function(e){
	       image_base64 = e.target.result;
		    $("#input_file").val(image_base64);
	       preview.attr("src", image_base64);
		   $("#data_code").val(image_base64);
	       preview.css("max-width",'180px');
	       preview.css("max-height",'180px');
	   };
	   reader.readAsDataURL(file);
	  
	});
	$(".l_val").blur(function(){
	
		if($(this).val()!="")
		{
			if($(this).val()>30)
			{
				alert("Invalid number of leaves")	
				$(this).val('');
			}
		}					  
	});
	
	
	
	/*For Holiday Module start*/
	$("#holi-end-date").on('change',function(){	
		var start_date = $("#holi-start-date").val().split("-");
		var end_date = $("#holi-end-date").val().split("-");	
		var st = new Date(start_date[2],start_date[1]-1,start_date[0]);
		var end = new Date(end_date[2],end_date[1]-1,end_date[0]);
		if(st>end)
		{		
			alert("To date must be equal/greater than from date");
			$(this).val('');
		}							 
	});
	
	$("#holi-start-date").on('change',function(){
		$("#holi-end-date").val('');								
	});
	/*For Holiday Module end*/
	
	$(".suspicious_to").datepicker({dateFormat:'d-m-yy',onClose:function(){	
	$(".suspicious_from").val('');
		if($(".suspicious_from").hasClass("hasDatepicker"))
		{
			$(".suspicious_from").removeClass('hasDatepicker');
		}
	$(".suspicious_from").datepicker({dateFormat:'d-m-yy',maxDate:$(this).datepicker('getDate')});
	}});
	
	$(".suspicious_from").datepicker({dateFormat:'d-m-yy',onClose:function(){	
	$(".suspicious_to").val('');
		if($(".suspicious_to").hasClass("hasDatepicker"))
		{
			$(".suspicious_to").removeClass('hasDatepicker');
		}
	$(".suspicious_to").datepicker({dateFormat:'d-m-yy',minDate:$(this).datepicker('getDate')});
	}});
	
	
	
	$("#address_copy").on("click",function(){
										  
        if($("#address_copy").is(':checked'))
	    {
		       $("input").each(function(){
			    this_class = $(this).attr("field_name");
		        $("input[field_name='"+this_class+"']").val($(this).val());							 
	       });
		}
		else
		{
			$("#address_tab_2 input[type=text]").each(function(){
				$(this).val('');												  
		    });		
		}
	});
	/*$(".contact").keypress(function(event){
		if($.trim($(this).val()).length>=20 && $(this).hasClass("contact_name"))
		{
			if(event.which!=0 && event.which!=8)
			     event.preventDefault();
		}
		else if($.trim($(this).val()).length>=10 && $(this).hasClass("contact_number"))
		{
			if(event.which!=0 && event.which!=8)
			     event.preventDefault();
		}
		else if($.trim($(this).val()).length>=14 && $(this).hasClass("line"))
		{
			if(event.which!=0 && event.which!=8)
			     event.preventDefault();
		}
		else if($.trim($(this).val()).length>=25 && $(this).hasClass("lines"))
		{
			if(event.which!=0 && event.which!=8)
			     event.preventDefault();
		}
		else if($.trim($(this).val()).length>=16 && $(this).hasClass("city"))
		{
			if(event.which!=0 && event.which!=8)
			     event.preventDefault();
		}
	});*/
	$(".settings").keypress(function(event){
		if($.trim($(this).val()).length>=20 && $(this).hasClass("place"))
		{
			if(event.which!=0 && event.which!=8)
			     event.preventDefault();
		}
		else if($.trim($(this).val()).length>=35 && $(this).hasClass("website"))
		{
			if(event.which!=0 && event.which!=8)
			     event.preventDefault();
		}
	});
	
});
	// remove row	
	$(".remove_row").live('click',function(){
		tbody =  $(this).closest("tbody");
		if($(this).closest("tr").find(".radio-address").attr("checked")=="checked")
		{
			$("#address").css("display","none");
			$("#address-title").css("display","none");
			
		}
		$(this).closest("tr").remove();
		tr =$(tbody).children("tr");
		$(tr).each(function(i){
			$(this).find("td.sno").text(i+1);
		});
	});
	
//checkbox clikc function

$(".family_name").live('keypress',function(){
	//alert($(this).val());					
	if($(this).val()!="")
	{
		$(".hide").show();
		
	}
	else if($(this).val()=="")
	{
		$(".hide").show();
	}
});
$(".required-check").live('click',function(){
		if($(this).attr("checked")=="checked")
		{
			if($.trim($(this).closest("tr").find(".lang").val())=="")
			{
				$(this).removeAttr("checked");
				$(this).next("input:hidden").val('');
			}
			else
			{
				$(this).next("input:hidden").val(1);
			}
		}
		else
		{
			$(this).next("input:hidden").val('');
		}
	});
$(".radio-address").live("click",function(){
										
	if($(this).is(':checked') )
	{
		$(".wage-address").each(function(){										 
		$(this).val('');								 
		});
		$("#address").css("display","block");
		$("#address-title").css("display","block");
	}
	else
	{
		$("#address").css("display","none");
	}
});
$(".lang").live("blur",function(){
		
		if($.trim($(this).val())=="")
		{
			elements = $(this).closest("tr").find(".required-check");
			$(elements).each(function(i){
				if($(this).attr("checked")=="checked")
				{
					$(this).removeAttr("checked");
					$(this).next("input:hidden").val('');	
				}
			});
		}
});

$(".address_tab input[type=text]").live("keyup blur",function(){
															  
	if($("#address_copy").is(':checked'))
	{													 
		this_class = $(this).attr("field_name");
		$("input[field_name='"+this_class+"']").val($(this).val());		
	}
});

$("#img-light").live('click',function(){
$("#light").slideDown(300);
$("#fade").show();
});
$("#img-normal,#fade").live('click',function(){
$("#light").slideUp(300);
$("#fade").hide();
});
$(".holiday-reset").live('mousedown',function(){														  
		$.ajax({
		   	url : BASE_URL + "api/reset_session/",
			type : "POST",
			data : {class:ct_class,method:ct_method},
			success:function(res)
			{				
				window.location = BASE_URL+"users/";
			}
		   });
		
});

/*For Employee Module*/
$(".end_date").live('change',function(){
	var start_date = $(this).closest("tr").find("input.start_date").val().split("-");
	var end_date = $(this).val().split("-");		
	var st = new Date(start_date[2],start_date[1]-1,start_date[0]);
	var end = new Date(end_date[2],end_date[1]-1,end_date[0]);
	if(st>=end)
	{		
		alert("End date must be greater than start date");
		$(this).val('');
	}							 
});

$(".start_date").live('change',function(){	
	$(this).closest("tr").find("input.end_date").val('')
});
$(".mail").live('blur',function(){
								
	var mail_id = new Array();				
	mail_id = $(this).val().split(',');
	var res = 0;
	for(k=0;k<mail_id.length;k++)
	{
		if(!check_valid_email(mail_id[k]))
			res = 1;
		
	}
	if(res==1)
	{
		alert("Invalid Email Id(s)");
		$(this).val('');		
	}
	
});
function check_valid_email(email)
{
	if(email!="")
	{
		var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;

		if (filter.test(email))
		{
			return true;
		}
		else
		{
			return false
		}
	}
}
