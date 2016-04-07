
	<center>
		<div class="form-group {{ ($errors->has('subjetivo')) ? 'has-error' : '' }} {{ (isset($lastSoap->subjetivo)) ? 'has-success has-feedback' : '' }}">

			{!! Form::label('subjetivo', 'Motivo de la Consulta', ['class' => 'control-label']) !!}
			{!! Form::textarea('subjetivo', null, ['class' => 'form-control', 'size' => '30x3', 'placeholder' => 'Motivo de la Consulta', 'aria-describedby' => "subjetivoStatusSuccess"]) !!}
			
			@if(isset($lastSoap->subjetivo))
				<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
				<span id="subjetivoStatusSuccess" class="sr-only">(Guardado)</span>
			@endif
			@if($errors->has('subjetivo'))
				<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
				<span id="subjetivoStatusSuccess" class="sr-only">(Error)</span>
			@endif
		</div>
		{!! Form::submit('Guardar', ['class' => 'btn btn-success']) !!}
	</center>
