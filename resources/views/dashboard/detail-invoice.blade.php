@extends('layouts.dashboard')
@section('contents')


<div class="card mb-3" style="border-radius: 10px;border:transparent;">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6 col-sm-12">
                
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard" class="fw-semibold"><i class="bi bi-house-fill"></i> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$data->invoice_number}}</li>
                    </ol>
                </nav>

            </div>
            <div class="col-md-6 col-sm-12 text-end">
                <form action="/invoice/reset" method="POST">
                    @csrf
                    <input type="text" name="myInvoice" value="{{$data->id}}" hidden>
                    <button type="submit" class="btn btn-outline-danger px-4 btn-sm" style="border-radius: 8px;"><i class="bi bi-arrow-counterclockwise"></i> Delete</button>
                </form>
            </div>
        </div>
        <hr>

        <div class="row">
            <div class="col-md-4 col-sm-12">
                <img class="mb-2" src="{{asset('storage/company-pic/'.$data->invoiceCompany->logo)}}" alt="{{$data->invoiceCompany->company_name}}" height="150px" width="150px"> <br>
                <small class="fw-bold text-muted mb-0">{{$data->invoiceCompany->address}}</small> <br>
                <small class="fw-bold text-muted mb-0"><i class="bi bi-telephone"></i> {{$data->invoiceCompany->contact}} <i class="bi bi-whatsapp ms-2"></i> {{$data->invoiceCompany->phone}}</small>
            </div>
            <div class="col-md-8 col-sm-12 align-self-start text-end">
                <h1 class="fw-bold mb-0">Invoice</h1>
                <h5 class="mb-0">#{{$data->invoice_number}}</h5>
            </div>
        </div>
        <hr>
        <div class="row justify-content-between mb-3">
            <div class="col-auto align-self-end">
                Bill to: <br>
                <span class="fw-bold">{{$data->bill_to}}</span>
            </div>
            <div class="col-auto text-end">
                <table>
                    <tr>
                        <td>Invoice Number </td>
                        <td class="px-3">:</td>
                        <td><span class="fw-bold">{{$data->invoice_number}}</span></td>
                    </tr>
                    <tr>
                        <td>Terms</td>
                        <td class="px-3">:</td>
                        <td><span class="fw-bold">Due on Receipt</span></td>
                    </tr>
                    <tr>
                        <td>Invoice Date </td>
                        <td class="px-3">:</td>
                        <td><span class="fw-bold">{{date('d-m-Y', strtotime($data->invoice_date))}}</span></td>
                    </tr>
                    <tr>
                        <td>Due Date </td>
                        <td class="px-3">:</td>
                        <td><span class="fw-bold">{{date('d-m-Y', strtotime($data->due_date))}}</span></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row g-1 mb-2">
            <div class="col-auto">
                <button class="btn btn-outline-dark btn-sm px-4 fw-bold" style="border-radius: 8px;" data-bs-toggle="modal" data-bs-target="#modalInsert"><i class="bi bi-plus"></i> Insert Data</button>
            </div>
            <div class="col-auto">
                <a href="/invoice-data/export/{{$data->slug}}" target="_blank" class="btn btn-dark btn-sm fw-bold" style="border-radius: 8px;"><i class="bi bi-cloud-arrow-down"></i> Download</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="table-primary">
                                <th>#</th>
                                <th>Item & Description</th>
                                <th class="text-center">Qty</th>
                                <th>Rate</th>
                                <th>Amount</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach($details as $detail)
                            <tr>
                                <td>{{$i++}}.</td>
                                <td>{{$detail->item}}</td>
                                <td class="text-center">{{$detail->qty}}</td>
                                <td>@currency_idr($detail->price)</td>
                                <td>@currency_idr($detail->amount)</td>
                                <td><a href="/invoice-data/{{$detail->id}}/delete" class="btn btn-sm btn-dark" style="border-radius: 8px;"><i class="bi bi-trash"></i></a></td>
                            </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="fw-bold">Total</td>
                                <td class="fw-bold">@currency_idr($sum)</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
               <small> Notes <br>
                Thank you for trusting us</small>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <small>{{$data->invoiceCompany->information}}</small>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3" style="border-radius: 10px;border:transparent;">
    <div class="card-body">
        <div class="row g-1 mb-3">
            <div class="col-auto">
                @if($receipt == null)
                <button class="btn btn-dark btn-sm px-4" data-bs-toggle="modal" data-bs-target="#modalReceipt" style="border-radius: 8px;"><i class="bi bi-plus"></i> Create Receipt</button>
                @else
                <a href="/invoice-data/{{$data->id}}/reset-receipt" class="btn btn-dark btn-sm px-4" style="border-radius: 8px;"><i class="bi bi-arrow-counterclockwise"></i> Reset</a>
                @endif
            </div>
            @if($receipt != null)
            <div class="col-auto">
                <a href="/invoice-data/export-receipt/{{$receipt->id}}" target="_blank" class="btn btn-outline-dark btn-sm fw-bold" style="border-radius: 8px;"><i class="bi bi-cloud-arrow-down"></i> Download</a>
            </div>
            @endif
        </div>

        <div class="row">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Invoice Number</th>
                            <th>Invoice Date</th>
                            <th>Invoice Amount</th>
                            <th>Payment Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($receipt != null)
                        <tr>
                            <td>{{$receipt->receiptInvoice->invoice_number}}</td>
                            <td>{{date('d-m-Y', strtotime($receipt->payment_date))}}</td>
                            <td>@currency_idr($sum)</td>
                            <td>@currency_idr($receipt->amount_received)</td>
                        </tr>
                        @else
                        <tr>
                            <td class="text-center text-muted" colspan="4">No Receipt</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalInsert" tabindex="-1" aria-labelledby="modalInsertLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="/invoice-data/store" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalInsertLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-3">

                    <div class="mb-3">
                        <label for="item" class="form-label fw-semibold">Item & Description</label>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Type item and description here" id="item" name="item" style="height: 100px" required></textarea>
                            <label for="item">Type item and description</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 col-sm-12 mb-3">
                            <label for="qty" class="form-label fw-semibold">Quantity</label>
                            <input type="number" class="form-control" id="qty" name="qty" required>
                        </div>
                        <div class="col">
                            <label for="price" class="form-label fw-semibold">Price</label>
                            <input type="text" class="form-control" id="price" name="price" required>
                            <input type="text" name="invoice_id" value="{{$data->id}}" hidden>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-nowrap p-0">
                    <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-2 m-0 rounded-0 border-end"><strong>Add</strong></button>
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-2 m-0 rounded-0  text-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalReceipt" tabindex="-1" aria-labelledby="modalReceiptLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="/invoice-data/store-receipt" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalReceiptLabel"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body mb-3">

                    <div class="mb-3">
                        <label for="payment_date" class="form-label fw-semibold">Payment Date</label>
                        <input type="date" class="form-control" id="payment_date" name="payment_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="payment_mode" class="form-label fw-semibold">Payment Mode</label>
                        <input type="text" class="form-control" id="payment_mode" name="payment_mode" required>
                    </div>
                    <div class="mb-3">
                        <label for="amount_received" class="form-label fw-semibold">Amount Received</label>
                        <input type="text" class="form-control" id="amount_received" name="amount_received" required>
                        <input type="text" name="invoice_id" value="{{$data->id}}" hidden>
                    </div>
                </div>
                <div class="modal-footer flex-nowrap p-0">
                    <button type="submit" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-2 m-0 rounded-0 border-end"><strong>Add</strong></button>
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 py-2 m-0 rounded-0  text-danger" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


@section('javascript')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        var price = document.getElementById('price');
        price.addEventListener('keyup', function(e) {
            price.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    });
</script>
<script>
    $(document).ready(function() {
        var amountReceived = document.getElementById('amount_received');
        amountReceived.addEventListener('keyup', function(e) {
            amountReceived.value = formatRupiah(this.value, 'Rp. ');
        });

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }
    });
</script>
@endsection

@endsection