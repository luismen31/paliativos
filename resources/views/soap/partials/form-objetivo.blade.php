{{-- Si esta vacio el subjetivo habilita el campo --}}
@if(empty($lastSoap->subjetivo))
	<?php $disabled = ['disabled' => 'disabled']; ?>
@else
	<?php $disabled = []; ?>
@endif

<center>
	<div class="form-group {{ ($errors->has('objetivo')) ? 'has-error' : '' }} {{ (!empty($lastSoap->objetivo)) ? 'has-success has-feedback' : '' }}">

		{!! Form::label('objetivo', 'Objetivo de la Consulta', ['class' => 'control-label']) !!}
		{!! Form::textarea('objetivo', null, ['class' => 'form-control', 'size' => '30x3', 'placeholder' => 'Objetivo de la Consulta'] + $disabled) !!}

		@if(!empty($lastSoap->objetivo))
			<span class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
			<span id="objetivoStatusSuccess" class="sr-only">(Guardado)</span>
		@endif
		@if($errors->has('objetivo'))
			<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
			<span id="subjetivoStatusSuccess" class="sr-only">(Error)</span>
		@endif
	</div>
	{!! Form::submit('Guardar', ['class' => 'btn btn-success'] + $disabled) !!}
</center>