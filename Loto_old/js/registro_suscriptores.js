 //document.getElementById("botonSubmit").addEventListener("click", prueba);
			//--Funcion para validar los campos del formulario. Si todos los campos son correctos se llama a la funcion que .submit()
			//que envia los datos a form_registrarse.php
			var aliasOk= 0;
			
			function validaciones(){
				
				var regex = new RegExp("^[a-zA-Z ]+$");//Solo letras y espacios
				var regexPass = new RegExp('^(?=.*\\d)(?=.*[a-zA-Z])[0-9a-zA-Z$&+,:;=?@#|\'<>.-^*()%!]{6,20}$', '');// entre 8 y 16 caracteres, al menos un dígito.Puede tener otros símbolos.
				var regexEmail = new RegExp("^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$");
				var regexCp = new RegExp("^[0-9]{5}$");
				const regexFecha = new RegExp('[1-9][0-9][0-9]{2}-([0][1-9]|[1][0-2])-([1-2][0-9]|[0][1-9]|[3][0-1])', '');

				
				
				//Nombre
				if(!document.getElementById("nombre").value==""){
					if(!regex.test(document.getElementById("nombre").value)){
						
						document.getElementById("nombre").className= "cajaform_2";
						document.getElementById("alertNombre").className= "errAlias2";
					}
					else{
						document.getElementById("alertNombre").className= "ocultarMensaje";
						document.getElementById("campos").className= "ocultarMensaje";
						document.getElementById("nombre").className= "cajaform";
					}
					
					//Apellido
					if(!document.getElementById("apellido").value==""){
						
						
						if(!regex.test(document.getElementById("apellido").value)){
							
							document.getElementById("apellido").className= "cajaform_2";
							document.getElementById("alertApelido").className= "errAlias2";
						}
						else{
							document.getElementById("alertApelido").className= "ocultarMensaje";
							document.getElementById("campos").className= "ocultarMensaje";
							document.getElementById("apellido").className= "cajaform";
						}
						
								//Alias
						if(!document.getElementById("username").value==""){
							
							
							//Email
							if(!document.getElementById("email").value==""){
								if(!regexEmail.test(document.getElementById("email").value)){
									
									document.getElementById("email").className= "cajaform_2";
									document.getElementById("alertEmail").className= "errAlias2";
								}
								else{
									document.getElementById("alertEmail").className= "ocultarMensaje";
									document.getElementById("campos").className= "ocultarMensaje";
									document.getElementById("email").className= "cajaform";
								}	
								
							//---
							if(!document.getElementById("email2").value==""){
								if(document.getElementById("email2").value != document.getElementById("email").value){
									
									document.getElementById("email2").className= "cajaform_2";
									document.getElementById("alertEmail2").className= "errAlias2";
								}
								else{
									document.getElementById("alertEmail2").className= "ocultarMensaje";
									document.getElementById("campos").className= "ocultarMensaje";
									document.getElementById("email2").className= "cajaform";
								}
	
								//--
								//Contraseña
								if(!document.getElementById("password").value==""){
									if(!regexPass.test(document.getElementById("password").value)){
										
										document.getElementById("password").className= "cajaform_2";
										document.getElementById("alertPass").className= "errAlias2";
									}
									else{
										document.getElementById("alertPass").className= "ocultarMensaje";
										document.getElementById("campos").className= "ocultarMensaje";
										document.getElementById("password").className= "cajaform";
									}
									
								}else{
									
									document.getElementById("campos").className= "condiciones";
									document.getElementById("password").className= "cajaform_2";
								}
								
								//--
								if(!document.getElementById("password2").value==""){
					
									if(document.getElementById("password2").value != document.getElementById("password").value){
										
										document.getElementById("password2").className= "cajaform_2";
										document.getElementById("alertPass2").className= "errAlias2";
									}
									else{
										document.getElementById("alertPass2").className= "ocultarMensaje";
										document.getElementById("campos").className= "ocultarMensaje";
										document.getElementById("password2").className= "cajaform";
									}
									
									//--
									//Genero
									if(!document.getElementById("genero").value==""){
										
										//--
										//Fecha de nacimiento
										if(!document.getElementById("fecha_nac").value==""){
											
											if(!regexFecha.test(document.getElementById("fecha_nac").value)){
												
												
												document.getElementById("fecha_nac").className= "cajaform_2";
												document.getElementById("alertFecha").className= "errAlias2";
												
												document.getElementById("fecha_nac").value = new Date().toISOString().slice(0, 19).replace('T', ' ');
											}
											else{
												document.getElementById("alertFecha").className= "ocultarMensaje";
												document.getElementById("campos").className= "ocultarMensaje";
												document.getElementById("fecha_nac").className= "cajaform";
											}
											
											//--
											//Código postal
											if(!document.getElementById("cp").value==""){
												if(!regexCp.test(document.getElementById("cp").value)){
													
													document.getElementById("cp").className= "cajaform_2";
													document.getElementById("alertCp").className= "errAlias2";
												}
												else{
													document.getElementById("alertCp").className= "ocultarMensaje";
													document.getElementById("campos").className= "ocultarMensaje";
													document.getElementById("cp").className= "cajaform";
												}
												//--
												//Ciudad
												if(!document.getElementById("poblacion").value==""){
													
													if(!regex.test(document.getElementById("poblacion").value)){
														
														document.getElementById("poblacion").className= "cajaform_2";
														document.getElementById("alertCiudad").className= "errAlias2";
													}
													else{
														document.getElementById("alertCiudad").className= "ocultarMensaje";
														document.getElementById("campos").className= "ocultarMensaje";
														document.getElementById("poblacion").className= "cajaform";
													}
													
													//--
													//Provincia
													if(!document.getElementById("provincia").value==""){
														
														if(!regex.test(document.getElementById("poblacion").value)){
															
															document.getElementById("provincia").className= "cajaform_2";
															document.getElementById("alertProvincia").className= "errAlias2";
														}
														else{
															document.getElementById("alertProvincia").className= "ocultarMensaje";
															document.getElementById("campos").className= "ocultarMensaje";
															document.getElementById("provincia").className= "cajaform";
														}
														//--
														//Pais
														if(!document.getElementById("pais").value==""){
															
															if(!regex.test(document.getElementById("poblacion").value)){
																
																document.getElementById("pais").className= "cajaform_2";
																document.getElementById("alertPais").className= "errAlias2";
															}
															else{
																document.getElementById("alertPais").className= "ocultarMensaje";
																document.getElementById("campos").className= "ocultarMensaje";
																document.getElementById("pais").className= "cajaform";
															}
															//--
															if(!document.getElementById("acepta_con").checked){
																document.getElementById("mensaje_con").className = "condiciones";

															}
															else{
																document.getElementById("mensaje_con").className = "ocultarMensaje";
															
																if(aliasOk ==1){
																	if(document.getElementById("recibe_com").checked )
																	{
																		document.getElementById("recibe_com").value = 1;
																		//*** SI TODO OK - SE ENVIA FORMULARIO ****//
																		document.formulario.submit()
																	}
																	else{
																		document.getElementById("recibe_com").value = 0;
																		//*** SI TODO OK - SE ENVIA FORMULARIO ****//
																		document.formulario.submit()
																	}
																	
																
																	
																}else{
																		document.getElementById("username").className = "cajaform_2";
																		document.getElementById("alias").className = "errAlias2";
																		document.getElementById("aliasOk").className = "ocultarMensaje";
																		document.getElementById("aliasVoid").className = "ocultarMensaje";
																		document.getElementById("alertAlias").className = "ocultarMensaje";
																	}
																
																	
																	
															}
															
														}else{
															
															
															document.getElementById("campos").className= "condiciones";
															document.getElementById("pais").className= "cajaform_2";
															
														}
				
													}else{
														
														
														
														document.getElementById("campos").className= "condiciones";
														document.getElementById("provincia").className= "cajaform_2";
													}
												}else{
													
													
													document.getElementById("campos").className= "condiciones";
													document.getElementById("poblacion").className= "cajaform_2";
												}
											}else{
												
												document.getElementById("campos").className= "condiciones";
												document.getElementById("cp").className= "cajaform_2";
												
												
											}
										}else{
											
											
											document.getElementById("campos").className= "condiciones";
											document.getElementById("fecha_nac").className= "cajaform_2";
											
										}
									}else{	
					
										document.getElementById("campos").className= "condiciones";
										document.getElementById("genero").className= "cajaform_2";
										
									}
								}else{

									document.getElementById("campos").className= "condiciones";
									document.getElementById("password2").className= "cajaform_2";
									
								}
							}else{
								
								
								document.getElementById("campos").className= "condiciones";
								document.getElementById("email2").className= "cajaform_2";
								
							}
								
						}else{
															
							document.getElementById("campos").className= "condiciones";
							document.getElementById("email").className= "cajaform_2";
						}
							
						}else{
							
							document.getElementById("campos").className= "condiciones";
							document.getElementById("username").className= "cajaform_2";
							
						}
	
					}else{
						
						document.getElementById("campos").className= "condiciones";
						document.getElementById("apellido").className= "cajaform_2";
	
					}	
				}
				else{
					
					document.getElementById("campos").className= "condiciones";
					document.getElementById("nombre").className= "cajaform_2";	
					
				}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
			}
