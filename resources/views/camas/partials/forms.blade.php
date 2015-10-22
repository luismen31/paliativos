<div class="row">
	<div class="form-group col-sm-6 col-sm-offset-3">
		{!! Form::label('CAMA', 'Cama:', array('class' => 'control-label')) !!}	    
		{!! Form::text('CAMA', null, array('class'=>'form-control input-sm', 'placeholder' => 'CAMA') ) !!}
	</div>
	<div class="form-group col-sm-6 col-sm-offset-3">
		{!! Form::label('ID_SALA', 'Sala:', array('class' => 'control-label')) !!}	    
		{!! Form::select('ID_SALA', \App\Sala::lists('SALA', 'ID_SALA')->toArray() ,null, array('class'=>'form-control input-sm') ) !!}
	</div>
</div>