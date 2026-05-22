<div id="loanInfo" class="card-body" style="@if(old('customer_type', $customer->customer_type ?? 2) != 2) display:none; @endif">
    <h3>{{__('customer.company.title')}}</h3>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="company-name" class="form-label">{{__('customer.company.name')}}</label>
            <input
                class="form-control @error('customer_company_name') is-invalid @enderror"
                type="text"
                id="company-name"
                name="customer_company_name"
                value="{{ old('customer_company_name', $customer->job->name ?? 'គ្មាន') }}"
                autofocus
            />
            @error('customer_company_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="company-name-latin" class="form-label">{{__('customer.company.name_latin')}}</label>
            <input
                class="form-control @error('customer_company_name_latin') is-invalid @enderror"
                type="text"
                id="company-name-latin"
                name="customer_company_name_latin"
                value="{{ old('customer_company_name_latin', $customer->job->latin_name ?? 'គ្មាន') }}"
                autofocus
            />
            @error('customer_company_name_latin')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="company_phone" class="form-label">{{__('customer.company.phone')}}</label>
            <input
                class="form-control @error('company_phone') is-invalid @enderror"
                type="text"
                id="company-phone"
                name="company_phone"
                value="{{ old('company_phone', $customer->job->phone ?? '000000000') }}"
                autofocus
            />
            @error('company_phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-6">
            <label for="company_email" class="form-label">{{__('customer.company.email')}}</label>
            <input
                class="form-control @error('company_email') is-invalid @enderror"
                type="text"
                id="company-email"
                name="company_email"
                value="{{ old('company_email', $customer->job->email ?? 'no@email.co') }}"
                autofocus
            />
            @error('company_email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="company_house_number" class="form-label">{{__('customer.house_number')}}</label>
            <input
                class="form-control @error('company_house_number') is-invalid @enderror"
                type="text"
                id="company_house_number"
                name="company_house_number"
                value="{{ old('company_house_number', $customer->job->house_number ?? 'គ្មាន') }}"
                autofocus
            />
            @error('company_house_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3 col-md-3">
            <label for="company-street-number" class="form-label">{{__('customer.street_number')}}</label>
            <input
                class="form-control @error('company_street_number') is-invalid @enderror"
                type="text"
                id="company-street-number"
                name="company_street_number"
                value="{{ old('company_street_number', $customer->job->street_number ?? 'គ្មាន') }}"
                autofocus
            />
            @error('company_street_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

      <div class="mb-3 col-md-3">
          <label for="company-group-number" class="form-label">{{__('customer.group_number')}}</label>
          <input
              class="form-control @error('company_group_number') is-invalid @enderror"
              type="text"
              id="company-group-number"
              name="company_group_number"
              value="{{ old('company_group_number', $customer->job->group_number ?? 'គ្មាន') }}"
              autofocus
          />
          @error('company_group_number')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>

      <div class="mb-3 col-md-3">
          <label for="company-village" class="form-label">{{__('customer.village')}}</label>
          <input
              class="form-control @error('company_village') is-invalid @enderror"
              type="text"
              id="company-village"
              name="company_village"
              value="{{ old('company_village', $customer->job->village ?? 'គ្មាន') }}"
              autofocus
          />
          @error('company_village')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>

      <div class="mb-3 col-md-4">
          <label for="company-commune" class="form-label">{{__('customer.commune')}}</label>
          <input
              class="form-control @error('company_commune') is-invalid @enderror"
              type="text"
              id="company-commune"
              name="company_commune"
              value="{{ old('company_commune', $customer->job->commune ?? 'គ្មាន') }}"
              autofocus
          />
          @error('company_commune')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>

      <div class="mb-3 col-md-4">
          <label for="company-district" class="form-label">{{__('customer.district')}}</label>
          <input
              class="form-control @error('company_district') is-invalid @enderror"
              type="text"
              id="company-district"
              name="company_district"
              value="{{ old('company_district', $customer->job->district ?? 'គ្មាន') }}"
              autofocus
          />
          @error('company_district')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>

      <div class="mb-3 col-md-4">
          <label for="company-province" class="form-label">{{__('customer.province')}}</label>
          <input
              class="form-control @error('company_province') is-invalid @enderror"
              type="text"
              id="company-province"
              name="company_province"
              value="{{ old('company_province', $customer->job->province ?? 'គ្មាន') }}"
              autofocus
          />
          @error('company_province')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>



      <div class="mb-3 col-md-4">
          <label for="salary" class="form-label">{{__('customer.salary')}}</label>
          <input
              class="form-control @error('salary') is-invalid @enderror"
              type="text"
              id="salary"
              name="salary"
              value="{{ old('salary', $customer->job->salary ?? 0) }}"
              autofocus
          />
          @error('salary')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>

      <div class="mb-3 col-md-4">
          <label for="other_income" class="form-label">{{__('customer.company.income')}}</label>
          <input
              class="form-control @error('other_income') is-invalid @enderror"
              type="text"
              id="other_income"
              name="other_income"
              value="{{ old('other_income', $customer->job->other_income ?? 0) }}"
              autofocus
          />
          @error('other_income')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>

      <div class="mb-3 col-md-4">
          <label class="form-label" for="date_income">{{__('customer.date_income')}}</label>
          <select id="date_income" class="select2 form-select @error('date_income') is-invalid @enderror" name="date_income">
            @for ($i=1;$i <= 31; $i ++)
                <option value="{{ $i }}" @if(old('date_income', $customer->job->salary_date ?? 1) == $i) selected @endif>{{ $i }}</option>
            @endfor
        </select>
        @error('date_income')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
          @enderror
      </div>
  </div>
</div>
