/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

var guest = $( '#guest' );
guest.live( 'pageinit',function(event){
  
});
guest.live("pageshow", function() {	    
    initialize();
    //setTimeout($("#showIns").click(), 500);
    pasajeroEvents();
    $( "#popupInstruction" ).popup( "open" );
});

$("#popupInstruction").live("pageshow", function() {	    
    alert();     
});