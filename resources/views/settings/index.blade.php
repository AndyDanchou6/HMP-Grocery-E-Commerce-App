@extends('app')

@section('content')

<div class="content-wrapper">

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">General Settings</h4>

        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <hr class="my-0" />
                    <div class="card-body">
                        <form id="formAccountSettings" action="{{ route('settings.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label text-dark" for="phone">Phone Number / G-cash Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text text-dark">PH (+63)</span>
                                        <input type="text" id="phone" name="phone" class="form-control text-dark" value="{{ $processedSettings['phone'] ?? '' }}" placeholder="XXX XXX XXXX" />
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label text-dark">Address</label>
                                    <input class="form-control text-dark" type="text" name="address" id="address" value="{{ $processedSettings['address'] ?? '' }}" placeholder="123 Main St, City, Province" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label text-dark">Facebook Page</label>
                                    <input class="form-control text-dark" type="text" name="fb_page" id="fb_page" value="{{ $processedSettings['fb_page'] ?? '' }}" placeholder="Your Facebook Page Name" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label text-dark">Facebook Link [optional]</label>
                                    <input class="form-control text-dark" type="text" name="fb_link" id="fb_link" value="{{ $processedSettings['fb_link'] ?? '' }}" placeholder="https://www.facebook.com/yourpage" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="opening_time" class="form-label text-dark">Opening Time</label>
                                    <input class="form-control text-dark" type="time" id="opening_time" name="opening_time" value="{{ $processedSettings['opening_time'] ?? '' }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="closing_time" class="form-label text-dark">Closing Time</label>
                                    <input type="time" class="form-control text-dark" id="closing_time" name="closing_time" value="{{ $processedSettings['closing_time'] ?? '' }}" />
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="map_url" class="form-label text-dark">Map Url [optional]</label>
                                    <textarea id="map_url" name="map_url" class="form-control text-dark" placeholder='Enter iframe code (e.g., &lt;iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125580.6943158609!2d124.72894843013358!3d10.390033588550887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33076e92da77cfd7%3A0x2945b1c797251bc2!2sHilongos%2C%20Leyte!5e0!3m2!1sen!2sph!4v1722666485083!5m2!1sen!2sph" width="100%" height="500" frameborder="0" style="border:0;" allowfullscreen&gt;&lt;/iframe&gt;)'>{{ $processedSettings['map_url'] ?? '' }}</textarea>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-outline-primary me-2" id="saveButton" disabled>Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        const form = document.getElementById('formAccountSettings');
        const saveButton = document.getElementById('saveButton');

        form.addEventListener('input', function() {
            saveButton.disabled = false;
            saveButton.classList.remove('btn-outline-primary');
            saveButton.classList.add('btn-success');
        });
    </script>
    @endsection