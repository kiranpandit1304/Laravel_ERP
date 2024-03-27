<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Data</title>
</head>
<body>
<table>
    <tr>
            <th>Name</th>
            <th>Variation name</th>
            <th>SKU</th>
            <th>Purchase price</th>
            <th>Sale price</th>
            <th>Tax rate</th>
            <th>HSN</th>
            <th>Unit name</th>
    </tr>
     @foreach($data as $value)
     <tr>
         <td>{{$value['productName']}}</td>
         <td>{{$value['variation_name']}}</td>
         <td>{{$value['sku']}}</td>
         <td>{{$value['purchase_price']}}</td>
         <td>{{$value['sale_price']}}</td>
         <td>{{$value['tax_rate']}}</td>
         <td>{{$value['hsn']}}</td>
         <td>{{$value['unitName']}}</td>
     </tr>

     @endforeach


</table>
</body>
</html>
