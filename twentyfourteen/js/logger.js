$.log = function(message,id){
  var $logger = $("#"+id+"");
  if($logger.val())
  $logger.val($logger.val() + "; " + message );
  else
  $logger.val(message );
}
