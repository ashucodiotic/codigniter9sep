$(document).ajaxStart(function() {
    $('.loader-fix').removeClass('d-none').addClass('d-flex');
})
$(document).ajaxStop(function() {
    $('.loader-fix').addClass('d-none').removeClass('d-flex');
});

$('body').on('click','.reset-form',function(){
   var form_name = $(this).attr('form')
   $('body').find('.'+form_name)[0].reset()
})

function sendAjaxFrm(rurl, rdata){
	var  returndata = "";
	$.ajax({
		url : siteurl+rurl,
		type:'POST',
		data: rdata,
		processData	: 	false,
		contentType	: 	false,
		async		: 	false,
		success:function(res){	
			
			res = $.parseJSON(res)		
			returndata = res;
			$('[data-toggle="tooltip"]').tooltip();
		},
		complete: function() {
	        $(this).data('requestRunning', false);
	    },
		 statusCode: {
		        500: function() {
		        	showMessage('danger', "Something went wrong on server")				          
		        },
		        404:function(){
		        	showMessage('danger', "Invalid Request")				          				        	
		        }				       
		      }

	})

	return returndata;
}


function sendAjax(rurl, rdata){	
	var  returndata = "";

	$.ajax({
		url : siteurl+rurl,
		type:'POST',
		data: rdata,		
		async		: 	false,
		
		success:function(res){	
			
			res = $.parseJSON(res)		
			returndata = res;
			$('[data-toggle="tooltip"]').tooltip()
		},
		complete: function() {
	        $(this).data('requestRunning', false);
	    },
		 statusCode: {
		        500: function() {
		        	showMessage('danger', "Something went wrong on server")				          
		        },
		        404:function(){
		        	showMessage('danger', "Invalid Request")				          				        	
		        }				       
		      }

	})

	return returndata;
}

function sendAjaxByGet(rurl,rdata){	
	var  returndata = "";
	$.ajax({
		url : siteurl+rurl,
		type: 'GET',
		data: rdata,		
		async		: 	false,
		
		success:function(res){	
			
			res = $.parseJSON(res)		
			returndata = res;
			$('[data-toggle="tooltip"]').tooltip()
		},
		complete: function() {
	        $(this).data('requestRunning', false);
	    },
		 statusCode: {
		        500: function() {
		        	showMessage('danger', "Something went wrong on server")				          
		        },
		        404:function(){
		        	showMessage('danger', "Invalid Request")				          				        	
		        }				       
		      }

	})

	return returndata;
}

  function addForm(objName,rurl,durl,modalName, thisObj){	
 	////console.log(ok);
		var formdata = new FormData(thisObj);
		var res = sendAjaxFrm(rurl, formdata);
		var status = res.status;
		var msg = res.msg;
				
		if(status.toLowerCase() == 'ok'){			
			$(modalName).find('form').trigger('reset');
			$(modalName).find('form').find('.form-group').each(function(){
				if ($(this).hasClass('is-filled')){
					$(this).removeClass('is-filled');
				}

				$(this).removeClass('is-filled');
				$(this).removeClass('has-success');
				if ($(this).find('img').length) {
					var html = '<span class="upload-IMg pointer" ><i class="fa fa-camera fa-2x" data-toggle="tooltip" style="vertical-align: middle;"></i> <b>Upload Image</b></span>';
					$(this).find('.flex-wrap').html(html);
				}
			});
			$(modalName).modal('hide');
			showMessage('success', msg);
			initTable(src, dest, durl, data);
		}else{

			$(modalName).modal('hide');
			showMessage('danger', msg);
		}
	}


