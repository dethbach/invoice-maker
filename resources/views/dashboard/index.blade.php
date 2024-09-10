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
<style>
    tr.clickable-row {
        cursor: pointer; /* Change cursor to pointer for clickable effect */
    }
</style>
@endsection
<div class="row g-3">
    <div class="col-4">
      <div class="card" style="border-radius: 10px;border:transparent;">
        <div class="card-body">
         <div class="row">
          <div class="col">
            <h5>Company Name</h5>
          </div>
          <div class="col text-end">
            <button class="btn btn-sm btn-dark" style="border-radius: 10px;" data-bs-toggle="modal" data-bs-target="#modalCompany">
              <i class="bi bi-plus"></i>
            </button>
          </div>
         </div>
         <hr>

         @forelse ($companies as $company)
            <a href="/company/{{$company->id}}/edit">
                <div class="row">
                    <div class="col">
                      <div class="d-flex align-items-center">
                        <img
                            src="{{asset('storage/company-pic/'.$company->logo)}}"
                            alt=""
                            style="width: 45px; height: 45px;object-fit: contain;"
                            class="rounded-circle"
                            />
                        <div class="ms-3">
                          <p class="fw-bold mb-1">{{$company->company_name}}</p>
                          <p class="text-muted mb-0">{{$company->phone}}</p>
                        </div>
                      </div>
                    </div>
                   </div>
            </a>
         <hr>
         @empty
         <div class="row">
            <div class="col text-center text-muted fw-bold">
                No data avalible
            </div>
         </div>
         @endforelse

        </div>
      </div>
    </div>
    <div class="col-8">
      <div class="card" style="border-radius: 10px;border:transparent;">
        <div class="card-body">
          <div class="row mb-3">
            <div class="col text-end">
              <button class="btn btn-outline-dark fw-semibold btn-sm px-4" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalInvoice"><i class="bi bi-plus"></i> New Invoice</button>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Customer Name</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr class="clickable-row" onclick="goToPage('/invoice/{{$invoice->slug}}')">
                                <td>{{$invoice->invoice_number}}</td>
                                <td>{{$invoice->bill_to}}</td>
                                <td>{{date('d-m-Y', strtotime($invoice->invoice_date))}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>


    
<div class="modal fade" id="modalCompany" tabindex="-1" aria-labelledby="modalCompanyLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="/company/store" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalCompanyLabel">Register New Company</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-3">

                    <div class="mb-3">
                        <label for="company_name" class="form-label fw-semibold">Company Name</label>
                        <input type="text" class="form-control" id="company_name" name="company_name" required>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Type address here" id="address" name="address" style="height: 100px" required></textarea>
                            <label for="address">Type address here</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="contact" class="form-label fw-semibold">Phone</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold">Whatsapp</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>

                    <div class="mb-3">
                        <label for="information" class="form-label fw-semibold">Information</label>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Type information here" id="information" name="information" style="height: 100px" required></textarea>
                            <label for="information">Type information here</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col text-center">
                            <div id="imagePreview" class="mb-3"></div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-6 text-center">
                            <div class="mb-3">
                                <label for="imageUpload" class="form-label fw-bold">Upload Company Logo</label>
                                <input class="form-control" type="file" id="imageUpload" name="imageUpload">
                                <label for="imageUpload" class="form-label text-muted">
                                    <small>Image format: jpg, jpeg, or png</small>
                                </label>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer flex-nowrap p-0">
                    <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-2 m-0 rounded-0 border-end"><strong>Save</strong></button>
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-2 m-0 rounded-0  text-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
    
<div class="modal fade" id="modalInvoice" tabindex="-1" aria-labelledby="modalInvoiceLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="/invoice/register" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalInvoiceLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-3">

                    <div class="mb-3">
                        <label for="company_id" class="form-label fw-semibold">Select Company</label>
                        <select class="form-select" aria-label="Select company" id="company_id" name="company_id" required>
                            @foreach($companies as $listcompany)
                            <option value="{{$listcompany->id}}">{{$listcompany->company_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="bill_to" class="form-label fw-semibold">Bill To</label>
                        <input type="text" class="form-control" id="bill_to" name="bill_to" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="invoice_date" class="form-label fw-semibold">Invoice Date</label>
                            <input type="date" class="form-control" id="invoice_date" name="invoice_date" required>
                        </div>
                        <div class="col-6">
                            <label for="due_date" class="form-label fw-semibold">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" required>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer flex-nowrap p-0">
                    <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-2 m-0 rounded-0 border-end"><strong>Save</strong></button>
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-2 m-0 rounded-0  text-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
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