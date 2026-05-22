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

    'accepted' => 'វាល :attribute ត្រូវតែទទួលយក។',
     'accepted_if' => 'វាល :attribute ត្រូវតែទទួលយកនៅពេលដែល :other is :value.',
     'active_url' => 'វាល :attribute ត្រូវតែជា URL ត្រឹមត្រូវ។',
     'after' => 'វាល :attribute ត្រូវតែជាកាលបរិច្ឆេទបន្ទាប់ពី :date ។',
     'after_or_equal' => 'វាល :attribute ត្រូវតែជាកាលបរិច្ឆេទបន្ទាប់ ឬស្មើនឹង :date។',
     'alpha' => 'វាល :attribute ត្រូវតែមានអក្សរតែប៉ុណ្ណោះ។',
     'alpha_dash' => 'វាល :attribute ត្រូវ​តែ​មាន​អក្សរ លេខ សញ្ញា​ចុច និង​សញ្ញា​គូស​ក្រោម។',
     'alpha_num' => 'វាល :attribute ត្រូវតែមានអក្សរ និងលេខប៉ុណ្ណោះ។',
     'array' => 'វាល :attribute ត្រូវតែជាអារេ។',
     'ascii' => 'វាល :attribute ត្រូវតែមានតួអក្សរ និងនិមិត្តសញ្ញាលេខមួយបៃបៃប៉ុណ្ណោះ។',
     'before' => 'វាល :attribute ត្រូវតែជាកាលបរិច្ឆេទមុន :date។',
     'before_or_equal' => 'វាល :attribute ត្រូវតែជាកាលបរិច្ឆេទមុន ឬស្មើនឹង :date។',
     'between' => [
         'array' => 'វាល :attribute ត្រូវតែមានរវាង :min និង :max items។',
         'file' => 'វាល :attribute ត្រូវតែស្ថិតនៅចន្លោះ :min និង :max kilobytes។',
         'numeric' => 'វាល :attribute ត្រូវតែស្ថិតនៅចន្លោះ :min និង :max.',
         'string' => 'វាល :attribute ត្រូវតែស្ថិតនៅចន្លោះ :min និង :max តួអក្សរ។',
     ],
     'boolean' => 'វាល :attribute ត្រូវតែពិត ឬមិនពិត។',
     'can' => 'វាល :attribute មានតម្លៃដែលមិនមានការអនុញ្ញាត។',
     'confirmed' => 'ការបញ្ជាក់វាល :attribute មិនត្រូវគ្នាទេ។',
     'current_password' => 'ពាក្យសម្ងាត់មិនត្រឹមត្រូវ។',
     'date' => 'វាល :attribute ត្រូវតែជាកាលបរិច្ឆេទត្រឹមត្រូវ។',
     'date_equals' => 'វាល :attribute ត្រូវតែជាកាលបរិច្ឆេទស្មើនឹង :date។',
     'date_format' => 'វាល :attribute ត្រូវតែផ្គូផ្គងទម្រង់ :format ។',
     'decimal' => 'វាល :attribute ត្រូវតែមាន :ខ្ទង់ទសភាគ។',
     'declined' => 'វាល :attribute ត្រូវតែត្រូវបានបដិសេធ។',
     'declined_if' => 'វាល :attribute ត្រូវតែត្រូវបានបដិសេធ នៅពេលដែល :other is :value។',
     'different' => 'វាល :attribute និង :other ត្រូវតែខុសគ្នា។',
     'digits' => 'វាល :attribute ត្រូវតែជា :digits digits។',
     'digits_between' => 'វាល :attribute ត្រូវតែស្ថិតនៅចន្លោះ :min និង :max digits។',
     'dimensions' => 'វាល :attribute មានវិមាត្ររូបភាពមិនត្រឹមត្រូវ។',
     'distinct' => 'វាល :attribute មានតម្លៃស្ទួន។',
     'doesnt_end_with' => 'វាល :attribute មិនត្រូវបញ្ចប់ដោយមួយក្នុងចំណោមខាងក្រោម៖ :values.',
     'doesnt_start_with' => 'វាល :attribute មិនត្រូវចាប់ផ្តើមដោយមួយក្នុងចំណោមខាងក្រោម៖ :values.',
     'email' => 'វាល :attribute ត្រូវតែជាអាសយដ្ឋានអ៊ីមែលត្រឹមត្រូវ។',
     'ends_with' => 'វាល :attribute ត្រូវតែបញ្ចប់ដោយមួយក្នុងចំណោមខាងក្រោម៖ :values.',
     'enum' => 'បានជ្រើសរើស :attribute មិនត្រឹមត្រូវ។',
     'exists' => 'បានជ្រើសរើស :attribute មិនត្រឹមត្រូវ។',
     'file' => 'វាល :attribute ត្រូវតែជាឯកសារ។',
     'filled' => 'វាល :attribute ត្រូវតែមានតម្លៃ។',
     'gt' => [
         'array' => 'វាល :attribute ត្រូវតែមានច្រើនជាង :value items ។',
         'file' => 'វាល :attribute ត្រូវតែធំជាង :value kilobytes។',
         'numeric' => 'វាល :attribute ត្រូវតែធំជាង :value។',
         'string' => 'វាល :attribute ត្រូវតែធំជាង :value character ។',
     ],
     'gte' => [
         'array' => 'វាល :attribute ត្រូវតែមាន :value items ឬច្រើនជាងនេះ។',
         'file' => 'វាល :attribute ត្រូវតែធំជាង ឬស្មើនឹង :value kilobytes។',
         'numeric' => 'វាល :attribute ត្រូវតែធំជាង ឬស្មើនឹង :value។',
         'string' => 'វាល :attribute ត្រូវតែធំជាង ឬស្មើនឹង :value character។',
     ],
     'image' => 'វាល :attribute ត្រូវតែជារូបភាព។',
     'in' => 'បានជ្រើសរើស :attribute មិនត្រឹមត្រូវ។',
     'in_array' => 'វាល :attribute ត្រូវតែមាននៅក្នុង :other ។',
     'integer' => 'វាល :attribute ត្រូវតែជាចំនួនគត់។',
     'ip' => 'វាល :attribute ត្រូវតែជាអាសយដ្ឋាន IP ត្រឹមត្រូវ។',
     'ipv4' => 'វាល :attribute ត្រូវតែជាអាសយដ្ឋាន IPv4 ត្រឹមត្រូវ។',
     'ipv6' => 'វាល :attribute ត្រូវតែជាអាសយដ្ឋាន IPv6 ត្រឹមត្រូវ។',
     'json' => 'វាល :attribute ត្រូវតែជាខ្សែអក្សរ JSON ត្រឹមត្រូវ។',
     'lowercase' => 'វាល :attribute ត្រូវតែជាអក្សរតូច។',
     'lt' => [
         'array' => 'វាល :attribute ត្រូវតែមានតិចជាង :value items។',
         'file' => 'វាល :attribute ត្រូវតែតិចជាង :value kilobytes។',
         'numeric' => 'វាល :attribute ត្រូវតែតិចជាង :value។',
         'string' => 'វាល :attribute ត្រូវតែតិចជាង :value character។',
     ],
     'lte' => [
        'array' => 'វាល :attribute មិនត្រូវមានលើសពី :value items។',
        'file' => 'វាល :attribute ត្រូវតែតិចជាង ឬស្មើនឹង :value kilobytes។',
        'numeric' => 'វាល :attribute ត្រូវតែតិចជាង ឬស្មើនឹង :value។',
        'string' => 'វាល :attribute ត្រូវតែតូចជាង ឬស្មើនឹង :value character។',
    ],
    'mac_address' => 'វាល :attribute ត្រូវតែជាអាសយដ្ឋាន MAC ត្រឹមត្រូវ។',
    'max' => [
        'array' => 'វាល :attribute មិនត្រូវមានលើសពី :max items។',
        'file' => 'វាល :attribute មិនត្រូវធំជាង :max kilobytes។',
        'numeric' => 'វាល :attribute មិនត្រូវធំជាង :max.',
        'string' => 'វាល :attribute មិនត្រូវធំជាង :max តួអក្សរទេ។',
    ],
    'max_digits' => 'វាល :attribute មិនត្រូវមានច្រើនជាង :max digits។',
    'mimes' => 'វាល :attribute ត្រូវតែជាឯកសារប្រភេទ៖ :values.',
    'mimetypes' => 'វាល :attribute ត្រូវតែជាឯកសារប្រភេទ៖ :values.',
    'min' => [
        'array' => 'វាល :attribute ត្រូវតែមានយ៉ាងហោចណាស់ :min items។',
        'file' => 'វាល :attribute ត្រូវតែមានយ៉ាងហោចណាស់ :min គីឡូបៃ។',
        ' numeric' => 'វាល :attribute ត្រូវតែមានយ៉ាងហោចណាស់ :min ។',
        'string' => 'វាល :attribute ត្រូវតែមានយ៉ាងហោចណាស់ :min តួអក្សរ។',
    ],
    'min_digits' => 'វាល :attribute ត្រូវតែមានយ៉ាងហោចណាស់ :min digits ។',
    'missing' => 'វាល :attribute ត្រូវតែបាត់។',
    'missing_if' => 'វាល :attribute ត្រូវតែបាត់នៅពេលដែល :other is :value.',
    'missing_unless' => 'វាល :attribute ត្រូវតែបាត់ លុះត្រាតែ :other is :value ។',
    'missing_with' => 'វាល :attribute ត្រូវតែបាត់នៅពេលដែល :values មានវត្តមាន។',
    'missing_with_all' => 'វាល :attribute ត្រូវតែបាត់នៅពេលដែល :values មានវត្តមាន។',
    'multiple_of' => 'វាល :attribute ត្រូវតែជាពហុគុណនៃ :value។',
    'not_in' => 'បានជ្រើសរើស :attribute មិនត្រឹមត្រូវ។',
    'not_regex' => 'ទម្រង់វាល :attribute គឺមិនត្រឹមត្រូវទេ។',
    ' numeric' => 'វាល :attribute ត្រូវតែជាលេខ។',
    'password' => [
        'letters' => 'វាល :attribute ត្រូវតែមានយ៉ាងហោចមួយអក្សរ។',
        'mixed' => 'វាល :attribute ត្រូវតែមានយ៉ាងហោចណាស់អក្សរធំមួយ និងអក្សរតូចមួយ។',
        'numbers' => 'វាល :attribute ត្រូវតែមានយ៉ាងហោចណាស់មួយលេខ។',
        'symbols' => 'វាល :attribute ត្រូវតែមានយ៉ាងហោចណាស់និមិត្តសញ្ញាមួយ។',
        'uncompromised' => 'attribute ដែលបានផ្តល់ឱ្យបានលេចឡើងនៅក្នុងការលេចធ្លាយទិន្នន័យ។ សូមជ្រើសរើស :attribute ។',
    ],
    'present' => 'វាល :attribute ត្រូវតែមានវត្តមាន។',
    'prohibited' => 'វាល :attribute ត្រូវបានហាមឃាត់។',
    'prohibited_if' => 'វាល :attribute ត្រូវបានហាមឃាត់នៅពេលដែល :other is :value។',
    'prohibited_unless' => 'វាល :attribute ត្រូវបានហាមឃាត់ លុះត្រាតែ :other is in :values.',
    'prohibits' => 'វាល :attribute ហាមឃាត់ : ផ្សេងទៀតពីវត្តមាន។',
    'regex' => 'ទម្រង់វាល :attribute គឺមិនត្រឹមត្រូវទេ។',
    'required' => 'វាល :attribute ត្រូវបានទាមទារ។',
    'required_array_keys' => 'វាល :attribute ត្រូវតែមានធាតុសម្រាប់៖ :values។',
    'required_if' => 'វាល :attribute ត្រូវបានទាមទារ នៅពេលដែល :other is :value.',
    'required_if_accepted' => 'វាល :attribute ត្រូវបានទាមទារ នៅពេលដែល :other ត្រូវបានទទួលយក។',
    'required_unless' => 'វាល :attribute ត្រូវបានទាមទារ លុះត្រាតែ :other is in :values.',
    'required_with' => 'វាល :attribute ត្រូវបានទាមទារ នៅពេលដែល :values មានវត្តមាន។',
    'required_with_all' => 'វាល :attribute ត្រូវបានទាមទារ នៅពេលដែល :values មានវត្តមាន។',
    'required_without' => 'វាល :attribute ត្រូវបានទាមទារ នៅពេលដែល :values មិនមានវត្តមាន។',
    'required_without_all' => 'វាល :attribute ត្រូវបានទាមទារ នៅពេលដែលគ្មាន :values មានវត្តមាន។',
    'same' => 'វាល :attribute ត្រូវតែផ្គូផ្គង :other ។',
    'size' => [
        'array' => 'វាល :attribute ត្រូវតែមាន :size items ។',
        'file' => 'វាល :attribute ត្រូវតែជា :size kilobytes។',
        ' numeric' => 'វាល :attribute ត្រូវតែជា :size ។',
        'string' => 'វាល :attribute ត្រូវតែជា :size character ។',
    ],
    'starts_with' => 'វាល :attribute ត្រូវតែចាប់ផ្តើមដោយមួយក្នុងចំណោមខាងក្រោម៖ :values.',
    'string' => 'វាល :attribute ត្រូវតែជាខ្សែអក្សរ។',
    'timezone' => 'វាល :attribute ត្រូវតែជាតំបន់ពេលវេលាត្រឹមត្រូវ។',
    'unique' => ':attribute ត្រូវ​បាន​យក​រួច​ហើយ។',
    'uploaded' => 'The :attribute បរាជ័យក្នុងការបង្ហោះ។',
    'uppercase' => 'វាល :attribute ត្រូវតែជាអក្សរធំ។',
    'url' => 'វាល :attribute ត្រូវតែជា URL ត្រឹមត្រូវ។',
    'ulid' => 'វាល :attribute ត្រូវតែជា ULID ត្រឹមត្រូវ។',
    'uuid' => 'វាល :attribute ត្រូវតែជា UUID ត្រឹមត្រូវ។',
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
