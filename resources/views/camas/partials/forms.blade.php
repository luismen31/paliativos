<div class="row">
	<div class="form-group col-sm-4 col-sm-offset-4">
		{!! Form::label('CAMA', 'Cama:', array('class' => 'control-label')) !!}
		{!! Form::text('CAMA', null, array('class'=>'form-control input-sm', 'placeholder' => 'CAMA') ) !!}
	</div>
	<div class="form-group col-sm-4 col-sm-offset-4">
		{!! Form::label('ID_SALA', 'Sala:', array('class' => 'control-label')) !!}
		{!! Form::select('ID_SALA', \App\Sala::lists('SALA', 'ID_SALA')->toArray() ,null, array('class'=>'form-control input-sm') ) !!}
	</div>
</div>