function generateTemplate(data, src, destination){		
        var source   = document.getElementById(src).innerHTML;
        var template = Handlebars.compile(source);
        var generatedTemplate = template(data);       
        var rowContainer = document.getElementById(destination);    
        rowContainer.innerHTML = generatedTemplate;
        
        // if(is_admin == "true"){
	    //   //console.log("yaha1")
	    //   $('.user-access-btn').removeClass('d-none')  
	    // }else{
	    //  var access_route_ids = $('.user-access-route-ids').val();
	    //  var access_route_ids_array =  access_route_ids.split(",")

	    //   for (var x = access_route_ids_array.length - 1; x >= 0; x--) {
	    //     $('body').find("[userAccessRouteId="+access_route_ids_array[x]+"]").removeClass('d-none');
	    //   }
	    // }
       
}


function initTable(src, dest, url, data){
	var res = sendAjax(url, data);

	var maxPage = res.result.pages;
	$('#max-page').text(maxPage);
	$('#current-page').text(res.result.page);

    if (parseInt(res.result.showing_upto) <= parseInt(res.result.showing_from)) {
    	res.result.showing_from = res.result.showing_upto;
    }

	generateTemplate(res, src, dest);	
	generateTemplate(res, 'fromTo', 'fromToContainer');	
	generateTemplate(res, 'totalResult', 'totalResultContainer');	
	generateTemplate(res, 'pageCountTemp', 'pageCountContainer');	
	
	
    if(res.result.page == 1){
		$('.btn-prev').addClass('d-none');
	}else{
		$('.btn-prev').removeClass('d-none');
	}

	if(res.result.count == res.result.showing_upto){	 	
	   $('.btn-next').addClass('d-none');  
	}else{	    
	    $('.btn-next').removeClass('d-none')        
	}

	$('[data-toggle="tooltip"]').tooltip();

	/*if(is_admin == "true"){
      //console.log("yaha1")
      $('.user-access-btn').removeClass('d-none')  
    }else{
     var access_route_ids = $('.user-access-route-ids').val();
     var access_route_ids_array =  access_route_ids.split(",")

      for (var x = access_route_ids_array.length - 1; x >= 0; x--) {
        $('body').find("[userAccessRouteId="+access_route_ids_array[x]+"]").removeClass('d-none');
      }
    }*/
}

$('.per-page').on('change',function(){
	var perPage = $(this).val();	
	$('#num-page').text(perPage);
	var src = $(this).attr('temp-src');
	var query = $('.search-form').find('input').val();
	var dest = $(this).attr('temp-dest');
	var url = $(this).attr('temp-url');
	
	$('#current-page').text(1);
	data.limit = perPage;
	data.page = 1;
	data.query = query;
	initTable(src, dest, url, data);
})

$('.search-form').on('submit',function(e){
	e.preventDefault();
	var query = $(this).find('input').val();	
	var perPage = $('#num-page').text();
	var src = $(this).attr('temp-src');
	var dest = $(this).attr('temp-dest');
	var url = $(this).attr('temp-url');
	
	$('#current-page').text(1);
	data.limit = perPage;
	data.page = 1;
	data.query = query;
	initTable(src, dest, url, data);
})

$('.search-form input').on('keyup',function(e){
	var query = $(this).val();	
	
	if (query == '') {
		var perPage = $('#num-page').text();
		var src = $(this).parents('.search-form').attr('temp-src');
		var dest = $(this).parents('.search-form').attr('temp-dest');
		var url = $(this).parents('.search-form').attr('temp-url');
		$('#current-page').text(1);
		data.limit = perPage;
		data.page = 1;
		data.query = query;
		initTable(src, dest, url, data);	
	}
	
})

$('body').find('.btn-next').on('click',function(){		
	var perPage = $('#num-page').text();	
	var query = $('.search-form').find('input').val();			
	var src = $(this).attr('temp-src');
	var dest = $(this).attr('temp-dest');
	var url = $(this).attr('temp-url');		
	var currentPage = $('#current-page').text();
	var maxPage = $('#max-page').text();	
	var page = parseInt(currentPage)+1;	 
	$('#current-page').text(page);
	data.limit = perPage;
	data.page = page;
	data.query = query;
	initTable(src, dest, url, data);
});


