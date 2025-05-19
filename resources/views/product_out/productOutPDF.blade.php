<!doctype html>
<html>
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
</head>

<style>
    #table-data {
        border-collapse: collapse;
        padding: 3px;
    }

    #table-data td, #table-data th {
        border: 1px solid black;
    }
</style>

<body>
<div class="invoice-box">
    <!-- <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            <img src="https://www.sparksuite.com/images/logo.png" style="width:100%; max-width:300px;">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table> -->


        <table border="0" id="table-data" width="100%">
            <tr>
                <td width="70px"><b>Invoice</b></td>
                <td width="">: ##{{ $product_out->id }}</td>
                <td width="30px"><b>Created</b></td>
                <td>: {{ $product_out->date }}</td>
            </tr>

            <tr>
                <td><b>Contact</b></td>
                <td>: {{ $product_out->customer->phone }}</td>
                <td><b>Address</b></td>
                <td>: {{ $product_out->customer->address }}</td>
            </tr>

            <tr>
                <td><b>Customer</b></td>
                <td>: {{ $product_out->customer->name }}</td>
                <td><b>Email</b></td>
                <td>: {{ $product_out->customer->email }}</td>
            </tr>

            <tr>
                <td><b>Product</b></td>
                <td >: {{ $product_out->product->name }}</td>
                <td><b>Quantity</b></td>
                <td >: {{ $product_out->quantity }}</td>
            </tr>

        </table>

        {{--<hr  size="2px" color="black" align="left" width="45%">--}}


        <table border="0" width="80%">
            <tr align="right">
                <td>Best Regard</td>
            </tr>
        </table>

    <!-- <table border="0" width="80%">
        <tr align="right">
            <td><img src="https://upload.wikimedia.org/wikipedia/en/f/f4/Timothy_Spall_Signature.png" width="100px" height="100px"></td>
        </tr>

    </table> -->
        <table border="0" width="80%">
            <tr align="right">
                <td>RYOSHKA IMS</td>
            </tr>
        </table>
</div>






<!-- New Invoice Starts Here -->
<!-- <div class="container">
    <div class="row">
        <div class="col-xs-12">
    		<div class="invoice-title">

    			<h2>Invoice</h2><h3 class="pull-right">Order # {{ $product_out->id }}</h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
                    {{ $product_out->customer->name }}<br>
                    {{ $product_out->customer->address }}<br>
                    {{ $product_out->customer->email }}<br>
                    {{ $product_out->customer->phone }}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Order Date:</strong><br>
    					{{ $product_out->date }}<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>
    
    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order Summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-bordered table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Product Name</strong></td>
        							<td class="text-center"><strong>Total Quantity</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<tr>
    								<td>{{ $product_out->product->name }}</td>
    								<td class="text-center">{{ $product_out->quantity }}</td>
    							</tr>
    							
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div> -->


</body>