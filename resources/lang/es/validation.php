<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    "accepted"         => ":attribute debe ser aceptado.",
    "active_url"       => ":attribute no es una URL válida.",
    "after"            => ":attribute debe ser una fecha posterior a :date.",
    "alpha"            => ":attribute solo debe contener letras.",
    "alpha_dash"       => ":attribute solo debe contener letras, números y guiones.",
    "alpha_num"        => ":attribute solo debe contener letras y números.",
    "array"            => ":attribute debe ser un conjunto.",
    "before"           => ":attribute debe ser una fecha anterior a :date.",
    "between"          => [
        "numeric" => ":attribute tiene que estar entre :min - :max.",
        "file"    => ":attribute debe pesar entre :min - :max kilobytes.",
        "string"  => ":attribute tiene que tener entre :min - :max caracteres.",
        "array"   => ":attribute tiene que tener entre :min - :max ítems.",
    ],
    "boolean"          => "El campo :attribute debe tener un valor verdadero o falso.",
    "confirmed"        => "La confirmación de :attribute no coincide.",
    "date"             => ":attribute no es una fecha válida.",
    "date_format"      => ":attribute no corresponde al formato :format.",
    "different"        => ":attribute y :other deben ser diferentes.",
    "digits"           => ":attribute debe tener :digits dígitos.",
    "digits_between"   => ":attribute debe tener entre :min y :max dígitos.",
    "email"            => ":attribute no es un correo válido",
    "exists"           => ":attribute es inválido.",
    "filled"           => "El campo :attribute es obligatorio.",
    "image"            => ":attribute debe ser una imagen.",
    "in"               => ":attribute es inválido.",
    "integer"          => ":attribute debe ser un número entero.",
    "ip"               => ":attribute debe ser una dirección IP válida.",
    'json'             => 'El campo :attribute debe tener una string JSON válida.',
    "max"              => [
        "numeric" => ":attribute no debe ser mayor a :max.",
        "file"    => ":attribute no debe ser mayor que :max kilobytes.",
        "string"  => ":attribute no debe ser mayor que :max caracteres.",
        "array"   => ":attribute no debe tener más de :max elementos.",
    ],
    "mimes"            => ":attribute debe ser un archivo con formato: :values.",
    "min"              => [
        "numeric" => "El tamaño de :attribute debe ser de al menos :min.",
        "file"    => "El tamaño de :attribute debe ser de al menos :min kilobytes.",
        "string"  => ":attribute debe contener al menos :min caracteres.",
        "array"   => ":attribute debe tener al menos :min elementos.",
    ],
    "not_in"           => ":attribute es inválido.",
    "numeric"          => ":attribute debe ser numérico.",
    "regex"            => "El formato de :attribute es inválido.",
    "required"         => "El campo :attribute es obligatorio.",
    "required_if"      => "El campo :attribute es obligatorio cuando :other es :value.",
    "required_with"    => "El campo :attribute es obligatorio cuando :values está presente.",
    "required_with_all" => "El campo :attribute es obligatorio cuando :values está presente.",
    "required_without" => "El campo :attribute es obligatorio cuando :values no está presente.",
    "required_without_all" => "El campo :attribute es obligatorio cuando ninguno de :values estén presentes.",
    "same"             => ":attribute y :other deben coincidir.",
    "size"             => [
        "numeric" => "El tamaño de :attribute debe ser :size.",
        "file"    => "El tamaño de :attribute debe ser :size kilobytes.",
        "string"  => ":attribute debe contener :size caracteres.",
        "array"   => ":attribute debe contener :size elementos.",
    ],
    "string"           => "The :attribute must be a string.",
    "timezone"         => "El :attribute debe ser una zona válida.",
    "unique"           => ":attribute ya ha sido registrado.",
    "url"              => "El formato :attribute es inválido.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
        'telefono' => [
            'required_if' => 'El campo Teléfono es obligatorio si se selecciono como forma de recuperar el Teléfono.'
        ],
        'correo' => [
            'required_if' => 'El campo Correo Electrónico es obligatorio si se selecciono como forma de recuperar el Correo.'
        ],
        'preg_recuperacion' => [
            'required_if' => 'El campo Pregunta de Recuperación es obligatorio si se selecciono como forma de recuperar el Pregunta.'
        ],
        'respuesta' => [
            'required_if' => 'El campo Respuesta es obligatorio si se selecciono como forma de recuperar el Pregunta.'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'search_paciente' => 'Buscar Paciente',
        'search_profesional' => 'Buscar Profesional',
        'search_cie10' => 'Diagnóstico/CIE-10',
        'NO_CEDULA' => 'Cédula',
        'PRIMER_NOMBRE' => 'Primer Nombre',
        'APELLIDO_PATERNO' => 'Apellido Paterno',
        'FECHA_NACIMIENTO' => 'Fecha Nacimiento',
        'FECHA_INGRESO' => 'Fecha de Ingreso',
        'ID_SEXO' => 'El campo Sexo',
        'CUIDADOR' => 'Cuidador',
        'PARENTEZCO_CUIDADOR' => 'Parentezco del Cuidador',
        'NO_IDONEIDAD' => 'No. Idoneidad',
        'E_MAIL' => 'Correo Electrónico',
        'ID_GRUPO_USUARIO' => 'Grupo Usuario',
        'ID_ESPECIALIDAD_MEDICA' => 'Especialidad Médica',

        'NO_IDENTIFICACION' => 'Usuario',
        'CLAVE_ACCESO' => 'Contraseña',
        'identificacion' => 'Usuario',
        'clave' => 'Contraseña',

        'CAMA' => 'Cama',
        'ID_SALA' => 'Sala',
        'SALA' => 'Sala',
        'DESCRIPCION' => 'Servicio Médico',
        'ID_TIEMPO_ATENCION' => 'Tiempo de Atención',
        'ZONA' => 'Zona',
        'ID_REFERIDO' => 'Referido',
        'ID_CAMA' => 'Cama',
        'FRECUENCIA' => 'Frecuencia',
        'ID_MOTIVO_SALIDA' => 'Motivo Salida',
        'ID_CONDICION_SALIDA' => 'Condición Salida',
        'TOTAL_DIAS_ESTANCIA' => 'Total días de Estancia',
        'FECHA_AUTOPSIA' => 'Fecha Autopsia',
        'year' => 'Año',
        'observacion_diagnostico' => 'Observación Diagnóstico',
        'cuadro_medicamento' => 'Cuadro Medicamento',
        'nombre_medicamento' => 'Nombre del Medicamento',
        'MINUTOS_UTILIZADOS' => 'Minutos Utilizados',
        'TIPO_CONTACTO' => 'Tipo de Contacto',
        'MOTIVO' => 'Motivo',
        'OBSERVACION' => 'Observación',
        'PREGUNTA_SEGURIDAD' => 'Pregunta de Seguridad',
        'RESPUESTA' => 'Respuesta',
        'respuesta' => 'Respuesta',
        'recuperar' => 'Recuperación Acceso',
        'preg_recuperacion' => 'Pregunta de Recuperación',
        'telefono' => 'Teléfono',
        'correo' => 'Correo Electrónico',
        'date_start' => 'Fecha Inicial',
        'date_end' => 'Fecha Final',
    ],

];
