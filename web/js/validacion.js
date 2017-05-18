      $(document).ready(function(){
				/*$(".repe").hide();*/
	  $("#boton").click(function (){
                $(".error").remove();
        		
				/*$("#email").focusout(function(){
							$(".repe").show(1000);
							});*/

				
				
				
		        var letras = ['T', 'R', 'W', 'A', 'G', 'M', 'Y', 'F', 'P', 'D', 'X', 'B',
				'N', 'J', 'Z', 'S', 'Q', 'V', 'H', 'L', 'C', 'K', 'E', 'T'];

				var numero = $("#numdni").val().substring(0,8);
				var letra = $("#numdni").val().substring(8,9);
				var letraCalculada = letras[numero % 23];

				if( $("#nombre").val() == ""){
                   alert("Ingrese su nombre");
                    return false;
					
				}else if( $("#apellido").val() == ""){
                   alert("Ingrese su apellido");
                    return false;
			
				}else if($("#numdni").val() == ""){
                    $("#numdni").focus().after("<span class='error'>Ingrese su DNI</span>");
                    return false;
				
				}else if (numero < 0 || numero > 99999999){

				$("#numdni").focus().after("<span class='error'>Ingrese su DNI correctamente</span>");
		        return false;
					
				
						} if(letraCalculada != letra.toUpperCase()){

						$("#numdni").focus().after("<span class='error'>Ingrese su DNI correctamente</span>");
						return false;
			
				
        
					
                }else if( $("#email").val() == ""){
                   alert("Ingrese el email correctamente");
                    return false;
        			
        		}else if( $("#email2").val() == ""){
                   alert("Ingrese el email correctamente");
                   return false;
        		}
        		
        		else if( $("#email").val() != $("#email2").val()){
                   alert("Los email no coinciden");
                    return false;
               }  		
			   
			   else if( $("#telefono").val() == ""){
                   alert("Ingrese su teléfono");
                    return false;
			  
			  } else if( $("#cpostal").val() == ""){
                   alert("Ingrese su C.Postal");
                    return false;
			   
			   }else if( $("#direccion").val() == ""){
                   alert("Ingrese su direccion");
                    return false;
			   }
			   
			   
			   if( $("#password").val() == ""){
                   alert("Ingrese la contraseña correctamente");
                    return false;
        			
        		}else if( $("#password2").val() == ""){
                   alert("Ingrese la contraseña correctamente");
                   return false;
        		}
        		
        		else if( $("#password").val() != $("#password2").val()){
                   alert("Las contraseñas no coinciden");
                    return false;
               }  		
			   
			   
            });
			
			
			
			
			
			
//SOLO NUMEROS EN UN INPUT
$(".numero, .cpostal").keypress(function(e){
     if((e.which!=8) && (e.which!=0) && (e.which<48 || e.which>57)) {
	return false;
     }
});

			
			});
						
					