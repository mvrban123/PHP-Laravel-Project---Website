<?php

namespace App\Http\Validators;

use App\Models\Korisnik;
use Illuminate\Support\Facades\Validator;
use App\Http\Sanitizers\BaseSanitizer;
use App\Modules\Registration\RegistrationSession;
use Illuminate\Validation\Rule;

class FamilyValidator {
    protected $rules = [];
    private $sanitized_data = [];

    public function validate($data, $ruleset = 'create')
    {  
        // $this->sanitized_data = BaseSanitizer::sanitize($data);
        $this->sanitized_data = $data;
        
        switch($ruleset)
        {
            case 'create':
                $this->rules = $this->getCreateRules();
                break;

            case 'update':
                // $this->rules = $this->getUpdateRules();
                $this->rules = null;
                break;
        };

        // Create the validator instance and validate.
        // $validator = Validator::make($data, $rules, $messages);
        $validator = Validator::make(
            $this->sanitized_data, 
            $this->rules
        );

        if ($result = $validator->fails()) 
        {
            $this->errors = ["NECES RAZBOJNICE"];
        }

        return !$result;
    }

    private function getCreateRules()
    {
        $create_rules = [
            'finalRegStep' => ['required', 'boolean'],
            // roditelj 1
            'rod1.*' => ['required_if:finalRegStep,1'],
            'rod1.name' => ['required_if:finalRegStep,1', 'string'],
            'rod1.lname' => ['required_if:finalRegStep,1', 'string'],
            'rod1.oib' => ['required_if:finalRegStep,1', 'digits:11'],
            'rod1.email' => [
                'bail',
                'required',
                'email:filter', 
                Rule::unique('korisnici', 'email')
            ],
            'rod1.passwd' => ['required_if:finalRegStep,1', 'string'],
            'rod1.username' => [
                'required',
                Rule::unique('korisnici', 'korisnicko_ime')
            ],
            'rod1.dob' => ['required_if:finalRegStep,1', 'date'],
            'rod1.gender' => ['required_if:finalRegStep,1', 'string'],
            'rod1.singleParent' => ['required_if:finalRegStep,1'],
            'rod1.phone' => ['required_if:finalRegStep,1', 'string'],
            'rod1.tel' => ['sometimes', 'string'],
            'rod1.loedu' => ['required_if:finalRegStep,1'],
            'rod1.profession' => ['required_if:finalRegStep,1', 'string'],
            'rod1.street_name' => ['required_if:finalRegStep,1', 'string'],
            'rod1.street_number' => ['required_if:finalRegStep,1', 'string'],
            'rod1.rucniUnos' => ['required_if:finalRegStep,1', 'boolean'],
            'rod1.residence_place' => [
                'bail',
                'string',
                Rule::requiredIf(function (){
                    return (
                        $this->sanitized_data['rod1']['rucniUnos'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ],
            'rod1.country' => [
                'bail',
                'string',
                Rule::requiredIf(function (){
                    return (
                        $this->sanitized_data['rod1']['rucniUnos'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ],
            'rod1.zip' => [
                'bail',
                'numeric',
                Rule::requiredIf(function (){
                    return (
                        $this->sanitized_data['rod1']['rucniUnos'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ],
            'rod1.residence_id' => [
                'bail',
                'numeric',
                Rule::requiredIf(function (){
                    return (
                        !$this->sanitized_data['rod1']['rucniUnos'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ],
            'rod1.notify' => ['required_if:finalRegStep,1', 'boolean'],
            'rod1.active_participant' => ['required_if:finalRegStep,1', 'boolean'],
            'rod1.reg_notes' => ['sometimes', 'string'],
            'rod1.skills' => ['sometimes', 'string'],
            'rod1.confirmation' => ['required_if:finalRegStep,1', 'boolean'],

            // roditelj 2
            'rod2.*' => [
                Rule::requiredIf(function (){
                    return (
                        !$this->sanitized_data['rod1']['singleParent'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ],
            'rod2.name' => ['sometimes','string'],
            'rod2.lname' => ['sometimes', 'string'],
            'rod2.oib' => ['sometimes', 'digits:11'],
            'rod2.email' => [
                'bail',
                'sometimes',
                'email:filter', 
                Rule::unique('korisnici', 'email')
            ],
            'rod2.passwd' => ['sometimes', 'string'],
            'rod2.username' => [
                'bail',
                'sometimes',
                Rule::unique('korisnici', 'korisnicko_ime')
            ],
            'rod2.dob' => ['sometimes', 'date'],
            'rod2.gender' => ['sometimes', 'string'],
            'rod2.same_address' => ['bail', 'sometimes', 'boolean'],
            'rod2.phone' => ['sometimes', 'string',],
            'rod2.tel' => ['sometimes', 'string'],
            'rod2.loedu' => ['sometimes', 'string'],
            'rod2.profession' => ['sometimes', 'string'],
            'rod2.street_name' => [
                'bail',
                'string',
                Rule::requiredIf(function (){
                    return (
                        !$this->sanitized_data['rod1']['singleParent'] &&
                        !$this->sanitized_data['rod2']['same_address'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ],
            'rod2.street_number' => [
                'bail',
                'string',
                Rule::requiredIf(function (){
                    return (
                        !$this->sanitized_data['rod1']['singleParent'] &&
                        !$this->sanitized_data['rod2']['same_address'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ],
            'rod2.residence_place' => [
                'bail',
                'string',
                Rule::requiredIf(function (){
                    return (
                        !$this->sanitized_data['rod1']['singleParent'] &&
                        !$this->sanitized_data['rod2']['same_address'] &&
                        $this->sanitized_data['rod2']['rucniUnos'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ],
            'rod2.country' => [
                'bail',
                'string',
                Rule::requiredIf(function (){
                    return (
                        !$this->sanitized_data['rod1']['singleParent'] &&
                        !$this->sanitized_data['rod2']['same_address'] &&
                        $this->sanitized_data['rod2']['rucniUnos'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ],
            'rod2.zip' => [
                'bail',
                'numeric',
                Rule::requiredIf(function (){
                    return (
                        !$this->sanitized_data['rod1']['singleParent'] &&
                        !$this->sanitized_data['rod2']['same_address'] &&
                        $this->sanitized_data['rod2']['rucniUnos'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ],
            'rod2.residence_id' => [
                'bail',
                'numeric',
                Rule::requiredIf(function (){
                    return (
                        !$this->sanitized_data['rod1']['singleParent'] &&
                        !$this->sanitized_data['rod2']['same_address'] &&
                        !$this->sanitized_data['rod2']['rucniUnos'] &&
                        $this->sanitized_data['finalRegStep']
                    );
                })
            ], 
            'rod2.notify' => ['sometimes', 'boolean'],
            'rod2.active_participant' => ['sometimes', 'boolean'],
            'rod2.reg_notes' => ['sometimes', 'string'],
            'rod2.skills' => ['sometimes', 'string'],
            'rod2.confirmation' => ['sometimes', 'boolean'],

            // djeca
            'djeca' => [
                'bail', 
                'required_if:finalRegStep,1', 
                'array', 
                'min:3'
            ],
            'djeca.*.*' => ['bail', 'required_if:finalRegStep,1'],
            'djeca.*.ime' => ['bail', 'string'],
            'djeca.*.prezime' => ['bail', 'string'],
            'djeca.*.datum' => ['bail', 'date'],
            'djeca.*.OIB' => [
                'bail', 
                'digits:11', 
                Rule::unique('korisnici', 'oib')
            ]
        ];

        return $create_rules;
    }
    
    private function getUpdateRules()
    {
        // dodatna 'required_if' pravila: https://laravel.com/docs/5.7/validation#rule-required-if
        // rjesenje za update djece i više korisnika odjednom: https://stackoverflow.com/a/43533523
        // $update_rules = $this->getCreateRules();
        
        $this->getUserIdsForUpdate();

        $update_rules = [
            'rod1.email' => [
                'bail',
                'email:filter', 
                Rule::unique('korisnici', 'email')->ignore('rod1.id_db')
            ],

            'rod1.username' => [
                'bail',
                'required',
                Rule::unique('korisnici', 'korisnicko_ime')->ignore('rod1.id_db')
            ],

            'rod2.email' => [
                'bail',
                'sometimes',
                'email:filter', 
                Rule::unique('korisnici', 'email')->ignore('rod2.id_db')
            ],

            'rod2.username' => [
                'bail',
                'required',
                Rule::unique('korisnici', 'korisnicko_ime')->ignore('rod2.id_db')
            ],

            'djeca.*.OIB' => [
                'bail',
                Rule::unique('korisnici', 'oib')->ignore('djeca.*.id_db')
            ]
        ];

        $update_rules = array_merge(
            $this->getCreateRules(), 
            $update_rules
        );

        return $update_rules;
    }

    private function getUserIdsForUpdate()
    {
        $registrationSession = new RegistrationSession();

        if ($registrationSession->hasKey($registrationSession->rod1IdDbLabel))
        {
            $this->sanitized_data['rod1']['id_db'] = $registrationSession->getRod1Id();
        }
        else {
            $this->sanitized_data['rod1']['id_db'] = null;
        }

        if ($registrationSession->hasKey($registrationSession->rod2IdDbLabel))
        {
            $this->sanitized_data['rod2']['id_db'] = $registrationSession->getRod2Id();
        }
        else {
            $this->sanitized_data['rod2']['id_db'] = null;
        }
    }
}
/*
    private function getUserIdsForUpdate()
    {
        $rod1_id = Korisnik::where(
            'email', '=', $this->sanitized_data['rod1']['email']
        )->first();

        if ($rod1_id)
        {
            $this->sanitized_data['rod1']['id_db'] = $rod1_id->id;
        }
        else {
            $this->sanitized_data['rod1']['id_db'] = null;
        }

        if (array_key_exists('email', $this->sanitized_data['rod2']))
        {
            $rod2_id = Korisnik::where(
                'email', '=', $this->sanitized_data['rod2']['email']
            )->first();         
            
            if ($rod2_id)
            {
                $this->sanitized_data['rod2']['id_db'] = $rod2_id->id;
            }
            else {
                $this->sanitized_data['rod2']['id_db'] = null;
            }
        }

        foreach ($this->sanitized_data['djeca'] as $key => $_) {
            $dijete = Korisnik::where(
                'oib', '=', $this->sanitized_data['djeca'][$key]['OIB']
            )->first();
            
            if ($dijete)
            {
                $this->sanitized_data['djeca'][$key]['id_db'] = $dijete->id;
            }
            else {
                $this->sanitized_data['djeca'][$key]['id_db'] = null;
            }
        }
    }
*/