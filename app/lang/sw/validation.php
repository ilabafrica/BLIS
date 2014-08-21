<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used by
	| the validator class. Some of these rules have multiple versions such
	| as the size rules. Feel free to tweak each of these messages here.
	|
	*/

	"accepted"             => ":attribute lazima kukubaliwa.",
	"active_url"           => ":attribute sio URL halali.",
	"after"                => ":attribute lazima iwe tarehe baada ya :date.",
	"alpha"                => ":attribute yachukua herufi pekee.",
	"alpha_dash"           => ":attribute yachukua herufi, namba na 'dashes' pekee.",
	"alpha_num"            => ":attribute yachukua herufi na namba pekee.",
	"array"                => ":attribute lazima iwe array.",
	"before"               => ":attribute lazima iwe tarehe kabla ya :date.",
	"between"              => array(
		"numeric" => ":attribute lazima iwe kati ya :min na :max.",
		"file"    => ":attribute lazima iwe kati ya :min na :max kilobytes.",
		"string"  => ":attribute lazima iwe kati ya :min na :max herufi.",
		"array"   => ":attribute lazima iwe na vitu kati ya :min na :max.",
	),
	"confirmed"            => ":attribute ya uthibitisho hailingani.",
	"date"                 => ":attribute sio tarehe halali.",
	"date_format"          => "Muundo wa :attribute haulingani na :format.",
	"different"            => ":attribute na :other lazima ziwe tofauti.",
	"digits"               => ":attribute lazima iwe na tarakimu :digits.",
	"digits_between"       => ":attribute lazima iwe na tarakimu kati ya :min na :max.",
	"email"                => ":attribute lazima iwe barua pepe halali.",
	"exists"               => ":attribute iliyochaguliwa si halali.",
	"image"                => ":attribute lazima iwe picha.",
	"in"                   => ":attribute iliyochaguliwa sio halali.",
	"integer"              => ":attribute lazima iwe namba kamili (integer).",
	"ip"                   => ":attribute lazima iwe anwani ya IP halali.",
	"max"                  => array(
		"numeric" => ":attribute haiwezi zidi :max.",
		"file"    => ":attribute haiwezi zidi :max kilobytes.",
		"string"  => ":attribute haiwezi zidi herufi :max.",
		"array"   => ":attribute haiwezi kuwa na vitu zaidi ya :max.",
	),
	"mimes"                => ":attribute lazima iwe faili ya aina: :values.",
	"min"                  => array(
		"numeric" => ":attribute lazima iwe angalau :min.",
		"file"    => ":attribute lazima iwe angalau :min kilobytes.",
		"string"  => ":attribute lazima iwe angalau :min characters.",
		"array"   => ":attribute lazima iwe na angalau vitu :min.",
	),
	"not_in"               => ":attribute iliyochaguliwa si halali.",
	"numeric"              => ":attribute lazima iwe namba.",
	"regex"                => "Muundo wa :attribute si halali.",
	"required"             => "Wahitajika kujaza ':attribute'.",
	"required_if"          => "Wahitajika kujaza :attribute iwapo :other ni :value.",
	"required_with"        => "Wahitajika kujaza :attribute iwapo :values ipo.",
	"required_with_all"    => "Wahitajika kujaza :attribute iwapo :values ipo.",
	"required_without"     => "Wahitajika kujaza :attribute iwapo :values haipo.",
	"required_without_all" => "Wahitajika kujaza :attribute iwapo mojawapo wa :values haipo.",
	"same"                 => ":attribute na :other lazima ziwe sawia.",
	"size"                 => array(
		"numeric" => ":attribute lazima iwe :size.",
		"file"    => ":attribute lazima iwe na kilobytes :size.",
		"string"  => ":attribute lazima iwe na herufi :size.",
		"array"   => ":attribute lazima iwe na vitu :size.",
	),
	"unique"               => "':attribute' tayari imechukuliwa.",
	"url"                  => "Muundo wa :attribute sio halali.",

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

	'custom' => array(
		'attribute-name' => array(
			'rule-name' => 'custom-message',
		),
	),

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

	'attributes' => array(
		'name' => 'Jina',
		'email' => 'Barua Pepe',
		),

);