/*
            function CrearUsuario()
            {
				
                var nombre = document.getElementById("nombre").value;                
                var username = document.getElementById("username").value;
                var apellido = document.getElementById("apellido").value;
                var email = document.getElementById("email").value;
                var email2 = document.getElementById("email2").value;
                var password = document.getElementById("password").value;
                var password2 = document.getElementById("password2").value;
				var genero = document.getElementById("genero").value;
				var fecha_nac = document.getElementById("fecha_nac").value;
				var cp = document.getElementById("cp").value;
				var poblacion = document.getElementById("poblacion").value;
				var provincia = document.getElementById("provincia").value;
				var pais = document.getElementById("pais").value;
				var fecha_ini = new Date().toISOString().slice(0, 19).replace('T', ' ');
				if(document.getElementById("recibe_com").checked)
				{
					var recibe_com = 1;
				}
				else{
					var recibe_com = 0;
				}
				
                var error;
                var err=0;

                // Comprovamos si los campos tienen valores
                if (nombre != "") 
                {
                    if (apellido != "")
                    {

                        // Comprovamos el alias                        
                        if (username=='')
                        {   
                            var error = document.getElementById("error_alias");
                            error.style.display='block';
                            err=1;
                        }


                        // Comprovamos si el correo es correcto
                       if (email != email2)
                        {
                            error = document.getElementById("error_correo");
                            error.style.display='block';
                            err=1;
                        }

                           // Comprovamos si la contraseña es correcta
                        if (password != password2)
                        {
                            error = document.getElementById("error_pwd");
                            error.style.display='block';
                            err=1;
                        }

                        if (err==0)
                        {
							
                            // Preparamos la variable para pasar los datos para registrar en la BBDD
                            var datos = [nombre, username, apellido, fecha_nac, genero, cp, poblacion, provincia, pais, password, email, recibe_com, fecha_ini];
							
                            $.ajax(
                            {
                                url:"/form_registrarse.php?datos=" + datos,
                                type: "POST",
                                success: function(data)
                                {
                                    //alert(data);
                                    if (data != -1)
                                    {
										alert(data);
										alert("Datos introducidos correctamente");
                                        parent.location.assign("/loto/Inicio.php");
										
										
                                    }
                                    else
                                    {
                                        var error = document.getElementById("error_alias");
                                        error.style.display ='block';
										
										
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown){
                                    //alert("KO===>"+textStatus);
									
                                }

                            });
                        }
                        else
                        {
                            error = document.getElementById("error_formulario");
                            error.style.display='block';
                        }

                        return;
                    }
                }
                
                error = document.getElementById("error_formulario");
                error.style.display='block';            
            }*/

            function VerificarAlias()
            {
                var username= document.getElementById("username").value;
                
                if (username=='')
                {   
                    //var error = document.getElementById("error_alias");
                    //error.style.display='block';
					document.getElementById("aliasVoid").className = "errAlias2";
					document.getElementById("username").className = "cajaform_2";
					document.getElementById("aliasOk").className = "ocultarMensaje";
					document.getElementById("alertAlias").className = "ocultarMensaje";
					
                }
                else
                {
				
                    $.ajax(
                    {

                        url: "/form_alias.php?username=" + username,
                        type: "GET",
                       
                        success: function(data)
                        {
						
                            if (data==-1)
                                {
                                    //var error = document.getElementById("error_alias");
                                    //error.style.display='block';
									document.getElementById("username").className = "cajaform_2";
									document.getElementById("alertAlias").className = "errAlias2";
									document.getElementById("aliasOk").className = "ocultarMensaje";
									document.getElementById("aliasVoid").className = "ocultarMensaje";
									document.getElementById("alias").className =  "ocultarMensaje";
									
									
									
                                }
							else{
								document.getElementById("username").className = "cajaform_3";
								document.getElementById("aliasOk").className = "aliasOk";
								document.getElementById("alertAlias").className = "ocultarMensaje";
								document.getElementById("aliasVoid").className = "ocultarMensaje";
								document.getElementById("alias").className =  "ocultarMensaje";
								aliasOk =1;
							}
							
                        },
                        error: function(jqXHR, textStatus, errorThrown) { 
                                    alert("KO===>"+textStatus);
								
                        }
						
                    });
					
                }  
					
            }
			/*
            function Alias()
            {
                var error = document.getElementById("error_alias");
                error.style.display='none';
            }*/


            function Correo()
            {
                var error = document.getElementById("error_correo");
                error.style.display='none';
            }


            function PWD()
            {
                var error = document.getElementById("error_pwd");
                error.style.display='none';
            }
			
