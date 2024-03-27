<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customer Data</title>
</head>
<body>
<table>
    <tr>
        <th>Name</th>
        <th>Gst No</th>
        <th>Email</th>
        <th>Nature of Business</th>
        <th>Contact Person</th>
        <th>Contact Number</th>
        <th>UPI</th>
        <th>Payment Terms</th>
    </tr>
     @foreach($data as $value)
     <tr>
         <td>{{$value['name']}}</td>
         <td>{{$value['tax_number']}}</td>
         <td>{{$value['email']}}</td>
         <td>{{$value['nature_of_business']}}</td>
         <td>{{$value['contact_person']}}</td>
         <td>{{$value['contact']}}</td>
         <td>{{$value['upi']}}</td>
         <td>{{$value['payment_terms_days']}}</td>
     </tr>

     @endforeach


</table>
</body>
</html>
