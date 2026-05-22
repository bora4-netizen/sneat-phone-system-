<div class="card-body">
    <div class="d-flex align-items-start align-items-sm-center gap-4">
        <img
            src="{{ isset($customer->profile_image) ? $customer->profile_image : asset('/assets/img/blank-profile.png') }}"
            alt="user-avatar"
            class="d-block rounded"
            height="100"
            width="100"
            id="uploadedAvatar"
            onError="this.onerror=null;this.src='{{ asset('/assets/img/blank-profile.png') }}';"
        />
        <input type="hidden" value="{{ isset($customer->profile_image) ? $customer->profile_image : asset('/assets/img/blank-profile.png') }}" class="mediaUserdata" />
        <div class="button-wrapper">
            <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                <span class="d-none d-sm-block">{{__('button.upload_new_photo')}}</span>
                <i class="bx bx-upload d-block d-sm-none"></i>
                <input
                    type="file"
                    id="upload"
                    name="profile"
                    class="account-file-input"
                    hidden
                    accept="image/png, image/jpeg"
                />
            </label>
            <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                <i class="bx bx-reset d-block d-sm-none"></i>
                <span class="d-none d-sm-block">{{__('button.reset')}}</span>
            </button>
            <p class="text-muted mb-0">Allowed JPG, GIF or PNG.</p>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="name" class="form-label">{{__('customer.name')}}</label>
            <input
                class="form-control @error('name') is-invalid @enderror"
                type="text"
                id="name"
                name="name"
                value="{{ old('name', $customer->name ?? '') }}"
                autofocus
            />
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
          <div class="mb-3 col-md-6">
              <label for="name-latin" class="form-label">{{__('customer.name_latin')}}</label>
              <input
                  class="form-control @error('latin_name') is-invalid @enderror"
                  type="text"
                  id="name-latin"
                  name="latin_name"
                  value="{{ old('latin_name', $customer->latin_name ?? '') }}"
                  autofocus
              />
              @error('latin_name')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-6">
              <label for="id_card_number" class="form-label">{{__('customer.id_card_number')}}</label>
              <input
                  class="form-control @error('id_card_number') is-invalid @enderror"
                  type="text"
                  id="id_card_number"
                  name="id_card_number"
                  value="{{ old('id_card_number', $customer->id_card_number ?? '') }}"
                  autofocus
              />
              @error('id_card_number')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-6">
              <label for="customer_type" class="form-label">{{__('customer.customer_type')}}</label>
              <select id="customer_type" class="select2 form-select @error('customer_type') is-invalid @enderror" name="customer_type">
                  <option value="1" @if(old('customer_type', $customer->customer_type ?? 1) != 2) @endif>{{__('customer.normal')}}</option>
                  <option value="2" selected @if(old('customer_type', $customer->customer_type ?? 1) == 2) selected @endif>{{__('customer.loan')}}</option>
              </select>
              @error('customer_type')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-6">
              <label for="gender" class="form-label">{{__('customer.gender')}}</label>
              <select id="gender" class="select2 form-select @error('gender') is-invalid @enderror" name="gender">
                  <option value="1" @if(old('gender', $customer->gender ?? 1) != 2) selected @endif>{{__('customer.male')}}</option>
                  <option value="2" @if(old('gender', $customer->gender ?? 1) == 2) selected @endif>{{__('customer.female')}}</option>
              </select>
              @error('gender')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-6">
              <label for="nationality" class="form-label">{{__('customer.nationality')}}</label>
              <select id="nationality" class="select2 form-select @error('nationality') is-invalid @enderror" name="nationality">
                  <option value="1" @if(old('nationality', $customer->nationality ?? 1) != 2) selected @endif >{{__('customer.cambodian')}}</option>
                  <option value="2" @if(old('nationality', $customer->nationality ?? 1) == 2) selected @endif>{{__('customer.foreigner')}}</option>
              </select>
              @error('nationality')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>


          <div class="mb-3 col-md-6">
              <label for="family_status" class="form-label">{{__('customer.family_status')}}</label>
              <select id="family_status" class="select2 form-select @error('family_status') is-invalid @enderror" name="family_status">
                  <option value="1" @if(old('family_status', $customer->family_status ?? 1) != 2) selected @endif>{{__('customer.single')}}</option>
                  <option value="2" @if(old('family_status', $customer->family_status ?? 1) == 2) selected @endif>{{__('customer.married')}}</option>
              </select>
              @error('family_status')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-6">
              <label class="form-label" for="dob">{{__('customer.dob')}}</label>
              <input class="form-control @error('dob') is-invalid @enderror" type="date" value="{{ old('dob', $customer->dob ?? '')}}" id="dob" name="dob"/>
              @error('dob')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>
          <div class="mb-3 col-md-4">
              <label for="phone" class="form-label">{{__('customer.phone')}} (1)</label>
              <input
                  class="form-control @error('phone') is-invalid @enderror"
                  type="text"
                  id="phone"
                  name="phone"
                  value="{{ old('phone', $customer->phone ?? '') }}"
                  autofocus
              />
              @error('phone')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-4">
              <label for="mobile" class="form-label">{{__('customer.phone')}}(2)</label>
              <input
                  class="form-control @error('mobile') is-invalid @enderror"
                  type="text"
                  id="mobile"
                  name="mobile"
                  value="{{ old('mobile', $customer->mobile ?? '00000000') }}"
                  autofocus
              />
              @error('mobile')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>


          <div class="mb-3 col-md-4">
              <label for="facebook" class="form-label">{{__('customer.facebook')}}</label>
              <input
                  class="form-control @error('facebook') is-invalid @enderror"
                  type="text"
                  id="facebook"
                  name="facebook"
                  value="{{ old('facebook', $customer->facebook ?? 'គ្មាន') }}"
                  autofocus
              />
              @error('facebook')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-3">
              <label for="house_number" class="form-label">{{__('customer.house_number')}}</label>
              <input
                  class="form-control @error('house_number') is-invalid @enderror"
                  type="text"
                  id="house-number"
                  name="house_number"
                  value="{{ old('house_number', $customer->house_number ?? '') }}"
                  autofocus
              />
              @error('house_number')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-3">
              <label for="street_number" class="form-label">{{__('customer.street_number')}}</label>
              <input
                  class="form-control @error('street_number') is-invalid @enderror"
                  type="text"
                  id="street-number"
                  name="street_number"
                  value="{{ old('street_number', $customer->street_number ?? '') }}"
                  autofocus
              />
              @error('street_number')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-3">
              <label for="group_number" class="form-label">{{__('customer.group_number')}}</label>
              <input
                  class="form-control @error('group_number') is-invalid @enderror"
                  type="text"
                  id="group-number"
                  name="group_number"
                  value="{{ old('group_number', $customer->group_number ?? '') }}"
                  autofocus
              />
              @error('group_number')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-3">
              <label for="village" class="form-label">{{__('customer.village')}}</label>
              <input
                  class="form-control @error('village') is-invalid @enderror"
                  type="text"
                  id="village"
                  name="village"
                  value="{{ old('village', $customer->village ?? '') }}"
                  autofocus
              />
              @error('village')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-3">
              <label for="district" class="form-label">{{__('customer.district')}}</label>
              <input
                  class="form-control @error('district') is-invalid @enderror"
                  type="text"
                  id="district"
                  name="district"
                  value="{{ old('district', $customer->district ?? '') }}"
                  autofocus
              />
              @error('district')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

          <div class="mb-3 col-md-3">
              <label for="commune" class="form-label">{{__('customer.commune')}}</label>
              <input
                  class="form-control @error('commune') is-invalid @enderror"
                  type="text"
                  id="commune"
                  name="commune"
                  value="{{ old('commune', $customer->commune ?? '') }}"
                  autofocus
              />
              @error('commune')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
          </div>

      <div class="mb-3 col-md-3">
          <label for="province" class="form-label">{{__('customer.province')}}</label>
          <input
              class="form-control @error('province') is-invalid @enderror"
              type="text"
              id="province"
              name="province"
              value="{{ old('province', $customer->province ?? '') }}"
              autofocus
          />
          @error('province')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>

      <div class="mb-3 col-md-3">
          <label for="housing_ownership_type" class="form-label">{{__('customer.housing_ownership_type')}}</label>
          <select id="housing_ownership_type" class="select2 form-select @error('housing_ownership_type') is-invalid @enderror" name="housing_ownership_type">
              <option value="1" @if(old('housing_ownership_type', $customer->housing_ownership_type ?? 1) == 1) selected @endif>{{__('customer.self')}}</option>
              <option value="2" @if(old('housing_ownership_type', $customer->housing_ownership_type ?? 1) == 2) selected @endif>{{__('customer.parents')}}</option>
              <option value="3" @if(old('housing_ownership_type', $customer->housing_ownership_type ?? 1) == 3) selected @endif>{{__('customer.relatives')}}</option>
              <option value="4" @if(old('housing_ownership_type', $customer->housing_ownership_type ?? 1) == 4) selected @endif>{{__('customer.rent')}}</option>
              <option value="5" @if(old('housing_ownership_type', $customer->housing_ownership_type ?? 1) == 5) selected @endif>{{__('customer.others')}}</option>
          </select>
          @error('housing_ownership_type')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>
  </div>
</div>
