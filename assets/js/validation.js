var regNumber       =   RegExp(/^[0-9]*$/);
var regName         =   RegExp(/^[a-z A-Z -.']+$/);
var regAlhpa        =   RegExp(/^[a-z A-Z ]+$/);
var regAlphaNum     =   RegExp(/^[a-z A-Z. 0-9'()/&,-]+$/);
var regAlphaDate    =   RegExp(/^[a-z A-Z. 0-9'()/&,-:]+$/);
var regEmail        =   RegExp(/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i);
var regCard         =   RegExp(/^[0-9.]*$/);
var regUrl          =   RegExp(/(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/);
var regPhone        =   RegExp(/^[0-9 \s]{10}$/);
var regIndiaPhone   =   RegExp(/^[0]?[789]\d{9}$/);
var regnotnumeric   =   RegExp(/^[a-z A-Z !@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]*$/);
var regJoinDate     =   RegExp(/^(0[1-9]|[12][0-9]|3[01])[\- \/.](?:(0[1-9]|1[012])[\- \/.](19|20)[0-9]{2})$/);
var regPassword     =   RegExp(/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/);
var regHour         =   RegExp(/^\d{1,2}[:][0-5][0-9]$/);
var regPin          =   RegExp(/^[0-9 \s]{6}$/);
var regalpha        =   RegExp(/^[a-z A-Z .]+$/);
var regindiamobile  =   RegExp(/^[6-9]\d{9}$/);
var regwithspecil   =   RegExp(/^[a-z A-Z. 0-9']+$/);
var regcode         =   RegExp(/^[A-Z 0-9']+$/);
var numericReg      =   RegExp(/^[0-9']+$/);



    function _onlyAlphaReg(nameObj,message){

        var name          =   $.trim($(nameObj).val());


         if ($.trim(name) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');
                      
             }else if(!regalpha.test(name) ||  name.length < 2 || name.length > 50 ){

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;

            }else{

                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }


  function _onlyNum(nameObj,message){        
        var name          =   $.trim(parseInt ($(nameObj).val()));


         if ($.trim(name) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');
                      return false;
                      
             }else if(!regNumber.test(name) ||  name < 1){
                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;

            }else{

                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }


    function _anythingget(nameObj,message){

        
        var name          =   $.trim($(nameObj).val());

         if ($.trim(name) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');
                      
             }else if(!regAlphaDate.test(name) ||  name.length < 2 || name.length > 50 ){

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;

            }else{

                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }



    function _couponCodeReg(nameObj,message){

        var name          =   $.trim($(nameObj).val());


         if ($.trim(name) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');

             }else if(!regcode.test(name) || name.length < 4 || name.length > 10 ){
                        
                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
            }else{

                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }



     function _discountReg(nameObj,message){

        var name          =   $.trim($(nameObj).val());


         if ($.trim(name) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');
                      
             }else if(!regNumber.test(name) || parseInt(name) < 1 || parseInt(name) > 100 ){
                      
                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
            }else{
                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }



    function _nospecilReg(nameObj,message){

        var name          =   $.trim($(nameObj).val());


         if ($.trim(name) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');
                      
             }else if(!regwithspecil.test(name)){
                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
            }else{
                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }



    function _emailReg(nameObj,message){

        var email          =   $.trim($(nameObj).val());

         if (email == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');

            }else if(!regEmail.test(email)){

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;

            }else{

                    nameObj.parent().find('.error').text('');
                    nameObj.removeClass('border-danger');
                    nameObj.parents('.form-group').removeClass('has-danger')
                    return  true;
            }

    }



    function _indiaMobileReg(nameObj,message){

        var mobile          =   $(nameObj).val();


        if (mobile == '') {

                        nameObj.trigger('focus');
                        nameObj.addClass('border-danger');
                        nameObj.parent().find('.error').text('This field is required');
                        nameObj.parents('.form-group').addClass('has-danger');

        }else if(!regindiamobile.test(mobile)){
                        nameObj.trigger('focus');
                        nameObj.addClass('border-danger');
                        nameObj.parent().find('.error').text(message);
                        nameObj.parents('.form-group').addClass('has-danger');
                        return  false;     
        }else{
                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
        }
    }   



    


    function _passwordReg(nameObj,message){

        var password          =   $(nameObj).val();

           if ($.trim(password) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');

             }else if(password.length < 6 || password.length >= 21){
                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
            }else{
                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }


     function _strongPasswordReg(nameObj,message){

        var password          =   $(nameObj).val();

           if ($.trim(password) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');

             }else if(!regPassword.test(password)){
                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
            }else{
                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }



     function _pin(nameObj,message){

        var name          =   $.trim($(nameObj).val());

         if ($.trim(name) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');

             }else if(!regPin.test(name)){
                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
            }else{

                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }

    function _numericReg(nameObj,message){

        var number          =   $(nameObj).val();
        
         if ($.trim(number) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');

            }else if(isNaN(number)){

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
                      

            }else{
                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }   

    function _alphaNum(nameObj,message){

        var name          =   $.trim($(nameObj).val());

         if ($.trim(name) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');

             }else if(!regAlphaNum.test(name)){
                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
            }else{

                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }



    function _numericNotBlankReg(nameObj,message){

        var number          =   $(nameObj).val();
        
         if (isNaN(number) || number == '') {

                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-error');
                      return  false;

            }else{

                    nameObj.parent().find('.error').text('');
                    nameObj.removeClass('border-danger');
                    nameObj.parents('.form-group').removeClass('has-error');
                    return  true;

            }

    }



    function _mobileReg(nameObj,message){

        var mobile          =   $(nameObj).val();


        if (mobile.length != 10 || isNaN(mobile) || mobile == '') {

                        nameObj.parent().find('.error').text(message);
                        nameObj.parents('.form-group').addClass('has-error');
                        return  false;
        }else{
                        nameObj.parent().find('.error').text('');
                        nameObj.removeClass('border-danger');
                        nameObj.parents('.form-group').removeClass('has-error');
                        return  true;
        }
    }



    function _selectoptionReg(nameObj,message){

        var select          =   $.trim($(nameObj).val());

        if (select == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parents('.form-group').find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
             }else{
                      nameObj.parents('.form-group').find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
        }
    }



    function _priceReg(nameObj,message){

        var price          =   $(nameObj).val();


        if ( price == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parents('.form-group').find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');
        }else if(price == 0 || isNaN(price) || price <= 0){
                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parents('.form-group').find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;    
        }else{

                       nameObj.parents('.form-group').find('.error').text('');
                       nameObj.parents('.form-group').removeClass('has-danger')
                       return  true;
        }
    }


     function removeValidatedFromtant(inputclass,msgClass){

                 $(inputclass).find('input').on('keyup',function(e){
                  if (e.keyCode!=13) {
                      $(this).parents(inputclass).removeClass('has-danger');
                      $(this).parent().find(msgClass).text('');    
                  }else{

                  }
                  
                });            
    }



    function removeChangeValidatedFromtant(parentclass,msgClass){


                 $(parentclass).find('input').on('click change',function(e){
                  if (e.keyCode!=13) {
                      $(this).parents(parentclass).removeClass('has-danger');
                      $(this).parent().find(msgClass).text('');    
                  }else{

                  }
                  
                });            
    }


    function removeValidatedFromtanttextarea(inputclass,msgClass){

                 $(inputclass).find('textarea').on('keyup',function(e){
                  if (e.keyCode!=13) {
                      $(this).parents(inputclass).removeClass('has-danger');
                      $(this).parent().find(msgClass).text('');    
                  }else{

                  }
                  
                });            
    }


       function removeValidatedFromtantSelect(inputclass,msgClass){

                 $(inputclass).find('select').on('change',function(e){
                  if (e.keyCode!=13) {
                      $(this).parents(inputclass).removeClass('has-danger');
                      $(this).parents(inputclass).find(msgClass).text('');    
                  }else{

                  }
                  
                });            
    }





      function _phoneNum(nameObj,message){

        var name          =   $.trim($(nameObj).val());

         if (!regPhone.test(name) || $.trim(name) == '') {

                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-error');
                      return  false;
             }else{
                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-error');
                      return  true;
            }

    }



    function _blankReg(nameObj,message){

        var name          =   $.trim($(nameObj).val());

         if ($.trim(name) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
             }else{
                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }

    }



    function _confirmPasswordReg(newPassObj,conpasswordObj,message){

        var newpassword          =   $(newPassObj).val();
        var confirmpassword      =   $(conpasswordObj).val();

           if ($.trim(confirmpassword) == '' || newpassword!=confirmpassword) {

                      conpasswordObj.trigger('focus');
                      conpasswordObj.parent().find('.error').text(message);
                      conpasswordObj.parents('.form-group').addClass('has-danger');
                      return  false;
             }else{
                      conpasswordObj.parent().find('.error').text('');
                      conpasswordObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }
    }




    function _pricesellingReg(mrpObj,spobj,message1,message2){

        var mrpVal          =   $(mrpObj).val();
        var spVal           =   $(spobj).val();


         if (spVal == '') {

                      
                      spobj.trigger('focus');
                      spobj.parents('.form-group').find('.error').text('This field is required');
                      spobj.parents('.form-group').addClass('has-danger');

            }else if(isNaN(spVal) || parseInt(spVal)<1){

                      spobj.trigger('focus');
                      spobj.parents('.form-group').find('.error').text(message1);
                      spobj.parents('.form-group').addClass('has-danger');
                      return  false;                      

            }else if(parseInt(mrpVal)<parseInt(spVal)){

                      spobj.trigger('focus');
                      spobj.parents('.form-group').find('.error').text(message2);
                      spobj.parents('.form-group').addClass('has-danger');
                      return  false;
                    
            }else{

                    spobj.parents('.form-group').find('.error').text('');
                    spobj.parents('.form-group').removeClass('has-danger')
                    return  true;
            }
    }




    function _dateReg(nameObj,message){

        var name          =   $.trim($(nameObj).val());
        var fullDate      =   new Date();
        var twoDigitMonth = ((fullDate.getMonth().length+1) === 1)? (fullDate.getMonth()+1) : '0' + (fullDate.getMonth()+1);

        var currentDate   =  fullDate.getDate()+ "/" + twoDigitMonth + "/" + fullDate.getFullYear();
        

         if ($.trim(name) == '') {

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text('This field is required');
                      nameObj.parents('.form-group').addClass('has-danger');
                      
             }else if(!regJoinDate.test(name) || name > currentDate){

                      nameObj.trigger('focus');
                      nameObj.addClass('border-danger');
                      nameObj.parent().find('.error').text(message);
                      nameObj.parents('.form-group').addClass('has-danger');
                      return  false;
                      
            }else{

                      nameObj.parent().find('.error').text('');
                      nameObj.removeClass('border-danger');
                      nameObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            } 

    }



    function _firstdatetodateReg(firstDateObj,endDateObj,message1,message2){
      

        var startdate             =   $.trim($(firstDateObj).val());      
        var enddate               =   $.trim($(endDateObj).val());      

         if (!regJoinDate.test(enddate) || $.trim(enddate) == '') {
                      endDateObj.trigger('focus');
                      endDateObj.parent().find('.error').text(message1);
                      endDateObj.parents('.form-group').addClass('has-danger');
                      return  false;
             }else if(Date.parse(startdate) >= Date.parse(enddate) || enddate== ''){                      
                      endDateObj.trigger('focus');
                      endDateObj.parent().find('.error').text(message2);
                      endDateObj.parents('.form-group').addClass('has-danger');
                      return  false;
            }else{
                      endDateObj.parent().find('.error').text('');
                      endDateObj.parents('.form-group').removeClass('has-danger')
                      return  true;
            }
       
    }




    function _twoqntyReg(goqntyObj,ctrqntyobj,message1,message2){



        var goqntyVal                =   $.trim($(goqntyObj).val());      
        var cntqntyVal               =   $.trim($(ctrqntyobj).val());   

        
      
       
        if ((goqntyVal == '' || !numericReg.test(goqntyVal) || goqntyVal == 0) && (cntqntyVal== '' || !numericReg.test(cntqntyVal) || cntqntyVal == 0) ) {

              goqntyObj.parent().find('.error').text(message1);
              goqntyObj.parents('.form-group').addClass('has-danger');
              goqntyObj.trigger('focus');
              return false;

        }else if (goqntyVal != '' && (!numericReg.test(goqntyVal) || goqntyVal == 0)) {

              goqntyObj.parent().find('.error').text(message1);
              goqntyObj.parents('.form-group').addClass('has-danger');
              goqntyObj.trigger('focus');
              return false;
            
        }else if (cntqntyVal != '' &&(!numericReg.test(cntqntyVal) || cntqntyVal == 0)) {


              ctrqntyobj.parent().find('.error').text(message2);
              ctrqntyobj.parents('.form-group').addClass('has-danger');
              ctrqntyobj.trigger('focus');
              return false;

        }else{
                
                ctrqntyobj.parent().find('.error').text('');
                ctrqntyobj.parents('.form-group').removeClass('has-danger')                

                ctrqntyobj.parent().find('.error').text('');
                ctrqntyobj.parents('.form-group').removeClass('has-danger')                
                return true;
        }

    }







    function _formReset(addbtnClass,formClass){

        $('body').on('click',addbtnClass,function(){
            $(formClass).trigger('reset');
            $('body').find(formClass).find('.has-danger').removeClass('has-danger');
            $('body').find(formClass).find('.has-success').removeClass('has-success');
            $('body').find(formClass).find('.error').text('');
            $('.selectpicker').selectpicker('refresh');

        })

    }


     function _successhas(inputClass){    
      if(!inputClass.parents('.form-group').hasClass('has-success')){
        inputClass.parents('.form-group').removeClass('has-danger');
        inputClass.parents('.form-group').addClass('has-success');
      }
      
    }

    $('body').on('keyup','.form-group .form-control',function(){      
        _successhas($(this));
    })



    function _clicksuccesshas(inputClass){    

      if(!inputClass.parents('.form-group').hasClass('has-success')){
        inputClass.parents('.form-group').removeClass('has-danger');
        inputClass.parents('.form-group').addClass('has-success');
      }
      
    }

    $('body').on('click ,change','.form-group .form-control',function(){      
        _clicksuccesshas($(this));
    });



  function _changesuccesshas(inputClass){    

      if(!inputClass.parents('.form-group').hasClass('has-success')){
          inputClass.parents('.form-group').removeClass('has-danger');
          inputClass.parents('.form-group').addClass('has-success');
      }
      
    }

    $('body').on('change','.form-group .selectpicker',function(){   
    
        _changesuccesshas($(this));
    })

