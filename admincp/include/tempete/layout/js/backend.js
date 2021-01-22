$(function(){

  $('[placeholder]').focus (function(){
    
    $(this).attr("data-text" , $(this).attr("placeholder"));
    $(this).attr("placeholder", "");
    
  }); 

  $('[placeholder]').blur (function(){
            
    $(this).attr('placeholder',$(this).attr('data-text'));
 
  });

   $("input").each(function(){
     
    if($(this).attr("required") === "required")
    {
         $(this).after("<span class='ask'>*</span>");
    }
 
  });


  $(".showpass").hover(function(){
      
    $("input[type='password']").attr("type","text");
    $(this).css({
      color: "#080",
    })

  });
  
  $("input[type='password']").blur(function(){
      
    $(this).attr("type","password");
    $(".showpass").css({
      color: "#000",
    })

  });

  $(".confirm").click(function(){

      return confirm("are you sure sir ?");
  });



  $(".alert-danger").fadeOut(10000);
  $(".alert-success").fadeOut(6000);

  $(".image").height($(window).height());

});