

<div class="card-body" id="guarantorInfo" style="@if(old('customer_type', $customer->customer_type ?? 2) != 2) display:none; @endif">
    <h3>{{__('customer.guarantor.title')}}</h3>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="customer-guarantor-name" class="form-label">{{__('customer.name')}}</label>
            <input
                class="form-control @error('guarantor_name') is-invalid @enderror"
                type="text"
                id="customer-guarantor-name"
                name="guarantor_name"
                value="{{ old('guarantor_name', $customer->guarantor->name ?? 'គ្មាន') }}"
                autofocus
            />
            @error('guarantor_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="customer-guarantor-latin-name" class="form-label">{{__('customer.name_latin')}}</label>
            <input
                class="form-control @error('guarantor_latin_name') is-invalid @enderror"
                type="text"
                id="customer-guarantor-latin-name"
                name="guarantor_latin_name"
                value="{{ old('guarantor_latin_name', $customer->guarantor->latin_name ?? 'គ្មាន') }}"
                autofocus
            />
            @error('guarantor_latin_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="guarantor-gender" class="form-label">{{__('customer.gender')}}</label>
            <select id="guarantor-gender" class="select2 form-select @error('guarantor_gender') is-invalid @enderror" name="guarantor_gender">
                <option value="1" @if(old('guarantor_gender', $customer->guarantor->gender ?? 1) != 2) selected @endif>{{__('customer.male')}}</option>
                <option value="2" @if(old('guarantor_gender', $customer->guarantor->gender ?? 1) == 2) selected @endif>{{__('customer.female')}}</option>
            </select>
            @error('guarantor_gender')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="guarantor-nationality" class="form-label">{{__('customer.nationality')}}</label>
            <select id="guarantor-nationality" class="select2 form-select @error('guarantor_nationality') is-invalid @enderror" name="guarantor_nationality">
                <option value="1" @if(old('guarantor_nationality', $customer->guarantor->nationality ?? 1) != 2) selected @endif >{{__('customer.cambodian')}}</option>
                <option value="2" @if(old('guarantor_nationality', $customer->guarantor->nationality ?? 1) == 2) selected @endif>{{__('customer.foreigner')}}</option>
            </select>
            @error('guarantor_nationality')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="guarantor-id-card-number" class="form-label">{{__('customer.id_card_number')}}</label>
            <input
                class="form-control @error('guarantor_id_card_number') is-invalid @enderror"
                type="text"
                id="guarantor-id-card-number"
                name="guarantor_id_card_number"
                value="{{ old('guarantor_id_card_number', $customer->guarantor->id_card_number ?? '000000000') }}"
                autofocus
            />
            @error('guarantor_id_card_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="guarantor-relationship" class="form-label">{{__('customer.guarantor.relationship')}}</label>
            <select id="guarantor-relationship" class="select2 form-select @error('guarantor_relationship') is-invalid @enderror" name="guarantor_relationship">
                <option value="1" @if(old('guarantor_relationship', $customer->guarantor->customer_relation_type ?? 1) == 1) selected @endif >{{__('customer.family')}}</option>
                <option value="2" @if(old('guarantor_relationship', $customer->guarantor->customer_relation_type ?? 1) == 2) selected @endif >{{__('customer.parents')}}</option>
                <option value="3" @if(old('guarantor_relationship', $customer->guarantor->customer_relation_type ?? 1) == 3) selected @endif >{{__('customer.relatives')}}</option>
                <option value="4" @if(old('guarantor_relationship', $customer->guarantor->customer_relation_type ?? 1) == 4) selected @endif >{{__('customer.friends')}}</option>
            </select>
            @error('guarantor_relationship')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="guarantor-status" class="form-label">{{__('customer.family_status')}}</label>
            <select id="guarantor-status" class="select2 form-select @error('guarantor_status') is-invalid @enderror" name="guarantor_status">
                <option value="1" @if(old('guarantor_status', $customer->guarantor->family_status ?? '') != 2) selected @endif>{{__('customer.single')}}</option>
                <option value="2" @if(old('guarantor_status', $customer->guarantor->family_status ?? '') == 2) selected @endif>{{__('customer.married')}}</option>
            </select>
            @error('guarantor_status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label class="form-label" for="guarantor-dob">{{__('customer.dob')}}</label>
            <input
                class="form-control @error('purchase_date') is-invalid @enderror"
                type="date"
                value="{{ old('guarantor_dob', $customer->guarantor->dob ?? now()->format('Y-m-d')) }}"
                id="guarantor-dob"
                name="guarantor_dob"
            />
            @error('guarantor_dob')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="guarantor-phone" class="form-label">{{__('customer.phone')}}</label>
            <input
                class="form-control @error('guarantor_phone') is-invalid @enderror"
                type="text"
                id="guarantor-phone"
                name="guarantor_phone"
                value="{{ old('guarantor_phone', $customer->guarantor->phone ?? '000000000') }}"
                autofocus
            />
            @error('guarantor_phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="guarantor-facebook" class="form-label">{{__('customer.facebook')}}</label>
            <input
                class="form-control @error('guarantor_facebook') is-invalid @enderror"
                type="text"
                id="guarantor-facebook"
                name="guarantor_facebook"
                value="{{ old('guarantor_facebook', $customer->guarantor->facebook ?? '000000000') }}"
                autofocus
            />
            @error('guarantor_facebook')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="guarantor-house-number" class="form-label">{{__('customer.house_number')}}</label>
            <input
                class="form-control @error('guarantor_house_number') is-invalid @enderror"
                type="text"
                id="guarantor-house-number"
                name="guarantor_house_number"
                value="{{ old('guarantor_house_number', $customer->guarantor->house_number ?? 'គ្មាន') }}"
                autofocus
            />
            @error('guarantor_house_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="street-number" class="form-label">{{__('customer.street_number')}}</label>
            <input
                class="form-control @error('guarantor_street_number') is-invalid @enderror"
                type="text"
                id="street-number"
                name="guarantor_street_number"
                value="{{ old('guarantor_street_number', $customer->guarantor->street_number ?? 'គ្មាន') }}"
                autofocus
            />
            @error('guarantor_street_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="guarantor-group-number" class="form-label">{{__('customer.group_number')}}</label>
            <input
                class="form-control @error('guarantor_group_number') is-invalid @enderror"
                type="text"
                id="group-number"
                name="guarantor_group_number"
                value="{{ old('guarantor_group_number', $customer->guarantor->group_number ?? 'គ្មាន') }}"
                autofocus
            />
            @error('guarantor_group_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="guarantor-village" class="form-label">{{__('customer.village')}}</label>
            <input
                class="form-control @error('guarantor_village') is-invalid @enderror"
                type="text"
                id="guarantor-village"
                name="guarantor_village"
                value="{{ old('guarantor_village', $customer->guarantor->village ?? 'គ្មាន') }}"
                autofocus
            />
            @error('guarantor_village')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="guarantor-commune" class="form-label">{{__('customer.commune')}}</label>
            <input
                class="form-control @error('guarantor_commune') is-invalid @enderror"
                type="text"
                id="guarantor-commune"
                name="guarantor_commune"
                value="{{ old('guarantor_commune', $customer->guarantor->commune ?? 'គ្មាន') }}"
                autofocus
            />
            @error('guarantor_commune')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="guarantor-district" class="form-label">{{__('customer.district')}}</label>
            <input
                class="form-control @error('guarantor_district') is-invalid @enderror"
                type="text"
                id="guarantor-district"
                name="guarantor_district"
                value="{{ old('guarantor_district', $customer->guarantor->district ?? 'គ្មាន') }}"
                autofocus
            />
            @error('guarantor_district')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="guarantor-province" class="form-label">{{__('customer.province')}}</label>
            <input
            class="form-control @error('guarantor_province') is-invalid @enderror"
            type="text"
            id="guarantor-province"
            name="guarantor_province"
            value="{{ old('guarantor_province', $customer->guarantor->province ?? 'គ្មាន') }}"
            autofocus
            />
            @error('guarantor_province')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="guarantor_property_owner" class="form-label">{{__('customer.housing_ownership_type')}}</label>
            <select id="guarantor_property_owner" class="select2 form-select @error('guarantor_property_owner') is-invalid @enderror" name="guarantor_property_owner">
                <option value="1" @if(old('guarantor_property_owner', $customer->guarantor->housing_ownership_type ?? '') == 1) selected @endif>{{__('customer.self')}}</option>
                <option value="2" @if(old('guarantor_property_owner', $customer->guarantor->housing_ownership_type ?? '') == 2) selected @endif>{{__('customer.parents')}}</option>
                <option value="3" @if(old('guarantor_property_owner', $customer->guarantor->housing_ownership_type ?? '') == 3) selected @endif>{{__('customer.rent')}}</option>
                <option value="4" @if(old('guarantor_property_owner', $customer->guarantor->housing_ownership_type ?? '') == 4) selected @endif>{{__('customer.others')}}</option>
            </select>
            @error('guarantor_property_owner')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
