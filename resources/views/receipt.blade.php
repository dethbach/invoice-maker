<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Receipt {{$invoice->invoice_number}} to {{$invoice->bill_to}}</title>
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
			background-color: transparent; /* Change the background-color of table here */
			text-align: left; /* Change the text-alignment of table here */
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

        .invoice-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
        }

        .table-invoice {
            width: 50%;
            margin-bottom: 40px;
        }

        .amount-received {
            background-color: #f0f0f0; /* Background color for the square */
            width: fit-content; /* Adjust the width of the square */
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            border-radius: 10px; /* Optional: rounded corners */
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .amount-received h3 {
            margin: 0;
            font-size: 18px;
        }

        .amount-received p {
            margin: 5px 0 0 0;
            font-size: 24px;
            font-weight: bold;
        }
    </style>
</head>
<body>

	<table style="width: 100%;margin-bottom: 40px;">
		<tr>
			<td>				
				<img class="mb-2" src="{{public_path('storage/company-pic/'.$invoice->invoiceCompany->logo)}}" alt="{{$invoice->invoiceCompany->company_name}}" height="125px" width="125px">
			</td>
			<td style="text-align: right;align-self: flex-start!important;">
				<h1 style="margin-bottom: 0px;padding-bottom: 0px;">Payment Receipt</h1>
				<h3>#{{$invoice->invoice_number}}</h3>
			</td>
		</tr>
		<tr>
			<td style="width:50%;text-wrap: pretty;padding-top: 10px;margin-top:10px;">
				<b>{{$invoice->invoiceCompany->company_name}}</b> <br>
				<small>{{$invoice->invoiceCompany->address}}</small> <br>
				<small>{{$invoice->invoiceCompany->contact}} {{$invoice->invoiceCompany->phone}}</small>
			</td>
		</tr>
	</table>



    <div class="invoice-container">
        <!-- Table on the left -->
        <table class="table-invoice">
            <tr>    
                <td>Bill To</td>
                <td style="padding-left: 10px; padding-right:10px;">:</td>
                <td><b>{{$invoice->bill_to}}</b></td>
            </tr>
            <tr>    
                <td>Payment Date</td>
                <td style="padding-left: 10px; padding-right:10px;">:</td>
                <td><b>{{date('d-m-Y', strtotime($data->payment_date))}}</b></td>
            </tr>
            <tr>
                <td>Payment Method</td>
                <td style="padding-left: 10px; padding-right:10px;">:</td>
                <td><b>{{$data->payment_mode}}</b></td>
            </tr>
        </table>
    
        <!-- Square on the right -->
        <div class="amount-received">
            <h3>Amount Received</h3>
            <p>@currency_idr($data->amount_received)</p>
        </div>
    </div>

    <hr style="border: 1px solid #ccc;">

    <h3>Payment For</h3>

	<table class="table-data">
			<tr>
				<th style="text-align: left;">Invoice Number</th>
				<th style="text-align: left;">Invoice Date</th>
				<th style="text-align: left;">Invoice Amount</th>
				<th style="text-align: left;">Payment Amount</th>
			</tr>
			
			<tr>
				<td>{{$data->receiptInvoice->invoice_number}}</td>
				<td>{{date('d-m-Y', strtotime($data->payment_date))}}</td>
				<td>@currency_idr($sum)</td>
				<td>@currency_idr($data->amount_received)</td>
			</tr>
	</table>

	
	<p>Thank you for trusting us</p>

</body>
</html>