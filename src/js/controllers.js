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
      	
    }
    )

})(); 