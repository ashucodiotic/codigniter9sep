//get district
$('body').on('change','.states',function(){
    var state   =   $(this).val();
    var res 	= 	sendAjax('get-district',{state_id:state});
    generateTemplate(res,'district-tamplate','district-container');
    $('#city-container').html('<option value="">---Select city---</option>');
});

//get city
$('body').on('change','.district',function(){
    var district    =   $(this).val();
    var res 		= 	sendAjax('get-city',{district_id:district});
    generateTemplate(res,'city-tamplate','city-container')
});

//delete data
 $('body').on('click','.delete-entry',function(e){
  var id            = $(this).attr('unqid');         
  var route         = $(this).attr('route');
  var title         = $(this).attr('title');
  confirmBoxActiveInactive(route,id,title,'danger','red');
});

//active inactive
 $('body').on('click','.change-status',function(e){
  var id            = $(this).attr('unqid');         
  var route         = $(this).attr('route');
  var title         = $(this).attr('title');
  var status        = $(this).attr('status');
  var msg           = $(this).attr('msg');
  if (status == 'active') {
    var data          = {id:id,status:1};
    confirmBoxActiveInactiveWithData(route,title,data,'danger','red',msg);
  }else{
    var data          = {id:id,status:0};
    confirmBoxActiveInactiveWithData(route,title,data,'success','green',msg);
  }
});
  var $loading = $('#loading').hide();
   $(document)
     .ajaxStart(function () {
        //ajax request went so show the loading image
         $loading.show();
     })
      .ajaxStop(function () {
       //got response so hide the loading image
        $loading.hide();
    });