$('body').find('.btn-prev').on('click',function(){	
	var perPage = $('#num-page').text();			
	var src = $(this).attr('temp-src');
	var query = $('.search-form').find('input').val();
	var dest = $(this).attr('temp-dest');
	var url = $(this).attr('temp-url');		
	var currentPage = $('#current-page').text();
	var page = currentPage == 1 ? 1 : parseInt(currentPage)-1;	
	$('#current-page').text(page);
	//var data = {'limit':perPage, 'page':page}	
	data.limit 	= perPage;
	data.page 	= page;
	data.query 	= query;
	initTable(src, dest, url, data);
});


Handlebars.registerHelper("inc", function(value, options){
    return parseInt(value) + 1;
});

Handlebars.registerHelper("incCount", function(index,page,limit){
	return parseInt((page-1)*limit) + (index+1);
});
	
  //delete table row
  $('body').on('click','.delete-btn',function(){
      var id        = $(this).attr('id');
      var key       = $(this).attr('key');
      var id_key    = $(this).attr('id_key');
      var res     	= sendAjax('delete',{id:id,key:key,id_key:id_key});
      if (res.status == 'ok') {
      	initTable(src, dest, url, data);
      	showMessage('success',res.msgs);
      }else{
      	showMessage('danger',res.msgs);
      }
      $(this).parents('.modal').modal('hide');
   });

    //some attr put on modal delete btn
  $('body').on('click','.delete-row',function(){
      var id        = $(this).attr('id');
      var key       = $(this).attr('key');
      var id_key    = $(this).attr('id_key');
      $('body').find('#deleteModal .delete-btn').attr({
      	id 	: id,
      	key : key,
      	id_key : id_key
      });
   });




Handlebars.registerHelper('ifCond', function (v1, operator, v2, options) {
    switch (operator) {
        case '==':
            return (v1 == v2) ? options.fn(this) : options.inverse(this);
        case '===':
            return (v1 === v2) ? options.fn(this) : options.inverse(this);
        case '!==':
            return (v1 !== v2) ? options.fn(this) : options.inverse(this);
        case '<':
            return (v1 < v2) ? options.fn(this) : options.inverse(this);
        case '<=':
            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
        case '>':
            return (v1 > v2) ? options.fn(this) : options.inverse(this);
        case '>=':
            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
        case '&&':
            return (v1 && v2) ? options.fn(this) : options.inverse(this);
        case '||':
            return (v1 || v2) ? options.fn(this) : options.inverse(this);
        default:
            return options.inverse(this);
    }
});


Handlebars.registerHelper('inArry', function (Arry,value) {	
    if(Array.isArray(Arry)){
    	if ($.inArray(value,Arry)){
    		return true;		
    	}else{
    		return false;
    	}
    }else{
    	return false;
    }
});


Handlebars.registerHelper('checked', function (Arry,value) {
    if(Array.isArray(Arry)){
    	if($.inArray(value,Arry) != -1){
    		return 'checked="true"';		
    	}else{
    		return;
    	}
    }else{
    	return;
    }
});


Handlebars.registerHelper('dateFormat', function (date) {

	var returnDate 	= '';
	var month 		=	new Array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
	var hours 		=	new Array('12','01','02','03','04','05','06','07','08','09','10','11','12','01','02','03','04','05','06','07','08','09','10','11');
	var min 		=	new Array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31','32','33','34','35','36','37','38','39','40','41','42','43','44','45','46','47','48','49','50','51','52','53','54','55','56','57','58','59');
	var dateObj 	=	new Date(date);
		returnDate += 	dateObj.getDate()+' ';
		returnDate += 	month[dateObj.getMonth()]+' ';
		returnDate += 	dateObj.getFullYear()+'  ,';
		returnDate += 	hours[dateObj.getHours()] + ':';
		returnDate += 	min[dateObj.getMinutes()] + ':';
		returnDate += 	min[dateObj.getSeconds()] +' ';
		if (dateObj.getHours() > 11) {
			returnDate += 'PM';
		}else{
			returnDate +='AM';
		}
	return returnDate

});


