<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>category Data</title>
</head>
<body>
<table>
    <tr>
        <th>Name</th>            
    </tr>
     @foreach($data as $value)
     <tr>
         <td>{{$value['name']}}</td>         
     </tr>

     @endforeach


</table>
</body>
</html>
