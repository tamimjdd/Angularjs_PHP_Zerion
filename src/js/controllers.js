(function(){

    angular.module("controllerModule",[]).controller('HelloWorldCtrl',function($scope){
         $scope.name = "hello world!";
         $scope.init = function () {
            var date_input=$('input[name="date"]'); //our date input has the name "date"
            var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
            var options={
              format: 'mm/dd/yyyy',
              container: container,
              todayHighlight: true,
              autoclose: true,
            };
            date_input.datepicker(options);
            
            $("#tel-input").mask("(000) 000-0000");
          
              var handle = $( "#custom-handle" );
              var rate = $( "#slider" ).slider({
                  max: 10,
                  create: function() {
                      handle.text( $( this ).slider( "value" ) );
                  },
                  slide: function( event, ui ) {
                      handle.text( ui.value );
                      $("#rate").val(ui.value );
                  }
              });	 
      };
      $scope.submitForm = function() {
          var error = "false";
           if($("#formGroupFirstNameInput").val() == null || $("#formGroupFirstNameInput").val().trim().length == 0){
               $("#formGroupFirstNameInput").addClass("error");
               error = "true";
           }else{
               $("#formGroupFirstNameInput").removeClass("error");
           }
           if($("#formGroupLastNameInput").val() == null || $("#formGroupLastNameInput").val().trim().length == 0){
               $("#formGroupLastNameInput").addClass("error");
               error = "true";
           }else{
               $("#formGroupLastNameInput").removeClass("error");
           }
           if($("#inputEmail3").val() == null || $("#inputEmail3").val().trim().length == 0){
               $("#inputEmail3").addClass("error");
               error = "true";
           }else{
              var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
              if (reg.test($("#inputEmail3").val()) == false) 
              {
                  $("#inputEmail3").addClass("error");
                  error = "true";
              }else{
                  $("#inputEmail3").removeClass("error");
              }
           }
           if($("#tel-input").val() == null || $("#tel-input").val().trim().length == 0){
               $("#tel-input").addClass("error");
               error = "true";
           }else{
               if($("#tel-input").val().trim().length == 14){
                   $("#tel-input").removeClass("error");
               }else{
                    $("#tel-input").addClass("error");
                  error = "true";
               }
               
           }
           if($("#zip-input").val() == null || $("#zip-input").val().trim().length == 0){
               $("#zip-input").addClass("error");
               error = "true";
           }else{
               if($("#zip-input").val().trim().length == 5){
                   $("#zip-input").removeClass("error");
               }else{
                    $("#zip-input").addClass("error");
                  error = "true";
               }
           }
           if($("#inlineFormCustomSelect").val() == "Choose" || $("#inlineFormCustomSelect").val().trim().length == 0){
               $("#inlineFormCustomSelect").addClass("error");
               error = "true";
           }else{
               $("#inlineFormCustomSelect").removeClass("error");
           }
           if($("#date").val() == null || $("#date").val().trim().length == 0){
               $("#date").addClass("error");
               error = "true";
           }else{
               $("#date").removeClass("error");
           }
           if(error == "true"){
               document.getElementById("errorAdd").innerHTML = "Complete the details!!";
               document.getElementById('errorAdd').scrollIntoView();
               return false;
           }else{
               document.getElementById("errorAdd").innerHTML = "";
               return true;
           }
      };	
    }
    )

})(); 