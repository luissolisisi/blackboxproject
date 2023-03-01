function vLongitud(objeto,texto,min,max) {
    if ( objeto.val().length > max || objeto.val().length < min ) {
        objeto.addClass('alert alert-danger');
        objeto.attr("placeholder",texto);
        return false;
    } else {

        objeto.removeClass('alert alert-danger');
       
        return true;
    }
}


function vExpresion(objeto,regexp,texto) {
    if ( !( regexp.test( objeto.val() ) ) ) {
        objeto.addClass('alert alert-danger');
        objeto.attr("placeholder",texto);
        return false;
    } else {
        objeto.removeClass('alert alert-danger');
        
        return true;
    }
}



function vConsecutivos(objeto,texto){
    record=0; 
    igual=1; 
    var letraRecord ;
    var b=0; 
    var letra="";
    var cadena=objeto.val();
    
    for (a=1;a<=cadena.length;a++){ 
       
       
        if (cadena.charAt(a)==cadena.charAt(b)){ 
       
            igual=igual+1; 
            letra=cadena.charAt(a);} 
        else{ 
            if(igual>=3){
                record=igual;
                letraRecord=letra;

            } 
            igual=1;
        } 
        b=a; 
    } 
    if(record>=3){
         objeto.addClass('alert alert-danger');
         objeto.attr("placeholder",texto);
         return false;
     }else{
        objeto.removeClass('alert alert-danger');
        return true;
     }
}
