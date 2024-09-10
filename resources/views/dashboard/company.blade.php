@extends('layouts.dashboard')
@section('contents')

@section('css')
<style>
    .thumbnail-profile {
    max-height: 150px;
    max-width: 150px;
    object-fit: cover;
    object-position: top;
    }
</style>
@endsection

<div class="row mb-3">
    <div class="col">
        <div class="card" style="border-radius: 10px;border:transparent;">
            <div class="card-body">

                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard" class="fw-semibold"><i class="bi bi-house-fill"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit {{$data->company_name}}</li>
                    </ol>
                </nav>

            </div>
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col">
        <div class="card mb-3" style="border-radius: 10px;border:transparent;">
            <div class="card-body">

                <div class="container-fluid">
                    <form action="/company/update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="company_name" class="form-label fw-semibold">Company Name</label>
                                <input type="text" class="form-control" id="company_name" name="company_name" value="{{$data->company_name}}" required>
                                <input type="text" class="form-control" id="company_id" name="company_id" value="{{$data->id}}" hidden>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="address" class="form-label fw-semibold">Address</label>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Type address here" id="address" name="address" style="height: 100px" required>{{$data->address}}</textarea>
                                    <label for="address">Type address here</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="contact" class="form-label fw-semibold">Phone</label>
                                <input type="text" class="form-control" id="contact" name="contact" value="{{$data->contact}}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="phone" class="form-label fw-semibold">Whatsapp</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{$data->phone}}" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="information" class="form-label fw-semibold">Information</label>
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Type information here" id="information" name="information" style="height: 100px" required>{{$data->information}}</textarea>
                                    <label for="information">Type information here</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-dark btn-sm px-5">Update</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="row mb-3">
    <div class="col">
        <div class="card mb-3" style="border-radius: 10px;border:transparent;">
            <div class="card-body">

                <div class="container-fluid">
                    <form action="/company/logo-update" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <div class="fw-bold">Company Logo</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-auto">
                                <img src="{{asset('storage/company-pic/'.$data->logo)}}" alt="Logo {{$data->company_name}}" class="img-thumbnail" style="height: 150px;width:150px;object-fit: contain;">
                            </div>
                            <div class="col-auto text-muted align-self-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                                    <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1"/>
                                </svg>
                            </div>
                            <div class="col-auto">
                                <div id="imagePreview" class="mb-3"></div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="imageUpload" class="form-label fw-bold">Upload Logo</label>
                                <input class="form-control" type="file" id="imageUpload" name="imageUpload">
                                <label for="imageUpload" class="form-label text-muted">
                                    <small>Image format: jpg, jpeg, or png</small>
                                </label>
                                <input type="text" class="form-control" id="company_logo_id" name="company_logo_id" value="{{$data->id}}" hidden>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-dark btn-sm px-5">Update</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

@section('javascript')
<script>
    // Function to handle file selection and preview
    function handleFileSelect(event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(event) {
            const imagePreview = document.getElementById("imagePreview");
            imagePreview.innerHTML = '';

            const imgElement = document.createElement("img");
            imgElement.setAttribute("src", event.target.result);
            imgElement.setAttribute("class", "thumbnail-profile");
            imagePreview.appendChild(imgElement);
        };

        reader.readAsDataURL(file);
    }

    // Add event listener for file selection
    const imageUpload = document.getElementById("imageUpload");
    imageUpload.addEventListener("change", handleFileSelect);
</script>


<script>
    function goToPage(url) {
        window.location.href = url;
    }
</script>
@endsection
@endsection