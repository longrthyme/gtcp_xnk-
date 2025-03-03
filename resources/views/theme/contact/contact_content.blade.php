@php
    $user = auth()->user();
    $disabled = '';
    if($user)
        $disabled = 'disabled';
@endphp
    @if($disabled != '')
    <input name="contact[name]" type="hidden" class="form-control" value="{{ $user->fullname??'' }}">
    <input name="contact[email]" type="hidden" class="form-control" value="{{ $user->email??'' }}">
    <input name="contact[phone]" type="hidden" class="form-control" value="{{ $user->phone??'' }}">
    <input name="contact[company]" type="hidden" class="form-control" value="{{ $user->company??'' }}">
    @endif
    <div class="list-content-loading">
         <div class="half-circle-spinner">
             <div class="circle circle-1"></div>
             <div class="circle circle-2"></div>
         </div>
     </div>
    <div class="row">
        <div class="col-lg-12 mb-3">
            <label for="name" class="form-label">{{ __('Your name') }}</label>
            <input required name="contact[name]" type="text" class="form-control" id="name" value="{{ $user->fullname??'' }}" {{ $disabled }}>
        </div>
        <div class="col-lg-12 mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input name="contact[email]" type="email" class="form-control" id="email" value="{{ $user->email??'' }}" {{ $disabled }}>
        </div>
        <div class="col-lg-12 mb-3">
            <label for="phone" class="form-label">{{ __('Phone') }}</label>
            <input name="contact[phone]" type="tel" class="form-control" id="phone" value="{{ $user->phone??'' }}" {{ $disabled }}>
        </div>
        <div class="col-lg-12 mb-3">
            <label for="company" class="form-label">{{ __('Company') }}</label>
            <input name="contact[company]" type="tel" class="form-control" id="company" value="{{ $user->company??'' }}" {{ $disabled }}>
        </div>
        <div class="col-lg-12 mb-3">
            <label for="subject" class="form-label">{{ __('Subject') }}</label>
            <input required name="contact[subject]" type="text" class="form-control" id="subject">
        </div>
    </div>
    
    
    <div class="mb-3">
        <label for="messase" class="form-label">{{ __('Request/Response') }}</label>
        <textarea name="contact[message]" class="form-control" id="message" rows="3" required></textarea>
    </div>
    @if(Session::get('error'))
    <div class="box-message mb-3">
        <p class="text-danger">{{ __(Session::get('message')) }}</p>
    </div>
    @endif
    @if(Session::get('success'))
    <div class="box-message mb-3">
        <p class="text-success">{{ __(Session::get('message')) }}</p>
    </div>
    @endif