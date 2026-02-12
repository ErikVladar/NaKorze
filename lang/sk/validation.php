<?php

return [

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

    'accepted' => 'Pole :attribute musí byť prijaté.',
    'accepted_if' => 'Pole :attribute musí byť prijaté, keď :other je :value.',
    'active_url' => 'Pole :attribute musí byť platná URL.',
    'after' => 'Pole :attribute musí byť dátum po :date.',
    'after_or_equal' => 'Pole :attribute musí byť dátum po alebo rovný :date.',
    'alpha' => 'Pole :attribute môže obsahovať iba písmená.',
    'alpha_dash' => 'Pole :attribute môže obsahovať iba písmená, čísla, pomlčky a podčiarkovníky.',
    'alpha_num' => 'Pole :attribute môže obsahovať iba písmená a čísla.',
    'any_of' => 'Pole :attribute je neplatné.',
    'array' => 'Pole :attribute musí byť pole.',
    'ascii' => 'Pole :attribute musí obsahovať iba jednobajtové alfanumerické znaky a symboly.',
    'before' => 'Pole :attribute musí byť dátum pred :date.',
    'before_or_equal' => 'Pole :attribute musí byť dátum pred alebo rovný :date.',
    'between' => [
        'array' => 'Pole :attribute musí mať medzi :min a :max položkami.',
        'file' => 'Pole :attribute musí byť medzi :min a :max kilobytmi.',
        'numeric' => 'Pole :attribute musí byť medzi :min a :max.',
        'string' => 'Pole :attribute musí byť medzi :min a :max znakmi.',
    ],
    'boolean' => 'Pole :attribute musí byť pravda alebo nepravda.',
    'can' => 'Pole :attribute obsahuje neautorizovanú hodnotu.',
    'confirmed' => 'Potvrdenie poľa :attribute sa nezhoduje.',
    'contains' => 'Pole :attribute chýba požadovaná hodnota.',
    'current_password' => 'Heslo je nesprávne.',
    'date' => 'Pole :attribute musí byť platný dátum.',
    'date_equals' => 'Pole :attribute musí byť dátum rovný :date.',
    'date_format' => 'Pole :attribute musí zodpovedať formátu :format.',
    'decimal' => 'Pole :attribute musí mať :decimal desatinných miest.',
    'declined' => 'Pole :attribute musí byť odmietnuté.',
    'declined_if' => 'Pole :attribute musí byť odmietnuté, keď :other je :value.',
    'different' => 'Pole :attribute a :other musia byť rôzne.',
    'digits' => 'Pole :attribute musí mať :digits číslic.',
    'digits_between' => 'Pole :attribute musí mať medzi :min a :max číslicami.',
    'dimensions' => 'Pole :attribute má neplatné rozmery obrázka.',
    'distinct' => 'Pole :attribute má duplikátnú hodnotu.',
    'doesnt_end_with' => 'Pole :attribute nesmie končiť niektorou z nasledujúcich: :values.',
    'doesnt_start_with' => 'Pole :attribute nesmie začínať niektorou z nasledujúcich: :values.',
    'email' => 'Pole :attribute musí byť platná e-mailová adresa.',
    'ends_with' => 'Pole :attribute musí končiť niektorou z nasledujúcich: :values.',
    'enum' => 'Vybraný :attribute je neplatný.',
    'exists' => 'Vybraný :attribute je neplatný.',
    'extensions' => 'Pole :attribute musí mať jednu z nasledujúcich rozšírení: :values.',
    'file' => 'Pole :attribute musí byť súbor.',
    'filled' => 'Pole :attribute musí mať hodnotu.',
    'gt' => [
        'array' => 'Pole :attribute musí mať viac ako :value položkami.',
        'file' => 'Pole :attribute musí byť väčšie ako :value kilobytmi.',
        'numeric' => 'Pole :attribute musí byť väčšie ako :value.',
        'string' => 'Pole :attribute musí byť väčšie ako :value znakmi.',
    ],
    'gte' => [
        'array' => 'Pole :attribute musí mať :value položkami alebo viac.',
        'file' => 'Pole :attribute musí byť väčšie alebo rovné :value kilobytmi.',
        'numeric' => 'Pole :attribute musí byť väčšie alebo rovné :value.',
        'string' => 'Pole :attribute musí byť väčšie alebo rovné :value znakmi.',
    ],
    'hex_color' => 'Pole :attribute musí byť platná hexadecimálna farba.',
    'image' => 'Pole :attribute musí byť obrázok.',
    'in' => 'Vybraný :attribute je neplatný.',
    'in_array' => 'Pole :attribute musí existovať v :other.',
    'in_array_keys' => 'Pole :attribute musí obsahovať aspoň jeden z nasledujúcich kľúčov: :values.',
    'integer' => 'Pole :attribute musí byť celé číslo.',
    'ip' => 'Pole :attribute musí byť platná IP adresa.',
    'ipv4' => 'Pole :attribute musí byť platná IPv4 adresa.',
    'ipv6' => 'Pole :attribute musí byť platná IPv6 adresa.',
    'json' => 'Pole :attribute musí byť platný JSON reťazec.',
    'list' => 'Pole :attribute musí byť zoznam.',
    'lowercase' => 'Pole :attribute musí byť malé písmená.',
    'lt' => [
        'array' => 'Pole :attribute musí mať menej ako :value položkami.',
        'file' => 'Pole :attribute musí byť menej ako :value kilobytmi.',
        'numeric' => 'Pole :attribute musí byť menej ako :value.',
        'string' => 'Pole :attribute musí byť menej ako :value znakmi.',
    ],
    'lte' => [
        'array' => 'Pole :attribute nesmie mať viac ako :value položkami.',
        'file' => 'Pole :attribute musí byť menej alebo rovné :value kilobytmi.',
        'numeric' => 'Pole :attribute musí byť menej alebo rovné :value.',
        'string' => 'Pole :attribute musí byť menej alebo rovné :value znakmi.',
    ],
    'mac_address' => 'Pole :attribute musí byť platná MAC adresa.',
    'max' => [
        'array' => 'Pole :attribute nesmie mať viac ako :max položkami.',
        'file' => 'Pole :attribute nesmie byť väčšie ako :max kilobytmi.',
        'numeric' => 'Pole :attribute nesmie byť väčšie ako :max.',
        'string' => 'Pole :attribute nesmie byť väčšie ako :max znakmi.',
    ],
    'max_digits' => 'Pole :attribute nesmie mať viac ako :max číslic.',
    'mimes' => 'Pole :attribute musí byť súbor typu: :values.',
    'mimetypes' => 'Pole :attribute musí byť súbor typu: :values.',
    'min' => [
        'array' => 'Pole :attribute musí mať aspoň :min položkami.',
        'file' => 'Pole :attribute musí byť aspoň :min kilobytmi.',
        'numeric' => 'Pole :attribute musí byť aspoň :min.',
        'string' => 'Pole :attribute musí byť aspoň :min znakmi.',
    ],
    'min_digits' => 'Pole :attribute musí mať aspoň :min číslic.',
    'missing' => 'Pole :attribute musí chýbať.',
    'missing_if' => 'Pole :attribute musí chýbať, keď :other je :value.',
    'missing_unless' => 'Pole :attribute musí chýbať, pokiaľ :other nie je :value.',
    'missing_with' => 'Pole :attribute musí chýbať, keď :values je prítomný.',
    'missing_with_all' => 'Pole :attribute musí chýbať, keď :values sú prítomné.',
    'multiple_of' => 'Pole :attribute musí byť násobkom :value.',
    'not_in' => 'Vybraný :attribute je neplatný.',
    'not_regex' => 'Formát poľa :attribute je neplatný.',
    'numeric' => 'Pole :attribute musí byť číslo.',
    'password' => [
        'letters' => 'Pole :attribute musí obsahovať aspoň jedno písmeno.',
        'mixed' => 'Pole :attribute musí obsahovať aspoň jedno veľké a jedno malé písmeno.',
        'numbers' => 'Pole :attribute musí obsahovať aspoň jedno číslo.',
        'symbols' => 'Pole :attribute musí obsahovať aspoň jeden symbol.',
        'uncompromised' => 'Dané :attribute sa objavilo v úniku údajov. Prosím zvolte iný :attribute.',
    ],
    'present' => 'Pole :attribute musí byť prítomné.',
    'present_if' => 'Pole :attribute musí byť prítomné, keď :other je :value.',
    'present_unless' => 'Pole :attribute musí byť prítomné, pokiaľ :other nie je :value.',
    'present_with' => 'Pole :attribute musí byť prítomné, keď :values je prítomný.',
    'present_with_all' => 'Pole :attribute musí byť prítomné, keď :values sú prítomné.',
    'prohibited' => 'Pole :attribute je zakázané.',
    'prohibited_if' => 'Pole :attribute je zakázané, keď :other je :value.',
    'prohibited_if_accepted' => 'Pole :attribute je zakázané, keď :other je prijaté.',
    'prohibited_if_declined' => 'Pole :attribute je zakázané, keď :other je odmietnuté.',
    'prohibited_unless' => 'Pole :attribute je zakázané, pokiaľ :other nie je v :values.',
    'prohibits' => 'Pole :attribute bráni :other byť prítomný.',
    'regex' => 'Formát poľa :attribute je neplatný.',
    'required' => 'Pole :attribute je povinné.',
    'required_array_keys' => 'Pole :attribute musí obsahovať záznamy pre: :values.',
    'required_if' => 'Pole :attribute je povinné, keď :other je :value.',
    'required_if_accepted' => 'Pole :attribute je povinné, keď :other je prijaté.',
    'required_if_declined' => 'Pole :attribute je povinné, keď :other je odmietnuté.',
    'required_unless' => 'Pole :attribute je povinné, pokiaľ :other nie je v :values.',
    'required_with' => 'Pole :attribute je povinné, keď :values je prítomný.',
    'required_with_all' => 'Pole :attribute je povinné, keď :values sú prítomné.',
    'required_without' => 'Pole :attribute je povinné, keď :values nie je prítomný.',
    'required_without_all' => 'Pole :attribute je povinné, keď žiadny z :values nie je prítomný.',
    'same' => 'Pole :attribute musí zodpovedať :other.',
    'size' => [
        'array' => 'Pole :attribute musí obsahovať :size položkami.',
        'file' => 'Pole :attribute musí byť :size kilobytmi.',
        'numeric' => 'Pole :attribute musí byť :size.',
        'string' => 'Pole :attribute musí byť :size znakmi.',
    ],
    'starts_with' => 'Pole :attribute musí začínať niektorou z nasledujúcich: :values.',
    'string' => 'Pole :attribute musí byť reťazec.',
    'timezone' => 'Pole :attribute musí byť platné časové pásmo.',
    'unique' => ':attribute už bol vzatý.',
    'uploaded' => ':attribute zlyhalo pri nahrávaní.',
    'uppercase' => 'Pole :attribute musí byť veľké písmená.',
    'url' => 'Pole :attribute musí byť platná URL.',
    'ulid' => 'Pole :attribute musí byť platný ULID.',
    'uuid' => 'Pole :attribute musí byť platný UUID.',

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
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