function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
	
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    
    var CSV = '';    
    //Set Report title in first row or line
    
    CSV += '';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";
        
        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
            
            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);
        
        //append Label row with line break
        CSV += row + '\r\n';
    }
    
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        
        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);
        
        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var fileName = "";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");   
    
    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".csv";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}



function confirmBoxActiveInactive(controller,id,title,buttonClass,type){
	//console.log(title)
	$.confirm({
		    title: title,
		    content: 'Are you sure '+title+' this entry !',
		    animation: 'scaleY',
            closeAnimation: 'scaleY',
            animateFromElement: false,
            theme: 'modern', // 'material', 'bootstrap'
		    type: type,
		    closeIcon: true,
		    buttons: {
		    	OK : {
			            btnClass: 'btn-'+buttonClass,
			            action: function(){
			            	_deleteAjax(controller,id);
			            }
			        },
		        Cancel: function () {
		          
		        },
		        
		    }
		});
}


function confirmBoxActiveInactiveWithData(controller,title,getdata,buttonClass,type,msg){
	$.confirm({
		    title: title,
		    content: msg,
		    animation: 'scaleY',
            closeAnimation: 'scaleY',
            animateFromElement: false,
            theme: 'modern', // 'material', 'bootstrap'
		    type: type,
		    closeIcon: true,
		    buttons: {
		    	OK : {
			            btnClass: 'btn-'+buttonClass,
			            action: function(){
			            	var dataToReturn	=	 sendAjax(controller,getdata);
			            	if (dataToReturn.status=='OK'){
								initTable(src, dest, url, data);
								showMessage('success', dataToReturn.msg);
							}else{
								showMessage('danger', dataToReturn.msg);
							}
			            }
			        },
		        Cancel: function () {
		          
		        },
		        
		    }
		});
}

function _deleteAjax(controller,id){	
	$.ajax({
			url 	    : 	siteurl+controller,
			method 	    : 	'POST',
			data 		: 	{'id':id},
			cache		: 	false,
			success 	: 	function(response){
				
				var responseObj = $.parseJSON(response);
				
					dataToReturn = responseObj;
				if (dataToReturn.status=='OK'){
					initTable(src, dest, url, data);
					showMessage('success', dataToReturn.msg);
				}else{
					showMessage('danger', dataToReturn.msg);
				}

			}	

		});

}

//peview page start
function goBack() {
  window.history.back();
}
//peview page end


//remove value in array start
  function arrayRemove(arr, value) {

     return arr.filter(function(ele){
         return ele != value;
     });

  }
//remove value in array end

function confirmBoxForPartyTab(controller,id,title,buttonClass,type){
	var isReturn  = false;
	$.confirm({
		    title: title,
		    content: 'Are you sure '+title+' this entry !',
		    animation: 'scaleY',
            closeAnimation: 'scaleY',
            animateFromElement: false,
            theme: 'modern', // 'material', 'bootstrap'
		    type: type,
		    closeIcon: true,
		    buttons: {
		    	OK : {
			            btnClass: 'btn-'+buttonClass,
			            action: function(){
			              	return  true;
			            }
			        },
		        Cancel: function () {
		          return  false;
		        },
		        
		    }
		});

}

function _deleteAjaxByPartyTab(controller,id){
	var isreturn	 = true;
	$.ajax({
			url 	    : 	siteurl+controller,
			method 	    : 	'POST',
			data 		: 	{'id':id},
			cache		: 	false,
			async		: 	false,
			success 	: 	function(response){				
				var responseObj = $.parseJSON(response);				
					dataToReturn = responseObj;
				if (dataToReturn.status=='OK'){
					isreturn = true;
					showMessage('success', dataToReturn.msg);
				}else{
					isreturn = false;
					showMessage('danger', dataToReturn.msg);
				}

			}	

		});
	return isreturn ;

}