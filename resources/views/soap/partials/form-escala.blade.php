<div class="row ">
	<div class="col-sm-3 col-sm-offset-4 well  ">
		<div class="form-group">
			{!! Form::label('COMPLETADO_POR', 'Completado Por:', ['class' => 'control-label']) !!}
			{!! Form::select('COMPLETADO_POR', ['0' => 'SELECCIONAR', '1' => 'PACIENTE', '2' => 'FAMILIAR DEL PACIENTE', '3' => 'PROFESIONAL MÉDICO', '4' => 'ASISTIDO POR EL CUIDADOR'], null, ['class' => 'form-control']) !!}
		</div>
		<div class="form-group">
			{!! Form::label('TIPO_CATEGORIA', 'Categoría:', ['class' => 'control-label']) !!}
			{!! Form::select('TIPO_CATEGORIA', ['0' => 'SELECCIONAR', '1' => 'DOMICILIARIA', '2' => 'AMBULATORIA', '3' => 'HOSPITALARIA'], $id_categoria, ['class' => 'form-control']) !!}
		</div>
	</div>
</div>

<div class="col-sm-12">
	<div class="price-box">
		<div class="form-pricing">
		  <!-- Slider DOLOR  -->
		  <div class="price-slider">
		    <h4 class="great">DOLOR</h4>

		    <div class="col-sm-12">
				<div id="slider"></div>
			 	<div style="margin-top:10px">
				 	<span size="8" class="left" style="float:left;">Sin Dolor</span>
				  	<span size="8" class="right" style="float:right;">Máximo Dolor</span>
				</div>				      
		    </div>
		  </div>
			  <!-- Intensidad en números-->

		    <div class="form-group col-sm-12" style="text-align:center">
		      <label for="dolor" class="control-label">Intensidad de Dolor: </label>
				  
				 <!-- muestra valor de intensidad -->
		      <div>
					<input type="hidden" name="DOLOR" id="dolor">
		        <p class="price lead" id="dolor-label" align="center"></p> 
		      </div>
		    </div>
			  <!-- FIN Slider DOLOR  -->
			  

			  

			  <!-- Slider CANSANCIO  -->

			    <div class="price-slider">
					<h4 class="great">CANSANCIO</h4>
					<div class="col-sm-12">
						<div id="slider2"></div>
				 		<div style="margin-top:10px">
							<span size="8" class="left" style="float:left;">Sin Cansancio</span>
							<span size="8" class="right" style="float:right;">Máximo Cansancio</span>
						</div>
					</div>
				</div>
					  <!-- Intensidad en números-->
		    <div class="form-group col-sm-12" style="text-align:center">
		      <label for="Cansancio" class="control-label">Intensidad de Cansancio: </label>
				  
				 <!-- muestra valor de intensidad de cansancio -->
		      <div>
		        <input type="hidden" name="CANSANCIO" id="cansancio">
		        <p class="price lead" id="cansancio-label"></p> 
		      </div>
		    </div>
				<!-- FIN Slider Cansancio  -->
			
				<!-- Slider NÁUSEAS	-->
			    <div class="price-slider">
					<h4 class="great">N&Aacute;USEA</h4>
					<div class="col-sm-12">
						<div id="slider3"></div>
				 		<div style="margin-top:10px">
							<span size="8" class="left" style="float:left;">Sin Náusea</span>
							<span size="8" class="right" style="float:right;">Máximo Náusea</span>
						</div>
					</div>
				</div>
					  <!-- Intensidad en números-->
		    <div class="form-group col-sm-12" style="text-align:center">
		      <label for="nausea" class="control-label">Intensidad de Náusea: </label>
				  
				 <!-- muestra valor de intensidad de nausea -->
		      <div>
		         <input type="hidden" id="nausea" name="NAUSEA">
		        <p class="price lead" id="nausea-label"></p> 
		      </div>
		    </div>
				<!-- FIN Slider nausea-->
			
				<!-- Slider DEPRESIÓN-->

			    <div class="price-slider">
					<h4 class="great">DEPRESI&Oacute;N</h4>
					<div class="col-sm-12">
						<div id="slider4"></div>
				 		<div style="margin-top:10px">
							<span size="8" class="left" style="float:left;">Sin Depresi&oacute;n</span>
							<span size="8" class="right" style="float:right;">Máximo Depresi&oacute;n</span>
						</div>
					</div>
				</div>
					  <!-- Intensidad en números-->
		    <div class="form-group col-sm-12" style="text-align:center">
		      <label for="depresion" class="control-label">Intensidad de Depresi&oacute;n: </label>
				  
				 <!-- muestra valor de intensidad de nausea -->
		      <div>
		         <input type="hidden" id="depresion" name="DEPRESION">
		        <p class="price lead" id="depresion-label"></p> 
		      </div>
		    </div>
				<!-- FIN Slider DEPRESIÓN-->
			
			
				<!-- Slider ANSIEDAD-->
			    <div class="price-slider">
					<h4 class="great">ANSIEDAD</h4>
					<div class="col-sm-12">
						<div id="slider5"></div>
				 		<div style="margin-top:10px">
							<span size="8" class="left" style="float:left;">Sin Ansiedad</span>
							<span size="8" class="right" style="float:right;">Máxima Ansiedad</span>
						</div>
					</div>
				</div>
					  <!-- Intensidad en números-->
		    <div class="form-group col-sm-12" style="text-align:center">
		      <label for="ansiedad" class="control-label">Intensidad de ansiedad: </label>
				  
				 <!-- muestra valor de intensidad de ansiedad -->
		      <div>
		         <input type="hidden" id="ansiedad" name="ANSIEDAD">
		        <p class="price lead" id="ansiedad-label"></p> 
		      </div>
		    </div>
				<!-- FIN Slider ANSIEDAD-->

			
			
				<!-- Slider somnolencia-->
			    <div class="price-slider">
					<h4 class="great">SOMNOLENCIA</h4>
					<div class="col-sm-12">
						<div id="slider6"></div>
				 		<div style="margin-top:10px">
							<span size="8" class="left" style="float:left;">Sin Somnolencia</span>
							<span size="8" class="right" style="float:right;">Máximo Somnolencia</span>
						</div>
					</div>
				</div>
					  <!-- Intensidad en números-->
		    <div class="form-group col-sm-12" style="text-align:center">
		      <label for="somnolencia" class="control-label">Intensidad de somnolencia: </label>
				  
				 <!-- muestra valor de intensidad de ansiedad -->
		      <div>
		         <input type="hidden" id="somnolencia" name="SOMNOLENCIA">
		        <p class="price lead" id="somnolencia-label"></p> 
		      </div>
		    </div>
				<!-- FIN Slider SOMNOLENCIA-->
			
			
					<!-- Slider Apetito-->
			    <div class="price-slider">
					<h4 class="great">APETITO</h4>
					<div class="col-sm-12">
						<div id="slider7"></div>
				 		<div style="margin-top:10px">
							<span size="8" class="left" style="float:left;">Máximo Apetito</span>
							<span size="8" class="right" style="float:right;">Sin Apetito</span>
						</div>
					</div>
				</div>
					  <!-- Intensidad en números-->
		    <div class="form-group col-sm-12" style="text-align:center">
		      <label for="apetito" class="control-label">Intensidad de apetito: </label>
				  
				 <!-- muestra valor de intensidad de apetito -->
		      <div>
		         <input type="hidden" id="apetito" name="APETITO">
		        <p class="price lead" id="apetito-label"></p> 
		      </div>

		    </div>
				<!-- FIN Slider APETITO-->
			
			
			  <!-- Slider BIENESTAR-->
			    <div class="price-slider">
					<h4 class="great">BIENESTAR	</h4>
					<div class="col-sm-12">
						<div id="slider8"></div>
				 		<div style="margin-top:10px">
							<span size="8" class="left" style="float:left;">Máximo Bienestar	</span>
							<span size="8" class="right" style="float:right;">Máximo Malestar</span>
						</div>
					</div>
				</div>
					  <!-- Intensidad en números-->
		    <div class="form-group col-sm-12" style="text-align:center">
		      <label for="bienestar" class="control-label">Intensidad de Bienestar: </label>
				  
				 <!-- muestra valor de intensidad de apetito -->
		      <div>
		         <input type="hidden" id="bienestar" name="BIENESTAR">
		        <p class="price lead" id="bienestar-label"></p> 
		      </div>
		    </div>
				<!-- FIN Slider bienestar-->
			
			
				  <!-- Slider aire-->
			    <div class="price-slider">
					<h4 class="great">AIRE	</h4>
					<div class="col-sm-12">
						<div id="slider9"></div>
				 		<div style="margin-top:10px">
							<span size="8" class="left" style="float:left;">Sin Falta de Aire</span>
							<span size="8" class="right" style="float:right;">Máxima Falta de Aire</span>
						</div>
					</div>
				</div>
					  <!-- Intensidad en números-->
		    <div class="form-group col-sm-12" style="text-align:center">
		      <label for="aire" class="control-label">Intensidad de Aire: </label>
				  
				 <!-- muestra valor de intensidad de apetito -->
		      	<div>
		         	<input type="hidden" id="aire" name="AIRE">
		        	<p class="price lead" id="aire-label"></p> 
		      	</div>
		    </div>
				<!-- FIN Slider aire-->
			
				  <!-- Slider dormir-->
			    <div class="price-slider">
					<h4 class="great">DORMIR	</h4>
					<div class="col-sm-12">
						<div id="slider10"></div>
				 		<div style="margin-top:10px">
							<span size="8" class="left" style="float:left;">Facilidad para Dormir</span>
							<span size="8" class="right" style="float:right;">Máximo Dificultad para Dormir</span>
						</div>
					</div>
				</div>
					  <!-- Intensidad en números-->
		    <div class="form-group col-sm-12" style="text-align:center">
		      <label for="dormir" class="control-label">Intensidad de Dormir: </label>
				  
				 <!-- muestra valor de intensidad de dormir -->
		      <div>
		         <input type="hidden" id="dormir" name="DORMIR">
		         <p class="price lead" id="dormir-label"></p> 
		      </div>
		    </div>
				<!-- FIN Slider aire-->
			
			
			<button type="submit" class="btn btn-primary btn-block">Guardar</button>			
	   	</div>
	</div>
</div>