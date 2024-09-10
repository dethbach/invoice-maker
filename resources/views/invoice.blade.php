<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>{{$data->invoice_number}} to {{$data->bill_to}}</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
	</style>
	<style>
		body{
			font-family: "Roboto", sans-serif;
		}

		* {
			box-sizing: border-box;
		  }

		.table-data{
			border-spacing: 0px;
			border-collapse: collapse;
			width: 100%;
			max-width: 100%;
			margin-bottom: 15px;
			background-color: transparent;
			text-align: left;
		}

		.table-data th {
			font-weight: bolder;
			font-size: medium;
			border: 0px solid black;
			padding: 8px;
			background-color: black;
			color: #ffffff;
		}

		.table-data td {
			/* border: 1px solid #cccccc; */
			border-collapse: collapse;
			border: 1px solid #ccc;
			padding: 8px;
		}
	</style>
</head>
<body>

	<table style="width: 100%;margin-bottom: 40px;">
		<tr>
			<td>				
				<img class="mb-2" src="{{public_path('storage/company-pic/'.$data->invoiceCompany->logo)}}" alt="{{$data->invoiceCompany->company_name}}" height="125px" width="125px">
			</td>
			<td style="text-align: right;align-self: flex-start!important;">
				<h1 style="margin-bottom: 0px;padding-bottom: 0px;">Invoice</h1>
				<h3>#{{$data->invoice_number}}</h3>
			</td>
		</tr>
		<tr>
			<td style="width:50%;text-wrap: pretty;padding-top: 10px;margin-top:10px;">
				<b>{{$data->invoiceCompany->company_name}}</b> <br>
				<small>{{$data->invoiceCompany->address}}</small> <br>
				<small>{{$data->invoiceCompany->contact}} {{$data->invoiceCompany->phone}}</small>
			</td>
			<td style="text-align: right;align-self: flex-end;">
				<b>Balance Due:</b> <br>
				@currency_idr($sum)
			</td>
		</tr>
	</table>


	<table style="width:50%;margin-bottom: 40px;">
		<tr>	
			<td>
				Bill To
			</td>
			<td style="padding-left: 10px;padding-right:10px;">:</td>
			<td><b>{{$data->bill_to}}</b></td>
		</tr>
		<tr>
			<td>Invoice Date</td>
			<td style="padding-left: 10px;padding-right:10px;">:</td>
			<td>{{date('d-m-Y', strtotime($data->invoice_date))}}</td>
		</tr>
		<tr>
			<td>Terms</td>
			<td style="padding-left: 10px;padding-right:10px;">:</td>
			<td>Due on Receipt</td>
		</tr>
		<tr>
			<td>Due Date</td>
			<td style="padding-left: 10px;padding-right:10px;">:</td>
			<td>{{date('d-m-Y', strtotime($data->due_date))}}</td>
		</tr>
	</table>

	<table class="table-data">
			<tr>
				<th style="width:5%;">#</th>
				<th style="text-align: left;">Item & Description</th>
				<th style="width:5%;">Qty</th>
				<th style="text-align: left;">Rate</th>
				<th style="text-align: left;">Amount</th>
			</tr>
			@php $i = 1; @endphp
			@foreach($details as $detail)
			<tr>
				<td>{{$i++}}.</td>
				<td>{{$detail->item}}</td>
				<td style="text-align: center;">{{$detail->qty}}</td>
				<td>@currency_idr($detail->price)</td>
				<td>@currency_idr($detail->amount)</td>
			</tr>
			@endforeach
			<tr>
				<td colspan="4" style="text-align: right"><b>Total</b></td>
				<td>@currency_idr($sum)</td>
			</tr>
	</table>

	
	<h3>Notes</h3>
	<p>{{$data->invoiceCompany->information}}</p>
	<b>Thank you for trusting us</b>
	
</body>
</html>