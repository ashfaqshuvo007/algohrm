<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice - 1000</title>
    <style>
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
          }
          .place {
            text-align: right;
            margin-top: 30px;
          }
          .bank {
            width: 100%;
            height: 70%;
            background: #ffff;
            border: none;
            font-size: 14px;
            font-family: Arial;
            color: black;
            overflow:hidden; 
            resize:none;
          }
          a {
            color: #5D6975;
            text-decoration: underline;
          }
          
          body {
            position: relative;
            width: 19cm;  
            height: 26cm;
            margin: 0 auto; 
            color: black;
            background: #FFFFFF; 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px;
          }
          header {
            padding: 10px 0;
          }
          
          #logo {
            float: left;
            margin-bottom: 10px;
          }
          
          #logo img {
            height: 80px;
          }
          
          h1 {
            border-top: 1px solid  #5D6975;
            border-bottom: 1px solid  #5D6975;
            color: black;
            font-size: 2.4em;
            line-height: 1.4em;
            font-weight: normal;
            text-align: left;
            margin: 0 0 20px 0;
          }
          h2 {
            color: black;
            font-size: 1.4em;
            line-height: 1.4em;
            font-weight: normal;
            margin: 10px 10px 20px 0;
            text-align: center;
          }
          .inv {
          }
          .users {
            display: block;
            margin-right: 30px;
            margin-left: 30px;
          }
          .seller {
            float: left;
            font-size: 16px;
            margin-bottom: 30px;
          }
          .company {
            float: right;
            font-size: 16px;
            margin-bottom: 30px;
          }
          
          #seller div,
          #company div {
            white-space: nowrap;        
          }
          table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
          }
          table tr:nth-child(2n-1) td {
            background: #F5F5F5;
          }
          table th,
          table td {
            text-align: right;
          }
          table th {
            padding: 5px 5px;
            color: #5D6975;
            border-bottom: 1px solid #C1CED9;
            white-space: nowrap;        
            font-weight: normal;
          }
          table .service,
          table .desc {
            text-align: left;
          }
          table td {
            padding: 5px;
            text-align: right;
          }
          table td.service,
          table td.desc {
            vertical-align: top;
          }
          table td.unit,
          table td.qty,
          table td.total {
            font-size: 1.2em;
          }
          table td.grand {
            border-top: 1px solid #5D6975;;
          }
          #notices .notice {
            color: #5D6975;
            font-size: 1.2em;
            margin-bottom: 20px;
          }
          footer {
            color: #5D6975;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #C1CED9;
            padding: 8px 0;
            text-align: center;
          }
          .total {
            font-family: Arial; 
            font-size: 14px;
          }
    </style>
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="/logo.png">
      </div>
      <div class="place">
        <div>Place of issue: Country, City</div>
        <div>Date of issue: 2019-05-06 12:00:00</div>
        <div>Date of sale: 2019-05-06 12:00:00</div>
      </div>
      <div class="inv">
          <h2 style="float: right"><strong>ORYGINAL/COPY</strong></h2>
          <h1>INVOICE Nr - <strong>1000</strong></h1>
          <div class="users">
            <div class="company">
              <div><strong>SELLER: </strong></div>
              <div>Company name</div>
              <div>Address</div>
              <div>Country, City</div>
              <div>Tax ID</div>
            </div>
            <div class="seller">
              <div><strong>BUYER: </strong></div>
              <div>Company Name</div>
              <div>Address</div>
              <div>Country, City</div>
              <div>Tax ID</div>
            </div>
          </div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th>PRODUCT</th>
            <th>NET</th>
            <th>VAT %</th>
            <th>VAT AMOUNT</th>
            <th>PST %</th>
            <th>PST AMOUNT</th>
            <th>GROSS</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($items as $item)
          <tr>
            <td class="desc">{{ $item->service }}</td>
            <td class="total">{{ $item->net }}</td>
            <td class="qty total">24</td>
            <td class="total">{{ $item->vat }}</td>
            <td class="unit total">5</td>
            <td class="total">{{ $item->pst }}</td>
            <td class="total">{{ $item->gross }}</td>
          </tr>
          @endforeach
          <tr>
            <td colspan="6" class="grand total">TOTAL NET</td>
            <td class="grand total">USD {{ $invoice->total_net }}</td>
          </tr>
          <tr>
            <td colspan="6">VAT 24%</td>
            <td class="total">USD {{ $invoice->total_vat }}</td>
          </tr>
          <tr>
            <td colspan="6">PST 5%</td>
            <td class="total">USD {{ $invoice->total_pst }}</td>
          </tr>
          <tr>
            <td colspan="6" class="grand total"><strong>TOTAL DUE</strong></td>
            <td class="grand total"><strong>USD {{ $invoice->total_gross }}</strong></td>
          </tr>
        </tbody>
      </table>
      <!--Payment Terms -->
      <div id="notices">
          <div class="notice"><strong>Terms of Payment: payment terms</strong></div>
      </div>
      <!--Bank details -->
      <div>
        <div><strong>Bank Details:</strong></div>
        <textarea class="bank" disabled rows='17'>bank details</textarea>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  </body>
</html>